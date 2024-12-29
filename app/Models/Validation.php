<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    //
    protected $table = 'validations';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function JobCategory() {
        return $this->belongsTo(Jobcategory::class, 'job_category_id', 'id');
    }

    public function validator()
    {
        return $this->belongsTo(Validator::class, 'validator_id', 'id'); 
    }

}