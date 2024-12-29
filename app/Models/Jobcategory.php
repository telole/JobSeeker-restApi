<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobcategory extends Model
{
    //
    protected $table = 'job_categories';
    // protected $fillable = [
    //     'job_category'
    // ];
    protected $guarded = ['id'];

    public function validations()
    {
        return $this->hasMany(Validation::class);
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class);
    }
}
