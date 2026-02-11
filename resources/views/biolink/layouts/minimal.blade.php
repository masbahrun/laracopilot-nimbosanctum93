<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $biolink->seo_title ?? $biolink->title }}</title>
    <meta name="description" content="{{ $biolink->seo_description ?? $biolink->description }}">
    <meta name="keywords" content="{{ $biolink->seo_keywords }}">
    {!! $biolink->custom_metatags !!}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-xl mx-auto px-4">
        <div class="text-center mb-8">
            <img src="{{ $biolink->avatar_url }}" alt="{{ $biolink->title }}" class="w-24 h-24 rounded-full mx-auto mb-4 border-2 border-gray-200">
            <h1 class="text-2xl font-light text-gray-900 mb-2">{{ $biolink->title }}</h1>
            @if($biolink->description)
            <p class="text-gray-600 text-sm">{{ $biolink->description }}</p>
            @endif
        </div>
        
        <div class="space-y-3">
            @foreach($bioItems as $item)
                @if($item->type === 'bio')
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-gray-700 text-sm">{{ $item->content }}</p>
                    </div>
                @elseif($item->type === 'link')
                    <a href="{{ $item->url }}" target="_blank" class="block bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            @if($item->icon_path)
                            <img src="{{ $item->icon_url }}" class="w-5 h-5 mr-3">
                            @endif
                            <span class="text-gray-900 font-light">{{ $item->title }}</span>
                        </div>
                    </a>
                @elseif($item->type === 'text')
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-gray-700 text-sm">{{ $item->content }}</p>
                    </div>
                @elseif($item->type === 'image')
                    <a href="{{ $item->url }}" target="_blank" class="block rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <img src="{{ $item->icon_url }}" alt="{{ $item->title }}" class="w-full">
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</body>
</html>
