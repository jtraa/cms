<?php

namespace App\Filament\Custom;

use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Support\FileNamer\FileNamer;

class CustomFileNamer extends FileNamer
{
    public function conversionFileName(string $fileName, Conversion $conversion): string
    {
        $strippedFileName = pathinfo($fileName, PATHINFO_FILENAME);
        $newFileName = "{$strippedFileName}-{$conversion->getName()}";

        // Check if the file already exists
        $count = 1;
        while (file_exists($newFileName)) {
            $newFileName = "{$strippedFileName}-{$conversion->getName()}-{$count}";
            $count++;
        }

        return $newFileName;
    }

    public function responsiveFileName(string $fileName): string
    {
        return pathinfo($fileName, PATHINFO_FILENAME);
    }
}
