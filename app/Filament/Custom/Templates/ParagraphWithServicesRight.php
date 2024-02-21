<?php

namespace App\Filament\Custom\Templates;

use App\Filament\Components\CustomTinyEditor;
use App\Models\Service;
use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

final class ParagraphWithServicesRight implements FilamentPageTemplate
{
    public static function title(): string
    {
        return __('filament::pages/admin.sections.paragraph_services');
    }

    public static function schema(): array
    {
        return [
            Card::make()
                ->schema([
                    TextInput::make('paragraphTitle')->label(__('filament::pages/admin.tables.title'))->columnSpan(2),
                    CustomTinyEditor::make('paragraphText')->label(__('filament::pages/admin.tables.text'))
                        ->profile('default')
                        ->fileAttachmentsDisk('uploads')->fileAttachmentsVisibility('public')
                        ->language('nl')
                        ->columnSpan(2)
                        ->minHeight(300),
                    TextInput::make('paragraphButton')->label('Button')->columnSpan(1),
                    TextInput::make('paragraphButtonLink')->label('Link button')->columnSpan(1),
                    Select::make('services')->label(__('filament::pages/admin.menu.services'))->columnSpan(2)
                        ->multiple()
                        ->options(Service::all()->pluck('title', 'id')),
                ]),
        ];
    }
}
