<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getArtistData();

        foreach ($data as $artist) {
            Artist::updateOrCreate($artist);
        }
    }

    private function getArtistData(): array
    {
        return [
            ['name' => 'Radiohead', 'type' => 'band'],
            ['name' => 'The Beatles', 'type' => 'band'],
            ['name' => 'Ghost', 'type' => 'band'],
            ['name' => 'Jack White', 'type' => 'solo'],
            ['name' => 'Thom Yorke', 'type' => 'solo'],
            ['name' => 'Paul McCartney', 'type' => 'solo'],
            ['name' => 'Depeche Mode', 'type' => 'band'],
            ['name' => 'The White Stripes', 'type' => 'band'],
            ['name' => 'Gojira', 'type' => 'band'],
            ['name' => 'Led Zeppelin', 'type' => 'band'],
            ['name' => 'Talk Talk', 'type' => 'band'],
            ['name' => 'David Bowie', 'type' => 'solo'],
            ['name' => 'Royal Blood', 'type' => 'band'],
            ['name' => 'Godspeed You! Black Emperor', 'type' => 'band'],
            ['name' => 'God Is An Astronaut', 'type' => 'band'],
            ['name' => 'Daft Punk', 'type' => 'duo'],
            ['name' => 'The Mars Volta', 'type' => 'band'],
            ['name' => 'Arctic Monkeys', 'type' => 'band'],
            ['name' => 'Fleetwood Mac', 'type' => 'band'],
            ['name' => 'Rush', 'type' => 'band'],
            ['name' => 'Nick Cave & The Bad Seeds', 'type' => 'band'],
            ['name' => 'Nick Cave', 'type' => 'solo'],
            ['name' => 'King Gizzard & The Lizard Wizard', 'type' => 'band'],
            ['name' => 'Sigur Rós', 'type' => 'band'],
            ['name' => 'Michael Jackson', 'type' => 'solo'],
            ['name' => 'Black Sabbath', 'type' => 'band'],
            ['name' => 'Black Country, New Road', 'type' => 'band'],
            ['name' => 'Black Midi', 'type' => 'band'],
            ['name' => 'The Porcupine Tree', 'type' => 'band'],
            ['name' => 'Riverside', 'type' => 'band'],
            ['name' => 'Marillion', 'type' => 'band'],
            ['name' => 'Queens Of The Stone Age', 'type' => 'band'],
            ['name' => 'The Smile', 'type' => 'band'],
        ];
    }
}
