<?php

namespace App\Filament\Resources\FilamentPageResource\RelationManagers;

use App\Filament\Resources\SectionResource;
use App\Models\FilamentPage;
use App\Models\Section;
use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ReplicateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return __('filament::pages/admin.menu.section');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament::pages/admin.menu.sections');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                    ])
                    ->columnSpan(['lg' => 7]),

            ])
            ->columns([
                'sm' => 9,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('title')->label(__('filament::pages/admin.tables.title')),
        ])
        ->filters([
            Tables\Filters\TrashedFilter::make()
        ])
        ->headerActions([
            CreateAction::make()
                ->url(fn ($livewire) => SectionResource::getUrl('create', ['pageRecord' => $livewire->ownerRecord->getKey()]))
        ])
        ->actions([
            Tables\Actions\EditAction::make()
                ->url(fn (Model $record): string => SectionResource::getUrl('edit', $record))
                ->hidden(fn ($record) => $record->fixed_section == 1),
            Tables\Actions\DeleteAction::make()
                ->hidden(fn ($record) => $record->fixed_section == 1),
            Tables\Actions\ForceDeleteAction::make(),
            Tables\Actions\RestoreAction::make(),
            ReplicateAction::make()
                ->beforeReplicaSaved(function (Section $replica, array $data): void {
                    $pageId = $data['title']; // Assuming the selected value is the article ID
                    $replica->filament_page_id = $pageId;
                    $replica->save();
                })
                ->form([
                    Select::make('title')->label(__('filament::pages/admin.tables.title'))
                        ->columnSpan(1)
                        ->required()
                        ->options(function () {
                            return FilamentPage::pluck('title', 'id');
                        })
                        ->lazy()
                        ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                            if (! $get('is_slug_changed_manually') && filled($state)) {
                                $set('slug', Str::slug($state));
                            }
                        }),
                ])
                ->hidden(fn ($record) => $record->fixed_section == 1),
        ])
        ->bulkActions([
            Tables\Actions\RestoreBulkAction::make(),
            Tables\Actions\ForceDeleteBulkAction::make(),
        ])->reorderable('order')->defaultSort('order');
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
