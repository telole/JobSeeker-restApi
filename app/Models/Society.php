<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class Society extends Model
{
    // 
    use HasFactory, HasApiTokens;
    protected $guarded = ['id'];
    protected $table = 'societies';
    protected $hidden =[
        'password',
        'created_at',
        'update_at',
    ];

    public function validation(){
        return $this->hasOne(Validation::class, 'society_id', 'id');
    }
    public $timestamps = false;

    public function Regional() {
        return $this->belongsTo(Regional::class, 'regional_id', 'id');
    }
}  
