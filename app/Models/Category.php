<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "categories";

    protected $fillable = [
        "title",
        "title_bn",
        "slug",
        "slug_bn",
        "description",
        "description_bn",
        "status",
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function getLocalizedTitle($local = null)
    {
        $local = $local ?? app()->getLocale();

        return $local === 'bn' && $this->title_bn ? $this->title_bn : $this->title;
    }

    public function getLocalizedSlug($local = null)
    {
        $local = $local ?? app()->getLocale();

        return $local === 'bn' && $this->slug_bn ? $this->slug_bn : $this->slug;
    }
}
