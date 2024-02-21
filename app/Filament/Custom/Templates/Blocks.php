<?php

namespace App\Filament\Custom\Templates;

use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

final class Blocks implements FilamentPageTemplate
{
    public static function title(): string
    {
        return __('filament::pages/admin.sections.blocks');
    }

    public static function schema(): array
    {
        return [
            Repeater::make('blocks')->label(__('filament::pages/admin.sections.blocks'))
                ->schema([
                    TextInput::make('blockTitle')->label(__('filament::pages/admin.tables.title')),
                    Textarea::make('blockDescription')->label(__('filament::pages/admin.tables.text')),
                    TextInput::make('blockLink')->label(__('filament::pages/admin.tables.link')),
                ])->createItemButtonLabel(__('filament::pages/admin.sections.add_block'))->minItems(1),
        ];
    }
}
