<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Employee;
use App\Models\FilamentPage;
use App\Models\Service;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->hidden(fn ($record) => ($record->published_until !== null && $record->published_until < Carbon::now()) || $record->published_at == null || $record->published_at > Carbon::now())
                ->url(
                    url: fn (Service $record) => url('/' . FilamentPage::where('id', 1)->firstOrFail()->slug . '/' . $record->slug),
                                        shouldOpenInNewTab: true
                                    ),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
