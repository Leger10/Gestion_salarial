<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carousel;

class CarouselSeeder extends Seeder
{
    public function run()
    {
        Carousel::create([
            'image' => 'image1.jpg',
            'titre' => 'Premier Slide',
            'commentaire' => 'Voici le premier commentaire du slide.'
        ]);

        Carousel::create([
            'image' => 'image2.jpg',
            'titre' => 'Deuxième Slide',
            'commentaire' => 'Voici le deuxième commentaire du slide.'
        ]);
    }
}

