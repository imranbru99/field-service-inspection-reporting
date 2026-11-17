@extends('layouts.marketing')

@section('title', 'Reports & Summaries')
@section('meta_description', 'PDF inspection reports and customer-ready work summaries backed by geotagged photo evidence.')

@section('content')
<section class="hero">
    <div class="eyebrow">Evidence to delivery</div>
    <h1>Photo proof becomes PDFs and customer summaries.</h1>
    <p>{{ $photoCount }} photo evidence files currently linked to inspection runs in the demo dataset.</p>
</section>

<section class="section">
    <div class="eyebrow">PDF reports</div>
    <h2>Unicode-ready inspection packs</h2>
    <div class="grid" style="margin-top:1rem">
        @foreach($pdfReports as $report)
            <div class="card">
                <span class="pill">{{ $report->status }}</span>
                <h3 style="margin-top:.6rem">{{ $report->title }}</h3>
                <p>{{ $report->summary }} · {{ $report->page_count }} pages · {{ optional($report->inspection)->reference }}</p>
            </div>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="eyebrow">Customer summaries</div>
    <h2>Work summaries facilities teams can forward</h2>
    <div class="grid" style="margin-top:1rem">
        @foreach($summaries as $summary)
            <div class="card">
                <h3>{{ $summary->title }}</h3>
                <p><strong>{{ $summary->headline }}</strong> — {{ $summary->body }}</p>
            </div>
        @endforeach
    </div>
</section>
@endsection
