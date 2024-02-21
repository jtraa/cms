<?php

namespace App\Filament\Resources;

use Beier\FilamentPages\Contracts\FilamentPageTemplate;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use App\Filament\Resources\SectionResource\Pages;
use App\Models\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Suleymanozev\FilamentRadioButtonField\Forms\Components\RadioButton;

class SectionResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                        static::getPrimaryColumnSchema(),
                        ...static::getTemplateSchemas(),
                        static::getSecondaryColumnSchema(),
                    ])
                    ->columnSpan(['lg' => 7]),
            ])
            ->columns([
                'xs' => 6,
                'lg' => 9,
            ]);
    }
    public static function getSecondaryColumnSchema(): Component
    {
        return Fieldset::make('id')
            ->schema([
                Select::make('filament_page_id')
                    ->relationship('filament_page', 'id')
                    ->default(request()->query('pageRecord'))
                ,
                Select::make('service_id')
                    ->relationship('service', 'id')
                    ->default(request()->query('serviceRecord'))
                ,
                Select::make('article_id')
                    ->relationship('article', 'id')
                    ->default(request()->query('articleRecord'))
            ]);
    }

    public static function getPrimaryColumnSchema(): Component
    {
        return Card::make()
            ->schema([
                ...static::insertBeforePrimaryColumnSchema(),
                RadioButton::make('data.template')
                    ->reactive()
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $set('data.templateName', Str::snake(self::getTemplateName($state))))
                    ->afterStateHydrated(fn (string $context, $state, callable $set) => $set('data.templateName', Str::snake(self::getTemplateName($state))))
                    ->options(
                        collect(static::getTemplates())->map(function ($template) {
                            return '<img class="w-screen" src="' . Storage::disk('uploads')->url('placeholders/placeholder-smaller.jpg') . '"><p style="font-size: .875rem; margin-left: 10px; margin-right: 10px;"> ' . htmlentities($template) . '</p>';
                        })->toArray()
                    )->columns(3)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('title', Str::title(preg_replace('/^.+\\\\/', '', $state))) : null),

                Hidden::make('title'),

                Hidden::make('data.templateName')

                    ->reactive(),
                ...static::insertAfterPrimaryColumnSchema(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label(__('filament::pages/admin.tables.title')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn ($record) => $record->fixed_section == 1),
            ])
            ->bulkActions([
            ]);
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
        return collect(config('filament-pages.templates', []));
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

        dd($data);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['data.content'] = $data['temp_content'][static::getTemplateName($data['template'])];
        unset($data['temp_content']);

        dd($data);

        return $data;
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
