<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spm_program extends Model
{
    use HasFactory;
    protected $table = 'spm_program';

    public function getpuskesmas(){
        return $this->hasOne(Puskesmas::class, 'id', 'puskesmas_id');
    }
}
