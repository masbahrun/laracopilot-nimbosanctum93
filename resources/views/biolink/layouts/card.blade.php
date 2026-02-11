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
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-6">
            @if($biolink->banner_path)
            <div class="h-32 bg-gradient-to-r from-blue-500 to-purple-600">
                <img src="{{ $biolink->banner_url }}" class="w-full h-full object-cover">
            </div>
            @else
            <div class="h-32 bg-gradient-to-r from-blue-500 to-purple-600"></div>
            @endif
            <div class="px-8 pb-8 -mt-16">
                <img src="{{ $biolink->avatar_url }}" alt="{{ $biolink->title }}" class="w-32 h-32 rounded-2xl border-4 border-white shadow-xl mb-4">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $biolink->title }}</h1>
                @if($biolink->description)
                <p class="text-gray-600">{{ $biolink->description }}</p>
                @endif
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($bioItems as $item)
                @if($item->type === 'bio')
                    <div class="col-span-full bg-white rounded-xl p-6 shadow-lg">
                        <p class="text-gray-700">{{ $item->content }}</p>
                    </div>
                @elseif($item->type === 'link')
                    <a href="{{ $item->url }}" target="_blank" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
                        <div class="flex items-center">
                            @if($item->icon_path)
                            <img src="{{ $item->icon_url }}" class="w-8 h-8 mr-3">
                            @endif
                            <span class="text-gray-900 font-semibold">{{ $item->title }}</span>
                        </div>
                    </a>
                @elseif($item->type === 'text')
                    <div class="col-span-full bg-white rounded-xl p-6 shadow-lg">
                        <p class="text-gray-700">{{ $item->content }}</p>
                    </div>
                @elseif($item->type === 'image')
                    <a href="{{ $item->url }}" target="_blank" class="block rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <img src="{{ $item->icon_url }}" alt="{{ $item->title }}" class="w-full">
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</body>
</html>
