<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class MetroList extends Model
{
    use HasFactory, Uuid;
    protected $table = 'metro_list';
    protected $casts = [
        'uuid' => 'string'
      ];
    protected $fillable = [
        'service_description',
        'access_description',
        'vcid',
        'port_access',
        'node_access',
        'vlan_access',
        'node_backhaul_1',
        'node_backhaul_2',
        'port_backhaul_1',
        'port_backhaul_2',
        'vlan_backhaul_1',
        'vlan_backhaul_2',
        'task_id',
        'createTime',
        'endTime',
        'startTime',
        'done',
        'done_date'
    ];

    public function configurationStatus()
    {
        return $this->belongsTo(ConfigurationStatus::class, 'id', 'metro_list_id');
    }
}
