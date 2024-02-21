<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteMapController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ConvertController;

use App\Models\Article;
use App\Models\Employee;
use App\Models\FilamentPage;
use App\Models\Service;

use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('sitemap', function () {

    SiteMapController::create();

    return 'Sitemap generated successfully.';
});

Route::post('send-mail', [MailController::class, 'index']);

Route::get('/welcome', function() {
    return Inertia::render('Welcome', [
        'component' => 'Welcome',
    ]);
});

Route::redirect('/admin/sections', '/admin/filament-pages');


Route::post('/convert', [ConvertController::class, 'store']);

Route::redirect('/', 'login');
Route::resource('pages', PageController::class);
Route::resource('team', EmployeeController::class)->only(['show']);
Route::resource('diensten', ServiceController::class)->only(['show']);
Route::resource('nieuws', ArticleController::class)->only(['show']);

Route::group(['middleware' => ['web', 'guest']], function(){
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('/auth/callback', [AuthController::class, 'connect'])->name('connect');
});

Route::group(['middleware' => ['web', 'MsGraphAuthenticated'], 'prefix' => 'app'], function(){
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});


Route::get('/{page}', [PageController::class, 'show'])->where('page', '[a-zA-Z0-9\-_\/]+');
Route::get('/team/{slug}', [EmployeeController::class, 'show'])->where('slug', '[a-zA-Z0-9\-_\/]+')->name('employees.show');
Route::get('/diensten/{slug}', [ServiceController::class, 'show'])->where('slug', '[a-zA-Z0-9\-_\/]+')->name('services.show');
Route::get('/nieuws/{slug}', [ArticleController::class, 'show'])->where('slug', '[a-zA-Z0-9\-_\/]+')->name('articles.show');

Route::get('/pagesfilament', [PageController::class, 'index']);
Route::resource('contents', ContentController::class);
Route::redirect('/admin/settings', '/admin/settings/1');
Route::redirect('/', '/home')->name('root');


Route::get('mail', function () {
    return view('mails/MyTestMail');
});
Route::resource('mails', MailController::class);
