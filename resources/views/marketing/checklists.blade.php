@extends('layouts.marketing')

@section('title', 'Mobile Checklists')
@section('meta_description', 'Reusable mobile inspection checklist templates with critical items, photo requirements, and pass/fail scoring.')

@section('content')
<section class="hero">
    <div class="eyebrow">Checklist library</div>
    <h1>Mobile checklists technicians finish on site.</h1>
    <p>Each template carries scored items, critical flags, and photo-required steps that feed PDF reports and customer summaries.</p>
</section>

@foreach($templates as $template)
<section class="section">
    <div class="eyebrow">{{ $template->category }}</div>
    <h2>{{ $template->name }} <span class="pill">v{{ $template->version }}</span></h2>
    <p style="color:var(--muted)">{{ $template->description }}</p>
    <div class="grid" style="margin-top:1rem">
        @foreach($template->items as $item)
            <div class="card">
                <h3>#{{ $item->sort_order }} {{ $item->label }}</h3>
                <p>
                    {{ $item->is_critical ? 'Critical · ' : '' }}
                    {{ $item->requires_photo ? 'Photo required · ' : '' }}
                    {{ $item->guidance }}
                </p>
            </div>
        @endforeach
    </div>
</section>
@endforeach
@endsection
