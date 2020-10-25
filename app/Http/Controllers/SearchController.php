<?php

namespace App\Http\Controllers;

use App\Validators\SearchFormValidator;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Http;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * @var string
     */
    protected $searchPath = "https://api.github.com/search/repositories";

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('search.index');
    }

    public function search()
    {
        $validatedData = SearchFormValidator::validateData();

        $query = $this->makeQuery();

        $searchResult = Http::get($this->searchPath . $query);

        $array = $searchResult->json();

        dd($array['items']);
    }

    /**
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
}
