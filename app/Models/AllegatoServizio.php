<?php

namespace App\Models;

use App\Traits\FunzioniAllegato;
use App\Traits\ThumbnailGenerationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllegatoServizio extends Model
{
    use FunzioniAllegato;

    protected $table = 'allegati';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($model) {
            $estensione = strtolower(pathinfo($model->filename_originale, PATHINFO_EXTENSION));
            $model->tipo_file = self::tipoFile($estensione);

            $thumbnailGenerationService = new ThumbnailGenerationService();
            $thumbnailPath = $thumbnailGenerationService->generate($model->path_filename, $model->tipo_file, 500, 500);
            $model->thumbnail = $thumbnailPath;

        });

        static::deleting(function ($model) {
            \Storage::delete($model->path_filename);
            \Log::debug('deleting;');
            if ($model->thumbnail) {
                \Storage::delete($model->thumbnail);
            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | RELAZIONI
    |--------------------------------------------------------------------------
    */
    public function allegato()
    {
        return $this->morphTo();
    }


    public static function perBlade($uid, $allegatoServizioId, $allegatoServizioType)
    {

        $allegatoServizioType = str_replace('_', '\\', $allegatoServizioType);
        $qb = self::where(function ($q) use ($uid, $allegatoServizioId, $allegatoServizioType) {
            if ($allegatoServizioId) {
                $q->where('orologio_id', $allegatoServizioId)->where('tipo_allegato', $allegatoServizioType);
            } else {
                $q->where('uid', $uid);
            }
        });

        return $qb->get(['id', 'path_filename', 'dimensione_file', 'thumbnail'])->toArray();
    }
}
