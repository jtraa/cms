<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'section_id',
        'title',
        'subtitle',
        'text',
        'attachment',
        'icon'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }


}
