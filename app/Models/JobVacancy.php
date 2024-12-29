<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\MockObject\Generator\ClassIsFinalException;

class JobVacancy extends Model
{
    //
    protected $table = 'job_vacancies';
    protected $guarded = ['id'];
    public $timestatmps = false;

    public function jobCategory() {
        return $this->belongsTo(Jobcategory::class, 'id');

    }

    public function AvaiblePosition()
    {
        return $this->hasMany(AvaiblePosition::class, 'job_vacancy_id', 'id');
    }
    

    public function JobApplies() {
        return $this->hasMany(JobApplyPosition::class, 'job_vacancy_id', 'id');
    }


}
