<?php
namespace SimpleShop\Commodity;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Foundation\Application as LaravelApplication;
use SimpleShop\Commodity\Search\RepositoryInterface;
use SimpleShop\Commodity\Search\SearchRepository;

class CommodityServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->setupConfig($this->app);
		$this->setupMigrations($this->app);
	}

	/**
	 * 初始化配置
	 *
	 * @param \Illuminate\Contracts\Container\Container $app
	 *
	 * @return void
	 */
	protected function setupConfig(Application $app)
	{
		$source = realpath(__DIR__.'/../config/commodity.php');

		if ($app instanceof LaravelApplication && $app->runningInConsole()) {
			$this->publishes([$source => config_path('commodity.php')]);
		} elseif ($app instanceof LumenApplication) {
			$app->configure('commodity');
		}

		$this->mergeConfigFrom($source, 'commodity');
	}

	/**
	 * 初始化数据库
	 *
	 * @param \Illuminate\Contracts\Container\Container $app
	 *
	 * @return void
	 */
	protected function setupMigrations(Application $app)
	{
		$source = realpath(__DIR__.'/../database/migrations/');

		if ($app instanceof LaravelApplication && $app->runningInConsole()) {
			$this->publishes([$source => database_path('migrations')], 'migrations');
		}
	}



	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
//		$this->app['commodity'] = $this->app->share(function($app)
//		{
//			$storage = $app['session'];
//			$events = $app['events'];
//
//			return new Commodity(
//				$storage,
//				$events
//			);
//		});
		$this->registerSearch();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	protected function registerSearch()
    {
        $this->app->singleton(RepositoryInterface::class, SearchRepository::class);
    }
}
