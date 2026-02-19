<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = "media";

    protected $fillable = [
        "user_id",
        "file_name",
        "title",
        "title_bn",
        "description",
        "description_bn",
        "location",
        "location_bn",
    ];

    public function files()
    {
        return $this->hasMany(MediaFile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
