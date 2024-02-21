<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\RelationManagers\SectionsArticleRelationManager;
use App\Http\Controllers\ConvertController;
use App\Models\FilamentPage;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\ArticleResource\Pages\CreateArticle;
use App\Filament\Resources\ArticleResource\Pages\EditArticle;
use App\Filament\Resources\ArticleResource\Pages\ListArticles;
use App\Models\Article;
use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use Carbon\Carbon;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
//use RalphJSmit\Filament\SEO\SEO;
use App\Filament\Components\SEO;
use Livewire\TemporaryUploadedFile;

class ArticleResource extends Resource
{

    public static function getRecordRouteKeyName(): ?string
    {
        return 'id';
    }
    public static function getModelLabel(): string
    {
        return __('filament::pages/admin.menu.article');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament::pages/admin.menu.articles');
    }

    protected static function getResourceId(?Article $record): ?int
    {
        return $record ? $record->id : null;
    }

    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;


    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationLabel(): string
    {
        return __('filament::pages/admin.menu.articles');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        static::getPrimaryColumnSchema(),
                        ...static::getTemplateSchemas(),
                    ])
                    ->columnSpan(['lg' => 7]),

                static::getSecondaryColumnSchema(),

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
                ImageColumn::make('thumbnail')->disk('uploads')->label(__('filament::pages/admin.tables.image'))->square(),
                TextColumn::make('title')
                    ->label(__('filament::pages/admin.tables.title'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label(__('filament::pages/admin.tables.slug'))
                    ->icon('heroicon-o-external-link')
                    ->iconPosition('after')
                    ->getStateUsing(fn (Article $record) => url('/' .  FilamentPage::where('id', 8)->firstOrFail()->slug . '/' . $record->slug))
                    ->searchable()
                    ->url(
                        url: fn (Article $record) => url('/' .  FilamentPage::where('id', 8)->firstOrFail()->slug . '/' . $record->slug),
                        shouldOpenInNewTab: true
                    )
                    ->sortable()
        ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make(__('filament::pages/admin.tables.status'))
                    ->getStateUsing(function (Article $record): string {
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
                BadgeColumn::make(__('filament::pages/admin.tables.in_index'))
                    ->getStateUsing(fn (Article $record): string => $record->in_index == 1 ?? true ? __('filament::pages/admin.status.yes') : __('filament::pages/admin.status.no'))
                    ->colors([
                        'success' => __('filament::pages/admin.status.yes'),
                        'danger' => __('filament::pages/admin.status.no'),
                    ]),

                TextColumn::make('published_at')
                    ->label(__('filament::pages/admin.tables.published_at'))
                    ->date(__('filament-pages::filament-pages.filament.form.published_at.displayFormat'))
                    ->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('published_until')
            ->label(__('filament::pages/admin.tables.published_until'))
            ->date(__('filament-pages::filament-pages.filament.form.published_at.displayFormat'))
            ->toggleable(isToggledHiddenByDefault: true),
            ])


            ->filters([
        TrashedFilter::make(),
        Filter::make('published_at')
            ->form([
                DatePicker::make('published_from')
                    ->label(__('filament-pages::filament-pages.filament.form.published_at.label'))
                    ->placeholder(fn ($state): string => '18. November ' . now()->subYear()->format('Y')),

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
                    $indicators['published_from'] = 'Published from ' . Carbon::parse($data['published_at'])->toFormattedDateString();
                }
                if ($data['published_until'] ?? null) {
                    $indicators['published_until'] = 'Published until ' . Carbon::parse($data['published_until'])->toFormattedDateString();
                }

                return $indicators;
            }),
    ])
        ->actions([
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
                        ->unique(Article::class, 'slug')
                ])
                ->beforeReplicaSaved(function (Article $replica, array $data): void {
                    $replica->fill($data);
                }),
            EditAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ])
        ->bulkActions([
            DeleteBulkAction::make(),
            ForceDeleteBulkAction::make(),
            RestoreBulkAction::make(),
        ])->defaultSort('published_at', 'desc');
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
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),

                TextInput::make('slug')
                    ->label(__('filament::pages/admin.tables.slug'))
                    ->columnSpan(1)
                    ->required()
                    ->unique(Article::class, 'slug', ignoreRecord: true),

                FileUpload::make('image')
                    ->label(__('filament::pages/admin.tables.image'))
                    ->disk('uploads')
                    ->columnSpan(2)
                    ->preserveFilenames()
                    ->image()
                    ->imageResizeMode('cover')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, ?Article $record): string {

                        if(static::getResourceId($record) != null) {
                            $id = static::getResourceId($record);
                        } else {
                            $latestService = Article::latest()->first();
                            $id = $latestService->id + 1;
                        }
                        $width = 444;
                        $height = 666;
                        $directory = "articles/{$id}";

                        $convertController = new ConvertController();
                        $newFile = $convertController->fileUpload($file, $width, $height, $directory, true, 48, 48);

                        return (string) str($newFile);
                    }),
                ...static::insertAfterPrimaryColumnSchema(),
        SEO::make()->columnSpan(2),
            ]);
    }

    public static function getSecondaryColumnSchema(): Component
    {
        return Card::make()
            ->schema([
                ...static::insertBeforeSecondaryColumnSchema(),
                Toggle::make('in_index'),
                DatePicker::make('published_at')
                    ->label(__('filament::pages/admin.tables.published_at'))
                    ->displayFormat(__('filament-pages::filament-pages.filament.form.published_at.displayFormat'))
                    ->default(now()),

                DatePicker::make('published_until')
                    ->label(__('filament::pages/admin.tables.published_until'))
                    ->displayFormat(__('filament-pages::filament-pages.filament.form.published_until.displayFormat')),

                Placeholder::make('created_at')
                    ->label(__('filament::pages/admin.tables.created_at'))
                    ->hidden(fn (?Article $record) => $record === null)
                    ->content(fn (Article $record): string => $record->created_at->diffForHumans()),

                Placeholder::make('updated_at')
                    ->label(__('filament::pages/admin.tables.updated_at'))
                    ->hidden(fn (?Article $record) => $record === null)
                    ->content(fn (Article $record): string => $record->updated_at->diffForHumans()),
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

    /**
     * @return Collection<FilamentPageTemplate>
     */
    public static function getTemplateClasses(): Collection
    {
        return collect(config('article-pages.templates', []));
    }

    /**
     * @return Collection<FilamentPageTemplate>
     */
    public static function getTemplates(): Collection
    {
        return static::getTemplateClasses()
            ->mapWithKeys(fn ($class) => [$class => $class::title()]);
    }

    public static function getTemplateName($class): string
    {
        return Str::of($class)->afterLast('\\')->snake()->toString();
    }

    public static function getTemplateSchemas(): array
    {
        return static::getTemplateClasses()
            ->map(fn ($class) => Group::make($class::schema())
                ->afterStateHydrated(fn ($component, $state) => $component->getChildComponentContainer()->fill($state))
                ->statePath('data.content')
                ->visible(fn ($get) => $get('data.template') === $class)
            )
            ->toArray();
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['data.content'] = $data['temp_content'][static::getTemplateName($data['template'])];
        unset($data['temp_content']);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['data.content'] = $data['temp_content'][static::getTemplateName($data['template'])];
        unset($data['temp_content']);

        return $data;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit' => EditArticle::route('/{record:id}/edit'),
            'view' => CreateArticle::route('/{record}'),
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
            RelationGroup::make('Sections', [
                SectionsArticleRelationManager::class,
            ])
        ];
    }
}

