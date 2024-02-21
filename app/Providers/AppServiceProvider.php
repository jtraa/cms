<?php

namespace App\Providers;

use App\Filament\Forms\Components\ModifiedFileUpload;
use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\EmployeeResource;
use App\Filament\Resources\FilamentPageResource;
use App\Filament\Resources\ServiceResource;
use App\Filament\Resources\SettingsResource;
use App\Filament\Resources\UserResource;
use App\Http\Controllers\ServiceController;
use BezhanSalleh\FilamentShield\Resources\RoleResource;
use Filament\Forms\Components\FileUpload;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Policies\UserPolicy;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;
use DutchCodingCompany\FilamentSocialite\Models\SocialiteUser;
use Laravel\Socialite\Contracts\User as UserContract;
use DutchCodingCompany\FilamentSocialite\Facades\FilamentSocialite;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                'Content',
                'Security',
                'Settings',
            ]);
        });

        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            $user = auth()->user();
            $page = $user && $user->can('view_filament::page') ? FilamentPageResource::getNavigationItems() : [];
            $service = $user && $user->can('view_service') ? ServiceResource::getNavigationItems() : [];
            $employee = $user && $user->can('view_employee') ? EmployeeResource::getNavigationItems() : [];
            $article= $user && $user->can('view_article') ? ArticleResource::getNavigationItems() : [];
            $users = $user && $user->can('view_user') ? UserResource::getNavigationItems() : [];
            $role= $user && $user->can('view_shield::role') ? RoleResource::getNavigationItems() : [];
            $settings= $user && $user->can('view_settings') ? SettingsResource::getNavigationItems() : [];

              $builder->items([
                NavigationItem::make(__('filament::pages/admin.menu.dashboard'))
                    ->icon('heroicon-o-home')
                    ->url('/admin')
                    ->isActiveWhen(function () {
                        return request()->is('admin');
                    }),
            ]);
            $contentItems = array_merge($page, $service, $article, $employee);
            if (!empty($contentItems)) {
                $builder->group(
                    NavigationGroup::make(__('filament::pages/admin.menu.content'))
                        ->items($contentItems)
                );
            }

            $securityItems = array_merge($users, $role);
            if (!empty($securityItems)) {
                $builder->group(
                    NavigationGroup::make(__('filament::pages/admin.menu.security'))
                        ->items($securityItems)
                );
            }

            if (!empty($settings)) {
                $builder->group(
                    NavigationGroup::make(__('filament::pages/admin.menu.settings'))
                        ->items($settings)
                );
            }

            return $builder;
//
//              ->groups([
//                NavigationGroup::make(__('filament::pages/admin.menu.content'))
//                    ->items(array_merge(
//                        $page,
//                        $service,
//                        $article,
//                        $employee,
//                    )),
//                NavigationGroup::make(__('filament::pages/admin.menu.security'))
//                    ->items(array_merge(
//                        $users,
//                        $role,
//                    )),
//                  NavigationGroup::make(__('filament::pages/admin.menu.settings'))
//                      ->hidden()
//                    ->items(array_merge(
//                        $settings,
//                    )),
//
//                ]);
//
//            return $builder;
        });

        FilamentSocialite::setCreateUserCallback(fn (SocialiteUserContract $oauthUser, FilamentSocialite $socialite) => $socialite->getUserModelClass()::create([
            'name' => $oauthUser->getName(),
            'email' => $oauthUser->getEmail(),
        ]));



    }
}
