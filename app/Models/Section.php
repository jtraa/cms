<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Section extends Model implements HasMedia
{
    use HasFactory, SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'order',
        'filament_page_id',
        'data.template',
        'data.templateName',
        'data'
    ];

    protected $casts = [
        'blocks' => 'json',
        'data' => 'json',
        'published_at' => 'immutable_datetime',
        'published_until' => 'immutable_datetime',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('template')
            ->fit(Manipulations::FIT_FILL, 500, 300)
            ->format(Manipulations::FORMAT_WEBP);
    }

    public function filament_page() {
        return $this->belongsTo(FilamentPage::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function article() {
        return $this->belongsTo(Article::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($section) {
            $section->setOrderValue();
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
}
