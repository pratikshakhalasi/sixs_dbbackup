<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSixsBackupSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sixs_backup_settings', function (Blueprint $table) {
            $table->increments('settings_id');
            $table->string('settings_name',150);
            $table->string('settings_label',150);
            $table->string('settings_value',255);
           	$table->string('settings_input_type',25);
            
            
        });
    }

   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sixs_dbbackup_settings');
    }
}
