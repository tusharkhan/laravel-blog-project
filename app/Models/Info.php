<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Info extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'infos';

    protected $fillable = [
        'category_id',
        'links',
        'message',
        'name',
        'email',
        'user_id',
        'status',
    ];

    protected $casts = [
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

    /**
     * Get links as an array (comma-separated).
     */
    public function getLinksArray()
    {
        return array_map('trim', explode(',', $this->links));
    }
}

