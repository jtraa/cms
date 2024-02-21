<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property string $slug
 * @property string $title
 * @property array{content: array, template: string, templateName: string} data
 * @property \Carbon\CarbonImmutable $published_at
 * @property \Carbon\CarbonImmutable $published_until
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Settings extends Model
{
    protected $guarded = [];

    protected $casts = [
        'blocks' => 'json',
        'data' => 'json',
        'published_at' => 'immutable_datetime',
        'published_until' => 'immutable_datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($settings) {
            $width = 250;
            $height = 80;

            $originalPath = pathinfo($settings->image, PATHINFO_DIRNAME);
            $filename = pathinfo($settings->image, PATHINFO_FILENAME);

            $newImage = $filename . '_' . $width . 'x' . $height . '.webp';
            $newImagePath = $originalPath . '/' . $newImage;
            $settings->image_with_size = $newImagePath;

            $conversionImage = $filename . '.webp';
            $conversionImagePath = $originalPath . '/' . $conversionImage;
            $settings->image_conversion = $conversionImagePath;
        });
    }
}

?>
