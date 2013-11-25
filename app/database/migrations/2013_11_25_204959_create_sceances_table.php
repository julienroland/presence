<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSceancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sceances', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps('date_start');
			$table->timestamps('date_end');
			$table->integer('repetition');
			$table->integer('for');
			$table->integer('cours_id');
			
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sceances');
	}

}