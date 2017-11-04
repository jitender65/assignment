<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('first_name', 200);
			$table->string('last_name', 200);
			$table->string('image_uri', 200)->default('');
			$table->bigInteger('team_id')->unsigned()->index('team_id');
			$table->bigInteger('user_id')->unsigned()->index('players_ibfk_2');
			$table->timestamps();
			$table->date('deleted_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('players');
	}

}
