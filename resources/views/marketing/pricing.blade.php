@extends('layouts.marketing')

@section('title', 'Pricing & ROI')
@section('meta_description', 'ROI model for field inspection software: hours saved from modular checklists, photo evidence, and PDF reporting.')

@section('content')
<section class="hero">
    <div class="eyebrow">Business case</div>
    <h1>Reclaim technician and dispatch hours every week.</h1>
    <p>With {{ $enabledCount }} of {{ $moduleCount }} modules enabled, the demo model estimates <strong>{{ $weeklyHours }} hours/week</strong> (~${{ number_format($weeklyValue) }}/week at a $45 blended rate).</p>
</section>

<section class="section">
    <div class="grid">
        <div class="card">
            <h3>Starter</h3>
            <div class="kpi">Core</div>
            <p>Customers, work orders, checklists, inspections, photo evidence. Ideal for single-trade crews.</p>
        </div>
        <div class="card">
            <h3>Professional</h3>
            <div class="kpi">+ Reports</div>
            <p>Adds PDF packs, customer summaries, and AI assist for narrative drafts.</p>
        </div>
        <div class="card">
            <h3>Enterprise</h3>
            <div class="kpi">Full</div>
            <p>Standards catalog scrape, attendance bridge, multi-site dispatch, and SSO-ready admin.</p>
        </div>
    </div>
</section>
@endsection
