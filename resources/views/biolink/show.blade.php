<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $biolink->seo_title ?? $biolink->title }}</title>
    <meta name="description" content="{{ $biolink->seo_description ?? $biolink->description }}">
    @if($biolink->seo_keywords)
    <meta name="keywords" content="{{ $biolink->seo_keywords }}">
    @endif
    <meta property="og:title" content="{{ $biolink->seo_title ?? $biolink->title }}">
    <meta property="og:description" content="{{ $biolink->seo_description ?? $biolink->description }}">
    @if($biolink->avatar_path)
    <meta property="og:image" content="{{ $biolink->avatar_url }}">
    @endif
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $biolink->seo_title ?? $biolink->title }}">
    <meta name="twitter:description" content="{{ $biolink->seo_description ?? $biolink->description }}">
    
    @if($biolink->custom_metatags)
    {!! $biolink->custom_metatags !!}
    @endif
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .bio-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .bio-link {
            transition: all 0.3s ease;
        }
        .bio-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Banner -->
        @if($biolink->banner_path)
        <div class="mb-6 rounded-2xl overflow-hidden shadow-xl">
            <img src="{{ $biolink->banner_url }}" alt="Banner" class="w-full h-48 object-cover">
        </div>
        @endif
        
        <!-- Profile Card -->
        <div class="bio-card rounded-2xl shadow-2xl p-8 mb-6 text-center">
            <!-- Avatar -->
            <div class="mb-6">
                <img src="{{ $biolink->avatar_url }}" alt="{{ $biolink->title }}" 
                     class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg object-cover">
            </div>
            
            <!-- Title & Description -->
            <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $biolink->title }}</h1>
            @if($biolink->description)
            <p class="text-gray-600 text-lg mb-6">{{ $biolink->description }}</p>
            @endif
            
            <!-- Bio Items -->
            <div class="space-y-4">
                @foreach($biolink->bioItems as $item)
                    @if($item->type === 'bio')
                        <div class="bg-gray-50 rounded-lg p-6 text-left">
                            @if($item->title)
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $item->title }}</h3>
                            @endif
                            <p class="text-gray-700">{{ $item->content }}</p>
                        </div>
                    @elseif($item->type === 'link')
                        <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" 
                           class="bio-link block bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg p-4 font-semibold hover:from-purple-600 hover:to-pink-600 shadow-md">
                            <div class="flex items-center justify-center space-x-3">
                                @if($item->icon_path)
                                <img src="{{ $item->icon_url }}" alt="Icon" class="w-6 h-6 rounded">
                                @else
                                <i class="fas fa-link"></i>
                                @endif
                                <span>{{ $item->title }}</span>
                            </div>
                        </a>
                    @elseif($item->type === 'image')
                        @if($item->url)
                        <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="block">
                            <div class="rounded-lg overflow-hidden shadow-md">
                                <img src="{{ $item->url }}" alt="{{ $item->title }}" class="w-full h-auto">
                                @if($item->title)
                                <div class="bg-white p-3 text-center font-semibold text-gray-800">{{ $item->title }}</div>
                                @endif
                            </div>
                        </a>
                        @endif
                    @elseif($item->type === 'text')
                        <div class="bg-blue-50 rounded-lg p-4 text-left">
                            @if($item->title)
                            <h4 class="font-semibold text-blue-900 mb-2">{{ $item->title }}</h4>
                            @endif
                            <p class="text-blue-800">{{ $item->content }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center text-white text-sm">
            <p class="mb-2">© {{ date('Y') }} {{ $biolink->title }}</p>
            <p>Powered by <a href="https://laracopilot.com/" target="_blank" class="underline hover:text-gray-200">LaraCopilot</a></p>
        </div>
    </div>
</body>
</html>
