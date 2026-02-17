<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Imagick;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Drivers\Imagick\Driver;


class ThumbnailGenerationService
{
    public function generate($pdfPath, string $tipoFile, $width, $height): string|null
    {

        if (!in_array($tipoFile, ['pdf', 'immagine'])) {
            return null;
        }

        $hashName = pathinfo($pdfPath, PATHINFO_FILENAME);
        $cartellaThumbnails = '/thumbnails/';
        \File::ensureDirectoryExists(Storage::disk('public')->path($cartellaThumbnails));

        switch ($tipoFile) {
            case 'pdf':
                return $this->pdf($pdfPath, $hashName, $cartellaThumbnails);

            case 'immagine':
                return $this->immagine($pdfPath, $hashName, $cartellaThumbnails, $width, $height);

        }

        return null;
    }


    private function pdf($pdfPath, string $hashName, $cartellaThumbnails)
    {
        $thumbnailPath = null;
        try {
            $thumbnailPath = $cartellaThumbnails . $hashName . '.jpg';

            $source = Storage::disk('public')->path($pdfPath);
            $target = Storage::disk('public')->path($thumbnailPath);
            $manager = ImageManager::imagick();

            $image = $manager->read($source);
            $image->setResolution(160, 160); //180
            $image->scaleDown(160, 160);
            $image->toWebp(75);
            $image->setBlendingColor('#ffffff');


            $image->save($target);

        } catch (\Exception $exception) {
            \Log::alert('Errore in ThumbnailGenerationService:' . $exception->getMessage() . ' alla linea:' . $exception->getLine());
        }

        return $thumbnailPath;

    }

    private function immagine($path, string $hashName, $cartellaThumbnails, $width, $height): string|null
    {

        $source = Storage::disk('public')->path($path);
        if (\File::exists($source)) {
            $thumbnailPath = $cartellaThumbnails . $hashName . '.jpg';
            $target = Storage::disk('public')->path($thumbnailPath);
            $manager = ImageManager::gd();
            $img = $manager->read($source)->scaleDown($width, $height);
            $img->save($target);
            return $thumbnailPath;
        } else {
            \Log::warning('File non trovato ' . $source);
            return null;
        }


    }

}
