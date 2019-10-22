<?php namespace Igniter\OnlineTracker\Controllers;

use AdminMenu;
use Carbon\Carbon;
use Igniter\OnlineTracker\Models\Settings;

class PageViews extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Igniter\OnlineTracker\Models\PageView',
            'title' => 'lang:igniter.onlinetracker::default.views.text_title',
            'emptyMessage' => 'lang:igniter.onlinetracker::default.views.text_empty',
            'defaultSort' => ['page_views', 'DESC'],
            'showCheckboxes' => FALSE,
            'configFile' => 'pageview',
        ],
    ];

    protected $requiredPermissions = 'igniter.onlinetracker.Views';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('pagevisits');
    }

    public function listExtendQuery($query)
    {
        if (($pastMonths = Settings::get('archive_time_out', 3)) > 0)
            $query->whereDate('created_at', '>=', Carbon::now()->subMonths($pastMonths));

        $query->with(['geoip', 'customer'])->groupBy('request_uri');
    }
}