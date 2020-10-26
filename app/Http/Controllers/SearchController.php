<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Validators\SearchFormValidator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * GitHub API search path
     *
     * @var string
     */
    protected $searchPath = "https://api.github.com/search/repositories";

    /**
     * SearchController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a search form.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('search.index');
    }

    /**
     * Start searching for repositories
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function search(Request $request)
    {
        $validatedData = SearchFormValidator::validateData();

        $query = $this->makeQuery();

        $result = Http::get($this->searchPath . $query)->json();

        $repositories = $this->fetchRepositories($result);

        // Store search result in session so we could use it during adding
        // and removing repositories from favorites on search result page
        $request->session()->put('lastSearch', $repositories);

        return view('search.result', compact('repositories'));

    }

    /**
     * Add repository to favorites
     *
     * @param Request $request
     * @param $githubId
     * @return Application|Factory|View
     */
    public function addToFavorites(Request $request, $githubId)
    {
        $repositories = [];

        if ($request->session()->has('lastSearch'))
        {
            $repositories = $request->session()->get('lastSearch');

            $repository = $repositories[$githubId];

            $favorite = Favorite::updateOrCreate(
                [
                    'id' => $repository['id'],
                ],
                [
                    'owner'       => $repository['owner']['login'],
                    'name'        => $repository['full_name'],
                    'description' => $repository['description'],
                    'stargazers'  => $repository['stargazers_count'],
                    'url'         => $repository['html_url'],
                ]
            );

            if (! Auth::user()->favorites->contains($favorite->id))
            {
                Auth::user()->favorites()->attach($favorite->id);
            }

            $repositories[$githubId]['in_favorites'] = 1;

            $request->session()->put('lastSearch', $repositories);
        }

        return view('search.result', compact('repositories'));
    }

    /**
     * Remove repository from favorites
     *
     * @param Request $request
     * @param $githubId
     * @return Application|Factory|View
     */
    public function removeFromFavorites(Request $request, $githubId)
    {
        $repositories = [];

        if ($request->session()->has('lastSearch'))
        {
            $repositories = $request->session()->get('lastSearch');

            if (Auth::user()->favorites->contains($githubId))
            {
                Auth::user()->favorites()->detach($githubId);
            }

            $repositories[$githubId]['in_favorites'] = 0;

            $request->session()->put('lastSearch', $repositories);
        }

        return view('search.result', compact('repositories'));
    }

    /**
     * Construct a query that is used in GitHub's search path
     *
     * @return string
     */
    private function makeQuery()
    {
        $parameters = app(Pipeline::class)
            ->send([])
            ->through([
                \App\QueryBuilder\Repository\Owner::class,
                \App\QueryBuilder\Repository\Name::class,
                \App\QueryBuilder\Repository\Description::class,
                \App\QueryBuilder\Repository\Language::class,
            ])
            ->thenReturn();

        return '?q=' . implode('+', $parameters);
    }

    /**
     * Fetch repositories' data from search result
     *
     * @param $result
     * @return array
     */
    public function fetchRepositories($result)
    {
        if (! array_key_exists('items', $result))
        {
            return [];
        }

        $items = $result['items'];

        $favorites = Auth::user()->favorites->pluck('id')->toArray();

        $repositories = [];

        foreach ($items as $item)
        {
            $githubId = $item['id'];

            // Copy repositories' data to a new array so that this array
            // keys were equal to GitHub keys so we could easily fetch
            // individual repository by it's GitHub id
            $repositories[$githubId] = $item;

            // Check if current repository is already in favorites in
            // our database for current user and set it's favorite
            // status to show it in result's view
            if (in_array($githubId, $favorites))
            {
                $repositories[$githubId]['in_favorites'] = 1;
            }
            else
            {
                $repositories[$githubId]['in_favorites'] = 0;
            }
        }

        return $repositories;
    }
}
