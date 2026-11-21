<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimulationLog extends Model
{
    public $timestamps = false;

    protected $table = 'simulation_logs';

    protected $fillable = ['product_id', 'session_id', 'input_json', 'result_json'];

    protected $casts = [
        'input_json' => 'array',
        'result_json' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}