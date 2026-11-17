<?php

namespace App\Http\Controllers;

use App\Models\ChecklistTemplate;
use App\Models\Customer;
use App\Models\Inspection;
use App\Models\PdfReport;
use App\Models\PhotoEvidence;
use App\Models\WorkOrder;
use App\Models\WorkSummary;
use App\Services\ModuleManager;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function home(ModuleManager $modules): View
    {
        return view('marketing.home', [
            'modules' => $modules->all(),
            'enabledCount' => count($modules->enabledKeys()),
            'weeklyHours' => $modules->weeklyHoursSaved(),
            'openOrders' => WorkOrder::query()->whereIn('status', ['open', 'assigned', 'in_progress'])->count(),
            'inspections' => Inspection::query()->count(),
            'photos' => PhotoEvidence::query()->count(),
            'reports' => PdfReport::query()->where('status', 'ready')->count(),
            'customers' => Customer::query()->where('status', 'active')->take(3)->get(),
            'checklists' => ChecklistTemplate::query()->where('is_active', true)->take(3)->get(),
        ]);
    }

    public function features(ModuleManager $modules): View
    {
        return view('marketing.features', [
            'modules' => $modules->all()->groupBy(fn (array $m) => $m['category'] ?? 'general'),
        ]);
    }

    public function modules(ModuleManager $modules): View
    {
        return view('marketing.modules', [
            'modules' => $modules->all(),
            'weeklyHours' => $modules->weeklyHoursSaved(),
        ]);
    }

    public function checklists(): View
    {
        return view('marketing.checklists', [
            'templates' => ChecklistTemplate::query()->with('items')->where('is_active', true)->get(),
        ]);
    }

    public function reports(): View
    {
        return view('marketing.reports', [
            'pdfReports' => PdfReport::query()->with('inspection')->latest()->take(8)->get(),
            'summaries' => WorkSummary::query()->with('customer')->latest()->take(8)->get(),
            'photoCount' => PhotoEvidence::query()->count(),
        ]);
    }

    public function pricing(ModuleManager $modules): View
    {
        $hours = $modules->weeklyHoursSaved();

        return view('marketing.pricing', [
            'weeklyHours' => $hours,
            'weeklyValue' => $hours * 45,
            'moduleCount' => $modules->all()->count(),
            'enabledCount' => count($modules->enabledKeys()),
        ]);
    }

    public function demo(): View
    {
        return view('marketing.demo', [
            'email' => config('fieldservice.demo.email'),
            'password' => config('fieldservice.demo.password'),
        ]);
    }
}
