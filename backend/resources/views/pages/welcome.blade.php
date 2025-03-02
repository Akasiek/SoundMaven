<main class="w-full">
    <h1 class="text-7xl font-black">
        Welcome
    </h1>

    <div>
        <ul class="list-disc list-inside">

        @foreach($albums as $album)
            <li wire:key="{{ $album->id }}">
                {{ $album->title }}
            </li>
        @endforeach
        </ul>
    </div>
</main>
