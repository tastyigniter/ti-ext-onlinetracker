<?php namespace Igniter\OnlineTracker\Controllers;

use AdminMenu;

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
            'defaultSort' => ['updated_at', 'DESC'],
            'showCheckboxes' => FALSE,
            'configFile' => 'pageview'
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
        $query->with(['geoip', 'customer'])->groupBy('request_uri');
    }
}