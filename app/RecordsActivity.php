<?php

namespace App;
use Illuminate\Support\Arr;

trait RecordsActivity
{

    public $oldAttributes = [];

    public static function bootRecordsActivity()
    {
        foreach ($recordableEvents = static::recordableEvents() as $event){
            static::$event( function ($model) use ($event) {

                $model->recordActivity($model->ActivityDescription($event));

            });

            if ($event == 'updated'){
                //when updating use original values as oldAttributes depending on model name
                static::updating( function ($model){
                    $model->oldAttributes = $model->getOriginal();
                });
            }

        }


    }

    protected function activityDescription($description){

        return "{$description}_" . strtolower(class_basename($this));

    }

    protected static function recordableEvents()
    {
        if(isset(static::$recordableEvents)){
            return static::$recordableEvents;
        }

        return ['created', 'updated', 'deleted'];

    }


    /**
     * Record activity for a project.
     *
     * @param string $description
     */
    public function recordActivity($description)
    {
        //Find updated changes, compare with oldAttributes, upload new to changes column
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);

    }

    public function activityChanges()
    {
        if ( $this->wasChanged() ) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();

    }

}
