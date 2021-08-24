<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationStatus extends Model
{
    use HasFactory;

    protected $table = "configuration_status";

    protected $fillable = [
        'order_id',
        'olt_site_id',
        'metro_list_id',
        'ont_line_id',
        'created_by',
    ];

    public function oltSite()
    {
        return $this->belongsTo(OltSite::class, 'olt_site_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function metroList()
    {
        return $this->belongsTo(MetroList::class, 'metro_list_id');
    }

    public function ontLine()
    {
        return $this->belongsTo(OntLineProfile::class, 'ont_line_id');
    }
}
