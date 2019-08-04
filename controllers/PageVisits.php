<?php namespace Igniter\OnlineTracker\Controllers;

use AdminMenu;
use Igniter\OnlineTracker\Models\Settings;

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

    protected $requiredPermissions = 'igniter.onlinetracker.PageVisits';

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