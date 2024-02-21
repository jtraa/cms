<?php

namespace App\Filament\Custom\Templates;

use App\Http\Controllers\ConvertController;
use App\Models\Section;
use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use App\Filament\Components\CustomFileUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

final class Gallery implements FilamentPageTemplate
{
    public static function title(): string
    {
        return __('filament::pages/admin.sections.gallery');
    }

    public static function schema(): array
    {
        return [
            Repeater::make('gallery')->label(__('filament::pages/admin.sections.gallery'))
                ->schema([
                    FileUpload::make('galleryImage')
                        ->label(__('filament::pages/admin.tables.image'))
                        ->disk('uploads')
                        ->preserveFilenames()
                        ->image()
                        ->imageResizeMode('cover')
                        ->getUploadedFileNameForStorageUsing(function (Closure $set, TemporaryUploadedFile $file, ?Section $record): string {

                            $convertController = new ConvertController();
                            $directory = $convertController->getDirectoryPath($record);

                            $width = 300;
                            $height = 225;

                            $newFile = $convertController->fileUpload($file, $width, $height, $directory, true, 300, 200);
                            $convertController->getPathForSection($newFile, $width, $height, $set);

                            return (string) str($newFile);
                        }),
                    TextInput::make('imageDescription')->label(__('filament::pages/admin.tables.description_image')),
                    Hidden::make('imageConverted'),
                    Hidden::make('imageWithSize'),
                ])->minItems(1)->createItemButtonLabel(__('filament::pages/admin.sections.add_image')),
        ];
    }
}
