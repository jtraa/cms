<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Article;
use App\Models\Employee;
use App\Models\FilamentPage;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{

    protected static string $resource = EmployeeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->hidden(fn ($record) => ($record->published_until !== null && $record->published_until < Carbon::now()) || $record->published_at == null || $record->published_at > Carbon::now())
                ->url(
                    url: fn (Employee $record) => url('/' . FilamentPage::where('id', 9)->firstOrFail()->slug . '/' . $record->slug),
                                        shouldOpenInNewTab: true
                                    ),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
