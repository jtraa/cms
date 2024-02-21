<?php

namespace App\Filament\Custom\Templates;

use App\Filament\Components\CustomTinyEditor;
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
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

final class Header implements FilamentPageTemplate
{
    public static function title(): string
    {
        return __('filament::pages/admin.sections.header');
    }

    public static function schema(): array
    {
        return [
            Repeater::make('sliders')->label(__('filament::pages/admin.sections.header'))
                ->schema([
                    TextInput::make('sliderTitle')->label(__('filament::pages/admin.tables.title')),
                    CustomTinyEditor::make('sliderContent')->label(__('filament::pages/admin.tables.text'))
                        ->profile('default')
                        ->fileAttachmentsDisk('uploads')
                        ->language('nl')
                        ->columnSpan(2)
                        ->minHeight(300),
                    TextInput::make('sliderButton')->label('Button'),
                    TextInput::make('sliderButtonLink')->label('Button Link'),
                    FileUpload::make('sliderImage')
                        ->label(__('filament::pages/admin.tables.image'))
                        ->disk('uploads')
                        ->columnSpan(2)
                        ->preserveFilenames()
                        ->image()
                        ->imageResizeMode('cover')
                        ->getUploadedFileNameForStorageUsing(function (Closure $set, TemporaryUploadedFile $file, ?Section $record): string {

                            $convertController = new ConvertController();
                            $directory = $convertController->getDirectoryPath($record);

                            $width = 512;
                            $height = 288;

                            $newFile = $convertController->fileUpload($file, $width, $height, $directory);
                            $convertController->getPathForSection($newFile, $width, $height, $set);

                            return (string) str($newFile);
                        }),
                    Hidden::make('imageConverted'),
                    Hidden::make('imageWithSize'),
                ])->minItems(1)
                ->createItemButtonLabel(__('filament::pages/admin.sections.add_slider'))
        ];
    }
}
