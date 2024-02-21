<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\File;

class ConvertController extends Controller
{
    public $newFileName;

    public function store()
    {

        $directory = $this->getDirectoryPathForEditor();

        $file = request()->file('file');

        $fileName = $file->getClientOriginalName();
        $fileName = strtolower($fileName);
        $fileName = str_replace(' ', '', $fileName);
        $extension = $file->getClientOriginalExtension();

        $uploadsDirectory = "public/uploads/{$directory}";
        if (!Storage::exists($uploadsDirectory)) {
            Storage::makeDirectory($uploadsDirectory, 0755, true);
        }

        $imgpath = $file->storeAs("/storage/app/public/uploads/{$directory}", $fileName, 'uploads');

        if($extension != 'svg') {
            $webpStoragePath = 'app/public/uploads/' . $directory . '/' . pathinfo($imgpath, PATHINFO_FILENAME) . '.webp';
            $webpStoragePath2 = 'app/public/uploads/' . $directory . '/' . $fileName;

            Image::load($file)
                ->format(Manipulations::FORMAT_WEBP)
                ->save($this->getUniqueFilePath($webpStoragePath));

            Image::load($file)
                ->save($this->getUniqueFilePath($webpStoragePath2));

            $webpPath = 'uploads/' . $directory . '/' . $this->newFileName . '.webp';

            return response()->json(['location' => '/' . $webpPath]);
        } else {
            $webpPath = 'uploads/' . $directory . '/' . $fileName;
            return response()->json(['location' => '/' . $webpPath]);
        }
    }

    public function fileUpload($file, $width, $height, $directory, $generateThumbnails = false, $thumbnailWidth = null, $thumbnailHeight = null)
    {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = strtolower($fileName);
        $fileName = str_replace(' ', '', $fileName);
        $extension = $file->getClientOriginalExtension();

        $counter = 0;

        if ($directory == null) {
            $directory = '';
        }

        $uniqueFileName = $fileName;

        while (Storage::disk('uploads')->exists("{$directory}/{$uniqueFileName}.{$extension}")) {
            $counter++;
            $uniqueFileName = $fileName . '_' . $counter;
        }

        $file->storeAs('', "{$directory}/{$uniqueFileName}.{$extension}", 'uploads');
        $storageImgPath = '' . "{$directory}/{$uniqueFileName}.{$extension}";

        if($extension != 'svg') {

            $webpStoragePath = ''. "{$directory}/{$uniqueFileName}" .'.webp';
            $webpStoragePath2 = ''. "{$directory}/{$uniqueFileName}" . '_' . $width . 'x' . $height . '.webp';

            Image::load(Storage::disk('uploads')->path($storageImgPath))
                ->format(Manipulations::FORMAT_WEBP)
                ->save(Storage::disk('uploads')->path($webpStoragePath));

            Image::load(Storage::disk('uploads')->path($storageImgPath))
                ->format(Manipulations::FORMAT_WEBP)
                ->fit(Manipulations::FIT_CROP, $width, $height)
                ->save(Storage::disk('uploads')->path($webpStoragePath2));
        }

        if ($generateThumbnails) {
            if($extension != 'svg') {
                $webpStoragePath2 = "{$directory}/{$uniqueFileName}" . '_' . $thumbnailWidth . 'x' . $thumbnailHeight . '.webp';
                Image::load(Storage::disk('uploads')->path($storageImgPath))
                    ->format(Manipulations::FORMAT_WEBP)
                    ->fit(Manipulations::FIT_CROP, $thumbnailWidth, $thumbnailHeight)
                    ->save(Storage::disk('uploads')->path($webpStoragePath2));
            }
        }


        return (string) str("{$directory}/{$uniqueFileName}.{$extension}");
    }

    private function getUniqueFilePath($path)
    {
        $slug = 'slug';
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = pathinfo($path, PATHINFO_FILENAME). '_' . $slug;
        $dirName = pathinfo($path, PATHINFO_DIRNAME);

        $counter = 0;

        $uniqueFileName = $fileName;
        while (file_exists(storage_path($dirName . '/' . $uniqueFileName . '.' . $extension))) {
            $counter++;
            $uniqueFileName = $fileName . '_' . $counter;
        }

        $this->newFileName = $uniqueFileName;

        return storage_path($dirName . '/' . $uniqueFileName . '.' . $extension);
    }

    public function getDirectoryPath($record)
    {
        if($record != null) {

            switch (true) {
                case $record['service_id'] != null:
                    $directory = "services/{$record['service_id']}";
                    break;

                case $record['article_id'] != null:
                    $directory = "articles/{$record['article_id']}";
                    break;

                case $record['filament_page_id'] != null:
                    $directory = "pages/{$record['filament_page_id']}";
                    break;
            }

        } else {
            $request = request();
            $payload = json_decode($request->getContent(), true);

            $filamentPageId = $payload['serverMemo']['data']['data']['filament_page_id'];
            $articleId = $payload['serverMemo']['data']['data']['article_id'];
            $serviceId = $payload['serverMemo']['data']['data']['service_id'];

            switch (true) {
                case $serviceId != null:
                    $directory = "services/{$serviceId}";
                    break;

                case $articleId != null:
                    $directory = "articles/{$articleId}";
                    break;

                case $filamentPageId != null:
                    $directory = "pages/{$filamentPageId}";
                    break;
            }
        }
        return $directory;
    }
    public function getDirectoryPathForEditor()
    {
        $request = request();
        $referer = $request->server->get('HTTP_REFERER');
        $segments = explode('/', $referer);
        $idSegment = $segments[count($segments) - 2];
        $id = intval($idSegment);

        if (!empty($id))
        {
            $section = Section::find($id);
            $articleId = $section->article_id;
            $filamentPageId = $section->filament_page_id;
            $serviceId = $section->service_id;

            switch (true) {
                case !empty($filamentPageId):
                    $directory = "pages/{$filamentPageId}";
                    break;

                case !empty($serviceId):
                    $directory = "services/{$serviceId}";
                    break;

                case !empty($articleId):
                    $directory = "articles/{$articleId}";
                    break;
            }
        } else {
            $queryString = parse_url($referer, PHP_URL_QUERY);
            parse_str($queryString, $queryParameters);
            $pageRecord = $queryParameters['pageRecord'] ?? null;
            $serviceRecord = $queryParameters['serviceRecord'] ?? null;
            $articleRecord = $queryParameters['articleRecord'] ?? null;

            switch (true) {
                case !empty($pageRecord):
                    $directory = "pages/{$pageRecord}";
                    break;

                case !empty($serviceRecord):
                    $directory = "services/{$serviceRecord}";
                    break;

                case !empty($articleRecord):
                    $directory = "articles/{$articleRecord}";
                    break;
            }
        }


        return $directory;
    }

    public function getPathForSection($newFile, $width, $height, $set)
    {
        $originalPath = pathinfo($newFile, PATHINFO_DIRNAME);
        $filename = pathinfo($newFile, PATHINFO_FILENAME);

        $newImage = $filename . '_' . $width . 'x' . $height . '.webp';
        $newImagePath = $originalPath . '/' . $newImage;
        $set('imageWithSize', $newImagePath);

        $conversionImage = $filename . '.webp';
        $conversionImagePath = $originalPath . '/' . $conversionImage;
        $set('imageConverted', $conversionImagePath);
    }

}
