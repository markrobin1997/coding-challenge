<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

	protected $fillable = [
		'name',
	];

	/**
	 * Relations
	 */
	public function eventSchedules() {
		return $this->hasMany(EventSchedule::class);
	}
}
