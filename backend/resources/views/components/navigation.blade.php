<nav class="fixed inset-x-0 top-0 w-full h-18 bg-zinc-800 px-4 sm:px-6 lg:px-8 z-50">
    <div class="max-w-7xl w-full mx-auto  flex justify-between items-center h-full">

        <a class="block w-48" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo">
        </a>

        <div class="flex gap-x-5">
            @foreach($links as $link)
                <a href="{{ $link['route'] }}" class="font-bold text-zinc-100 hover:text-zinc-300 hover:underline">
                    {{ $link['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>
