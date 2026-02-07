<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLink extends Model
{
    use HasFactory;

    protected $table = "post_links";

    protected $fillable = [
        "post_id",
        "title",
        "url",
        "order",
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
