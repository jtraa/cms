<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Employee;
use App\Models\FilamentPage;
use App\Models\Service;
use App\Models\Settings;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Sitemap\SitemapGenerator;

class PageController extends Controller
{
    public function index()
    {

    }

    public function show($slug)
    {

        $today = Carbon::today();

        $page = FilamentPage::where('slug', $slug)
            ->where(function ($query) use ($today) {
                $query->where('published_until', '>=', $today)
                    ->orWhereNull('published_until');
            })
            ->where('published_at', '<=', $today)
            ->with(['seo', 'sections' => function ($query) {
                $query->orderBy('order', 'asc');
            }, 'sections.media'])
            ->firstOrFail();

        $filamentPages = FilamentPage::all();
        $settings = Settings::where('id', 1)->firstOrFail();

        $pages = $filamentPages
            ->where('in_menu', '!=', 0)
            ->where('published_at', '<=', $today)
            ->sortBy('order')
        ;

        $services = Service::with( 'sections')
            ->where(function ($query) use ($today) {
                $query->where('published_until', '>=', $today)
                    ->orWhereNull('published_until');
            })
            ->where('published_at', '<=', $today)->get();

        $employees = Employee::with( 'seo')
            ->where(function ($query) use ($today) {
                $query->where('published_until', '>=', $today)
                    ->orWhereNull('published_until');
            })
            ->where('published_at', '<=', $today)->get();

        $articles = Article::with('sections')
            ->where(function ($query) use ($today) {
                $query->where('published_until', '>=', $today)
                    ->orWhereNull('published_until');
            })
            ->where('published_at', '<=', $today)->get();;

        $data = [
            'page' => $page,
            'pages' => $pages,
            'services' => $services,
            'employees' => $employees,
            'articles' => $articles,
            'settings' => $settings,

        ];

        $this->seo($page, $settings);

        return view('pages_website.show', compact('data'));
    }

    public function seo($page, $settings)
    {
        $url = url()->current();
        $baseUrl = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);

        $sections = json_decode($page->sections);
        $collection = new Collection($sections);

        $firstFilledSection = $collection->first(function ($section) {
            if (isset($section->data))
            {
                $content = $section->data->content;
                if (isset($content->paragraphText) && trim(strip_tags($content->paragraphText)) !== '') {
                    return true;
                }
                return false;
            }
            return false;
        });

        $firstImageSection = $collection->first(function ($section) {
            if (isset($section->data)) {
                $content = $section->data->content;
                if (isset($content->imageConverted)) {
                    return true;
                }
                if (isset($content->images)) {
                    foreach ($content->images as $image) {
                        if (isset($image->imageConverted)) {
                            return true;
                        }
                    }
                    return false;
                }
                if (isset($content->gallery)) {
                    foreach ($content->gallery as $image) {
                        if (isset($image->imageConverted)) {
                            return true;
                        }
                    }
                    return false;
                }

            }
            return false;
        });

        if($firstImageSection) {
            $imageSection = null;

            if (isset($firstImageSection->data->content->imageConverted)) {
                $imageSection = $firstImageSection->data->content->imageConverted;
            } else if (is_array($firstImageSection->data->content->images)) {
                $imageSection = $firstImageSection->data->content->images[0]->imageConverted;
            }  else if (isset($firstImageSection->data->content->gallery[0]->imageConverted)) {
                $imageSection = $firstImageSection->data->content->gallery[0]->imageConverted;
            }
            OpenGraph::addImage($baseUrl . '/uploads/' . $imageSection);
            TwitterCard::setImage($baseUrl . '/uploads/' . $imageSection);
        } else {
            OpenGraph::addImage($baseUrl . '/uploads/' . $settings->image);
            TwitterCard::setImage($baseUrl . '/uploads/' . $settings->image);
        }

        if ($page->seo->description != null) {
            SEOMeta::setDescription($page->seo->description);
            OpenGraph::setDescription($page->seo->description);
            TwitterCard::setDescription($page->seo->description);
        } else if ($firstFilledSection) {

            $paragraphText = $firstFilledSection->data->content->paragraphText;
            $paragraphTextWithoutHtml = strip_tags($paragraphText);

            $paragraphTextWithoutHtmlAndNbsp = str_replace("&nbsp;", "", $paragraphTextWithoutHtml);
            $paragraphTextWithoutHtmlAndNbspAndDash = str_replace("&ndash;", "-", $paragraphTextWithoutHtmlAndNbsp);
            $paragraphTextWithoutNewlines = preg_replace("/\r|\n/", " ", $paragraphTextWithoutHtmlAndNbspAndDash);

            $first_150_chars = Str::substr($paragraphTextWithoutNewlines, 0, 160);

            SEOMeta::setDescription($first_150_chars);
            OpenGraph::setDescription($first_150_chars);
            TwitterCard::setDescription($first_150_chars);
        } else {
            SEOMeta::setDescription($settings->description);
            OpenGraph::setDescription($settings->description);
            TwitterCard::setDescription($settings->description);
        }

        if ($page->seo->title != null) {
            SEOMeta::setTitle($page->seo->title . ' | ' . $settings->companyname);
            OpenGraph::setTitle($page->seo->title . ' | ' . $settings->companyname);
            TwitterCard::setTitle($page->seo->title . ' | ' . $settings->companyname)
                ->addValue('card', 'summary_large_image')
                ->setUrl($url)
                ->setSite($baseUrl);
        } else {
            SEOMeta::setTitle($page->title . ' | ' . $settings->companyname);
            OpenGraph::setTitle($page->title . ' | ' . $settings->companyname);
            TwitterCard::setTitle($page->title . ' | ' . $settings->companyname)
                ->addValue('card', 'summary_large_image')
                ->setUrl($url)
                ->setSite($baseUrl);
        }

        SEOMeta::addKeyword([$page->slug, $settings->companyname, $page->seo->description]);
        OpenGraph::setUrl($baseUrl)
            ->addProperty('type', 'page')
            ->addProperty('locale', 'nl-NL')
            ->addProperty('locale:alternate', ['nl-NL', 'en-US']);

    }
}
