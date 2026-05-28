<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Tech Conference 2026',
                'description' => 'A full-day conference covering the latest in web development, AI, and cloud computing. Featuring keynote speakers from top tech companies.',
                'date' => '2026-06-15 09:00:00',
                'price' => 49.99,
                'capacity' => 200,
            ],
            [
                'title' => 'Summer Music Festival',
                'description' => 'An outdoor music festival featuring local and international artists. Food trucks, craft beer, and great vibes all day long.',
                'date' => '2026-07-20 14:00:00',
                'price' => 75.00,
                'capacity' => 500,
            ],
            [
                'title' => 'Startup Pitch Night',
                'description' => 'Watch 10 startups pitch their ideas to a panel of investors. Network with founders and VCs over drinks and appetizers.',
                'date' => '2026-05-10 18:00:00',
                'price' => 15.00,
                'capacity' => 100,
            ],
            [
                'title' => 'Photography Workshop',
                'description' => 'Hands-on workshop covering portrait photography, lighting techniques, and post-processing. Bring your own camera.',
                'date' => '2026-08-05 10:00:00',
                'price' => 35.00,
                'capacity' => 30,
            ],
            [
                'title' => 'Charity Gala Dinner',
                'description' => 'An elegant evening of fine dining, live entertainment, and a silent auction. All proceeds go to local children\'s charities.',
                'date' => '2026-09-12 19:00:00',
                'price' => 120.00,
                'capacity' => 150,
            ],
        ];

        foreach ($events as $event) {
            Event::firstOrCreate(
                ['title' => $event['title']],
                $event
            );
        }
    }
}
