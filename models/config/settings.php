<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => [
                    'label' => 'lang:admin::lang.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                ],
                'saveClose' => [
                    'label' => 'lang:admin::lang.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-data' => 'close:1',
                ],
            ],
        ],
        'fields' => [
            'status' => [
                'label' => 'lang:igniter.onlinetracker::default.label_status',
                'type' => 'switch',
                'span' => 'left',
                'default' => TRUE,
            ],
            'track_robots' => [
                'label' => 'lang:igniter.onlinetracker::default.label_track_robots',
                'type' => 'switch',
                'span' => 'right',
                'default' => FALSE,
            ],
            'exclude_routes' => [
                'label' => 'lang:igniter.onlinetracker::default.label_exclude_routes',
                'type' => 'textarea',
                'span' => 'left',
            ],
            'exclude_paths' => [
                'label' => 'lang:igniter.onlinetracker::default.label_exclude_paths',
                'type' => 'textarea',
                'span' => 'right',
            ],
            'exclude_ips' => [
                'label' => 'lang:igniter.onlinetracker::default.label_exclude_ips',
                'type' => 'textarea',
            ],
            'online_time_out' => [
                'label' => 'lang:igniter.onlinetracker::default.label_online_time_out',
                'type' => 'number',
                'span' => 'left',
                'default' => 5,
                'comment' => 'lang:igniter.onlinetracker::default.help_customer_online',
            ],
            'archive_time_out' => [
                'label' => 'lang:igniter.onlinetracker::default.label_archive_time_out',
                'type' => 'select',
                'span' => 'right',
                'default' => '3',
                'options' => [
                    '0' => 'lang:igniter.onlinetracker::default.text_never_delete',
                    '1' => 'lang:igniter.onlinetracker::default.text_1_month',
                    '3' => 'lang:igniter.onlinetracker::default.text_3_months',
                    '6' => 'lang:igniter.onlinetracker::default.text_6_months',
                    '12' => 'lang:igniter.onlinetracker::default.text_12_months',
                ],
                'comment' => 'lang:igniter.onlinetracker::default.help_customer_online_archive',
            ],
            'geoip_reader' => [
                'label' => 'lang:igniter.onlinetracker::default.label_geoip_reader',
                'type' => 'select',
                'default' => 'maxmind',
                'options' => [
                    'geoip2' => 'lang:igniter.onlinetracker::default.text_maxmind',
                    'ipstack' => 'lang:igniter.onlinetracker::default.text_ipstack',
                ],
            ],
            'geoip_reader_ipstack_access_key' => [
                'label' => 'lang:igniter.onlinetracker::default.label_geoip_reader_ipstack_access_key',
                'type' => 'text',
                'comment' => 'lang:igniter.onlinetracker::default.help_geoip_reader_ipstack',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'geoip_reader',
                    'condition' => 'value[ipstack]',
                ],
            ],
            'geoip_reader_maxmind_account_id' => [
                'label' => 'lang:igniter.onlinetracker::default.label_geoip_reader_maxmind_account_id',
                'type' => 'text',
                'span' => 'left',
                'comment' => 'lang:igniter.onlinetracker::default.help_geoip_reader_maxmind',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'geoip_reader',
                    'condition' => 'value[geoip2]',
                ],
            ],
            'geoip_reader_maxmind_license_key' => [
                'label' => 'lang:igniter.onlinetracker::default.label_geoip_reader_maxmind_license_key',
                'type' => 'text',
                'span' => 'right',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'geoip_reader',
                    'condition' => 'value[geoip2]',
                ],
            ],
        ],
        'rules' => [
            ['online_time_out', 'lang:igniter.onlinetracker::default.label_online_time_out', 'required|integer'],
            ['archive_time_out', 'lang:igniter.onlinetracker::default.label_archive_time_out', 'required|integer'],
        ],

    ],
];
