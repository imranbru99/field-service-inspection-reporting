<?php

return [
    'name' => 'Field Service Inspection & Reporting Tool',
    'accent' => '#4338CA',
    'demo' => [
        'email' => env('DEMO_USER_EMAIL', 'demo@field-inspection.test'),
        'password' => env('DEMO_USER_PASSWORD', 'password'),
    ],
    'sla_hours_default' => (int) env('FIELD_SLA_HOURS', 24),
    'photo_max_mb' => (int) env('FIELD_PHOTO_MAX_MB', 12),
];
