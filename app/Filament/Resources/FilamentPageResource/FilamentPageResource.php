<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FilamentPageResource\RelationManagers\SectionsRelationManager;
use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use App\Filament\Resources\FilamentPageResource\Pages\CreateFilamentPage;
use App\Filament\Resources\FilamentPageResource\Pages\EditFilamentPage;
use App\Filament\Resources\FilamentPageResource\Pages\ListFilamentPages;
use App\Models\FilamentPage;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
//use RalphJSmit\Filament\SEO\SEO;
use App\Filament\Components\SEO;


class FilamentPageResource extends Resource
{

    public static function getRecordRouteKeyName(): ?string
    {
        return 'id';
    }

    protected static ?string $inverseRelationship = 'section';

    public static function getModel(): string
    {
        return config('filament-pages.filament.model', FilamentPage::class);
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return __('filament-pages::filament-pages.filament.recordTitleAttribute');
    }

    protected static function getNavigationLabel(): string
    {
        return __('filament::pages/admin.menu.pages');
    }

    public static function getModelLabel(): string
    {
        return __('filament::pages/admin.menu.page');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament::pages/admin.menu.pages');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-pages::filament-pages.filament.pluralLabel');
    }

    protected static ?string $navigationGroup = 'Content';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationSort(): ?int
    {
        return (int) __('filament-pages::filament-pages.filament.navigation.sort');
    }

    protected static function getNavigationIcon(): string
    {
        return __('filament-pages::filament-pages.filament.navigation.icon');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        static::getPrimaryColumnSchema(),

                    ])
                    ->columnSpan(['lg' => 7]),

                static::getSecondaryColumnSchema(),

            ])
            ->columns([
                'sm' => 9,
                'lg' => null,
            ]);
    }

    public static function list()
    {
        return \Livewire\Livewire::create(\App\Http\Livewire\CustomTable::class);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('filament::pages/admin.tables.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label(__('filament::pages/admin.tables.slug'))
                    ->icon('heroicon-o-external-link')
                    ->iconPosition('after')
                    ->getStateUsing(fn (FilamentPage $record) => url($record->slug))
                    ->searchable()
                    ->url(
                        url: fn (FilamentPage $record) => url($record->slug),
                        shouldOpenInNewTab: true
                    )
                    ->sortable()
        ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make(__('filament::pages/admin.tables.status'))
                    ->getStateUsing(function (FilamentPage $record): string {
                        if ($record->published_at && $record->published_at->isPast()) {
                            if ($record->published_until != null) {
                                return $record->published_until && $record->published_until->isFuture() ? __('filament::pages/admin.status.active') : __('filament::pages/admin.status.inactive');
                            } else {
                                return __('filament::pages/admin.status.active');
                            }

                        } else {
                            return __('filament::pages/admin.status.draft');
                        }
                    })
                    ->colors([
                        'success' => __('filament::pages/admin.status.active'),
                        'warning' => __('filament::pages/admin.status.draft'),
                        'danger' => __('filament::pages/admin.status.inactive'),
                    ]),

                 BadgeColumn::make('In Menu')
                     ->getStateUsing(fn (FilamentPage $record): string => $record->in_menu == 1 ?? true ? __('filament::pages/admin.status.yes') : __('filament::pages/admin.status.no'))
                     ->colors([
                         'success' => __('filament::pages/admin.status.yes'),
                         'danger' => __('filament::pages/admin.status.no'),
                     ]),

                TextColumn::make('published_at')
                    ->label(__('filament-pages::filament-pages.filament.form.published_at.label'))
                    ->date(__('filament-pages::filament-pages.filament.form.published_at.displayFormat'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_until')
                    ->label(__('Published until'))
                    ->date(__('filament-pages::filament-pages.filament.form.published_at.displayFormat'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
        Filter::make('published_at')
            ->form([
                DatePicker::make('published_from')
                    ->label(__('filament-pages::filament-pages.filament.form.published_at.label'))
                    ->placeholder(fn ($state): string => '18. November '.now()->subYear()->format('Y')),
                DatePicker::make('published_until')
                    ->label(__('filament-pages::filament-pages.filament.form.published_until.label'))
                    ->placeholder(fn ($state): string => now()->format('d. F Y')),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['published_from'],
                        fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                    ->when(
                        $data['published_until'],
                        fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];
                if ($data['published_from'] ?? null) {
                    $indicators['published_from'] = 'Published from '.Carbon::parse($data['published_at'])->toFormattedDateString();
                }
                if ($data['published_until'] ?? null) {
                    $indicators['published_until'] = 'Published until '.Carbon::parse($data['published_until'])->toFormattedDateString();
                }

                return $indicators;
            }),
        TrashedFilter::make(),
    ])
        ->actions([
            EditAction::make(),
            ReplicateAction::make()
                ->excludeAttributes(['title'])
                ->form([
                    TextInput::make('title')
                        ->label(__('filament::pages/admin.tables.title'))
                        ->columnSpan(1)
                        ->required()
                        ->lazy()
                        ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                            if (! $get('is_slug_changed_manually') && filled($state)) {
                                $set('slug', Str::slug($state));
                            }
                        }),

                    TextInput::make('slug')
                        ->label(__('filament::pages/admin.tables.slug'))
                        ->columnSpan(1)
                        ->required()
                        ->unique(FilamentPage::class, 'slug')
                ])
                ->beforeReplicaSaved(function (FilamentPage $replica, array $data): void {
                    $replica->fill($data);
                }),
            DeleteAction::make()
                ->hidden(fn ($record) => $record->fixed_page == 1),
            ForceDeleteAction::make(),
            RestoreAction::make(),

        ])
        ->bulkActions([
            ForceDeleteBulkAction::make(),
            RestoreBulkAction::make(),
        ])->reorderable('order')->defaultSort('order');
    }

    public static function getPrimaryColumnSchema(): Component
    {
        return Card::make()
            ->columns(2)
            ->schema([
                ...static::insertBeforePrimaryColumnSchema(),
                TextInput::make('title')
                    ->label(__('filament::pages/admin.tables.title'))
                    ->columnSpan(1)
                    ->required()
                    ->lazy()
                    ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                        if (! $get('is_slug_changed_manually') && filled($state)) {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->label(__('filament::pages/admin.tables.slug'))
                    ->columnSpan(1)
                    ->required()
                    ->unique(FilamentPage::class, 'slug', ignoreRecord: true),
                SEO::make()
                    ->columnSpan(2),
                ...static::insertAfterPrimaryColumnSchema(),
            ]);
    }

    public static function getSecondaryColumnSchema(): Component
    {
        return Card::make()
            ->schema([
                ...static::insertBeforeSecondaryColumnSchema(),
                Toggle::make('in_menu'),

                DatePicker::make('published_at')
                    ->label(__('filament::pages/admin.tables.published_at'))
                    ->displayFormat(__('filament-pages::filament-pages.filament.form.published_at.displayFormat'))
                    ->default(now()),

                DatePicker::make('published_until')
                    ->label(__('filament::pages/admin.tables.published_until'))
                    ->displayFormat(__('filament-pages::filament-pages.filament.form.published_until.displayFormat')),

                Placeholder::make('created_at')
                    ->label(__('filament::pages/admin.tables.created_at'))
                    ->hidden(fn (?FilamentPage $record) => $record === null)
                    ->content(fn (FilamentPage $record): string => $record->created_at->diffForHumans()),

                Placeholder::make('updated_at')
                    ->label(__('filament::pages/admin.tables.updated_at'))
                    ->hidden(fn (?FilamentPage $record) => $record === null)
                    ->content(fn (FilamentPage $record): string => $record->updated_at->diffForHumans()),
                ...static::insertAfterSecondaryColumnSchema(),
            ])
            ->columnSpan(['lg' => 2]);
    }

    public static function insertBeforePrimaryColumnSchema(): array
    {
        return [];
    }

    public static function insertAfterPrimaryColumnSchema(): array
    {
        return [];
    }

    public static function insertBeforeSecondaryColumnSchema(): array
    {
        return [];
    }

    public static function insertAfterSecondaryColumnSchema(): array
    {
        return [];
    }



    public static function getPages(): array
    {
        return [
            'index' => ListFilamentPages::route('/'),
            'create' => CreateFilamentPage::route('/create'),
            'edit' => EditFilamentPage::route('/{record:id}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('Pages', [
                SectionsRelationManager::class,
            ])
        ];
    }



}
