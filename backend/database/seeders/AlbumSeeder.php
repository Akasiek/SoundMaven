<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getAlbumData();

        foreach ($data as $album) {
            Album::updateOrCreate([
                'title' => $album['title'],
                'artist_id' => $album['artist_id'],
            ], [
                'release_date' => $album['release_date'],
                'description' => fake()->paragraph(6),
            ]);
        }
    }

    private function getArtistAlbumsData(string $artistName, array $albums): array
    {
        $artist = Artist::where('name', $artistName)->first();

        return array_map(function ($album) use ($artist) {
            return [
                'title' => $album['title'],
                'release_date' => $album['release_date'],
                'artist_id' => $artist->id,
            ];
        }, $albums);
    }

    private function getAlbumData(): array
    {
        return array_merge(
            $this->getArtistAlbumsData('Radiohead', [
                ['title' => 'Pablo Honey', 'release_date' => '1993-02-22'],
                ['title' => 'The Bends', 'release_date' => '1995-03-13'],
                ['title' => 'OK Computer', 'release_date' => '1997-05-21'],
                ['title' => 'Kid A', 'release_date' => '2000-10-02'],
                ['title' => 'Amnesiac', 'release_date' => '2001-06-05'],
                ['title' => 'Hail to the Thief', 'release_date' => '2003-06-09'],
                ['title' => 'In Rainbows', 'release_date' => '2007-10-10'],
                ['title' => 'The King of Limbs', 'release_date' => '2011-02-18'],
                ['title' => 'A Moon Shaped Pool', 'release_date' => '2016-05-08'],
            ]),
            $this->getArtistAlbumsData('The Beatles', [
                ['title' => 'Please Please Me', 'release_date' => '1963-03-22'],
                ['title' => 'With the Beatles', 'release_date' => '1963-11-22'],
                ['title' => 'A Hard Day\'s Night', 'release_date' => '1964-07-10'],
                ['title' => 'Beatles for Sale', 'release_date' => '1964-12-04'],
                ['title' => 'Help!', 'release_date' => '1965-08-06'],
                ['title' => 'Rubber Soul', 'release_date' => '1965-12-03'],
                ['title' => 'Revolver', 'release_date' => '1966-08-05'],
                ['title' => 'Sgt. Pepper\'s Lonely Hearts Club Band', 'release_date' => '1967-06-01'],
                ['title' => 'Magical Mystery Tour', 'release_date' => '1967-11-27'],
                ['title' => 'The Beatles', 'release_date' => '1968-11-22'],
                ['title' => 'Abbey Road', 'release_date' => '1969-09-26'],
                ['title' => 'Let It Be', 'release_date' => '1970-05-08'],
            ]),
            $this->getArtistAlbumsData('Ghost', [
                ['title' => 'Opus Eponymous', 'release_date' => '2010-10-18'],
                ['title' => 'Infestissumam', 'release_date' => '2013-04-10'],
                ['title' => 'Meliora', 'release_date' => '2015-08-21'],
                ['title' => 'Prequelle', 'release_date' => '2018-06-01'],
                ['title' => 'Impera', 'release_date' => '2022-03-11'],
            ]),
            $this->getArtistAlbumsData('Jack White', [
                ['title' => 'Blunderbuss', 'release_date' => '2012-04-23'],
                ['title' => 'Lazaretto', 'release_date' => '2014-06-10'],
                ['title' => 'Boarding House Reach', 'release_date' => '2018-03-23'],
                ['title' => 'Fear of the Dawn', 'release_date' => '2021-10-22'],
            ]),
            $this->getArtistAlbumsData('Thom Yorke', [
                ['title' => 'The Eraser', 'release_date' => '2006-07-10'],
                ['title' => 'Tomorrow\'s Modern Boxes', 'release_date' => '2014-09-26'],
                ['title' => 'Anima', 'release_date' => '2019-06-27'],
            ]),
            $this->getArtistAlbumsData('Paul McCartney', [
                ['title' => 'McCartney', 'release_date' => '1970-04-17'],
                ['title' => 'Ram', 'release_date' => '1971-05-17'],
                ['title' => 'McCartney II', 'release_date' => '1980-05-16'],
                ['title' => 'McCartney III', 'release_date' => '2020-12-18'],
            ]),
            $this->getArtistAlbumsData('Depeche Mode', [
                ['title' => 'Speak & Spell', 'release_date' => '1981-10-05'],
                ['title' => 'A Broken Frame', 'release_date' => '1982-09-27'],
                ['title' => 'Construction Time Again', 'release_date' => '1983-08-22'],
                ['title' => 'Some Great Reward', 'release_date' => '1984-09-24'],
                ['title' => 'Black Celebration', 'release_date' => '1986-03-17'],
                ['title' => 'Music for the Masses', 'release_date' => '1987-09-28'],
                ['title' => 'Violator', 'release_date' => '1990-03-19'],
                ['title' => 'Songs of Faith and Devotion', 'release_date' => '1993-03-22'],
                ['title' => 'Ultra', 'release_date' => '1997-04-14'],
                ['title' => 'Exciter', 'release_date' => '2001-05-14'],
                ['title' => 'Playing the Angel', 'release_date' => '2005-10-17'],
                ['title' => 'Sounds of the Universe', 'release_date' => '2009-04-17'],
                ['title' => 'Delta Machine', 'release_date' => '2013-03-22'],
                ['title' => 'Spirit', 'release_date' => '2017-03-17'],
                ['title' => 'Memento Mori', 'release_date' => '2023-01-13'],
            ]),
            $this->getArtistAlbumsData('The White Stripes', [
                ['title' => 'The White Stripes', 'release_date' => '1999-06-15'],
                ['title' => 'De Stijl', 'release_date' => '2000-06-20'],
                ['title' => 'White Blood Cells', 'release_date' => '2001-07-03'],
                ['title' => 'Elephant', 'release_date' => '2003-04-01'],
                ['title' => 'Get Behind Me Satan', 'release_date' => '2005-06-07'],
                ['title' => 'Icky Thump', 'release_date' => '2007-06-15'],
            ]),
            $this->getArtistAlbumsData('Gojira', [
                ['title' => 'Terra Incognita', 'release_date' => '2001-11-19'],
                ['title' => 'The Link', 'release_date' => '2003-03-18'],
                ['title' => 'From Mars to Sirius', 'release_date' => '2005-09-27'],
                ['title' => 'The Way of All Flesh', 'release_date' => '2008-10-13'],
                ['title' => 'L\'Enfant Sauvage', 'release_date' => '2012-06-22'],
                ['title' => 'Magma', 'release_date' => '2016-06-17'],
                ['title' => 'Fortitude', 'release_date' => '2021-04-30'],
            ]),
            $this->getArtistAlbumsData('Led Zeppelin', [
                ['title' => 'Led Zeppelin', 'release_date' => '1969-01-12'],
                ['title' => 'Led Zeppelin II', 'release_date' => '1969-10-22'],
                ['title' => 'Led Zeppelin III', 'release_date' => '1970-10-05'],
                ['title' => 'Led Zeppelin IV', 'release_date' => '1971-11-08'],
                ['title' => 'Houses of the Holy', 'release_date' => '1973-03-28'],
                ['title' => 'Physical Graffiti', 'release_date' => '1975-02-24'],
                ['title' => 'Presence', 'release_date' => '1976-03-31'],
                ['title' => 'The Song Remains the Same', 'release_date' => '1976-10-28'],
                ['title' => 'In Through the Out Door', 'release_date' => '1979-08-15'],
                ['title' => 'Coda', 'release_date' => '1982-11-19'],
            ]),
            $this->getArtistAlbumsData('Talk Talk', [
                ['title' => 'The Party\'s Over', 'release_date' => '1982-07-01'],
                ['title' => 'It\'s My Life', 'release_date' => '1984-02-13'],
                ['title' => 'The Colour of Spring', 'release_date' => '1986-03-03'],
                ['title' => 'Spirit of Eden', 'release_date' => '1988-09-16'],
                ['title' => 'Laughing Stock', 'release_date' => '1991-09-16'],
            ]),
            $this->getArtistAlbumsData('David Bowie', [
                ['title' => 'David Bowie', 'release_date' => '1967-06-01'],
                ['title' => 'Space Oddity', 'release_date' => '1969-11-14'],
                ['title' => 'The Rise and Fall of Ziggy Stardust and the Spiders from Mars', 'release_date' => '1972-06-16'],
                ['title' => 'Aladdin Sane', 'release_date' => '1973-04-13'],
                ['title' => 'Pin Ups', 'release_date' => '1973-10-19'],
                ['title' => 'Diamond Dogs', 'release_date' => '1974-05-24'],
                ['title' => 'Young Americans', 'release_date' => '1975-03-07'],
                ['title' => 'Station to Station', 'release_date' => '1976-01-23'],
                ['title' => 'Low', 'release_date' => '1977-01-14'],
                ['title' => 'Heroes', 'release_date' => '1977-10-14'],
                ['title' => 'Lodger', 'release_date' => '1979-05-18'],
                ['title' => 'Scary Monsters (and Super Creeps)', 'release_date' => '1980-09-12'],
                ['title' => 'Let\'s Dance', 'release_date' => '1983-04-14'],
                ['title' => 'Earthling', 'release_date' => '1997-02-03'],
                ['title' => 'The Next Day', 'release_date' => '2013-03-08'],
                ['title' => 'Blackstar', 'release_date' => '2016-01-08'],
            ]),
            $this->getArtistAlbumsData('Royal Blood', [
                ['title' => 'Royal Blood', 'release_date' => '2014-08-22'],
                ['title' => 'How Did We Get So Dark?', 'release_date' => '2017-06-16'],
                ['title' => 'Typhoons', 'release_date' => '2021-04-30'],
                ['title' => 'Back To The Water Below', 'release_date' => '2023-09-01'],
            ]),
            $this->getArtistAlbumsData('Godspeed You! Black Emperor', [
                ['title' => 'F♯ A♯ ∞', 'release_date' => '1997-08-14'],
                ['title' => 'Lift Your Skinny Fists Like Antennas to Heaven', 'release_date' => '2000-10-09'],
                ['title' => 'Yanqui U.X.O.', 'release_date' => '2002-11-11'],
                ['title' => 'Allelujah! Don\'t Bend! Ascend!', 'release_date' => '2012-10-15'],
                ['title' => 'Asunder, Sweet and Other Distress', 'release_date' => '2015-03-31'],
                ['title' => 'Luciferian Towers', 'release_date' => '2017-09-22'],
                ['title' => 'G_d\'s Pee AT STATE\'S END!', 'release_date' => '2021-04-02'],
            ]),
            $this->getArtistAlbumsData('God Is An Astronaut', [
                ['title' => 'The End of the Beginning', 'release_date' => '2002-04-08'],
                ['title' => 'All Is Violent, All Is Bright', 'release_date' => '2005-01-17'],
                ['title' => 'Far from Refuge', 'release_date' => '2007-04-16'],
                ['title' => 'God Is an Astronaut', 'release_date' => '2008-11-07'],
                ['title' => 'Age of the Fifth Sun', 'release_date' => '2010-05-17'],
                ['title' => 'Origins', 'release_date' => '2013-09-16'],
                ['title' => 'Helios | Erebus', 'release_date' => '2015-06-21'],
                ['title' => 'Epitaph', 'release_date' => '2018-04-27'],
                ['title' => 'Ghost Tapes #10', 'release_date' => '2021-02-12'],
            ]),
            $this->getArtistAlbumsData('Daft Punk', [
                ['title' => 'Homework', 'release_date' => '1997-01-20'],
                ['title' => 'Discovery', 'release_date' => '2001-03-12'],
                ['title' => 'Human After All', 'release_date' => '2005-03-14'],
                ['title' => 'Random Access Memories', 'release_date' => '2013-05-17'],
            ]),
            $this->getArtistAlbumsData('The Mars Volta', [
                ['title' => 'De-Loused in the Comatorium', 'release_date' => '2003-06-24'],
                ['title' => 'Frances the Mute', 'release_date' => '2005-03-01'],
                ['title' => 'Amputechture', 'release_date' => '2006-09-12'],
                ['title' => 'The Bedlam in Goliath', 'release_date' => '2008-01-29'],
                ['title' => 'Octahedron', 'release_date' => '2009-06-23'],
                ['title' => 'Noctourniquet', 'release_date' => '2012-03-26'],
            ]),
            $this->getArtistAlbumsData('Arctic Monkeys', [
                ['title' => 'Whatever People Say I Am, That\'s What I\'m Not', 'release_date' => '2006-01-23'],
                ['title' => 'Favourite Worst Nightmare', 'release_date' => '2007-04-23'],
                ['title' => 'Humbug', 'release_date' => '2009-08-19'],
                ['title' => 'Suck It and See', 'release_date' => '2011-06-06'],
                ['title' => 'AM', 'release_date' => '2013-09-06'],
                ['title' => 'Tranquility Base Hotel & Casino', 'release_date' => '2018-05-11'],
                ['title' => 'The Car', 'release_date' => '2023-09-01'],
            ]),
            $this->getArtistAlbumsData('Fleetwood Mac', [
                ['title' => 'Rumours', 'release_date' => '1977-02-04'],
                ['title' => 'Tusk', 'release_date' => '1979-10-12'],
                ['title' => 'Tango in the Night', 'release_date' => '1987-04-13'],
            ]),
            $this->getArtistAlbumsData('Rush', [
                ['title' => 'Rush', 'release_date' => '1974-03-01'],
                ['title' => 'Fly by Night', 'release_date' => '1975-02-15'],
                ['title' => 'Caress of Steel', 'release_date' => '1975-09-24'],
                ['title' => '2112', 'release_date' => '1976-04-01'],
                ['title' => 'A Farewell to Kings', 'release_date' => '1977-09-01'],
                ['title' => 'Hemispheres', 'release_date' => '1978-10-29'],
                ['title' => 'Permanent Waves', 'release_date' => '1980-01-01'],
                ['title' => 'Moving Pictures', 'release_date' => '1981-02-12'],
                ['title' => 'Signals', 'release_date' => '1982-09-09'],
                ['title' => 'Grace Under Pressure', 'release_date' => '1984-04-12'],
                ['title' => 'Power Windows', 'release_date' => '1985-10-29'],
                ['title' => 'Hold Your Fire', 'release_date' => '1987-09-08'],
                ['title' => 'Presto', 'release_date' => '1989-11-21'],
                ['title' => 'Roll the Bones', 'release_date' => '1991-09-03'],
                ['title' => 'Counterparts', 'release_date' => '1993-10-19'],
                ['title' => 'Test for Echo', 'release_date' => '1996-09-10'],
                ['title' => 'Vapor Trails', 'release_date' => '2002-05-14'],
                ['title' => 'Feedback', 'release_date' => '2004-06-29'],
                ['title' => 'Snakes & Arrows', 'release_date' => '2007-05-01'],
                ['title' => 'Clockwork Angels', 'release_date' => '2012-06-08'],
            ]),
            $this->getArtistAlbumsData('Nick Cave & The Bad Seeds', [
                ['title' => 'From Her to Eternity', 'release_date' => '1984-06-18'],
                ['title' => 'The Firstborn Is Dead', 'release_date' => '1985-06-03'],
                ['title' => 'Kicking Against the Pricks', 'release_date' => '1986-08-18'],
                ['title' => 'Your Funeral... My Trial', 'release_date' => '1986-11-03'],
                ['title' => 'Tender Prey', 'release_date' => '1988-09-19'],
                ['title' => 'The Good Son', 'release_date' => '1990-04-16'],
                ['title' => 'Henry\'s Dream', 'release_date' => '1992-04-27'],
                ['title' => 'Let Love In', 'release_date' => '1994-04-18'],
                ['title' => 'Murder Ballads', 'release_date' => '1996-02-05'],
                ['title' => 'The Boatman\'s Call', 'release_date' => '1997-03-03'],
                ['title' => 'No More Shall We Part', 'release_date' => '2001-04-02'],
                ['title' => 'Nocturama', 'release_date' => '2003-02-11'],
                ['title' => 'Abattoir Blues / The Lyre Of Orpheus', 'release_date' => '2004-09-20'],
                ['title' => 'Dig!!! Lazarus Dig!!!', 'release_date' => '2008-04-08'],
                ['title' => 'Push the Sky Away', 'release_date' => '2013-02-18'],
                ['title' => 'Skeleton Tree', 'release_date' => '2016-09-09'],
                ['title' => 'Ghosteen', 'release_date' => '2019-10-04'],
            ]),
        );
    }
}
