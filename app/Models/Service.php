<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

/**
 * @property string $slug
 * @property string $title
 * @property array{content: array, template: string, templateName: string} data
 * @property \Carbon\CarbonImmutable $published_at
 * @property \Carbon\CarbonImmutable $published_until
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Service extends Model
{
    use HasSEO;
    protected $guarded = [];

    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $casts = [
        'blocks' => 'json',
        'data' => 'json',
        'published_at' => 'immutable_datetime',
        'published_until' => 'immutable_datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            $service->setOrderValue();

            $width = 90;
            $height = 90;

            $originalPath = pathinfo($service->image, PATHINFO_DIRNAME);
            $filename = pathinfo($service->image, PATHINFO_FILENAME);

            $newImage = $filename . '_' . $width . 'x' . $height . '.webp';
            $newImagePath = $originalPath . '/' . $newImage;
            $service->image_with_size = $newImagePath;

            $conversionImage = $filename . '.webp';
            $conversionImagePath = $originalPath . '/' . $conversionImage;
            $service->image_conversion = $conversionImagePath;

            $thumbnail = $filename . '_' . 48 . 'x' . 48 . '.webp';
            $thumbnailPath = $originalPath . '/' . $thumbnail;
            $service->thumbnail = $thumbnailPath;
        });

        static::updating(function ($service) {

            $width = 90;
            $height = 90;

            $originalPath = pathinfo($service->image, PATHINFO_DIRNAME);
            $filename = pathinfo($service->image, PATHINFO_FILENAME);

            $newImage = $filename . '_' . $width . 'x' . $height . '.webp';
            $newImagePath = $originalPath . '/' . $newImage;
            $service->image_with_size = $newImagePath;

            $conversionImage = $filename . '.webp';
            $conversionImagePath = $originalPath . '/' . $conversionImage;
            $service->image_conversion = $conversionImagePath;

            $thumbnail = $filename . '_' . 48 . 'x' . 48 . '.webp';
            $thumbnailPath = $originalPath . '/' . $thumbnail;
            $service->thumbnail = $thumbnailPath;

        });
    }

    public function setOrderValue()
    {
        // Fetch the highest 'order' value from the employees table
        $latestOrder = static::max('order');

        // Increment the order value by 1 for the new record
        $newOrder = $latestOrder + 1;

        // Set the incremented order value for the new employee
        $this->order = $newOrder;
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}

?>
