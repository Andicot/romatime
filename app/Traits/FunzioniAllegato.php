<?php

namespace App\Traits;

use App\Http\Controllers\Backend\FornitoreController;

trait FunzioniAllegato
{
    public function urlFile()
    {
        return '/storage' . $this->path_filename;
    }

    public function urlThumbnail(): string|null
    {
        return $this->thumbnail ? '/storage' . $this->thumbnail : null;
    }


    protected static function tipoFile($estensione)
    {

        switch ($estensione) {
            case 'png':
            case 'jpeg':
            case 'jpg':
                return 'immagine';

            case 'pdf':
                return 'pdf';

            default:
                return $estensione;
        }

    }

    protected function tabAllegatiRecords($id, $tab, $classeModel, $classeController)
    {

        $qb = \App\Models\AllegatoServizio::query()
            ->where('allegato_id', $id)
            ->where('allegato_type', $classeModel);

        return $qb->paginate()->withPath(action([$classeController, 'tab'], ['id' => $id, 'tab' => $tab]));
    }

}
