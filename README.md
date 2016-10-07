# sixs_dbbackup


----------------------------------------------------
step-1 :  Add below line in your composer.json file
	"sixs/backup": "0.1.*"

step-2: update composer
	composer update

---------------------OR---------------------------- 
step-1 :  run command: composer require sixs/backup

----------------------------------------------------
step-2:	Add in composer json psr-4 autoload
	"Sixs\\Backup\\": "vendor/sixs/backup/src/"

step-3: Add in config/app.php  provider list
	Sixs\Backup\BackupServiceProvider::class

step-4: publish required files
	php artisan vendor:publish --provider="Sixs\Backup\BackupServiceProvider"

step-5: Run migration
	php artisan migrate

Step-6: Run seeds (if not found error run composer dump-autoload)
	php artisan db:seed --class=SixsBackupSettingsTableSeeder

step-7: Create "sixsbackup" folder in upload directory

step-8: Run your project url{domain/public}/sixs/backup

Note: require to use composer require laravelcollective/html

--------------------------------------------------------------------
To get backup mail based on frequecy setting, You need to setup a Cron

use following command for cron:
/usr/bin/curl -o temp.txt http://yourdomain/sixsbackup/sendbackup


