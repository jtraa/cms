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
class Article extends Model
{
    protected $guarded = [];

    use HasSEO;

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

        static::creating(function ($article) {
            $article->setOrderValue();

            $width = 444;
            $height = 666;

            if(!empty($article->image)) {
                $originalPath = pathinfo($article->image, PATHINFO_DIRNAME);
                $filename = pathinfo($article->image, PATHINFO_FILENAME);

                $newImage = $filename . '_' . $width . 'x' . $height . '.webp';
                $newImagePath = $originalPath . '/' . $newImage;
                $article->image_with_size = $newImagePath;

                $conversionImage = $filename . '.webp';
                $conversionImagePath = $originalPath . '/' . $conversionImage;
                $article->image_conversion = $conversionImagePath;

                $thumbnail = $filename . '_' . 48 . 'x' . 48 . '.webp';
                $thumbnailPath = $originalPath . '/' . $thumbnail;
                $article->thumbnail = $thumbnailPath;
            } else {
                $article->image_with_size = NULL;
                $article->image_conversion = NULL;
                $article->thumbnail = NULL;
            }
        });

        static::updating(function ($article) {
            $width = 444;
            $height = 666;

            if(!empty($article->image)) {
                $originalPath = pathinfo($article->image, PATHINFO_DIRNAME);
                $filename = pathinfo($article->image, PATHINFO_FILENAME);

                $newImage = $filename . '_' . $width . 'x' . $height . '.webp';
                $newImagePath = $originalPath . '/' . $newImage;
                $article->image_with_size = $newImagePath;

                $conversionImage = $filename . '.webp';
                $conversionImagePath = $originalPath . '/' . $conversionImage;
                $article->image_conversion = $conversionImagePath;

                $thumbnail = $filename . '_' . 48 . 'x' . 48 . '.webp';
                $thumbnailPath = $originalPath . '/' . $thumbnail;
                $article->thumbnail = $thumbnailPath;
            } else {
                $article->image_with_size = NULL;
                $article->image_conversion = NULL;
                $article->thumbnail = NULL;
            }
        });
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function setOrderValue()
    {
        // Fetch the highest 'order' value from the articles table
        $latestOrder = static::max('order');

        // Increment the order value by 1 for the new record
        $newOrder = $latestOrder + 1;

        // Set the incremented order value for the new article
        $this->order = $newOrder;
    }
}

?>
