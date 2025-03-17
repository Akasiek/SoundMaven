<main class="max-w-7xl mx-auto">
    <div class="grid grid-cols-4 gap-x-10 gap-y-10">
        @foreach ($artists as $artist)
            <a class="block" href="{{ route('artist.show', $artist->slug) }}">

                <div class="w-full h-48 aspect-video overflow-hidden">
                    <img src="{{$artist->background_image_preview}}" alt="{{ $artist->name }}" class="w-full h-full object-cover object-center">
                </div>
                {{ $artist->name }}
            </a>
        @endforeach
    </div>

    {{--    {{ $artists->links() }}--}}
</main>
