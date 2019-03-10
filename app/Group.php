<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //Gerentes e Diretores
    const VIP = [4];

    public function users()
    {
        return $this->hasMany('App\User')->orderBy('name');
    }
}
