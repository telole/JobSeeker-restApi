<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Regional extends Model
{
    //
    use HasFactory, HasApiTokens;

    protected $table ='regionals';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function Society() {
        return $this->hasMany(Society::class, 'regional_id', 'id');
    }


}
