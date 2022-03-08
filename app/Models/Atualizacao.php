<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atualizacao extends Model
{
    use HasFactory;

    protected $table = "atualizacoes";

    public function User(){
        return $this->hasMany('App\User');
    }
}
