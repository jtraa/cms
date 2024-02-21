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
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Livewire\TemporaryUploadedFile;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

final class ParagraphWithImageLeft implements FilamentPageTemplate
{
    public static function title(): string
    {
        return __('filament::pages/admin.sections.paragraph_image_left');
    }

    public static function schema(): array
    {
        return [
            Card::make()
                ->schema([
                    TextInput::make('paragraphTitle')->label(__('filament::pages/admin.tables.title')),
                    CustomTinyEditor::make('paragraphText')->label(__('filament::pages/admin.tables.text'))
                        ->profile('default')
                        ->fileAttachmentsDisk('uploads')->fileAttachmentsVisibility('public')
                        ->language('nl')
                        ->columnSpan(2)
                        ->minHeight(300),
                    FileUpload::make('paragraphImage')
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
                ]),
        ];
    }
}
