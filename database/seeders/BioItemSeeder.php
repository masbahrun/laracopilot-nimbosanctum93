<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Biolink;
use App\Models\BioItem;

class BioItemSeeder extends Seeder
{
    public function run()
    {
        $biolinks = Biolink::all();
        
        foreach ($biolinks as $biolink) {
            // Bio item
            BioItem::create([
                'biolink_id' => $biolink->id,
                'type' => 'bio',
                'title' => 'About Me',
                'content' => 'Welcome to my bio page! I\'m passionate about what I do and love connecting with people.',
                'order' => 1,
                'active' => true
            ]);
            
            // Links
            $links = [
                ['title' => 'Website', 'url' => 'https://example.com'],
                ['title' => 'YouTube Channel', 'url' => 'https://youtube.com/@example'],
                ['title' => 'Instagram', 'url' => 'https://instagram.com/example'],
                ['title' => 'Twitter/X', 'url' => 'https://twitter.com/example'],
                ['title' => 'LinkedIn', 'url' => 'https://linkedin.com/in/example'],
            ];
            
            foreach ($links as $index => $link) {
                BioItem::create([
                    'biolink_id' => $biolink->id,
                    'type' => 'link',
                    'title' => $link['title'],
                    'url' => $link['url'],
                    'order' => $index + 2,
                    'active' => true
                ]);
            }
            
            // Text item
            BioItem::create([
                'biolink_id' => $biolink->id,
                'type' => 'text',
                'title' => 'Contact Info',
                'content' => 'Email: contact@example.com | Phone: +1 234 567 890',
                'order' => 8,
                'active' => true
            ]);
        }
    }
}