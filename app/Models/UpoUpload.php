<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpoUpload extends Model
{
    protected $fillable = ['order_id', 'rfq_id', 'file_url', 'original_name', 'status', 'admin_note'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }
}