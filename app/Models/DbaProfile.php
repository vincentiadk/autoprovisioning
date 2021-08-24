<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class DbaProfile extends Model
{
    use HasFactory, Uuid;

    protected $casts = [
        'uuid' => 'string'
    ];

    protected $fillable = [
        'uuid',
        'user_id',
        'olt_site_id',
        'profile_id',
        'profile_name',
        'tcont_type',
        'fix_bw',
        'assure_bw',
        'max_bw'
    ];
}
