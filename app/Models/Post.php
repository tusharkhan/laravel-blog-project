<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'title',
        'title_bn',
        'slug',
        'slug_bn',
        'category_id',
        'content',
        'content_bn',
        'thumbnail',
        'views',
        'is_featured',
        'enable_comment',
        'status',
        'publisher',
        'publisher_bn',
        'reporter',
        'reporter_bn',
        'location',
        'location_bn',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'enable_comment' => 'boolean',
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function readTime()
    {
        $minutesToRead = round(Str::wordCount(static::find($this->id)->content) / 200);
        if ($minutesToRead < 1) {
            return 'Less than a minute';
        }

        return $minutesToRead.' Mins Read';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'ASC');
    }

    public function links()
    {
        return $this->hasMany(PostLink::class)->orderBy('order', 'ASC');
    }

    // Localization helper methods
    public function getLocalizedTitle($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'bn' && $this->title_bn ? $this->title_bn : $this->title;
    }

    public function getLocalizedSlug($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'bn' && $this->slug_bn ? $this->slug_bn : $this->slug;
    }

    public function getLocalizedContent($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'bn' && $this->content_bn ? $this->content_bn : $this->content;
    }

    public function getLocalizedPublisher($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'bn' && $this->publisher_bn ? $this->publisher_bn : $this->publisher;
    }

    public function getLocalizedReporter($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'bn' && $this->reporter_bn ? $this->reporter_bn : $this->reporter;
    }

    public function getLocalizedLocation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'bn' && $this->location_bn ? $this->location_bn : $this->location;
    }
}
