<?php
namespace Sixs\Backup\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Response;
use Redirect;
use Sixs\Backup\Models\SixsBackup;

Class BackupController extends Controller
{
	public function Index(Request $request)
	{
		
		$settings = DB::table('sixs_backup_settings')->get();
			$this->data = array(
				'pageTitle'	=> 'Settings',
				'pageNote'	=>  'Settings',
				'pageModule' => 'Settings',
				'results' => $settings
			);	
			return view('backup::index',$this->data);
	}
	public function postSave(Request $request)
	{
		$params = $request->all();
		foreach($params as $key=>$val):
		DB::table('sixs_backup_settings')
		->where('settings_name', $key)
		->update(['settings_value' => $val]);
		endforeach;
		return Redirect::to('sixs/backup');
	}
	public function getManualDownload()
	{
		$backup = new SixsBackup();
		try{
			$a = $backup->backup_Database();
			if($a)
			{
				$file= public_path(). '/uploads/sixsbackup/'.$a;
				$headers = array(
						'Content-Type: application/sql',
				);
				return Response::download($file, $a, $headers);
			}
		}catch(Exception $e)
		{
	
		}
	}
	public function sendBackup()
	{
		$backup = new SixsBackup();
		$input =  DB::table('sixs_backup_settings')->get();
		foreach($input as $inp)
		{
			$values[$inp->settings_name] = $inp->settings_value;
		}
			
		try{
			$freq_time = date('Y-m-d H:i:s',strtotime('+'.$values['backup_frequency'],strtotime($values['last_backup_time'])));
	
			if(strtotime(date('Y-m-d H:i:s')) >= strtotime($freq_time))
			{
				$a = $backup->backup_Database();
				if($a)
				{
					$file = public_path(). '/uploads/sixsbackup/'.$a;
					$values['file'] = $file;
					$values['filename'] = $a;
	
					$a = Mail::send('backup:backup_mail', $values, function($message) use ($values)
					{
						$message->subject(' Mysql backup'.date('Y-m-d H:i:s'));
						$message->to($values['backup_to_email']);
						$message->from($values['backup_from_email']);
						$message->attach($values['file'], array(
								'as' => $values['filename'],
								'mime' => 'application/sql')
								);
					});
					if($a)
					{
						DB::table('sixs_backup_settings')
						->where('settings_name', 'last_backup_time')
						->update(['settings_value' => date('Y-m-d H:i:s')]);
					}
	
				}
					
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();die;
		}
			
	}
}
