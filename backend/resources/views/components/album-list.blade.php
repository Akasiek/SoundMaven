<div class="grid grid-cols-4 gap-x-12 gap-y-16">
    @foreach($albums as $album)
        <div>
            <div class="w-full aspect-square overflow-hidden">
                <img src="{{ $album->cover_image }}" alt="{{ $album->title }}" class="w-full h-full object-cover object-center">
            </div>

            <div class="flex">
                <div class="flex-1">
                    <h2 class="text-xl font-bold">{{ $album->title }}</h2>
                    @if ($showArtist)
                        <h3 class="text-xl">{{ $album->artist->name }}</h3>
                    @endif
                    <p class="text-sm font-sans mt-2 text-zinc-400">
                        {{ \Illuminate\Support\Carbon::make($album->release_date)->toFormattedDateString() }}
                    </p>
                </div>

                <div class="px-4 py-2 text-3xl font-black flex justify-center <?= $album->rating_color ?>">
                    {{ $album->average_rating }}
                </div>
            </div>
        </div>

    @endforeach
</div>
