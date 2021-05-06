<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Document extends Model
{
    protected $appends = ['url_image'];

    protected $fillable = [
        'title',
        'authors',
        'summary',
        'keywords',
        'url_file',
        'date_published',
        'user_id'
    ];

    public function getUrlImageAttribute()
    {
        return URL::to('/') . Storage::url($this->url_file);
    }
}
