<?php namespace Igniter\OnlineTracker\Controllers;

use AdminMenu;
use Carbon\Carbon;
use Igniter\OnlineTracker\Models\PageVisit;
use Igniter\OnlineTracker\Models\Settings;
use Illuminate\Support\Facades\Cache;

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

    public function index()
    {
        $this->clearOldRecords();

        $this->asExtension('ListController')->index();
    }

    public function index_onUpdateGeoIp()
    {
        Settings::make()->updateMaxMindDatabase();

        flash()->success('MaxMind GeoIP Database file updated.');

        return $this->refresh();
    }

    public function listExtendQuery($query)
    {
        if (($pastMonths = (int)Settings::get('archive_time_out', 3)) > 0)
            $query->whereDate('created_at', '>=', Carbon::now()->subMonths($pastMonths));

        $query->with(['geoip', 'customer'])->distinct()->groupBy('ip_address');
    }

    protected function clearOldRecords()
    {
        $seconds = Carbon::now()->addHours(24);
        $deleted = Cache::remember('igniter_onlinetracker_pagevisits', $seconds, function () {
            if (($pastMonths = (int)Settings::get('archive_time_out', 3)) > 0)
                PageVisit::whereDate('created_at', '<=', Carbon::now()->subMonths($pastMonths))->delete();

            return TRUE;
        });

        return $deleted;
    }
}