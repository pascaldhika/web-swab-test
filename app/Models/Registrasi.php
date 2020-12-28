<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    protected $table = 'registrasi';

    public function details()
	{
		return $this->hasMany('App\Models\RegistrasiDetail','registrasiid');
	}

	public function payments()
	{
		return $this->hasMany('App\Models\RegistrasiDetailPayment','registrasiid');
	}
}
