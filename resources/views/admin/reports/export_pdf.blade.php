<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reports Export</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; font-size: 12px; }
        th { background: #f3f3f3; }
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>
    <h2>Filtered Reports Export</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Animal</th>
                <th>Camera</th>
                <th>Behavior</th>
                <th>Confidence</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->animal_name }}</td>
                    <td>{{ $report->camera }}</td>
                    <td>{{ $report->classification }}</td>
                    <td>{{ $report->confidence }}</td>
                    <td>{{ $report->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>