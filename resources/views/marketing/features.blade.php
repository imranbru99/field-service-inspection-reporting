@extends('layouts.marketing')

@section('title', 'Features')
@section('meta_description', 'Feature catalog for field inspections: work orders, mobile checklists, photo evidence, PDF reports, AI assist, and modular toggles.')

@section('content')
<section class="hero">
    <div class="eyebrow">Feature catalog</div>
    <h1>Everything a modern field inspection business needs.</h1>
    <p>Grouped by module category so operators can map capabilities to HVAC, fire safety, utilities, and cold-chain programs.</p>
</section>

@foreach($modules as $category => $items)
<section class="section">
    <div class="eyebrow">{{ strtoupper($category) }}</div>
    <h2>{{ ucfirst(str_replace('_', ' ', $category)) }} capabilities</h2>
    <div class="grid" style="margin-top:1rem">
        @foreach($items as $module)
            <div class="card">
                <span class="pill {{ $module['enabled'] ? '' : 'off' }}">{{ $module['enabled'] ? 'ON' : 'OFF' }}</span>
                <h3 style="margin-top:.6rem">{{ $module['name'] }}</h3>
                <p>{{ $module['description'] }}</p>
            </div>
        @endforeach
    </div>
</section>
@endforeach
@endsection
