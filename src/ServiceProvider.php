<?php

namespace Patrickjunod\Matomic;

use Patrickjunod\Matomic\Client\MatomicClient;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $widgets = [
        \Patrickjunod\Matomic\Widgets\MatomicMostVisitedPagesWidget::class,
    ];

    public function bootAddon()
    {
        parent::boot();

        $this->bootAddonConfig();

        $this->addPermissions();

    }

    protected function addPermissions()
    {
        Permission::group('matomic', 'Matomic', function () {
            Permission::make('view Matomo analytics');
        });
    }

    protected function bootAddonConfig()
    {

        $this->mergeConfigFrom(__DIR__.'/../config/matomic.php', 'matomic');

        $this->publishes([
            __DIR__.'/../config/matomic.php' => config_path('statamic/matomic.php'),
        ], 'matomic');

        return $this;
    }
}
