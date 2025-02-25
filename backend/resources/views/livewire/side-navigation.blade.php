<aside class="min-w-80 h-screen bg-zinc-800 p-5">
    <a class="block w-full" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo">
    </a>

    <form class="w-full my-6" wire:submit="search">
        <div class="relative">

        <input type="text" placeholder="Search..." wire:model.blur="searchQuery"
               class="w-full py-2 px-2.5 bg-zinc-800 text-zinc-100 rounded-md border-2 border-green-400 focus:outline-none relative
               shadow-[0_0_0_0] shadow-green-400/50 focus:shadow-[0_0_12px_0] transition-shadow duration-300
               after:absolute after:inset-0 after:content-none after:z-20 after:rounded-md after:inset-shadow-[0_0_35px_0_#000]
               ">
        <button class="absolute right-1.5 px-2 top-1.5 bottom-1.5 flex items-center justify-center cursor-pointer" type="submit">
            <x-feathericon-search class="w-5 h-5 text-green-400 z-20"/>
            <div class="absolute inset-0 bg-zinc-800 blur-[2px]"></div>
        </button>
        </div>
    </form>
</aside>
