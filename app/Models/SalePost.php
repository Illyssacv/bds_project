<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalePost extends Model
{
    protected $table = 'sale_posts';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'area',
        'address',
        'bedrooms',
        'bathrooms',
        'is_furnished',
        'status'
    ];
    // ép datatype
    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'float',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'is_furnished' => 'boolean',
        'status' => 'integer',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(SalePostImage::class);
    }

    public function chats()
    {
        return $this->hasMany(SalePostChat::class);
    }
    public function index()
    {
        $pending = SalePost::with('user')
            ->where('status', 0)      // 0 = chờ duyệt
            ->latest()
            ->paginate(10);

        return view('admin.posts.approval', compact('pending'));
    }
}
