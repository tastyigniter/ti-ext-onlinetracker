<?php namespace IgniterLab\OnlineTracker\Controllers;

use AdminMenu;
use IgniterLab\OnlineTracker\Models\Settings;

class PageViews extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'IgniterLab\OnlineTracker\Models\PageView',
            'title'        => 'lang:igniterlab.onlinetracker::default.views.text_title',
            'emptyMessage' => 'lang:igniterlab.onlinetracker::default.views.text_empty',
            'defaultSort'  => ['updated_at', 'DESC'],
            'showCheckboxes' => false,
            'configFile'   => 'pageview'
        ],
    ];

    protected $requiredPermissions = 'Igniterlab.Onlinetracker.Views';

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