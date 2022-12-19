<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'certificate';

    public function getPuskesmas(){
        return $this->hasOne(Puskesmas::class, 'id', 'id_puskesmas');
    }

    public function getKader(){
        return $this->hasOne(User::class, 'id', 'id_kader');
    }

    public function getPosyandu(){
        return $this->hasOne(Posyandu::class, 'id', 'id_posyandu');
    }
}
