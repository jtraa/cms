<?php

namespace App\Filament\Components;

use Closure;
use Illuminate\Http\UploadedFile;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class CustomFileUpload extends FileUpload
{
    protected $storeUsingCallback = null;

    public function storeUsing(callable $callback)
    {
        $this->storeUsingCallback = $callback;

        return $this;
    }

    public function convertToWebp()
    {

        $quality = 80;

        $this->storeUsing(function (UploadedFile $file) use ($quality) {
            $image = Image::load($file);

            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            dd($filename);

            $convertedFile = Storage::disk('public')->path("images/{$filename}.webp");

            $image->format(Manipulations::FORMAT_WEBP)
                ->quality($quality)
                ->save($convertedFile);



            return new UploadedFile(
                $convertedFile,
                "{$filename}.webp",
                'image/webp',
                null,
                true
            );
        });

        return $this;
    }

    public function handleUpload()
    {
        if ($this->storeUsingCallback) {
            $temporaryUploadedFile = $this->getTemporaryUploadedFile();

            $storedFile = call_user_func($this->storeUsingCallback, $temporaryUploadedFile);

            $this->setUploadedFileUrl($storedFile->url());

            return;
        }

        parent::handleUpload();
    }

    protected function getUploadedFileUrl()
    {
        if ($this->storeUsingCallback) {
            return $this->uploadedFileUrl;
        }

        return parent::getUploadedFileUrl();
    }
}
