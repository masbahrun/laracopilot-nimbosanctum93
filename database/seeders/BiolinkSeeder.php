<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Biolink;

class BiolinkSeeder extends Seeder
{
    public function run()
    {
        $biolinks = [
            [
                'domain' => 'johndoe.bio',
                'title' => 'John Doe - Digital Creator',
                'description' => 'Content creator, photographer, and digital nomad',
                'seo_title' => 'John Doe | Digital Creator & Photographer',
                'seo_description' => 'Follow my journey as a digital creator and photographer traveling the world',
                'seo_keywords' => 'photography, digital creator, travel, content',
                'active' => true
            ],
            [
                'domain' => 'janesmithdesign.com',
                'title' => 'Jane Smith Design',
                'description' => 'UI/UX Designer & Brand Strategist',
                'seo_title' => 'Jane Smith | UI/UX Designer',
                'seo_description' => 'Creating beautiful digital experiences and brand identities',
                'seo_keywords' => 'design, ui, ux, branding, portfolio',
                'active' => true
            ],
            [
                'domain' => 'techguru.io',
                'title' => 'Tech Guru',
                'description' => 'Software Engineer & Tech Reviewer',
                'seo_title' => 'Tech Guru | Software Engineering & Reviews',
                'seo_description' => 'Reviews, tutorials, and insights on the latest tech',
                'seo_keywords' => 'technology, software, programming, reviews',
                'active' => true
            ],
            [
                'domain' => 'foodieblog.net',
                'title' => 'Foodie Adventures',
                'description' => 'Food blogger & recipe creator',
                'seo_title' => 'Foodie Adventures | Recipes & Food Reviews',
                'seo_description' => 'Delicious recipes and restaurant reviews from around the world',
                'seo_keywords' => 'food, recipes, cooking, restaurants',
                'active' => true
            ],
            [
                'domain' => 'fitlife.pro',
                'title' => 'FitLife Coach',
                'description' => 'Personal trainer & nutrition expert',
                'seo_title' => 'FitLife | Personal Training & Nutrition',
                'seo_description' => 'Transform your body and life with professional fitness coaching',
                'seo_keywords' => 'fitness, training, nutrition, health',
                'active' => true
            ],
            [
                'domain' => 'musicproducer.studio',
                'title' => 'Beat Master Studio',
                'description' => 'Music producer & sound engineer',
                'seo_title' => 'Beat Master | Music Production Studio',
                'seo_description' => 'Professional music production and sound engineering services',
                'seo_keywords' => 'music, production, beats, studio',
                'active' => true
            ],
            [
                'domain' => 'artistportfolio.art',
                'title' => 'Creative Artist',
                'description' => 'Digital artist & illustrator',
                'seo_title' => 'Creative Artist | Digital Art Portfolio',
                'seo_description' => 'Explore my digital art and illustration portfolio',
                'seo_keywords' => 'art, digital art, illustration, portfolio',
                'active' => true
            ],
            [
                'domain' => 'travelwithme.world',
                'title' => 'Travel With Me',
                'description' => 'Travel blogger & adventure seeker',
                'seo_title' => 'Travel With Me | Adventure & Travel Blog',
                'seo_description' => 'Join me on adventures around the world',
                'seo_keywords' => 'travel, adventure, blog, destinations',
                'active' => true
            ],
            [
                'domain' => 'fashionista.style',
                'title' => 'Fashionista Daily',
                'description' => 'Fashion blogger & style consultant',
                'seo_title' => 'Fashionista | Fashion & Style Tips',
                'seo_description' => 'Daily fashion inspiration and style tips',
                'seo_keywords' => 'fashion, style, trends, outfits',
                'active' => true
            ],
            [
                'domain' => 'gamerzone.gg',
                'title' => 'Gamer Zone',
                'description' => 'Pro gamer & game streamer',
                'seo_title' => 'Gamer Zone | Gaming & Streaming',
                'seo_description' => 'Watch me play and learn gaming strategies',
                'seo_keywords' => 'gaming, esports, streaming, games',
                'active' => true
            ],
            [
                'domain' => 'businesscoach.biz',
                'title' => 'Business Growth Coach',
                'description' => 'Business consultant & growth strategist',
                'seo_title' => 'Business Coach | Growth Strategy Consulting',
                'seo_description' => 'Scale your business with proven strategies',
                'seo_keywords' => 'business, consulting, growth, strategy',
                'active' => true
            ],
            [
                'domain' => 'petlover.pets',
                'title' => 'Pet Lover Community',
                'description' => 'Pet care tips & animal welfare',
                'seo_title' => 'Pet Lover | Pet Care & Animal Welfare',
                'seo_description' => 'Everything you need to know about pet care',
                'seo_keywords' => 'pets, animals, care, welfare',
                'active' => true
            ],
            [
                'domain' => 'yogamaster.zen',
                'title' => 'Yoga Master',
                'description' => 'Yoga instructor & mindfulness coach',
                'seo_title' => 'Yoga Master | Yoga & Mindfulness',
                'seo_description' => 'Find peace and balance through yoga',
                'seo_keywords' => 'yoga, meditation, mindfulness, wellness',
                'active' => true
            ],
            [
                'domain' => 'cryptotrader.crypto',
                'title' => 'Crypto Trader Pro',
                'description' => 'Cryptocurrency trader & analyst',
                'seo_title' => 'Crypto Trader | Cryptocurrency Analysis',
                'seo_description' => 'Daily crypto market analysis and trading signals',
                'seo_keywords' => 'cryptocurrency, trading, bitcoin, crypto',
                'active' => true
            ],
            [
                'domain' => 'bookworm.books',
                'title' => 'Bookworm Reviews',
                'description' => 'Book reviewer & literary critic',
                'seo_title' => 'Bookworm | Book Reviews & Recommendations',
                'seo_description' => 'Honest book reviews and reading recommendations',
                'seo_keywords' => 'books, reviews, reading, literature',
                'active' => true
            ]
        ];
        
        foreach ($biolinks as $biolink) {
            Biolink::create($biolink);
        }
    }
}