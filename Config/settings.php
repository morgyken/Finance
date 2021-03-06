<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    'receipt_prefix' => [
        'description' => 'Receipt Prefix',
        'view' => 'text',
        'hint' => 'A 3-digit code added to receipt-number'
    ],
    'background_manifest' => [
        'view' => 'checkbox',
        'description' => 'Use a background job to process payment list'
    ],
    'post_pay_insurance' => [
        'view' => 'checkbox',
        'description' => 'Allow patients with insurance to be billed later'
    ],
    'enable_jambo_pay' => [
        'view' => 'checkbox',
        'description' => 'Enable payment via JamboPay https://www.jambopay.com/'
    ],
    'merchant_id' => [
        'view' => 'text',
        'description' => 'Jambo Pay Merchant ID https://www.jambopay.com/',
        'hint' => 'Only for JamboPay Payment Integration'
    ],
];
