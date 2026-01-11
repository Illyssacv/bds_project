<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_REVIEWED = 1;
    const STATUS_DISMISSED = 2;
    protected $table = 'report';
    protected $fillable = [
        'reported_by',
        'sale_post_id',
        'reason',
        'status',
        'is_action_taken'
    ];
    protected $casts = [
        'status' => 'integer',
        'is_action_taken' => 'boolean',
    ];
    // Relationship 
    public function salePost()
    {
        return $this->belongsTo(SalePost::class, 'sale_post_id');
    }
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
    //Pending handle
    public function scopePending($q)
    {
        return $q->where('status', self::STATUS_PENDING);
    }
    public function scopeReviewed($q)
    {
        return $q->where('status', self::STATUS_REVIEWED);
    }
    public function scopeDismissed($q)
    {
        return $q->where('status', self::STATUS_DISMISSED);
    }
    //Salepost action
    public function markAsReviewedAndHidePost(): void
    {
        // 1. Cập nhật trạng thái report
        $this->update([
            'status' => self::STATUS_REVIEWED,           // reviewed
            'is_action_taken' => true,
        ]);

        // 2. Ẩn bài đăng (status = 3)  
        if ($this->salePost) {
            $this->salePost->update([               //hidden
                'status' => 3,
            ]);
        }
    }
    public function markAsDismissed(): void
    {
        $this->update([
            'status' => self::STATUS_DISMISSED,           // dismissed
            'is_action_taken' => false,
        ]);
    }
}
