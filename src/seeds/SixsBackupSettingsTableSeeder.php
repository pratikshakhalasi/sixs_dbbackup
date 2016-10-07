<?php

use Illuminate\Database\Seeder;

class SixsBackupSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('sixs_backup_settings')->insert([
            'settings_name' => 'backup_to_email',
            'settings_label' => 'Backup To Email',
            'settings_value' => '',
       		'settings_input_type' => 'email',
        ]);
       DB::table('sixs_backup_settings')->insert([
       		'settings_name' => 'backup_from_email',
       		'settings_label' => 'Backup From Email',
       		'settings_value' => '',
       		'settings_input_type' => 'email',
       ]);
       
       DB::table('sixs_backup_settings')->insert([
       		'settings_name' => 'backup_frequency',
       		'settings_label' => 'Backup Frequency',
       		'settings_value' => '',
       		'settings_input_type' => 'select',
       ]);
       
       DB::table('sixs_backup_settings')->insert([
       		'settings_name' => 'last_backup_time',
       		'settings_label' => 'Last Backup time',
       		'settings_value' => '',
       		'settings_input_type' => 'hidden',
       ]);
       
      
    }
}
