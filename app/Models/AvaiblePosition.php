<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaiblePosition extends Model
{
    //
    protected $table = 'available_positions';
    protected $guarded = ['id'];


    public function JobVacancy()
{
    return $this->belongsTo(JobVacancy::class, 'job_vacancy_id', 'id');
}


    public function jobApples() {
        return $this->hasMany(JobApplyPosition::class, 'position_id', 'id');
    }
}
