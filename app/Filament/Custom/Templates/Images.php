<?php

namespace App\Filament\Custom\Templates;

use App\Http\Controllers\ConvertController;
use App\Models\Employee;
use App\Models\Section;
use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use Closure;
use Filament\Forms\Components\Card;
use App\Filament\Components\CustomFileUpload;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Spatie\Image\Manipulations;
use Spatie\Image\Image;

final class Images implements FilamentPageTemplate
{

    public static function title(): string
    {
        return __('filament::pages/admin.sections.image');
    }

    public static function schema(): array
    {
        return [
            Repeater::make('images')->label(__('filament::pages/admin.sections.image'))
                ->schema([
                    FileUpload::make('imageLink')
                        ->label(__('filament::pages/admin.tables.image'))
                        ->disk('uploads')
                        ->columnSpan(2)
                        ->preserveFilenames()
                        ->image()
                        ->imageResizeMode('cover')
                        ->getUploadedFileNameForStorageUsing(function (Closure $set, TemporaryUploadedFile $file, ?Section $record): string {

                            $convertController = new ConvertController();
                            $directory = $convertController->getDirectoryPath($record);

                            $width = 1920;
                            $height = 1080;

                            $newFile = $convertController->fileUpload($file, $width, $height, $directory);
                            $convertController->getPathForSection($newFile, $width, $height, $set);

                            return (string) str($newFile);
                        }),
                    Hidden::make('imageConverted'),
                    Hidden::make('imageWithSize'),
                ])
        ];
    }
}
