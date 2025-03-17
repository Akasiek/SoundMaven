<div class="grid grid-cols-4 gap-x-12 gap-y-16">
    @foreach($albums as $album)
        @livewire(\App\Livewire\AlbumCard::class, ['album' => $album, 'showArtist' => $showArtist])
    @endforeach
</div>
