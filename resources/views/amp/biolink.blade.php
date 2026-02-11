<!doctype html>
<html amp lang="en">
<head>
    <meta charset="utf-8">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <title>{{ $biolink->seo_title ?? $biolink->title }}</title>
    <link rel="canonical" href="http://{{ $biolink->domain }}">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="description" content="{{ $biolink->seo_description ?? $biolink->description }}">
    @if($biolink->seo_keywords)
    <meta name="keywords" content="{{ $biolink->seo_keywords }}">
    @endif
    {!! $biolink->custom_metatags !!}
    
    <!-- AMP Boilerplate -->
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    
    <!-- Custom AMP Styles -->
    <style amp-custom>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 0 16px;
        }
        .profile {
            text-align: center;
            margin-bottom: 32px;
        }
        .avatar {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: block;
            border: 3px solid #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .banner {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 16px;
        }
        .title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 8px 0;
        }
        .description {
            font-size: 14px;
            color: #666;
            margin: 0 0 24px 0;
            line-height: 1.5;
        }
        .bio-item {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .bio-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .bio-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #1a1a1a;
        }
        .bio-icon {
            width: 32px;
            height: 32px;
            margin-right: 12px;
            border-radius: 6px;
        }
        .bio-title {
            font-size: 16px;
            font-weight: 600;
            flex-grow: 1;
        }
        .bio-arrow {
            width: 20px;
            height: 20px;
            color: #999;
        }
        .bio-text {
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        .bio-content {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
            margin-top: 8px;
        }
        .bio-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
        }
        .footer {
            text-align: center;
            padding: 32px 0;
            color: #999;
            font-size: 12px;
        }
        .amp-badge {
            display: inline-block;
            padding: 4px 12px;
            background: {{ $biolink->theme_color ?? '#667eea' }};
            color: #fff;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Profile Section -->
        <div class="profile">
            @if($biolink->banner_path)
            <amp-img src="{{ $biolink->banner_url }}" 
                     width="600" 
                     height="120" 
                     layout="responsive"
                     class="banner"
                     alt="Banner">
            </amp-img>
            @endif
            
            <amp-img src="{{ $biolink->avatar_url }}" 
                     width="96" 
                     height="96" 
                     layout="fixed"
                     class="avatar"
                     alt="{{ $biolink->title }}">
            </amp-img>
            
            <h1 class="title">{{ $biolink->title }}</h1>
            
            @if($biolink->description)
            <p class="description">{{ $biolink->description }}</p>
            @endif
            
            <span class="amp-badge">⚡ AMP Enabled</span>
        </div>
        
        <!-- Bio Items -->
        @foreach($bioItems as $item)
            @if($item->type === 'bio')
                <div class="bio-item">
                    @if($item->title)
                    <div class="bio-title">{{ $item->title }}</div>
                    @endif
                    @if($item->content)
                    <div class="bio-content">{{ $item->content }}</div>
                    @endif
                </div>
            @elseif($item->type === 'link')
                <div class="bio-item">
                    <a href="{{ $item->url }}" class="bio-link" target="_blank" rel="noopener">
                        @if($item->icon_path)
                        <amp-img src="{{ $item->icon_url }}" 
                                 width="32" 
                                 height="32" 
                                 layout="fixed"
                                 class="bio-icon"
                                 alt="Icon">
                        </amp-img>
                        @endif
                        <span class="bio-title">{{ $item->title }}</span>
                        <svg class="bio-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @elseif($item->type === 'text')
                <div class="bio-item">
                    @if($item->title)
                    <div class="bio-title">{{ $item->title }}</div>
                    @endif
                    @if($item->content)
                    <div class="bio-text">{{ $item->content }}</div>
                    @endif
                </div>
            @elseif($item->type === 'image' && $item->icon_path)
                <div class="bio-item">
                    @if($item->url)
                    <a href="{{ $item->url }}" target="_blank" rel="noopener">
                        <amp-img src="{{ $item->icon_url }}" 
                                 width="600" 
                                 height="400" 
                                 layout="responsive"
                                 class="bio-image"
                                 alt="{{ $item->title }}">
                        </amp-img>
                    </a>
                    @else
                    <amp-img src="{{ $item->icon_url }}" 
                             width="600" 
                             height="400" 
                             layout="responsive"
                             class="bio-image"
                             alt="{{ $item->title }}">
                    </amp-img>
                    @endif
                    @if($item->title)
                    <div class="bio-title" style="margin-top: 12px;">{{ $item->title }}</div>
                    @endif
                </div>
            @endif
        @endforeach
        
        <!-- Footer -->
        <div class="footer">
            <p>{{ $biolink->domain }}</p>
            <p>Powered by AMP Technology</p>
        </div>
    </div>
</body>
</html>
