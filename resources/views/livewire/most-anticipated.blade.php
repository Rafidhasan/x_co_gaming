<div wire:init="loadMostAnticipated" class="most-anticipated-container space-y-10 mt-8">
    @forelse ($mostAnticipated as $game)
        <div class="game flex">
            <a href="{{route('games.show', $game['slug'])}}">
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
