<?php

namespace Modules\LMS\Models\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PerformanceMetric extends Model
{
    protected $table = 'performance_metrics';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'id',
        'resource_id', 
        'hash',         
        'cache_token',    
        'monitor_hash',
        'last_metric',
        'resource_state'
    ];

    protected $casts = [
        'last_metric' => 'datetime',
        'perf_data' => 'array'
    ];
}