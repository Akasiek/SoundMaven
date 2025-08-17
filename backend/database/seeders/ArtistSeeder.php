<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(bool $seedImages = true): void
    {
        $data = $this->getArtistData();

        foreach ($data as $artist) {
            $model = Artist::updateOrCreate(['name' => $artist['name']], ['type' => $artist['type']]);
            if ($seedImages && isset($artist['image'])) {
                $model->attachBackgroundImage(base_path("database/seeders/data/artist_background_images/{$artist['image']}"));
            }
        }
    }

    private function getArtistData(): array
    {
        return [
            ['name' => 'Radiohead', 'type' => 'band', 'image' => 'radiohead.webp'],
            ['name' => 'The Beatles', 'type' => 'band', 'image' => 'the_beatles.webp'],
            ['name' => 'Pink Floyd', 'type' => 'band', 'image' => 'pink_floyd.webp'],
            ['name' => 'Ghost', 'type' => 'band', 'image' => 'ghost.webp'],
            ['name' => 'Jack White', 'type' => 'solo', 'image' => 'jack_white.webp'],
            ['name' => 'Thom Yorke', 'type' => 'solo', 'image' => 'thom_yorke.webp'],
            ['name' => 'Paul McCartney', 'type' => 'solo', 'image' => 'paul_mccartney.webp'],
            ['name' => 'Depeche Mode', 'type' => 'band', 'image' => 'depeche_mode.webp'],
            ['name' => 'The White Stripes', 'type' => 'band', 'image' => 'the_white_stripes.webp'],
            ['name' => 'Gojira', 'type' => 'band', 'image' => 'gojira.webp'],
            ['name' => 'Led Zeppelin', 'type' => 'band', 'image' => 'led_zeppelin.webp'],
            ['name' => 'Talk Talk', 'type' => 'band', 'image' => 'talk_talk.webp'],
            ['name' => 'David Bowie', 'type' => 'solo', 'image' => 'david_bowie.webp'],
            ['name' => 'Royal Blood', 'type' => 'band', 'image' => 'royal_blood.webp'],
            ['name' => 'Godspeed You! Black Emperor', 'type' => 'band', 'image' => 'gybe.webp'],
            ['name' => 'God Is An Astronaut', 'type' => 'band', 'image' => 'god_is_an_astronaut.webp'],
            ['name' => 'Daft Punk', 'type' => 'duo', 'image' => 'daft_punk.webp'],
            ['name' => 'The Mars Volta', 'type' => 'band', 'image' => 'the_mars_volta.webp'],
            ['name' => 'Arctic Monkeys', 'type' => 'band', 'image' => 'arctic_monkeys.webp'],
            ['name' => 'Fleetwood Mac', 'type' => 'band', 'image' => 'fleetwood_mac.webp'],
            ['name' => 'Rush', 'type' => 'band', 'image' => 'rush.webp'],
            ['name' => 'Nick Cave & The Bad Seeds', 'type' => 'band', 'image' => 'nick_cave_and_the_bad_seeds.webp'],
            ['name' => 'Nick Cave', 'type' => 'solo', 'image' => 'nick_cave.webp'],
            ['name' => 'King Gizzard & The Lizard Wizard', 'type' => 'band', 'image' => 'king_gizzard.webp'],
            ['name' => 'Sigur Rós', 'type' => 'band', 'image' => 'sigur_ros.webp'],
            ['name' => 'Michael Jackson', 'type' => 'solo', 'image' => 'michael_jackson.webp'],
            ['name' => 'Black Sabbath', 'type' => 'band', 'image' => 'black_sabbath.webp'],
            ['name' => 'Black Country, New Road', 'type' => 'band', 'image' => 'bcnr.webp'],
            ['name' => 'Black Midi', 'type' => 'band', 'image' => 'black_midi.webp'],
            ['name' => 'Porcupine Tree', 'type' => 'band', 'image' => 'porcupine_tree.webp'],
            ['name' => 'Riverside', 'type' => 'band', 'image' => 'riverside.webp'],
            ['name' => 'Marillion', 'type' => 'band', 'image' => 'marillion.webp'],
            ['name' => 'Queens Of The Stone Age', 'type' => 'band', 'image' => 'queens_of_the_stone_age.webp'],
            ['name' => 'The Smile', 'type' => 'band', 'image' => 'the_smile.webp'],
        ];
    }
}
