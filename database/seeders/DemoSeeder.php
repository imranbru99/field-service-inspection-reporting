<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\ChecklistTemplate;
use App\Models\ChecklistTemplateItem;
use App\Models\Customer;
use App\Models\Inspection;
use App\Models\InspectionChecklistItem;
use App\Models\InspectionFinding;
use App\Models\PdfReport;
use App\Models\PhotoEvidence;
use App\Models\Site;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkSummary;
use App\Services\ModuleManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $users = $this->seedUsers();
        app(ModuleManager::class)->syncFromConfig();

        $customers = $this->seedCustomers();
        $templates = $this->seedChecklists();
        $workOrders = $this->seedWorkOrders($customers, $templates, $users);
        $inspections = $this->seedInspections($workOrders, $templates, $users);
        $this->seedReports($inspections, $users);
    }

    /** @return array<string, User> */
    protected function seedUsers(): array
    {
        $password = config('fieldservice.demo.password', 'password');

        $defs = [
            'super' => ['name' => 'Imran Ahmed', 'email' => 'admin@field-inspection.test', 'role' => UserRole::SuperAdmin, 'org' => 'ImranDev BD', 'title' => 'Platform Architect'],
            'admin' => ['name' => 'Nadia Rahman', 'email' => 'ops-admin@field-inspection.test', 'role' => UserRole::Admin, 'org' => 'FieldOps BD', 'title' => 'Operations Admin'],
            'manager' => ['name' => 'Karim Hossain', 'email' => 'manager@field-inspection.test', 'role' => UserRole::Manager, 'org' => 'FieldOps BD', 'title' => 'Dispatch Manager'],
            'staff' => ['name' => 'Rina Akter', 'email' => 'tech@field-inspection.test', 'role' => UserRole::Staff, 'org' => 'FieldOps BD', 'title' => 'Field Technician'],
            'client' => ['name' => 'Acme Facilities', 'email' => 'client@field-inspection.test', 'role' => UserRole::Client, 'org' => 'Acme Facilities Ltd', 'title' => 'Facilities Lead'],
            'demo' => ['name' => 'Demo User', 'email' => config('fieldservice.demo.email'), 'role' => UserRole::Demo, 'org' => 'Demo Co', 'title' => 'Evaluator'],
        ];

        $users = [];
        foreach ($defs as $key => $def) {
            $users[$key] = User::query()->updateOrCreate(
                ['email' => $def['email']],
                [
                    'name' => $def['name'],
                    'password' => $password,
                    'role' => $def['role'],
                    'organization_name' => $def['org'],
                    'job_title' => $def['title'],
                    'phone' => '+88015'.random_int(10000000, 99999999),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        return $users;
    }

    /** @return array<string, array{customer: Customer, site: Site}> */
    protected function seedCustomers(): array
    {
        $items = [
            ['name' => 'Acme Facilities Ltd', 'slug' => 'acme-facilities', 'industry' => 'Commercial RE', 'site' => 'Gulshan Tower A', 'city' => 'Dhaka'],
            ['name' => 'Delta Cold Chain', 'slug' => 'delta-cold-chain', 'industry' => 'Logistics', 'site' => 'Chattogram Depot 3', 'city' => 'Chattogram'],
            ['name' => 'GreenGrid Energy', 'slug' => 'greengrid-energy', 'industry' => 'Utilities', 'site' => 'Savar Substation', 'city' => 'Savar'],
        ];

        $out = [];
        foreach ($items as $item) {
            $customer = Customer::query()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'contact_name' => 'Site Contact',
                    'email' => Str::slug($item['slug']).'@example.test',
                    'phone' => '+8801711000000',
                    'industry' => $item['industry'],
                    'status' => 'active',
                    'notes' => 'Priority field inspection account.',
                ]
            );

            $site = Site::query()->updateOrCreate(
                ['customer_id' => $customer->id, 'code' => strtoupper(substr($item['slug'], 0, 4)).'-01'],
                [
                    'name' => $item['site'],
                    'address_line' => 'Service Lane 12',
                    'city' => $item['city'],
                    'region' => 'Dhaka Division',
                    'postal_code' => '1200',
                    'country' => 'BD',
                    'latitude' => 23.7800000 + (mt_rand(-50, 50) / 1000),
                    'longitude' => 90.4100000 + (mt_rand(-50, 50) / 1000),
                    'access_notes' => 'Check in with security desk; PPE required.',
                ]
            );

            $out[$item['slug']] = compact('customer', 'site');
        }

        return $out;
    }

    /** @return array<string, ChecklistTemplate> */
    protected function seedChecklists(): array
    {
        $defs = [
            'hvac-quarterly' => [
                'name' => 'HVAC Quarterly Safety',
                'category' => 'HVAC',
                'items' => [
                    ['Inspect filters and airflow', true, false],
                    ['Verify condensate drainage', true, true],
                    ['Check electrical panels', true, true],
                    ['Record supply/return temps', false, false],
                    ['Photograph nameplate data', true, false],
                ],
            ],
            'fire-safety' => [
                'name' => 'Fire Safety Walkthrough',
                'category' => 'Fire',
                'items' => [
                    ['Extinguisher pressure OK', true, true],
                    ['Exit lighting functional', true, true],
                    ['Alarm panel clear', true, true],
                    ['Egress paths unobstructed', true, false],
                ],
            ],
            'cold-storage' => [
                'name' => 'Cold Storage Integrity',
                'category' => 'Cold Chain',
                'items' => [
                    ['Door seal integrity', true, true],
                    ['Temperature log within range', false, true],
                    ['Compressor vibration check', true, false],
                    ['Defrost cycle verification', false, false],
                ],
            ],
        ];

        $templates = [];
        foreach ($defs as $slug => $def) {
            $template = ChecklistTemplate::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $def['name'],
                    'category' => $def['category'],
                    'version' => '1.0',
                    'is_active' => true,
                    'description' => "Mobile checklist for {$def['name']}.",
                    'item_count' => count($def['items']),
                ]
            );

            foreach ($def['items'] as $i => $item) {
                ChecklistTemplateItem::query()->updateOrCreate(
                    [
                        'checklist_template_id' => $template->id,
                        'sort_order' => $i + 1,
                    ],
                    [
                        'label' => $item[0],
                        'item_type' => 'pass_fail',
                        'requires_photo' => $item[1],
                        'is_critical' => $item[2],
                        'guidance' => 'Mark pass/fail and attach photo when required.',
                    ]
                );
            }

            $templates[$slug] = $template->fresh('items');
        }

        return $templates;
    }

    /**
     * @param  array<string, array{customer: Customer, site: Site}>  $customers
     * @param  array<string, ChecklistTemplate>  $templates
     * @param  array<string, User>  $users
     * @return array<int, WorkOrder>
     */
    protected function seedWorkOrders(array $customers, array $templates, array $users): array
    {
        $plan = [
            ['WO-1001', 'acme-facilities', 'hvac-quarterly', 'HVAC quarterly inspection', 'high', 'assigned'],
            ['WO-1002', 'delta-cold-chain', 'cold-storage', 'Cold room integrity check', 'urgent', 'in_progress'],
            ['WO-1003', 'greengrid-energy', 'fire-safety', 'Substation fire walkthrough', 'normal', 'open'],
            ['WO-1004', 'acme-facilities', 'fire-safety', 'Lobby fire safety revisit', 'low', 'completed'],
        ];

        $orders = [];
        foreach ($plan as [$number, $customerKey, $templateKey, $title, $priority, $status]) {
            $bundle = $customers[$customerKey];
            $orders[] = WorkOrder::query()->updateOrCreate(
                ['number' => $number],
                [
                    'customer_id' => $bundle['customer']->id,
                    'site_id' => $bundle['site']->id,
                    'technician_id' => $users['staff']->id,
                    'checklist_template_id' => $templates[$templateKey]->id,
                    'title' => $title,
                    'priority' => $priority,
                    'status' => $status,
                    'service_type' => $templates[$templateKey]->category,
                    'description' => 'Demo work order for field inspection workflows.',
                    'scheduled_at' => now()->subHours(random_int(1, 20)),
                    'due_at' => now()->addHours(random_int(4, 48)),
                    'started_at' => in_array($status, ['in_progress', 'completed'], true) ? now()->subHours(2) : null,
                    'completed_at' => $status === 'completed' ? now()->subHour() : null,
                ]
            );
        }

        return $orders;
    }

    /**
     * @param  array<int, WorkOrder>  $workOrders
     * @param  array<string, ChecklistTemplate>  $templates
     * @param  array<string, User>  $users
     * @return array<int, Inspection>
     */
    protected function seedInspections(array $workOrders, array $templates, array $users): array
    {
        $inspections = [];

        foreach ($workOrders as $index => $workOrder) {
            $template = $workOrder->checklistTemplate ?? $templates['hvac-quarterly'];
            $reference = 'INS-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT);

            $inspection = Inspection::query()->updateOrCreate(
                ['reference' => $reference],
                [
                    'work_order_id' => $workOrder->id,
                    'technician_id' => $users['staff']->id,
                    'checklist_template_id' => $template->id,
                    'status' => $workOrder->status === 'completed' ? 'completed' : ($workOrder->status === 'open' ? 'draft' : 'in_progress'),
                    'outcome' => $workOrder->status === 'completed' ? 'passed' : ($index === 1 ? 'conditional' : null),
                    'pass_rate' => $workOrder->status === 'completed' ? 100 : ($index === 1 ? 75 : 40),
                    'started_at' => now()->subHours(3 - $index),
                    'completed_at' => $workOrder->status === 'completed' ? now()->subHour() : null,
                    'notes' => 'Demo inspection with mobile checklist responses and photo evidence.',
                ]
            );

            foreach ($template->items as $item) {
                $result = match (true) {
                    $inspection->status === 'draft' => 'pending',
                    $item->is_critical && $index === 1 => 'fail',
                    default => 'pass',
                };

                $line = InspectionChecklistItem::query()->updateOrCreate(
                    [
                        'inspection_id' => $inspection->id,
                        'checklist_template_item_id' => $item->id,
                    ],
                    [
                        'label' => $item->label,
                        'result' => $result,
                        'is_critical' => $item->is_critical,
                        'notes' => $result === 'fail' ? 'Requires corrective action.' : null,
                        'sort_order' => $item->sort_order,
                    ]
                );

                if ($item->requires_photo && $result !== 'pending') {
                    PhotoEvidence::query()->updateOrCreate(
                        [
                            'inspection_id' => $inspection->id,
                            'inspection_checklist_item_id' => $line->id,
                            'caption' => $item->label.' evidence',
                        ],
                        [
                            'captured_by' => $users['staff']->id,
                            'file_path' => 'evidence/'.$reference.'/'.Str::slug($item->label).'.jpg',
                            'mime_type' => 'image/jpeg',
                            'file_size_kb' => random_int(220, 980),
                            'latitude' => 23.78,
                            'longitude' => 90.41,
                            'captured_at' => now()->subMinutes(random_int(10, 180)),
                        ]
                    );
                }
            }

            if ($index === 1) {
                InspectionFinding::query()->updateOrCreate(
                    [
                        'inspection_id' => $inspection->id,
                        'title' => 'Door seal compression loss',
                    ],
                    [
                        'severity' => 'high',
                        'description' => 'Cold storage door gasket shows uneven compression on the hinge side.',
                        'recommendation' => 'Replace gasket kit and re-test temperature hold overnight.',
                        'status' => 'open',
                    ]
                );
            }

            $inspections[] = $inspection->fresh(['photos', 'findings', 'workOrder']);
        }

        return $inspections;
    }

    /**
     * @param  array<int, Inspection>  $inspections
     * @param  array<string, User>  $users
     */
    protected function seedReports(array $inspections, array $users): void
    {
        foreach ($inspections as $inspection) {
            if (! in_array($inspection->status, ['completed', 'in_progress'], true)) {
                continue;
            }

            PdfReport::query()->updateOrCreate(
                ['slug' => Str::slug($inspection->reference.'-report')],
                [
                    'inspection_id' => $inspection->id,
                    'work_order_id' => $inspection->work_order_id,
                    'generated_by' => $users['staff']->id,
                    'title' => 'Inspection PDF — '.$inspection->reference,
                    'status' => 'ready',
                    'locale' => 'en',
                    'page_count' => 3 + $inspection->photos->count(),
                    'file_path' => 'reports/'.$inspection->reference.'.pdf',
                    'summary' => 'Customer-ready PDF pack with checklist scores and photo evidence.',
                    'generated_at' => now()->subMinutes(30),
                ]
            );

            WorkSummary::query()->updateOrCreate(
                [
                    'inspection_id' => $inspection->id,
                    'title' => 'Work Summary — '.$inspection->reference,
                ],
                [
                    'work_order_id' => $inspection->work_order_id,
                    'customer_id' => $inspection->workOrder?->customer_id,
                    'authored_by' => $users['staff']->id,
                    'status' => 'ready',
                    'headline' => $inspection->outcome === 'passed'
                        ? 'All critical checks passed'
                        : 'Findings recorded for follow-up',
                    'body' => 'Technician completed the mobile checklist and attached photo evidence for customer review.',
                    'recommendations' => $inspection->findings->first()?->recommendation
                        ?? 'Continue scheduled preventive maintenance.',
                    'photo_count' => $inspection->photos->count(),
                    'published_at' => now()->subMinutes(20),
                ]
            );
        }
    }
}
