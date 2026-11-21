<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rfq extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'company', 'project_note', 'status'];

    public function items(): HasMany
    {
        return $this->hasMany(RfqItem::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
}