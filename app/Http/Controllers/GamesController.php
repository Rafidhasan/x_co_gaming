<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $game = Http::withHeaders(config('services.igdb'))
            ->withOptions([
                'body' => "
                fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating,
                slug, involved_companies.company.name, genres.name, aggregated_rating, summary, websites.*, videos.*, screenshots.*, similar_games.cover.url, similar_games.name, similar_games.rating,similar_games.platforms.abbreviation, similar_games.slug;
                    where slug=\"{$slug}\";
                "
            ])->get('https://api-v3.igdb.com/games',)
            ->json();

        dump($game);

        abort_if(!$game, 404);

        return view('show', [
            'game' => $this->formatGameForView($game[0]),
        ]);
    }

    private function formatGameForView($game) {
        $temp = collect($game)->merge([
            'coverImageUrl' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
            'rating' => isset($game['rating']) ? round($game['rating']).'%' :null,
            'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            'genres'=>collect($game['genres'])->pluck('name')->implode(', '),
            'involved_companies'=> $game['involved_companies'][0]['company']['name'],
            'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            'memberRating' => array_key_exists('rating', $game) ? round($game['rating']).'%' : '0%',
            'criticRating' => array_key_exists('aggregated_rating', $game) ? round($game['aggregated_rating']).'%' : '0%',
            'trailar' => 'https://youtube.com/watch/'.$game['videos'][0]['video_id'],
            'screenshots' => collect($game['screenshots'])->map(function ($screenshot) {
                return [
                    'big' => Str::replaceFirst('thumb', 'screenshot_big', $screenshot['url']),
                    'huge' => Str::replaceFirst('thumb', 'screenshot_huge', $screenshot['url'])
                ];
            })->take(9),
        ]);

        return $temp;
    }
}
