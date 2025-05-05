<table class="table-auto w-full text-left border-collapse">
    <thead>
        <tr>
            <th class="px-4 py-2 border">Timestamp</th>
            <th class="px-4 py-2 border">Animal</th>
            <th class="px-4 py-2 border">Confidence (%)</th>
            <th class="px-4 py-2 border">Status</th>
            <th class="px-4 py-2 border">Camera</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $log)
            <tr>
                <td class="px-4 py-2 border">{{ $log['created_at'] ?? '-' }}</td>
                <td class="px-4 py-2 border">{{ $log['animal_name'] ?? '-' }}</td>
                <td class="px-4 py-2 border">{{ $log['confidence'] ?? '-' }}</td>
                <td class="px-4 py-2 border">{{ $log['classification'] ?? '-' }}</td>
                <td class="px-4 py-2 border">{{ $log['camera'] ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
