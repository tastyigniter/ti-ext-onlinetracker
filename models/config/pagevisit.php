<?php

return [
    'list' => [
        'filter'  => [
            'search' => [
                'prompt' => 'lang:igniterlab.onlinetracker::default.text_filter_search',
                'mode'   => 'all' // or any, exact
            ],
            'scopes' => [
                'access' => [
                    'label'      => 'lang:igniterlab.onlinetracker::default.text_filter_access',
                    'type'       => 'select',
                    'conditions' => 'access_type = :filtered',
                    'options'    => [
                        'browser' => 'lang:igniterlab.onlinetracker::default.text_browser',
                        'mobile'  => 'lang:igniterlab.onlinetracker::default.text_mobile',
                        'robot'   => 'lang:igniterlab.onlinetracker::default.text_robot',
                    ],
                ],
                'date'   => [
                    'label'      => 'lang:igniterlab.onlinetracker::default.text_filter_date',
                    'type'       => 'date',
                    'conditions' => 'YEAR(updated_at) = :year AND MONTH(updated_at) = :month',
                    'modelClass' => 'IgniterLab\OnlineTracker\Models\PageVisit',
                    'options'    => 'getOnlineDates',
                ],
                'recent' => [
                    'label' => 'lang:igniterlab.onlinetracker::default.text_filter_online',
                    'type'  => 'checkbox',
                    'scope' => 'isOnline',
                ],
            ],
        ],
        'toolbar' => [
            'buttons' => [
                'views'    => [
                    'label' => 'lang:igniterlab.onlinetracker::default.button_page_views',
                    'class' => 'btn btn-default',
                    'href'  => 'igniterlab/onlinetracker/pageviews',
                ],
                'settings' => [
                    'label' => 'lang:igniterlab.onlinetracker::default.button_settings',
                    'class' => 'btn btn-default',
                    'href'  => 'extensions/edit/igniterlab/onlinetracker/settings',
                ],
                'filter'   => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
                'update'   => [
                    'label'        => 'lang:igniterlab.onlinetracker::default.button_update',
                    'class'        => 'btn btn-default pull-right',
                    'data-request' => 'onUpdateGeoIp',
                ],
            ],
        ],
        'columns' => [
            'ip_address'    => [
                'label'      => 'lang:igniterlab.onlinetracker::default.column_ip',
                'type'       => 'text',
                'searchable' => TRUE,
            ],
            'country_city'  => [
                'label'      => 'lang:igniterlab.onlinetracker::default.column_name',
                'type'       => 'text',
                'searchable' => TRUE,
            ],
            'page_views'    => [
                'label'  => 'lang:igniterlab.onlinetracker::default.column_views',
                'type'   => 'text',
                'select' => 'COUNT(ip_address)',
            ],
            'customer_name' => [
                'label'      => 'lang:igniterlab.onlinetracker::default.column_customer',
                'relation'   => 'customer',
                'select'     => 'concat(first_name, " ", last_name)',
                'searchable' => TRUE,
            ],
            'access_type'   => [
                'label'      => 'lang:igniterlab.onlinetracker::default.column_access',
                'type'       => 'text',
                'searchable' => TRUE,
            ],
            'platform'      => [
                'label'      => 'lang:igniterlab.onlinetracker::default.column_platform',
                'type'       => 'text',
                'searchable' => TRUE,
            ],
            'browser'       => [
                'label'      => 'lang:igniterlab.onlinetracker::default.column_browser',
                'type'       => 'text',
                'searchable' => TRUE,
            ],
            'referrer_uri'  => [
                'label' => 'lang:igniterlab.onlinetracker::default.column_referrer_url',
                'type'  => 'text',
            ],
            'last_activity'    => [
                'label'  => 'lang:igniterlab.onlinetracker::default.column_last_activity',
                'type'   => 'timesince',
                'select' => 'MAX(updated_at)',
            ],
        ],
    ],
];
