<?php

namespace Dervis\Library\Payments\Core;

use Dervis\Library\Payments\Core\Repository\ConfigurationStore;
use Dervis\Library\Payments\Mpesa\Cashier;
use Dervis\Library\Payments\Mpesa\MpesaRepository;
use Dervis\Library\Payments\Repository\Core\LaravelConfig;
use Illuminate\Support\ServiceProvider;


/**
 * Class PerfectPaymentServiceProvider
 * @package Dervis\Library\Payments\Core
 */
class PerfectPaymentServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind('MpesaRepository', function () {
//            return $this->app->make(MpesaRepository::class);
//        });
//        $this->app->singleton('EquityRepository', function () {
//            return $this->app->make(EquityRepository::class);
//        });
        $this->app->bind('banker', function () {
            return $this->app->make(Cashier::class);
        });
    }
}