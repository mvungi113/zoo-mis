{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detection Logs Export</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 4px; font-size: 12px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Detection Logs Export</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Animal Name</th>
                <th>Camera</th>
                <th>Confidence</th>
                <th>Classification</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log['id'] }}</td>
                <td>{{ $log['animal_name'] }}</td>
                <td>{{ $log['camera'] }}</td>
                <td>{{ $log['confidence'] }}</td>
                <td>{{ $log['classification'] }}</td>
                <td>{{ $log['created_at'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> --}}