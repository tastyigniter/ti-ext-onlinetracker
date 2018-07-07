<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save'      => [
                    'label'        => 'lang:admin::default.button_save',
                    'class'        => 'btn btn-primary',
                    'data-request' => 'onSave',
                ],
                'saveClose' => [
                    'label'             => 'lang:admin::default.button_save_close',
                    'class'             => 'btn btn-default',
                    'data-request'      => 'onSave',
                    'data-request-data' => 'close:1',
                ],
                'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'igniterlab/onlinetracker/pagevisits'],
            ],
        ],
        'fields'  => [
            'status'                           => [
                'label' => 'lang:igniterlab.onlinetracker::default.label_status',
                'type'  => 'switch',
                'span'        => 'left',
                'default'  => true,
            ],
            'track_robots'                           => [
                'label' => 'lang:igniterlab.onlinetracker::default.label_track_robots',
                'type'  => 'switch',
                'span'        => 'right',
                'default'  => false,
            ],
            'exclude_routes'                   => [
                'label'       => 'lang:igniterlab.onlinetracker::default.label_exclude_routes',
                'type'        => 'textarea',
                'span'        => 'left',
            ],
            'exclude_paths'                   => [
                'label'       => 'lang:igniterlab.onlinetracker::default.label_exclude_paths',
                'type'        => 'textarea',
                'span'        => 'right',
            ],
            'exclude_ips'                   => [
                'label'       => 'lang:igniterlab.onlinetracker::default.label_exclude_ips',
                'type'        => 'textarea',
            ],
            'customer_online_time_out'         => [
                'label'   => 'lang:igniterlab.onlinetracker::default.label_customer_online_time_out',
                'type'    => 'number',
                'span'    => 'left',
                'default' => 5,
                'comment' => 'lang:igniterlab.onlinetracker::default.help_customer_online',
            ],
            'customer_online_archive_time_out' => [
                'label'   => 'lang:igniterlab.onlinetracker::default.label_customer_online_archive_time_out',
                'type'    => 'select',
                'span'    => 'right',
                'options' => [
                    '0'  => 'lang:igniterlab.onlinetracker::default.text_never_delete',
                    '1'  => 'lang:igniterlab.onlinetracker::default.text_1_month',
                    '3'  => 'lang:igniterlab.onlinetracker::default.text_3_months',
                    '6'  => 'lang:igniterlab.onlinetracker::default.text_6_months',
                    '12' => 'lang:igniterlab.onlinetracker::default.text_12_months',
                ],
                'comment' => 'lang:igniterlab.onlinetracker::default.help_customer_online_archive',
            ],
        ],
        'rules'   => [
            ['customer_online_time_out', 'lang:igniterlab.onlinetracker::default.label_customer_online_time_out', 'required|integer'],
            ['customer_online_archive_time_out', 'lang:igniterlab.onlinetracker::default.label_customer_online_archive_time_out', 'required|integer'],
        ],

    ],
];