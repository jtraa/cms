<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Settings;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\Request;
use App\Models\FilamentPage;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {

    }

    public function show($slug)
    {
        $today = Carbon::today();

        $employee = Employee::where('slug', $slug)
            ->where(function ($query) use ($today) {
                $query->where('published_until', '>=', $today)
                    ->orWhereNull('published_until');
            })
            ->where('published_at', '<=', $today)
            ->firstOrFail();

        $filamentPages = FilamentPage::all();

        $pages = $filamentPages
            ->where('in_menu', '!=', 0)
            ->where('published_at', '<=', $today)
            ->sortBy('order')
        ;
        $employeePage =
            FilamentPage::where('id', 9)->firstOrFail();
        ;
        $services = Service::with( 'sections')
            ->where(function ($query) use ($today) {
                $query->where('published_until', '>=', $today)
                    ->orWhereNull('published_until');
            })
            ->where('published_at', '<=', $today)->get();
        $settings = Settings::where('id', 1)->firstOrFail();

        $employeeData = [
            'employee' => $employee,
            'pages' => $pages,
            'services' => $services,
            'settings' => $settings,
            'employeePage' => $employeePage,
        ];

        $this->seo($employee, $settings, $employeePage);


        return view('pages_website.show', compact('employeeData'));
    }

    public function seo($employee, $settings, $employeePage)
    {
        $url = url()->current();
        $baseUrl = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);

        if ($employee->seo->description != null) {
            SEOMeta::setDescription($employee->seo->description);
            OpenGraph::setDescription($employee->seo->description);
            TwitterCard::setDescription($employee->seo->description);
        }  else {
            $employeeAbout = htmlspecialchars(strip_tags($employee->about));
            $description = substr($employeeAbout, 0, 160);

            SEOMeta::setDescription($description);
            OpenGraph::setDescription($description);
            TwitterCard::setDescription($description);
        }
        if ($employee->seo->title != null) {
            SEOMeta::setTitle($employee->seo->title . ' | ' . $employeePage->title . ' | ' .$settings->companyname);
            OpenGraph::setTitle($employee->seo->title . ' | ' . $employeePage->title . ' | ' .$settings->companyname);
            TwitterCard::setTitle($employee->seo->title . ' | ' . $employeePage->title . ' | ' .$settings->companyname)
                ->addValue('card', 'summary_large_image')
                ->setUrl($url)
                ->setSite($baseUrl);
        } else {
            SEOMeta::setTitle($employee->first_name . ' ' . $employee->last_name . ' | ' . $employeePage->title . ' | ' .$settings->companyname);
            OpenGraph::setTitle($employee->first_name . ' ' . $employee->last_name . ' | ' . $employeePage->title . ' | ' .$settings->companyname);
            TwitterCard::setTitle($employee->first_name . ' ' . $employee->last_name . ' | ' . $employeePage->title . ' | ' .$settings->companyname)
                ->addValue('card', 'summary_large_image')
                ->setUrl($url)
                ->setSite($baseUrl);
        }

        OpenGraph::addImage($baseUrl . '/uploads/' . $employee->image_conversion);
        TwitterCard::setImage($baseUrl . '/uploads/' . $employee->image_conversion);

        SEOMeta::addKeyword([$employee->slug, $settings->companyname, $employee->seo->description]);
        OpenGraph::setUrl($baseUrl)
            ->addProperty('type', 'page')
            ->addProperty('locale', 'nl-NL')
            ->addProperty('locale:alternate', ['nl-NL', 'en-US']);

        SEOMeta::addMeta('article:published_time', $employee->published_at->toW3CString(), 'property')
            ->addMeta('article:modified_time', $employee->updated_at->toW3CString(), 'property')
            ->addMeta('article:section', 'Medewerker', 'property');

        OpenGraph::setType('article')
            ->setArticle([
                'published_time' => $employee->published_at->toW3CString(),
                'modified_time' => $employee->updated_at->toW3CString(),
                'author' => $settings->companyname,
                'section' => 'Team',
            ]);
    }
}
