<div wire:init="loadComingSoon" class="coming-soon mt-12 lg:mt-0 ">
    <h2 class="text-red-600 uppercase tracking-wide font-semibold">Coming Soon</h2>
    <div class="coming-soon-container space-y-10 mt-8">
        @forelse ($comingSoon as $game)
            <div class="game flex">
                <a href="">
                    <img src="{{$game['cover']['url']}}" alt="cover" class="w-16 hover:opacity-75 transition ease-in-out duration-150">
                </a>
                <div class="ml-4">
                    <a href="{{route('games.show', $game['slug'])}}" class="hover:text-gray-300">{{$game['name']}}</a>
                    <div class="text-gray-400 text-sm mt-1">
                        {{ Carbon\Carbon::parse($game['first_release_date'])->format('M Y D')}}
                    </div>
                </div>
            </div>
            @empty
                <div>
                    <div class="spinner mt-8"></div>
                </div>
        @endforelse
    </div>
</div>
