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
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-2xl mx-auto">
        @if($biolink->banner_path)
        <div class="h-48 bg-gradient-to-r from-pink-500 to-orange-500">
            <img src="{{ $biolink->banner_url }}" class="w-full h-full object-cover">
        </div>
        @else
        <div class="h-48 bg-gradient-to-r from-pink-500 to-orange-500"></div>
        @endif
        
        <div class="bg-white px-6 pb-6">
            <div class="flex items-end -mt-16 mb-4">
                <img src="{{ $biolink->avatar_url }}" alt="{{ $biolink->title }}" class="w-32 h-32 rounded-full border-4 border-white shadow-xl">
                <div class="ml-6 mb-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $biolink->title }}</h1>
                    @if($biolink->description)
                    <p class="text-gray-600">{{ $biolink->description }}</p>
                    @endif
                </div>
            </div>
            
            <div class="space-y-3 mt-6">
                @foreach($bioItems as $item)
                    @if($item->type === 'bio')
                        <div class="border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-700">{{ $item->content }}</p>
                        </div>
                    @elseif($item->type === 'link')
                        <a href="{{ $item->url }}" target="_blank" class="flex items-center justify-between border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                @if($item->icon_path)
                                <img src="{{ $item->icon_url }}" class="w-6 h-6 mr-3 rounded">
                                @endif
                                <span class="text-gray-900 font-medium">{{ $item->title }}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @elseif($item->type === 'text')
                        <div class="border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-700">{{ $item->content }}</p>
                        </div>
                    @elseif($item->type === 'image')
                        <a href="{{ $item->url }}" target="_blank" class="block rounded-lg overflow-hidden border border-gray-200">
                            <img src="{{ $item->icon_url }}" alt="{{ $item->title }}" class="w-full">
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
