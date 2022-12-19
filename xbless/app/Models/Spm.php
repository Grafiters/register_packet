<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spm extends Model
{
    use HasFactory;
    protected $table = 'spm';

    public function getpuskesmas(){
        return $this->hasOne(Puskesmas::class, 'id', 'puskesmas_id');
    }
}
