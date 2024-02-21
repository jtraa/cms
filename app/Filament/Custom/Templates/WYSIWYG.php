<?php

namespace App\Filament\Custom\Templates;

use App\Filament\Components\CustomTinyEditor;
use App\Http\Controllers\ConvertController;
use App\Models\Section;
use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Livewire\TemporaryUploadedFile;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

final class WYSIWYG implements FilamentPageTemplate
{
    public static function title(): string
    {
        return __('filament::pages/admin.sections.wysiwyg');
    }

    public static function schema(): array
    {
        return [
            Repeater::make('editors')->label(__('filament::pages/admin.sections.wysiwyg'))
                ->schema([
                    CustomTinyEditor::make('text')
                        ->label(__('filament::pages/admin.tables.text'))
                        ->template('example')
                        ->profile('default')
                        ->fileAttachmentsDisk('uploads')
                        ->language('nl')
                        ->columnSpan(2)
                        ->minHeight(300),
                ])->minItems(1)
                ->createItemButtonLabel('Add editor'),
        ];
    }
}
