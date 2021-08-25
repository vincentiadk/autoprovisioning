<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OltList extends Model
{
    use HasFactory;

    protected $fillable = [
        'nms_ip',
        'node_ip',
        'node_id',
        'node_type',
        'brand',
        'type',
    ];
}
