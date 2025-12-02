<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Examples Overview</title>
    <style>
        :root {
            color-scheme: light;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Inter', 'PingFang SC', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: radial-gradient(circle at 10% 20%, #f5f7fb, #ffffff 70%);
            color: #1f2933;
            min-height: 100vh;
            padding: 2rem;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .hero {
            text-align: center;
            margin-bottom: 2rem;
        }
        .hero h1 {
            font-size: 2.4rem;
            margin-bottom: 0.5rem;
        }
        .hero p {
            color: #64748b;
            margin: 0;
        }
        .card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            color: #94a3b8;
        }
        th, td {
            padding: 0.9rem;
            text-align: left;
        }
        tbody tr {
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }
        tbody tr:hover {
            background: rgba(148, 163, 184, 0.12);
        }
        .empty {
            text-align: center;
            padding: 2rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
<div class="container">
    <header class="hero">
        <h1>Examples Overview</h1>
    </header>

    <section class="card">
        <table>
            <thead>
            <tr>
                <tr>
                <th>URI</th>
            </tr>
            </thead>
            <tbody>
            @forelse($routes as $route)
                <tr>
                    <td><a href="{{ url($route->uri()) }}" target="_blank" rel="noopener noreferrer">{{ $route->uri() }}</a></td>
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="5">No examples available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>
</div>
</body>
</html>
