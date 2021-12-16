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
        'vsiname',
        'node_backhaul_1',
        'node_backhaul_2',
        'port_backhaul_1',
        'port_backhaul_2',
        'vlan_backhaul_1',
        'vlan_backhaul_2',
        'vlan',
        'task_id',
        'createTime',
        'endTime',
        'startTime',
        'done',
        'done_date',
        'node_access_name',
        'node_backhaul_1_name',
        'node_backhaul_2_name',
        'qos_access',
        'qos_backhaul_1',
        'qos_backhaul_2',
        'scheduler_access',
        'scheduler_backhaul_1',
        'scheduler_backhaul_2',
        'status'
    ];

    public function configurationStatus()
    {
        return $this->belongsTo(ConfigurationStatus::class, 'id', 'metro_list_id');
    }
}
