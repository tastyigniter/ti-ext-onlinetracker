<?php namespace Igniter\OnlineTracker\DashboardWidgets;

use Admin\Classes\BaseDashboardWidget;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DB;
use Igniter\OnlineTracker\Models\PageView;
use Illuminate\Support\Collection;

/**
 * PageViews dashboard widget.
 */
class PageViews extends BaseDashboardWidget
{
    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'pageviews';

    public function initialize()
    {
        $this->setProperty('rangeFormat', 'MMMM D, YYYY');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'label' => 'admin::lang.dashboard.label_widget_title',
                'default' => 'igniter.onlinetracker::default.views.text_title',
            ],
        ];
    }

    /**
     * Renders the widget.
     */
    public function render()
    {
        return $this->makePartial('~/extensions/igniter/onlinetracker/dashboardwidgets/pageviews/pageviews');
    }

    public function loadAssets()
    {
        $this->addJs('~/app/system/assets/ui/js/vendor/moment.min.js', 'moment-js');
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.js', 'daterangepicker-js');
        $this->addCss('~/app/admin/dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.css', 'daterangepicker-css');

        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/vendor/chartjs/Chart.min.js', 'chartsjs-js');
        $this->addCss('~/app/admin/dashboardwidgets/charts/assets/css/charts.css', 'charts-css');
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/js/charts.js', 'charts-js');
    }

    public function onFetchDatasets()
    {
        $start = post('start');
        $end = post('end');

        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        return $this->getDatasets($start, $end);
    }

    protected function getDatasets($start, $end)
    {
        $config = [
            'label' => 'igniter.onlinetracker::default.views.text_title',
            'color' => '#64B5F6',
            'model' => PageView::class,
            'column' => 'created_at',
        ];

        $result[] = $this->makeDataset($config, $start, $end);

        return $result;
    }

    protected function makeDataset($config, $start, $end)
    {
        list($r, $g, $b) = sscanf($config['color'], '#%02x%02x%02x');
        $backgroundColor = sprintf('rgba(%s, %s, %s, 0.5)', $r, $g, $b);
        $borderColor = sprintf('rgb(%s, %s, %s)', $r, $g, $b);

        return [
            'label' => lang($config['label']),
            'data' => $this->queryDatasets($config, $start, $end),
            'fill' => FALSE,
            'backgroundColor' => $backgroundColor,
            'borderColor' => $borderColor,
        ];
    }

    protected function queryDatasets($config, $start, $end)
    {
        $modelClass = $config['model'];
        $dateColumnName = $config['column'];

        $dateColumn = DB::raw('DATE_FORMAT('.$dateColumnName.', "%Y-%m-%d") as x');
        $query = $modelClass::select($dateColumn, DB::raw('count(*) as y'));
        $query->whereBetween($dateColumnName, [$start, $end])->groupBy('x');

        $dateRanges = $this->getDatePeriod($start, $end);

        return $this->getPointsArray($dateRanges, $query->get());
    }

    protected function getDatePeriod($start, $end)
    {
        return new DatePeriod(
            Carbon::parse($start),
            new DateInterval('P1D'),
            Carbon::parse($end)
        );
    }

    protected function getPointsArray($dateRanges, Collection $result)
    {
        $points = [];
        $keyedResult = $result->keyBy('x');
        foreach ($dateRanges as $date) {
            $x = $date->format('Y-m-d');
            $points[] = [
                'x' => $x,
                'y' => $keyedResult->get($x) ?? 0,
            ];
        }

        return $points;
    }
}
