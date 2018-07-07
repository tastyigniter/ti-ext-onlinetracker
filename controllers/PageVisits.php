<?php namespace IgniterLab\OnlineTracker\Controllers;

use AdminMenu;
use IgniterLab\OnlineTracker\Models\Settings;

class PageVisits extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'IgniterLab\OnlineTracker\Models\PageVisit',
            'title'        => 'lang:igniterlab.onlinetracker::default.text_title',
            'emptyMessage' => 'lang:igniterlab.onlinetracker::default.text_empty',
            'defaultSort'  => ['updated_at', 'DESC'],
            'showCheckboxes' => false,
            'configFile'   => 'pagevisit'
        ],
    ];

    protected $requiredPermissions = 'Igniterlab.Onlinetracker.PageVisits';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('pagevisits');
    }

    public function index_onUpdateGeoIp()
    {
        Settings::make()->updateMaxMindDatabase();

        flash()->success('MaxMind GeoIP Database file updated.');

        return $this->refresh();
    }

    public function listExtendQuery($query)
    {
        $query->with(['geoip', 'customer'])->distinct()->groupBy('ip_address');
    }
}