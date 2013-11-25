<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSceancesHasElevesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sceancesHasEleves', function(Blueprint $table) {
			$table->integer('sceances_id');
			$table->integer('eleves_id');
			$table->integer('presence_id');
			
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
		Schema::drop('sceancesHasEleves');
	}

}
