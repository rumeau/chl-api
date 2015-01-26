<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 024 24/01/2015
 * Time: 13:03
 */

return [
    'expire' => 5,
    'daily_indexes' => [
        'service_url' => [
            'di' => [
                'url' => 'http://si3.bcentral.cl/bdemovil/BDE/IndicadoresDiarios',
                'method' => 'GET',
            ],
            'utm' => [
                'url' => 'http://si3.bcentral.cl/bdemovil/BDE/Series/MOV_SC_PR12',
                'method' => 'GET',
            ],
        ],
    ],
];
