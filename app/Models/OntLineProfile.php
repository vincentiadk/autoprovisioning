<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class OntLineProfile extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'olt_site_id',
        'profile_id',
        'tcont_1',
        'tcont_2',
        'tcont_3',
        'tcont_4',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function oltSite()
    {
        return $this->belongsTo(OltSite::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
