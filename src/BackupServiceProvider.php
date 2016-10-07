<?php namespace Sixs\Backup;
	
use Illuminate\Support\ServiceProvider;
    
class BackupServiceProvider extends ServiceProvider {

    

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    	
	    if (! $this->app->routesAreCached()) {
	        require __DIR__.'/Http/routes.php';
	    }
		 $this->loadViewsFrom(__DIR__.'/views','backup');
		 $this->publishes([
		 		__DIR__.'/migrations' => base_path('database/migrations'),
		 ]);
		 $this->publishes([
		 		__DIR__.'/seeds' => base_path('database/seeds'),
		 ]);
		 $this->publishes([
		 		__DIR__.'/assets/css' => base_path('public/sixsBackup/css'),
		 ]);
		
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['backup'] = $this->app->share(function($app)
        {
            return new Backup;
        });
    }
}
?>