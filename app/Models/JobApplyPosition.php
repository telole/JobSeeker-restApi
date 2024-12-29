<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplyPosition extends Model
{
    //
    protected $table = 'job_apply_positions';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function JobApplySociety() {
        return $this->belongsTo(JobApplySociety::class, 'job_apply_societies_id');
    }

    public function position() {
        return $this->belongsTo(AvaiblePosition::class, 'position_id');
    }

    public function society() {
        return $this->belongsTo(Society::class, 'society_id');
    }

    public function jobVacancy() {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
}
