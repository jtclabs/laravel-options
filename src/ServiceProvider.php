<?php

namespace JtcLabs\LaravelOptions;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionApplication;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionEncryption;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionPersistence;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionPersistencePreparation;
use JtcLabs\LaravelOptions\Repository\OptionApplier;
use JtcLabs\LaravelOptions\Repository\OptionDatabasePersistenceHandler;
use JtcLabs\LaravelOptions\Repository\OptionEncrypter;
use JtcLabs\LaravelOptions\Repository\OptionPersistencePreparer;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {

        $this->app->bind(
            HandlesOptionEncryption::class,
            OptionEncrypter::class
        );

        $this->app->bind(
            HandlesOptionPersistencePreparation::class,
            function(){
                return new OptionPersistencePreparer(
                    resolve(HandlesOptionEncryption::class)
                );
            }
        );

        $this->app->bind(
            HandlesOptionPersistence::class,
            function(){
                return new OptionDatabasePersistenceHandler(
                    resolve(HandlesOptionPersistencePreparation::class)
                );
            }
        );

        $this->app->bind(
            HandlesOptionApplication::class,
            function(){
                return new OptionApplier(
                    resolve(HandlesOptionPersistencePreparation::class)
                );
            }
        );

        if (Schema::hasTable('options')) {
            $this->registerOptions(resolve(HandlesOptionApplication::class));
        }

    }

    protected function registerOptions(HandlesOptionApplication $applier)
    {
        $applier->applyOptions(
            $applier->retrieveAutoloadOptions()
        );
    }

}