<!-- resources/views/page-visits.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Visits</title>
</head>
<body>
    <div class="container">
        <h1>Page Visits</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>IP Address</th>
                    <th>URL</th>
                    <th>Browser</th>
                    <th>Device Type</th>
                    <th>Referrer</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pageVisits as $visit)
                    <tr>
                        <td>{{ $visit->ip_address }}</td>
                        <td>{{ $visit->url }}</td>
                        <td>{{ $visit->browser }}</td>
                        <td>{{ $visit->device_type }}</td>
                        <td>{{ $visit->referrer }}</td>
                        <td>{{ $visit->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
