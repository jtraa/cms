<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\Thumbnail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

class Employee extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasSEO;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $casts = [
        'blocks' => 'json',
        'data' => 'json',
        'published_at' => 'immutable_datetime',
        'published_until' => 'immutable_datetime',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'telephone',
        'about',
        'image',
        'image_with_size',
        'image_conversion',
        'order',
        'published_at',
        'published_until',
        'slug',
        'in_index',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            $employee->setOrderValue();
            $slug = Str::slug($employee->first_name . '-' . $employee->last_name);
            $employee->slug = $slug;

            $width = 444;
            $height = 666;

            if(!empty($employee->image)) {
                $originalPath = pathinfo($employee->image, PATHINFO_DIRNAME);
                $filename = pathinfo($employee->image, PATHINFO_FILENAME);

                $newImage = $filename . '_' . $width . 'x' . $height . '.webp';
                $newImagePath = $originalPath . '/' . $newImage;
                $employee->image_with_size = $newImagePath;

                $conversionImage = $filename . '.webp';
                $conversionImagePath = $originalPath . '/' . $conversionImage;
                $employee->image_conversion = $conversionImagePath;

                $thumbnail = $filename . '_' . 48 . 'x' . 48 . '.webp';
                $thumbnailPath = $originalPath . '/' . $thumbnail;
                $employee->thumbnail = $thumbnailPath;
            } else {
                $employee->image_with_size = NULL;
                $employee->image_conversion = NULL;
                $employee->thumbnail = NULL;
            }
        });

        static::updating(function ($employee) {
            $slug = Str::slug($employee->first_name . '-' . $employee->last_name);
            $employee->slug = $slug;

            $width = 444;
            $height = 666;

            if(!empty($employee->image)) {
                $originalPath = pathinfo($employee->image, PATHINFO_DIRNAME);
                $filename = pathinfo($employee->image, PATHINFO_FILENAME);

                $newImage = $filename . '_' . $width . 'x' . $height . '.webp';
                $newImagePath = $originalPath . '/' . $newImage;
                $employee->image_with_size = $newImagePath;

                $conversionImage = $filename . '.webp';
                $conversionImagePath = $originalPath . '/' . $conversionImage;
                $employee->image_conversion = $conversionImagePath;

                $thumbnail = $filename . '_' . 48 . 'x' . 48 . '.webp';
                $thumbnailPath = $originalPath . '/' . $thumbnail;
                $employee->thumbnail = $thumbnailPath;
            } else {
                $employee->image_with_size = NULL;
                $employee->image_conversion = NULL;
                $employee->thumbnail = NULL;
            }
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
