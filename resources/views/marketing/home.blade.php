@extends('layouts.marketing')

@section('title', 'Field Service Inspection & Reporting Tool')
@section('meta_description', 'Field service inspection and reporting tool with mobile checklists, photo evidence, PDF reports, and customer-ready work summaries for technicians.')

@section('content')
<section class="hero">
    <div class="eyebrow">Field service operations</div>
    <h1>Inspect once. Prove everything. Deliver customer-ready reports.</h1>
    <p>Mobile checklists, geotagged photo evidence, Unicode PDF packs, and work summaries — toggled by module so HVAC, facilities, utilities, and cold-chain teams run only what they need.</p>
    <div class="cta-row">
        <a class="btn" href="{{ route('demo') }}">Launch Demo</a>
        <a class="btn secondary" href="{{ route('modules') }}">Explore Modules</a>
    </div>
</section>

<section class="section">
    <div class="grid">
        <div class="card"><div class="kpi">{{ $openOrders }}</div><p>Open / active work orders</p></div>
        <div class="card"><div class="kpi">{{ $enabledCount }}</div><p>Modules enabled right now</p></div>
        <div class="card"><div class="kpi">{{ $weeklyHours }}h</div><p>Estimated weekly hours saved</p></div>
        <div class="card"><div class="kpi">{{ $photos }}</div><p>Photo evidence artifacts</p></div>
    </div>
</section>

<section class="section">
    <div class="eyebrow">Customers & sites</div>
    <h2>Accounts technicians visit every week</h2>
    <div class="grid" style="margin-top:1rem">
        @foreach($customers as $customer)
            <div class="card">
                <span class="pill">{{ $customer->industry }}</span>
                <h3 style="margin-top:.6rem">{{ $customer->name }}</h3>
                <p>{{ $customer->notes }}</p>
            </div>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="eyebrow">Checklist library</div>
    <h2>Reusable mobile inspection templates</h2>
    <div class="grid" style="margin-top:1rem">
        @foreach($checklists as $checklist)
            <div class="card">
                <h3>{{ $checklist->name }}</h3>
                <p>{{ $checklist->description }} · {{ $checklist->item_count }} items · v{{ $checklist->version }}</p>
            </div>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="eyebrow">Proof & delivery</div>
    <h2>{{ $inspections }} inspections · {{ $reports }} PDF reports ready</h2>
    <p style="color:var(--muted);max-width:640px">Every completed run can emit a Unicode PDF pack and a customer work summary without leaving the indigo FieldInspect dashboard.</p>
</section>
@endsection
