<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplySociety extends Model
{
    //
    protected $guarded =['id'];
    public $timestamps = false;

    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function jobApplyPositions()
    {
        return $this->hasMany(JobApplyPosition::class, 'job_apply_societies_id');
    }


}
