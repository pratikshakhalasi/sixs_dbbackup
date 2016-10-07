<?php namespace Sixs\Backup\Models;
	
	use Illuminate\Database\Eloquent\Model;
	
	use DB;
	class SixsBackup extends Model {
		
		public function getImagePath($folder)
		{
			return url().'/uploads/'.$folder;
		}
		
			public function backup_Database($tables = '*')
			{
				$this->deleteOldFiles();
				$data = '';
				$DbName = DB::connection()->getDatabaseName();
				
				// GET ALL TABLES
				if($tables == '*')
				{
					$tables = array();
					$result =  DB::select('SHOW TABLES');
					
					foreach($result as $res)
					{
						foreach($res as $key=>$val):
							$tables[] = $res->$key;
						endforeach;
					}
					
				}
				
				$data = 'SET FOREIGN_KEY_CHECKS=0;' . "\r\n";
				$data.= 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";' . "\r\n";
				$data.= 'SET AUTOCOMMIT=0;' . "\r\n";
				$data.= 'START TRANSACTION;' . "\r\n";
				
				
				foreach($tables as $table)
				{
					$result = DB::table($table)->get();
					$result1[] = DB::table($table)->get();
					$fields = DB::select('SHOW COLUMNS FROM '.$table);
					$num_fields = count($fields);
					
					$data.= 'DROP TABLE IF EXISTS '.$table.';';
					$row2 = DB::select('SHOW CREATE TABLE '.$table);
					$row3[] = DB::select('SHOW CREATE TABLE '.$table);
					
					foreach($row2[0] as $key=>$val)
					{
						if($key == 'Create Table')
							$data.= "\n\n".$val.";\n\n";
					}
					
					
						
						foreach($result as $row)
						{
							$data.= 'INSERT INTO '.$table.' VALUES(';
							$x= 0;
							foreach($row as $key=>$val) 
							{
								$val = addslashes($val);
								$val = $this->clean($val); // CLEAN QUERIES
								if($val == "" || $val == '0000-00-00 00:00:00')
								{
									$data.= 'NULL' ; 
								}else
									$data.= '"'.$val.'"' ; 
								 if ($x  != ($num_fields -1)) { 
									$data.= ','; 
								  }
								$x++;
							}  // end of the for loop 2
							$data.= ");\n";
						} // end of the while loop
						
					
					$data.="\n\n\n";
					
				}  // end of the foreach*/
				
				$data .= 'SET FOREIGN_KEY_CHECKS=1;' . "\r\n";
				$data.= 'COMMIT;';
				
				//SAVE THE BACKUP AS SQL FILE
				$filename = $DbName.'-Database-Backup-'.date('Y-m-d @ h-i-s').'.sql';
				$file_path = public_path().'/uploads/sixsbackup/'.$filename; 
				$handle = fopen($file_path,'w+');
				fwrite($handle,$data);
				fclose($handle);
				
				if($data)
				return $filename;
				else
				return false;
			}
			function clean($str) {
				if(@isset($str)){
					$str = @trim($str);
					if(get_magic_quotes_gpc()) {
						$str = stripslashes($str);
					}
					return $str;
				}
				else{
					return 'NULL';
				}
			}
			public function deleteOldFiles()
			{
				$dir = public_path().'/uploads/sixsbackup/';

				/*** cycle through all files in the directory ***/
				foreach (glob($dir."*") as $file) {

				/*** if file is 24 hours (86400 seconds) old then delete it ***/
				if (filemtime($file) < time() - 600) {
					unlink($file);
					}
				}
			}
			
		}
		