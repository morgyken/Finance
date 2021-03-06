<?php

namespace Ignite\Finance\Providers;

use Ignite\Finance\Console\FixOldPrescriptions;
use Ignite\Finance\Console\JambopayCron;
use Ignite\Finance\Console\PreparePayments;
use Ignite\Finance\Library\EvaluationLibrary;
use Ignite\Finance\Library\FinanceLibrary;
use Ignite\Finance\Library\InventoryLibrary;
use Ignite\Finance\Library\JamboPay;
use Ignite\Finance\Library\Mpesa\Cashier;
use Ignite\Finance\Library\Mpesa\MpesaInitializer;
use Ignite\Finance\Library\Mpesa\Repository\MpesaRepository;
use Ignite\Finance\Repositories\EvaluationRepository;
use Ignite\Finance\Repositories\FinanceRepository;
use Ignite\Finance\Repositories\InventoryRepository;
use Ignite\Finance\Repositories\Jambo;
use Illuminate\Support\ServiceProvider;

class FinanceServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->commands([
            FixOldPrescriptions::class,
            PreparePayments::class,
            JambopayCron::class,
        ]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('finance.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'finance'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/finance');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/finance';
        }, \Config::get('view.paths')), [$sourcePath]), 'finance');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/finance');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'finance');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'finance');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(EvaluationRepository::class, EvaluationLibrary::class);
        $this->app->bind(FinanceRepository::class, FinanceLibrary::class);
        $this->app->bind(InventoryRepository::class, InventoryLibrary::class);
        $this->app->singleton(MpesaRepository::class, MpesaInitializer::class);
        $this->app->bind(Jambo::class, JamboPay::class);
        $this->app->bind('pesa', function () {
            return $this->app->make(Cashier::class);
        });
    }

}
