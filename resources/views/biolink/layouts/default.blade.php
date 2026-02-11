<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $biolink->seo_title ?? $biolink->title }}</title>
    <meta name="description" content="{{ $biolink->seo_description ?? $biolink->description }}">
    <meta name="keywords" content="{{ $biolink->seo_keywords }}">
    {!! $biolink->custom_metatags !!}
    
    <!-- AMP Version Link -->
    <link rel="amphtml" href="{{ url('/ampproject/' . $biolink->domain) }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $biolink->theme_color ?? "#667eea" }}'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Banner -->
        @if($biolink->banner_path)
        <div class="mb-6 rounded-2xl overflow-hidden shadow-lg">
            <img src="{{ $biolink->banner_url }}" alt="Banner" class="w-full h-48 object-cover">
        </div>
        @endif
        
        <!-- Profile -->
        <div class="text-center mb-8">
            <img src="{{ $biolink->avatar_url }}" alt="{{ $biolink->title }}" class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-white shadow-xl">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $biolink->title }}</h1>
            @if($biolink->description)
            <p class="text-gray-600 mb-4">{{ $biolink->description }}</p>
            @endif
            
            <!-- AMP Link Badge -->
            <a href="{{ url('/ampproject/' . $biolink->domain) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-full text-sm hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 19.5h9l-1 2.5 10-17.5h-9l1-2.5z"/>
                </svg>
                View AMP Version
            </a>
        </div>
        
        <!-- Bio Items -->
        <div class="space-y-4">
            @foreach($bioItems as $item)
                @if($item->type === 'bio')
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        @if($item->title)
                        <h3 class="font-bold text-lg mb-2">{{ $item->title }}</h3>
                        @endif
                        <p class="text-gray-700">{{ $item->content }}</p>
                    </div>
                @elseif($item->type === 'link')
                    <a href="{{ $item->url }}" target="_blank" class="block bg-white rounded-xl p-5 shadow-md hover:shadow-xl transition-all hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-grow">
                                @if($item->icon_path)
                                <img src="{{ $item->icon_url }}" class="w-10 h-10 rounded-lg mr-4">
                                @endif
                                <span class="text-gray-900 font-semibold">{{ $item->title }}</span>
                            </div>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                @elseif($item->type === 'text')
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        @if($item->title)
                        <h3 class="font-bold text-lg mb-2">{{ $item->title }}</h3>
                        @endif
                        <p class="text-gray-700">{{ $item->content }}</p>
                    </div>
                @elseif($item->type === 'image')
                    <div class="bg-white rounded-xl overflow-hidden shadow-md">
                        @if($item->url)
                        <a href="{{ $item->url }}" target="_blank">
                            <img src="{{ $item->icon_url }}" alt="{{ $item->title }}" class="w-full hover:opacity-95 transition-opacity">
                        </a>
                        @else
                        <img src="{{ $item->icon_url }}" alt="{{ $item->title }}" class="w-full">
                        @endif
                        @if($item->title)
                        <div class="p-4">
                            <h3 class="font-bold text-lg">{{ $item->title }}</h3>
                        </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-12 text-gray-500 text-sm">
            <p>{{ $biolink->domain }}</p>
        </div>
    </div>
</body>
</html>
