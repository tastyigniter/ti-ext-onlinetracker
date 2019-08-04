<?php

return [
    'list' => [
        'filter' => [
            'scopes' => [
                'date' => [
                    'label' => 'lang:igniter.onlinetracker::default.text_filter_date',
                    'type' => 'date',
                    'conditions' => 'YEAR(updated_at) = :year AND MONTH(updated_at) = :month',
                    'modelClass' => 'Igniter\OnlineTracker\Models\PageVisit',
                    'options' => 'getOnlineDates',
                ],
            ],
        ],
        'toolbar' => [
            'buttons' => [
                'visits' => [
                    'label' => 'lang:igniter.onlinetracker::default.button_page_visits',
                    'class' => 'btn btn-default',
                    'href' => 'igniter/onlinetracker/pagevisits',
                ],
                'settings' => [
                    'label' => 'lang:igniter.onlinetracker::default.button_settings',
                    'class' => 'btn btn-default',
                    'href' => 'extensions/edit/igniter/onlinetracker/settings',
                ],
                'filter' => ['label' => 'lang:admin::lang.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
            ],
        ],
        'columns' => [
            'request_uri' => [
                'label' => 'lang:igniter.onlinetracker::default.column_request_uri',
                'type' => 'text',
            ],
            'page_views' => [
                'label' => 'lang:igniter.onlinetracker::default.column_views',
                'type' => 'text',
                'select' => 'COUNT(request_uri)',
            ],
        ],
    ],
];
