<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSchedulesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('event_schedules', function (Blueprint $table) {
			$table->id();
			$table->date('date');
			$table->integer('event_id')->unsigned();
			$table->foreign('event_id')
				->references('id')
				->on('events')
				->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('event_schedules');
	}
}
