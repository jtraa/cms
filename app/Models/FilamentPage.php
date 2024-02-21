<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
class FilamentPage extends Model
{
    protected $guarded = [];

    use SoftDeletes;
    use HasSEO;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function doNotDelete($title) {
        $number = 1;
        return in_array($title, $number);
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

        static::creating(function ($employee) {
            $employee->setOrderValue();
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
