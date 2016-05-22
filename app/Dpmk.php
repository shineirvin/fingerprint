<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpmk extends Model
{
	protected $table = 'dpmk';

	public $timestamps = false;

	protected $fillable = [
		'kelasmk_id',
		'nim'
	];

}
