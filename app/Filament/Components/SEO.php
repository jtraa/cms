<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SEO
{
    public static function make(array $only = ['title', 'description']): Group
    {
        return Group::make(
            Arr::only([
                'title' => TextInput::make('title')
                    ->label(__('filament::pages/admin.SEO.title'))
                    ->columnSpan(2),
                'description' => Textarea::make('description')
                    ->label(__('filament::pages/admin.SEO.description'))
                    ->helperText(function (?string $state): string {
                        return (string) Str::of(strlen($state))
                            ->append(' / ')
                            ->append(160 . ' ')
                            ->append(Str::of(__('filament::pages/admin.SEO.characters'))->lower());
                    })
                    ->reactive()
                    ->columnSpan(2),
            ], $only)
        )
            ->afterStateHydrated(function (Group $component, ?Model $record) use ($only): void {
                $component->getChildComponentContainer()->fill(
                    $record?->seo?->only($only) ?: []
                );
            })
            ->statePath('seo')
            ->dehydrated(false)
            ->saveRelationshipsUsing(function (Model $record, array $state) use ($only): void {
                $state = collect($state)->only($only)->map(fn ($value) => $value ?: null)->all();

                if ($record->seo && $record->seo->exists) {
                    $record->seo->update($state);
                } else {
                    $record->seo()->create($state);
                }
            });
    }
}
