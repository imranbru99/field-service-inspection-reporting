<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Field Service Inspection & Reporting Tool') — FieldInspect</title>
    <meta name="description" content="@yield('meta_description', 'Field service inspection and reporting tool with mobile checklists, photo evidence, PDF reports, and customer-ready work summaries for technicians.')">
    <meta name="keywords" content="field service inspection, mobile checklist, photo evidence, PDF inspection report, work order, technician reporting, Laravel Filament">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #4338CA;
            --accent-dark: #312E81;
            --ink: #1e1b4b;
            --muted: #4c4a6a;
            --mist: #eef2ff;
            --line: #c7d2fe;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "DM Sans", system-ui, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(1000px 480px at 0% -10%, #a5b4fc 0%, transparent 55%),
                radial-gradient(900px 420px at 100% 0%, #818cf8 0%, transparent 40%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 40%, #eef2ff 100%);
            min-height: 100vh;
        }
        a { color: var(--accent); text-decoration: none; }
        .wrap { width: min(1120px, 92%); margin: 0 auto; }
        header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 0; gap: 1rem; flex-wrap: wrap;
        }
        .brand {
            font-family: "Space Grotesk", sans-serif;
            font-size: 1.4rem; color: var(--accent-dark); letter-spacing: -0.02em;
        }
        nav { display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; }
        nav a { color: var(--muted); font-weight: 500; font-size: .92rem; }
        nav a:hover { color: var(--accent); }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--accent); color: #fff !important; border-radius: 12px;
            padding: .7rem 1.15rem; font-weight: 700; border: 0; cursor: pointer;
            box-shadow: 0 12px 28px rgba(67, 56, 202, .28);
        }
        .btn.secondary { background: transparent; color: var(--accent) !important; border: 1.5px solid var(--accent); box-shadow: none; }
        .hero { padding: 3.2rem 0 2.2rem; display: grid; gap: 1.1rem; max-width: 780px; }
        .hero h1 {
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(2.3rem, 5vw, 3.5rem); line-height: 1.08; margin: 0;
            color: var(--ink);
        }
        .hero p { font-size: 1.12rem; color: var(--muted); margin: 0; line-height: 1.65; }
        .cta-row { display: flex; gap: .8rem; flex-wrap: wrap; margin-top: .4rem; }
        .grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        .card {
            background: rgba(255,255,255,.88); border: 1px solid var(--line);
            border-radius: 18px; padding: 1.15rem 1.2rem;
            backdrop-filter: blur(6px);
        }
        .card h3 { margin: 0 0 .4rem; font-size: 1.05rem; }
        .card p { margin: 0; color: var(--muted); line-height: 1.5; font-size: .94rem; }
        .section { padding: 2.4rem 0; }
        .section h2 {
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(1.75rem, 3vw, 2.35rem); margin: 0 0 .45rem;
        }
        .eyebrow { color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: .08em; font-size: .72rem; }
        .pill {
            display: inline-block; padding: .2rem .55rem; border-radius: 999px;
            background: #e0e7ff; color: var(--accent-dark); font-size: .72rem; font-weight: 700;
        }
        .pill.off { background: #fee2e2; color: #991b1b; }
        footer { border-top: 1px solid var(--line); margin-top: 3rem; padding: 2rem 0 3rem; color: var(--muted); font-size: .92rem; }
        .kpi { font-size: 1.75rem; font-weight: 700; color: var(--accent-dark); }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 16px; overflow: hidden; }
        th, td { text-align: left; padding: .85rem 1rem; border-bottom: 1px solid var(--line); font-size: .94rem; }
        th { background: #e0e7ff; color: var(--accent-dark); }
    </style>
</head>
<body>
<div class="wrap">
    <header>
        <a class="brand" href="{{ route('home') }}">FieldInspect</a>
        <nav>
            <a href="{{ route('features') }}">Features</a>
            <a href="{{ route('modules') }}">Modules</a>
            <a href="{{ route('checklists') }}">Checklists</a>
            <a href="{{ route('reports') }}">Reports</a>
            <a href="{{ route('pricing') }}">Pricing / ROI</a>
            <a href="{{ route('demo') }}">Demo</a>
            <a class="btn" href="/admin">Admin Login</a>
        </nav>
    </header>

    @yield('content')

    <footer>
        <strong style="color:var(--ink)">Field Service Inspection &amp; Reporting Tool</strong> — built by
        <a href="https://imrandev.bd">Imran Ahmed</a> · <a href="https://imrandev.bd/contact">Contact</a>
    </footer>
</div>
</body>
</html>
