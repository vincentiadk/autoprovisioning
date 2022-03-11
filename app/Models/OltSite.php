<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class OltSite extends Model
{
    use HasFactory, Uuid;

    protected $casts = [
        'uuid' => 'string'
    ];

    protected $fillable = [
        'user_id',
        'hostname',
        'uplink_port',
        'site_id',
        'site_name',
        'bw_order_total',
        'vlan',
        'ip_ont',
        'sn_ont',
        'description',
        'updated_by',
        'mac_add_node',
        'datek_metro'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function dbaProfiles()
    {
        return $this->hasMany(DbaProfile::class);
    }

    public function vlan()
    {
        return $this->hasMany(Vlan::class);
    }

    public function ontLineProfiles()
    {
        return $this->hasMany(OntLineProfile::class, 'olt_site_id');
    }

    public function oltList()
    {
        return $this->belongsTo(OltList::class, 'hostname');
    }

    public function configurationStatus()
    {
        return $this->belongsTo(ConfigurationStatus::class, 'id', 'olt_site_id');
    }
}
