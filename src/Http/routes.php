<?php
Route::get('sixs/backup', 'Sixs\Backup\Http\Controllers\BackupController@index');
Route::post('sixsbackup/save','Sixs\Backup\Http\Controllers\BackupController@postSave');
Route::get('sixsbackup/sendbackup','Sixs\Backup\Http\Controllers\BackupController@sendBackup');
Route::get('sixsbackup/download','Sixs\Backup\Http\Controllers\BackupController@getManualDownload');
?>