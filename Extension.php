<?php namespace IgniterLab\OnlineTracker;

use GeoIp2\Database\Reader;
use IgniterLab\OnlineTracker\Classes\RepositoryManager;
use IgniterLab\OnlineTracker\Classes\Tracker;
use IgniterLab\OnlineTracker\Middleware\LogOnlineUser;
use IgniterLab\OnlineTracker\Models\GeoIp;
use IgniterLab\OnlineTracker\Models\PageVisit;
use IgniterLab\OnlineTracker\Models\Settings;
use Jenssegers\Agent\AgentServiceProvider;
use System\Classes\BaseExtension;

/**
 * OnlineTracker Extension Information File
 */
class Extension extends BaseExtension
{
    /**
     * Returns information about this extension.
     *
     * @return array
     */
    public function extensionMeta()
    {
        return [
            'name'        => 'OnlineTracker',
            'author'      => 'IgniterLab',
            'description' => 'No description provided yet...',
            'icon'        => 'fa-plug',
            'version'     => '1.0.0',
        ];
    }

    /**
     * Register method, called when the extension is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AgentServiceProvider::class);

        $this->app->singleton('tracker.reader', function ($app) {
            return new Reader((new Settings)->getDatabasePath());
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
     * Initialize method, called right before the request route.
     *
     * @return void
     */
    public function initialize()
    {
//        dump('initialize');
    }

    /**
     * Registers any front-end components implemented in this extension.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
// Remove this line and uncomment the line below to activate
//            'IgniterLab\OnlineTracker\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any admin permissions used by this extension.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'Igniterlab.Onlinetracker.PageVisits' => [
                'description' => 'Some permission',
                'action'      => ['access', 'add', 'manage', 'delete'],
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'customers_online' => [
                'priority'   => 50,
                'class'      => 'customersonline',
                'icon'       => 'fa-globe',
                'href'       => admin_url('igniterlab/onlinetracker/pagevisits'),
                'title'      => lang('igniterlab.onlinetracker::default.text_title'),
                'permission' => 'IgniterLab.OnlineTracker.PageVisits',
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Page Tracker Settings',
                'description' => 'Manage online tracker settings.',
                'model'       => 'IgniterLab\OnlineTracker\Models\Settings',
                'permissions' => ['Igniterlab.Onlinetracker'],
            ],
        ];
    }
}
