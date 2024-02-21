<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Http\Controllers\ConvertController;
use App\Models\Article;
use App\Models\FilamentPage;
use App\Models\Service;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;
//use RalphJSmit\Filament\SEO\SEO;
use App\Filament\Components\SEO;
use Spatie\Image\Manipulations;
use App\Models\Employee;
use Spatie\Image\Image;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Support\Str;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Components\CustomTinyEditor;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;

class EmployeeResource extends Resource
{
    public static function getModelLabel(): string
    {
        return __('filament::pages/admin.menu.employee');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament::pages/admin.menu.employees');
    }

    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Content';

    protected static function getNavigationLabel(): string
    {
        return __('filament::pages/admin.menu.employees');
    }

    protected static ?int $navigationSort = 2;

    protected static function getResourceId(?Employee $record): ?int
    {
        return $record ? $record->id : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::getPrimaryColumnSchema(),
                static::getSecondaryColumnSchema(),
            ]);
    }

    public static function getPrimaryColumnSchema() {
        $firstState = '';
        return Grid::make(4)
            ->schema([

                TextInput::make('first_name')
                    ->label(__('filament::pages/admin.tables.first_name'))
                    ->columnSpan(1)
                    ->required()
                    ->lazy()
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                TextInput::make('last_name')
                    ->label(__('filament::pages/admin.tables.last_name'))
                    ->columnSpan(1)
                    ->required()
                    ->lazy()
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                TextInput::make('telephone')->label(__('filament::pages/admin.tables.phone'))->required()->columnSpan(2),
                TextInput::make('email')->label(__('filament::pages/admin.tables.email'))->required()->columnSpan(1),
                DatePicker::make('published_at')
                    ->label(__('filament::pages/admin.tables.published_at'))
                    ->displayFormat(__('filament-pages::filament-pages.filament.form.published_at.displayFormat'))
                    ->columnSpan(1)
                    ->required()
                    ->default(now()),
                DatePicker::make('published_until')
                    ->label(__('filament::pages/admin.tables.published_until'))
                    ->columnSpan(1)
                    ->displayFormat(__('filament-pages::filament-pages.filament.form.published_until.displayFormat')),
                Toggle::make('in_index')->columnSpan(1)->inline(false)
                    ->label(__('filament::pages/admin.tables.in_index'))
            ]);
    }

    public static function getSecondaryColumnSchema() {
            return Grid::make(2)
                ->schema([
                    FileUpload::make('image')
                        ->label(__('filament::pages/admin.tables.image'))
                        ->disk('uploads')
                        ->columnSpan(2)
                        ->preserveFilenames()
                        ->image()
                        ->imageResizeMode('cover')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, ?Employee $record): string {

                            if(static::getResourceId($record) != null) {
                                $id = static::getResourceId($record);
                            } else {
                                $latestService = Employee::latest()->first();
                                $id = $latestService->id + 1;
                            }
                            $width = 444;
                            $height = 666;
                            $directory = "employees/{$id}";

                            $convertController = new ConvertController();
                            $newFile = $convertController->fileUpload($file, $width, $height, $directory, true, 48, 48);

                            return (string) str($newFile);
                        }),
                    CustomTinyEditor::make('about')
                        ->label(__('filament::pages/admin.tables.about'))
                        ->profile('default')
                        ->fileAttachmentsDisk('uploads')->fileAttachmentsVisibility('public')
                        ->language('nl')
                        ->columnSpan(2)
                        ->minHeight(300)
                        ->required(),
                    SEO::make()->columnSpan(2),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')->disk('uploads')->label(__('filament::pages/admin.tables.image'))->square(),
                TextColumn::make('first_name')->label(__('filament::pages/admin.tables.first_name')),
                TextColumn::make('last_name')->label(__('filament::pages/admin.tables.last_name')),
                TextColumn::make('slug')
                    ->label(__('filament-pages::filament-pages.filament.form.slug.label'))
                    ->icon('heroicon-o-external-link')
                    ->iconPosition('after')
                    ->getStateUsing(fn (Employee $record) => url('/' . FilamentPage::where('id', 9)->firstOrFail()->slug . '/' . $record->slug))
                    ->searchable()
                    ->url(function (Employee $record) {
                        return url('/' . FilamentPage::where('id', 9)->firstOrFail()->slug . '/' . $record->slug);
                    }, true)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('status')->label(__('filament::pages/admin.tables.status'))
                    ->getStateUsing(function (Employee $record): string {
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
                BadgeColumn::make('In Index')->label(__('filament::pages/admin.tables.in_index'))
                    ->getStateUsing(fn (Employee $record): string => $record->in_menu == 1 ?? true ? __('filament::pages/admin.status.yes') : __('filament::pages/admin.status.no'))
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
            ->actions([
            ReplicateAction::make()
                ->excludeAttributes(['title'])
                ->form([
                    TextInput::make('first_name')
                        ->label(__('filament::pages/admin.tables.first_name'))
                        ->columnSpan(1)
                        ->required()
                        ->lazy()
                        ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                    TextInput::make('last_name')
                        ->label(__('filament::pages/admin.tables.last_name'))
                        ->columnSpan(1)
                        ->required()
                        ->lazy()
                        ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                ])
                ->beforeReplicaSaved(function (Employee $replica, array $data): void {
                    $replica->fill($data);
                }),
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ])->reorderable('order')->defaultSort('order');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
