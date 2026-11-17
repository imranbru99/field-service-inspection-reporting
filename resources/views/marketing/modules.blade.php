@extends('layouts.marketing')

@section('title', 'Modules')
@section('meta_description', 'Toggle field service modules on or off: work orders, checklists, photo evidence, PDF reports, AI assist, and attendance.')

@section('content')
<section class="hero">
    <div class="eyebrow">Modular platform</div>
    <h1>Run only the modules your field business needs.</h1>
    <p>Estimated capacity from enabled modules: <strong>{{ $weeklyHours }} hours/week</strong>. Core modules stay available for inspection-critical workflows.</p>
</section>

<section class="section">
    <table>
        <thead>
            <tr>
                <th>Module</th>
                <th>Category</th>
                <th>Status</th>
                <th>Hrs/wk</th>
                <th>Core</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modules as $module)
                <tr>
                    <td>
                        <strong>{{ $module['name'] }}</strong><br>
                        <span style="color:var(--muted);font-size:.88rem">{{ $module['description'] }}</span>
                    </td>
                    <td>{{ $module['category'] ?? '—' }}</td>
                    <td><span class="pill {{ $module['enabled'] ? '' : 'off' }}">{{ $module['enabled'] ? 'Enabled' : 'Disabled' }}</span></td>
                    <td>{{ $module['hours_saved_weekly'] ?? 0 }}</td>
                    <td>{{ !empty($module['core']) ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
