<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Toggleable field-service modules
    |--------------------------------------------------------------------------
    | Field service companies enable only the inspection domains they need.
    */
    'customers_sites' => [
        'enabled' => (bool) env('MODULE_CUSTOMERS_SITES', true),
        'name' => 'Customers & Sites',
        'description' => 'Customer accounts, service sites, asset tags, and site access notes for technicians.',
        'category' => 'crm',
        'hours_saved_weekly' => 14,
        'core' => true,
    ],
    'work_orders' => [
        'enabled' => (bool) env('MODULE_WORK_ORDERS', true),
        'name' => 'Work Orders',
        'description' => 'Dispatchable work orders with priority, SLA windows, and technician assignment.',
        'category' => 'operations',
        'hours_saved_weekly' => 28,
        'core' => true,
    ],
    'checklists' => [
        'enabled' => (bool) env('MODULE_CHECKLISTS', true),
        'name' => 'Mobile Checklists',
        'description' => 'Reusable inspection checklist templates with scored items and pass/fail rules.',
        'category' => 'inspection',
        'hours_saved_weekly' => 24,
        'core' => true,
    ],
    'inspections' => [
        'enabled' => (bool) env('MODULE_INSPECTIONS', true),
        'name' => 'Field Inspections',
        'description' => 'On-site inspection runs linked to work orders, checklists, and findings.',
        'category' => 'inspection',
        'hours_saved_weekly' => 22,
        'core' => true,
    ],
    'photo_evidence' => [
        'enabled' => (bool) env('MODULE_PHOTO_EVIDENCE', true),
        'name' => 'Photo Evidence',
        'description' => 'Timestamped photo capture with captions, geotags, and checklist item linkage.',
        'category' => 'evidence',
        'hours_saved_weekly' => 18,
        'core' => true,
    ],
    'pdf_reports' => [
        'enabled' => (bool) env('MODULE_PDF_REPORTS', true),
        'name' => 'PDF Reports',
        'description' => 'Unicode-ready PDF inspection packs for customers, insurers, and regulators.',
        'category' => 'reporting',
        'hours_saved_weekly' => 16,
        'core' => false,
    ],
    'customer_summaries' => [
        'enabled' => (bool) env('MODULE_CUSTOMER_SUMMARIES', true),
        'name' => 'Customer Work Summaries',
        'description' => 'Customer-ready work summaries with findings, photos, and recommended next steps.',
        'category' => 'reporting',
        'hours_saved_weekly' => 12,
        'core' => false,
    ],
    'ai_assist' => [
        'enabled' => (bool) env('MODULE_AI_ASSIST', true),
        'name' => 'AI Inspection Assist',
        'description' => 'AI hub wiring for finding narratives, defect classification hints, and report drafts.',
        'category' => 'ai',
        'hours_saved_weekly' => 20,
        'core' => false,
    ],
    'catalog_scrape' => [
        'enabled' => (bool) env('MODULE_CATALOG_SCRAPE', false),
        'name' => 'Standards Catalog Scraper',
        'description' => 'Optional AI catalog scrape assist for manufacturer and safety standards libraries.',
        'category' => 'data',
        'hours_saved_weekly' => 8,
        'core' => false,
    ],
    'attendance_ops' => [
        'enabled' => (bool) env('MODULE_ATTENDANCE_OPS', false),
        'name' => 'Technician Attendance',
        'description' => 'Optional attendance hub bridge for technician time-clock and site check-in.',
        'category' => 'workforce',
        'hours_saved_weekly' => 9,
        'core' => false,
    ],
    'speed_optimizer' => [
        'enabled' => (bool) env('MODULE_SPEED_OPTIMIZER', true),
        'name' => 'Drutogoti Speed Layer',
        'description' => 'Performance helpers for mobile field forms and admin dashboards.',
        'category' => 'platform',
        'hours_saved_weekly' => 6,
        'core' => false,
    ],
];
