<?php

namespace App\Observers;
use App\Models\MetroList;
use App\Models\ActivityLog;
use App\Models\User;

class MetroObserver
{
    private $sessys;

    public function __construct($sessys)
    {
        $this->sessys = $sessys;
    }

    public function created(MetroList $model)
    {
        ActivityLog::create([
            'log_name' => 'create',
            'description' => 'create metro',
            'subject_id' => $model->id,
            'subject_type' => MetroList::class,
            'causer_id' => $this->sessys != null ? 0 : (session('id') != null ? session('id') : 0),
            'causer_type' => User::class,
            'properties' => json_encode($model->toArray()),
        ]);
    }

    public function deleting(MetroList $model)
    {
        ActivityLog::create([
            'log_name' => 'delete',
            'description' => 'delete metro',
            'subject_id' => $model->id,
            'subject_type' => MetroList::class,
            'causer_id' => $this->sessys != null ? 0 : (session('id') != null ? session('id') : 0),
            'causer_type' => User::class,
            'properties' => json_encode($model->toArray()),
        ]);
    }

    public function updated(MetroList $model)
    {
        $dirty = $model->getDirty();
        unset($dirty["configurationStatus"]);

        $changes = $model->getChanges();
        unset($changes["configurationStatus"]);
        
        $original = $model->getOriginal();
        $intersect = array_intersect_key($original, $dirty);

        $dirty = $intersect;
        ActivityLog::create([
            'log_name' => 'update',
            'description' => 'update metro',
            'subject_id' => $model->id,
            'subject_type' => MetroList::class,
            'causer_id' => $this->sessys != null ? 0 : (session('id') != null ? session('id') : 0),
            'causer_type' => User::class,
            'properties' => json_encode([
                    'old' => $dirty,
                    'new' => $changes
                ])
        ]);
    }
}
