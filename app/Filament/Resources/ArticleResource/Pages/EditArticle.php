<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\SectionResource;
use App\Models\Article;
use App\Models\FilamentPage;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\ViewAction;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->hidden(fn ($record) => ($record->published_until !== null && $record->published_until < Carbon::now()) || $record->published_at == null || $record->published_at > Carbon::now())
                ->url(
                    url: fn (Article $record) => url('/' . FilamentPage::where('id', 8)->firstOrFail()->slug . '/' . $record->slug),
                                        shouldOpenInNewTab: true
                                    ),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
