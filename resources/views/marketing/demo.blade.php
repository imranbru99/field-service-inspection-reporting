@extends('layouts.marketing')

@section('title', 'Demo Access')
@section('meta_description', 'Demo credentials for the Field Service Inspection & Reporting Tool Filament admin.')

@section('content')
<section class="hero">
    <div class="eyebrow">Try the product</div>
    <h1>Demo users for every role.</h1>
    <p>Password for seeded accounts: <strong>{{ $password }}</strong>. Prefer the dedicated demo login below for evaluators.</p>
</section>

<section class="section">
    <div class="grid">
        <div class="card">
            <h3>Demo evaluator</h3>
            <p>Email: <code>{{ $email }}</code><br>Password: <code>{{ $password }}</code></p>
            <p style="margin-top:.8rem"><a class="btn" href="/admin">Open Admin</a></p>
        </div>
        <div class="card">
            <h3>Other seeded roles</h3>
            <p>
                Super Admin: admin@field-inspection.test<br>
                Admin: ops-admin@field-inspection.test<br>
                Manager: manager@field-inspection.test<br>
                Technician: tech@field-inspection.test<br>
                Client: client@field-inspection.test
            </p>
        </div>
    </div>
</section>
@endsection
