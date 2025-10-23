<?php

return [

    'label' => 'การนำทางการแบ่งหน้า',

    'overview' => '{1} กำลังแสดงผล 1 รายการ|[2,*] กำลังแสดง :first ถึง :last ของ :total ผลลัพธ์',

    'fields' => [

        'records_per_page' => [

            'label' => 'ต่อหน้า',

            'options' => [
                'all' => 'ทั้งหมด',
            ],

        ],

    ],

    'actions' => [

        'go_to_page' => [
            'label' => 'ไปที่หน้า :page',
        ],

        'next' => [
            'label' => 'ต่อไป',
        ],

        'previous' => [
            'label' => 'ก่อนหน้า',
        ],

    ],

];
