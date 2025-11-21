<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['title'] ?? 'Demo Page' }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        pre { background: #f0f0f0; padding: 10px; }
        .alert-success { background: #d4edda; padding: 10px; margin: 10px 0; }
        .alert-error { background: #f8d7da; padding: 10px; margin: 10px 0; }
        ul { margin: 10px 0; padding-left: 20px; }
        img { max-width: 100%; height: auto; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>{{ $data['title'] ?? 'Demo Page' }}</h1>

    @foreach($data['sections'] ?? [] as $sec)
        @switch($sec['type'] ?? '')
            @case('text')
                <h2>{{$sec['title'] ?? ''}}</h2>
                <p>{{ $sec['text'] ?? '' }}</p>
                @break

            @case('img')
                <img src="{{ $sec['src'] ?? '' }}" alt="{{ $sec['alt'] ?? '' }}" />
                @break

            @case('code')
                <pre><code>{{ $sec['code'] ?? '' }}</code></pre>
                @break

            @case('alert')
                <div class="alert-{{ $sec['alertType'] ?? 'success' }}">
                    {{ $sec['message'] ?? '' }}
                </div>
                @break

            @case('list')
                <ul>
                    @foreach($sec['items'] ?? [] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
                @break
        @endswitch
    @endforeach

</body>
</html>
