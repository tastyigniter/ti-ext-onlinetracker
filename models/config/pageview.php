<?php

return [
    'list' => [
        'filter'  => [
            'search' => [
                'prompt' => 'lang:igniterlab.onlinetracker::default.text_filter_search',
                'mode'   => 'all' // or any, exact
            ],
            'scopes' => [
                'date'   => [
                    'label'      => 'lang:igniterlab.onlinetracker::default.text_filter_date',
                    'type'       => 'date',
                    'conditions' => 'YEAR(updated_at) = :year AND MONTH(updated_at) = :month',
                    'modelClass' => 'IgniterLab\OnlineTracker\Models\PageVisit',
                    'options'    => 'getOnlineDates',
                ],
            ],
        ],
        'toolbar' => [
            'buttons' => [
                'visits' => [
                    'label' => 'lang:igniterlab.onlinetracker::default.button_page_visits',
                    'class' => 'btn btn-default',
                    'href'  => 'igniterlab/onlinetracker/pagevisits',
                ],
                'settings' => [
                    'label' => 'lang:igniterlab.onlinetracker::default.button_settings',
                    'class' => 'btn btn-default',
                    'href'  => 'extensions/edit/igniterlab/onlinetracker/settings',
                ],
                'filter'   => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
            ],
        ],
        'columns' => [
            'request_uri'   => [
                'label' => 'lang:igniterlab.onlinetracker::default.column_request_uri',
                'type'  => 'text',
            ],
            'page_views'       => [
                'label'      => 'lang:igniterlab.onlinetracker::default.column_views',
                'type'       => 'text',
                'select'       => 'COUNT(request_uri)',
            ],
        ],
    ],
];
