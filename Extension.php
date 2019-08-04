<?php namespace Igniter\OnlineTracker;

use Igniter\OnlineTracker\Classes\RepositoryManager;
use Igniter\OnlineTracker\Classes\Tracker;
use Igniter\OnlineTracker\Geoip\ReaderManager;
use Igniter\OnlineTracker\Middleware\LogOnlineUser;
use Igniter\OnlineTracker\Models\GeoIp;
use Igniter\OnlineTracker\Models\PageVisit;
use Igniter\OnlineTracker\Models\Settings;
use Jenssegers\Agent\AgentServiceProvider;
use System\Classes\BaseExtension;

/**
 * OnlineTracker Extension Information File
 */
class Extension extends BaseExtension
{
    /**
     * Register method, called when the extension is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AgentServiceProvider::class);

        $this->app->singleton('tracker.reader', function ($app) {
            return new ReaderManager($app);
        });

        $this->app->singleton('tracker.repository.manager', function ($app) {
            return new RepositoryManager(
                new PageVisit,
                new GeoIp
            );
        });

        $this->app->singleton('tracker', function ($app) {
            return new Tracker(
                new Settings,
                $app['tracker.repository.manager'],
                $app['request'],
                $app['session.store'],
                $app['router'],
                $app['agent'],
                $app['tracker.reader']
            );
        });

        if (!$this->app->runningInAdmin())
            $this->app['Illuminate\Contracts\Http\Kernel']->pushMiddleware(LogOnlineUser::class);
    }

    /**
     * Registers any admin permissions used by this extension.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'igniter.onlinetracker.PageVisits' => [
                'description' => 'Manage online tracker settings',
                'group' => 'module',
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'pagevisits' => [
                'priority' => 50,
                'class' => 'pagevisits',
                'icon' => 'fa-globe',
                'href' => admin_url('igniter/onlinetracker/pagevisits'),
                'title' => lang('igniter.onlinetracker::default.text_title'),
                'permission' => 'igniter.onlinetracker.PageVisits',
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Page Tracker Settings',
                'description' => 'Manage online tracker settings.',
                'model' => 'Igniter\OnlineTracker\Models\Settings',
                'permissions' => ['igniter.onlinetracker'],
            ],
        ];
    }

    public function registerDashboardWidgets()
    {
        return [
            \Igniter\OnlineTracker\DashboardWidgets\PageViews::class => [
                'label' => 'Page Views chart widget',
                'context' => 'dashboard',
            ],
        ];
    }
}
