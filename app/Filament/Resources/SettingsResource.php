<?php

namespace App\Filament\Resources;

use App\Filament\Components\CustomTinyEditor;
use App\Filament\Resources\SettingsResource\Pages;
use App\Filament\Resources\SettingsResource\Pages\CreateSettings;
use App\Filament\Resources\SettingsResource\Pages\EditSettings;
use App\Filament\Resources\SettingsResource\Pages\ListSettings;
use App\Filament\Resources\SettingsResource\Pages\ViewSettings;
use App\Filament\Resources\SettingsResource\RelationManagers;
use App\Http\Controllers\ConvertController;
use App\Models\Employee;
use App\Models\Settings;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class SettingsResource extends Resource
{

    public static function getModelLabel(): string
    {
        return __('filament::pages/admin.menu.settings');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament::pages/admin.menu.settings');
    }

    protected static function getNavigationLabel(): string
    {
        return __('filament::pages/admin.menu.settings');
    }

    protected static function getNavigationGroup(): string
    {
        return __('filament::pages/admin.menu.settings');
    }

    protected static ?int $navigationSort = 1;
    protected static ?string $model = Settings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('companyname')->label(__('filament::pages/admin.settings.company_name'))->required(),
                TextInput::make('address')->label(__('filament::pages/admin.settings.address'))->required(),
                TextInput::make('housenumber')->label(__('filament::pages/admin.settings.house_number'))->required(),
                TextInput::make('postalcode')->label(__('filament::pages/admin.settings.postal_code'))->required(),
                TextInput::make('city')->label(__('filament::pages/admin.settings.city'))->required(),
                TextInput::make('telephonenumber')->label(__('filament::pages/admin.settings.telephone'))->required(),
                TextInput::make('email')->label(__('filament::pages/admin.settings.email'))->email()->required(),
                TextInput::make('kvk')->label(__('filament::pages/admin.settings.kvk'))->required(),
                TextInput::make('btw')->label(__('filament::pages/admin.settings.btw'))->required(),
                TextInput::make('websitename')->label(__('filament::pages/admin.settings.website_name'))->required(),
                TextInput::make('description')->label(__('filament::pages/admin.settings.description_website'))->required(),
                TextInput::make('linkedinlink')->label(__('filament::pages/admin.settings.linkedin_link')),
                TextInput::make('instagramlink')->label(__('filament::pages/admin.settings.instagram_link')),
                TextInput::make('facebooklink')->label(__('filament::pages/admin.settings.facebook_link')),
                TextInput::make('googlemapslink')->label(__('filament::pages/admin.settings.googlemaps_link')),
                TextInput::make('recaptchakey')->label(__('filament::pages/admin.settings.recaptcha_key'))->required(),
                CustomTinyEditor::make('footertext')->label(__('filament::pages/admin.settings.footer_text'))
                    ->profile('default')
                    ->fileAttachmentsDisk('uploads')->fileAttachmentsVisibility('public')
                    ->language('nl')
                    ->columnSpan(2),
                FileUpload::make('image')
                    ->label(__('filament::pages/admin.settings.image'))
                    ->disk('uploads')
                    ->columnSpan(2)
                    ->preserveFilenames()
                    ->image()
                    ->imageResizeMode('cover')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {

                        $width = 250;
                        $height = 80;
                        $directory = "settings";

                        $convertController = new ConvertController();
                        $newFile = $convertController->fileUpload($file, $width, $height, $directory);

                        return (string) str($newFile);
                    }),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyname')->label('Company Name'),
                TextColumn::make('address')->label('Address'),
                TextColumn::make('housenumber')->label('House Number'),
                TextColumn::make('postalcode')->label('Postal Code'),
                TextColumn::make('city')->label('City'),
                TextColumn::make('telephonenumber')->label('Telephone Number'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('kvk')->label('KVK (Dutch Chamber of Commerce) Number'),
                TextColumn::make('btw')->label('BTW (Dutch VAT) Number'),
                TextColumn::make('websitename')->label('Website Name Online'),
                TextColumn::make('description')->label('Description Website'),
                TextColumn::make('linkedinlink')->label('LinkedIn Link'),
                TextColumn::make('googlemapslink')->label('Google Maps Link'),
                TextColumn::make('recaptchakey')->label('Recaptcha Key'),

            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            ]);
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
            'index' => ListSettings::route('/'),
            'view' => ViewSettings::route('/{record:id}'),
            'edit' => EditSettings::route('/{record:id}/edit'),
        ];
    }
}
