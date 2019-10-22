<?php

return [
    'list' => [
        'filter' => [
            'search' => [
                'prompt' => 'lang:igniter.onlinetracker::default.text_filter_search',
                'mode' => 'all' // or any, exact
            ],
            'scopes' => [
                'access' => [
                    'label' => 'lang:igniter.onlinetracker::default.text_filter_access',
                    'type' => 'select',
                    'conditions' => 'access_type = :filtered',
                    'options' => [
                        'browser' => 'lang:igniter.onlinetracker::default.text_browser',
                        'mobile' => 'lang:igniter.onlinetracker::default.text_mobile',
                        'robot' => 'lang:igniter.onlinetracker::default.text_robot',
                    ],
                ],
                'date' => [
                    'label' => 'lang:igniter.onlinetracker::default.text_filter_date',
                    'type' => 'date',
                    'conditions' => 'YEAR(updated_at) = :year AND MONTH(updated_at) = :month',
                    'modelClass' => 'Igniter\OnlineTracker\Models\PageVisit',
                    'options' => 'getOnlineDates',
                ],
                'recent' => [
                    'label' => 'lang:igniter.onlinetracker::default.text_filter_online',
                    'type' => 'checkbox',
                    'scope' => 'isOnline',
                ],
            ],
        ],
        'toolbar' => [
            'buttons' => [
                'views' => [
                    'label' => 'lang:igniter.onlinetracker::default.button_page_views',
                    'class' => 'btn btn-default',
                    'href' => 'igniter/onlinetracker/pageviews',
                ],
                'settings' => [
                    'label' => 'lang:igniter.onlinetracker::default.button_settings',
                    'class' => 'btn btn-default',
                    'href' => 'extensions/edit/igniter/onlinetracker/settings',
                ],
                'filter' => ['label' => 'lang:admin::lang.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
                'update' => [
                    'label' => 'lang:igniter.onlinetracker::default.button_update',
                    'class' => 'btn btn-default pull-right',
                    'data-request' => 'onUpdateGeoIp',
                ],
            ],
        ],
        'columns' => [
            'ip_address' => [
                'label' => 'lang:igniter.onlinetracker::default.column_ip',
                'type' => 'text',
                'searchable' => TRUE,
            ],
            'country_city' => [
                'label' => 'lang:admin::lang.label_name',
                'type' => 'text',
                'sortable' => FALSE,
            ],
            'page_views' => [
                'label' => 'lang:igniter.onlinetracker::default.column_views',
                'type' => 'text',
                'select' => 'COUNT(ip_address)',
            ],
            'customer_name' => [
                'label' => 'lang:igniter.onlinetracker::default.column_customer',
                'relation' => 'customer',
                'select' => 'concat(first_name, " ", last_name)',
                'searchable' => TRUE,
            ],
            'access_type' => [
                'label' => 'lang:igniter.onlinetracker::default.column_access',
                'type' => 'text',
                'searchable' => TRUE,
            ],
            'platform' => [
                'label' => 'lang:igniter.onlinetracker::default.column_platform',
                'type' => 'text',
                'searchable' => TRUE,
            ],
            'browser' => [
                'label' => 'lang:igniter.onlinetracker::default.column_browser',
                'type' => 'text',
                'searchable' => TRUE,
            ],
            'referrer_uri' => [
                'label' => 'lang:igniter.onlinetracker::default.column_referrer_url',
                'type' => 'text',
            ],
            'last_activity' => [
                'label' => 'lang:igniter.onlinetracker::default.column_last_activity',
                'type' => 'timesince',
                'select' => 'MAX(updated_at)',
            ],
        ],
    ],
];
