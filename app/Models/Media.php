<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'user_id',
        'file_name',
        'title',
        'title_bn',
        'description',
        'description_bn',
        'location',
        'location_bn',
    ];

    public function files()
    {
        return $this->hasMany(MediaFile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLocalizedTitle($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'bn' && $this->title_bn ? $this->title_bn : $this->title;
    }

    public function getLocalizedDescription($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'bn' && $this->description_bn ? $this->description_bn : $this->description;
    }

    public function getLocalizedLocation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'bn' && $this->location_bn ? $this->location_bn : $this->location;
    }

    public function getLocalizedCreatedAt()
    {
        $locale = app()->getLocale();

        return $locale === 'bn'
            ? \App\Utills\Helper::englishToBanglaDateConverter($this->created_at, 'F d, Y')
            : $this->created_at->format('d M, Y');
    }
}
