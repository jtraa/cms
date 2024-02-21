<?php

namespace App\Filament\Resources\FilamentPageResource\Pages;

use App\Filament\Resources\FilamentPageResource;
use App\Filament\Resources\SectionResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Model;

class CreateFilamentPage extends CreateRecord
{
    public static function getResource(): string
    {
        return config('filament-pages.filament.resource', FilamentPageResource::class);
    }
}
