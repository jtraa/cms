<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFormRequest as Request;
use App\Mail\SendMail;
use App\Models\Article;
use App\Models\Employee;
use App\Models\Mail as ContactForm;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use App\Models\FilamentPage;

class SiteMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function create()
    {
        $url = url()->current();
        $baseUrl = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);

        $today = Carbon::today();
        $sitemap = Sitemap::create($baseUrl);

        $filamentPages = FilamentPage::query()
            ->whereDate('published_at', '<', Carbon::now())
            ->where(function ($query) {
                $query->whereDate('published_until', '>=', Carbon::now())
                    ->orWhereNull('published_until');
            })
            ->orderBy('order', 'asc')
            ->get();

        $serviceSlug = FilamentPage::find(1);
        $articleSlug = FilamentPage::find(8);
        $employeeSlug = FilamentPage::find(9);

        $articles = Article::query()
            ->whereDate('published_at', '<', Carbon::now())
            ->where(function ($query) {
                $query->whereDate('published_until', '>=', Carbon::now())
                    ->orWhereNull('published_until');
            })
            ->orderBy('order', 'asc')
            ->get();

        $services = Service::query()
            ->whereDate('published_at', '<', Carbon::now())
            ->where(function ($query) {
                $query->whereDate('published_until', '>=', Carbon::now())
                    ->orWhereNull('published_until');
            })
            ->orderBy('order', 'asc')
            ->get();

        $employees = Employee::query()
            ->whereDate('published_at', '<', Carbon::now())
            ->where(function ($query) {
                $query->whereDate('published_until', '>=', Carbon::now())
                    ->orWhereNull('published_until');
            })
            ->orderBy('order', 'asc')
            ->get();

        foreach ($filamentPages as $page) {
            $sitemap->add(Url::create('/' . $page->slug)
                ->setLastModificationDate($page->updated_at));
        }
        foreach ($services as $service) {
            $sitemap->add(Url::create('/' . $serviceSlug->slug . '/' . $service->slug)
                ->setLastModificationDate($service->updated_at));
        }
        foreach ($articles as $article) {
            $sitemap->add(Url::create('/' . $articleSlug->slug . '/' . $article->slug)
                ->setLastModificationDate($article->updated_at));
        }
        foreach ($employees as $employee) {
            $sitemap->add(Url::create('/' . $employeeSlug->slug . '/' . $employee->slug)
                ->setLastModificationDate($employee->updated_at));
        }
        $sitemap->writeToFile('sitemap.xml');
    }
}
