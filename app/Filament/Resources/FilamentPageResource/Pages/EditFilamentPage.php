<?php

namespace App\Filament\Resources\FilamentPageResource\Pages;

use App\Filament\Resources\FilamentPageResource;
use App\Filament\Resources\SectionResource;
use App\Models\Employee;
use App\Models\FilamentPage;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\CreateAction;

class EditFilamentPage extends EditRecord
{
    public static function getResource(): string
    {
        return config('filament-pages.filament.resource', FilamentPageResource::class);
    }

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->hidden(fn ($record) => ($record->published_until !== null && $record->published_until < Carbon::now()) || $record->published_at == null || $record->published_at > Carbon::now())
                ->url(
                    url: fn (FilamentPage $record) => url('/' . $record->slug),
                                        shouldOpenInNewTab: true
                                    ),
            Actions\DeleteAction::make()
                ->hidden(fn ($record) => $record->fixed_page == 1),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
