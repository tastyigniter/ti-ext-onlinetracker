<?php

namespace Igniter\OnlineTracker\Controllers;

use AdminMenu;

class PageVisits extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Igniter\OnlineTracker\Models\PageVisit',
            'title' => 'lang:igniter.onlinetracker::default.text_title',
            'emptyMessage' => 'lang:igniter.onlinetracker::default.text_empty',
            'defaultSort' => ['last_activity', 'DESC'],
            'showCheckboxes' => FALSE,
            'configFile' => 'pagevisit',
        ],
    ];

    protected $requiredPermissions = 'Igniter.OnlineTracker.*';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('pagevisits');
    }

    public function index()
    {
        app('tracker')->clearOldLog();

        $this->asExtension('ListController')->index();
    }

    public function listExtendQuery($query)
    {
        $query->with(['geoip', 'customer'])->distinct()->groupBy('ip_address');
    }
}
