<div class="grid grid-cols-4 gap-x-10 gap-y-10">
    @foreach($albums as $album)
        <div>

            <div class="w-full aspect-square overflow-hidden">
                <img src="{{ $album->cover_image }}" alt="{{ $album->title }}" class="w-full h-full object-cover object-center">
            </div>
            <h2 class="text-xl font-bold">{{ $album->title }}</h2>
            @if ($showArtist)
                <h3 class="text-xl">{{ $album->artist->name }}</h3>
            @endif
            <p class="text-sm font-sans mt-2 text-zinc-400">
                {{ \Illuminate\Support\Carbon::make($album->release_date)->toFormattedDateString() }}
            </p>
        </div>

    @endforeach
</div>
