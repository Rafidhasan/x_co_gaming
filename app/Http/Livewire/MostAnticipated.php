<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Carbon;

use Livewire\Component;

class MostAnticipated extends Component
{
    public $mostAnticipated = [];

    public function loadMostAnticipated () {
        $current = Carbon::now()->timestamp;
        $afterFourMonths = Carbon::now()->addMonths(1)->timestamp;

        $this->mostAnticipated = Http::withHeaders(config('services.igdb'))
        ->withOptions([
            'body' => "
            fields name, summary, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count;
            where platforms = (48,49,130,6) & (first_release_date > {$current} & first_release_date < {$afterFourMonths});
            sort popularity desc;
            limit 5;
            "
        ])->get('https://api-v3.igdb.com/games',)
        ->json();
    }
    public function render()
    {
        return view('livewire.most-anticipated');
    }
}
