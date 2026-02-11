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
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen py-12">
    <div class="max-w-xl mx-auto px-4">
        <div class="text-center mb-8">
            <img src="{{ $biolink->avatar_url }}" alt="{{ $biolink->title }}" class="w-28 h-28 rounded-full mx-auto mb-4 border-4 border-white shadow-xl">
            <h1 class="text-3xl font-bold text-white mb-2">{{ $biolink->title }}</h1>
            @if($biolink->description)
            <p class="text-white text-opacity-90">{{ $biolink->description }}</p>
            @endif
        </div>
        
        <div class="space-y-4">
            @foreach($bioItems as $item)
                @if($item->type === 'bio')
                    <div class="glass rounded-xl p-5">
                        <p class="text-white">{{ $item->content }}</p>
                    </div>
                @elseif($item->type === 'link')
                    <a href="{{ $item->url }}" target="_blank" class="glass rounded-xl p-5 block hover:bg-white hover:bg-opacity-20 transition-all">
                        <div class="flex items-center text-white">
                            @if($item->icon_path)
                            <img src="{{ $item->icon_url }}" class="w-6 h-6 mr-3">
                            @endif
                            <span class="font-medium">{{ $item->title }}</span>
                        </div>
                    </a>
                @elseif($item->type === 'text')
                    <div class="glass rounded-xl p-5">
                        <p class="text-white">{{ $item->content }}</p>
                    </div>
                @elseif($item->type === 'image')
                    <a href="{{ $item->url }}" target="_blank" class="block rounded-xl overflow-hidden">
                        <img src="{{ $item->icon_url }}" alt="{{ $item->title }}" class="w-full">
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</body>
</html>
