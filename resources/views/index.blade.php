@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h2 class="text-red-600 uppercase tracking-wide font-semibold">Popular Games</h2>
        <livewire:popular-games>

        <div class="flex flex-col lg:flex-row my-10">
            <div class="recently-reviewed w-4/4 mr-0 lg:w-3/4 lg:mr-32">
                <h2 class="text-red-600 uppercase tracking-wide font-semibold">Recently Reviewed</h2>
                <livewire:recently-reviewed>
            </div>

            <div class="most-anticipated mt-12 lg:mt-0 lg:w-1/4">
                <h2 class="text-red-600 uppercase tracking-wide font-semibold">Most Anticipated</h2>
                <livewire:most-anticipated>

                <livewire:coming-soon>
            </div>
        </div>
    </div>
@endsection
