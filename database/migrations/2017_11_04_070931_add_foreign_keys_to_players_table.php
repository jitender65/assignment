<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPlayersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('players', function(Blueprint $table)
		{
			$table->foreign('team_id', 'players_ibfk_1')->references('id')->on('teams')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id', 'players_ibfk_2')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('players', function(Blueprint $table)
		{
			$table->dropForeign('players_ibfk_1');
			$table->dropForeign('players_ibfk_2');
		});
	}

}
