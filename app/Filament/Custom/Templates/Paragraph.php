<?php

namespace App\Filament\Custom\Templates;

use App\Filament\Components\CustomTinyEditor;
use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

final class Paragraph implements FilamentPageTemplate
{
    public static function title(): string
    {
        return __('filament::pages/admin.sections.paragraph');
    }

    public static function schema(): array
    {
        return [
            Card::make()
                ->schema([
//                    Placeholder::make('Example')
//                        ->content(new HtmlString('<img src="' .  Storage::disk('uploads')->url('placeholders/placeholder.jpg') . '"/>'))
//                        ->columnSpan(2),
                    TextInput::make('paragraphTitle')->label(__('filament::pages/admin.tables.title')),
                    CustomTinyEditor::make('paragraphText')->label(__('filament::pages/admin.tables.text'))
                        ->profile('default')
                        ->fileAttachmentsDisk('uploads')->fileAttachmentsVisibility('public')
                        ->language('nl')
                        ->columnSpan(2)
                        ->minHeight(300),
                ]),
        ];
    }
}
