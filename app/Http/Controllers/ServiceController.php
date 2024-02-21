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

class ServiceController extends Controller
{
    public function index()
    {

    }

    public function show($slug)
    {
        $today = Carbon::today();

        $service = Service::where('slug', $slug)
            ->where(function ($query) use ($today) {
                $query->where('published_until', '>=', $today)
                    ->orWhereNull('published_until');
            })
            ->where('published_at', '<=', $today)
            ->with(['sections' => function ($query) {
        $query->orderBy('order', 'asc');
    }])->firstOrFail();

        $filamentPages = FilamentPage::all();

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
        $settings = Settings::where('id', 1)->firstOrFail();

        $servicePage =
            FilamentPage::where('id', 1)->firstOrFail();
        ;

        $serviceData = [
            'service' => $service,
            'pages' => $pages,
            'services' => $services,
            'settings' => $settings,
            'servicePage' => $servicePage,
        ];

        $this->seo($service, $settings, $servicePage);

        return view('pages_website.show', compact('serviceData'));
    }

    public function seo($service, $settings, $servicePage)
    {
        $url = url()->current();
        $baseUrl = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);

        $sections = json_decode($service->sections);
        $collection = new Collection($sections);

        $firstFilledSection = $collection->first(function ($section) {
            $content = $section->data->content;
            if (isset($content->paragraphText) && trim(strip_tags($content->paragraphText)) !== '') {
                return true;
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

        if ($service->seo->description != null) {
            SEOMeta::setDescription($service->seo->description);
            OpenGraph::setDescription($service->seo->description);
            TwitterCard::setDescription($service->seo->description);
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

        OpenGraph::setUrl($baseUrl)
            ->addProperty('type', 'page')
            ->addProperty('locale', 'nl-NL')
            ->addProperty('locale:alternate', ['nl-NL', 'en-US']);

        if ($service->seo->title != null) {
            SEOMeta::setTitle($service->seo->title . ' | ' . $servicePage->title . ' | ' .$settings->companyname);
            OpenGraph::setTitle($service->seo->title . ' | ' . $servicePage->title . ' | ' .$settings->companyname);
            TwitterCard::setTitle($service->seo->title . ' | ' . $servicePage->title . ' | ' .$settings->companyname)
                ->addValue('card', 'summary_large_image')
                ->setUrl($url)
                ->setSite($baseUrl);
        } else {
            SEOMeta::setTitle($service->title . ' | ' . $servicePage->title . ' | ' .$settings->companyname);
            OpenGraph::setTitle($service->title . ' | ' . $servicePage->title . ' | ' .$settings->companyname);
            TwitterCard::setTitle($service->title . ' | ' . $servicePage->title . ' | ' .$settings->companyname)
                ->addValue('card', 'summary_large_image')
                ->setUrl($url)
                ->setSite($baseUrl);
        }

        SEOMeta::addMeta('article:published_time', $service->published_at->toW3CString(), 'property')
            ->addMeta('article:modified_time', $service->updated_at->toW3CString(), 'property')
            ->addMeta('article:section', 'Dienst', 'property')
            ->addKeyword([$service->slug, $settings->companyname, $service->seo->description]);

        OpenGraph::setType('article')
            ->setArticle([
                'published_time' => $service->published_at->toW3CString(),
                'modified_time' => $service->updated_at->toW3CString(),
                'author' => $settings->companyname,
                'section' => 'Dienst',
            ]);
    }
}
