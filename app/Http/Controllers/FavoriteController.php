<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class FavoriteController
 * @package App\Http\Controllers
 */
class FavoriteController extends Controller
{
    /**
     * FavoriteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a list of favorite repositories
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $repositories = Auth::user()
            ->favorites()
            ->orderBy('updated_at')
            ->get()
            ->toArray();

        return view('favorites.index', compact('repositories'));
    }

    /**
     * * Remove repository from favorites
     *
     * @param Request $request
     * @param $githubId
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function remove(Request $request, $githubId)
    {
         if (Auth::user()->favorites->contains($githubId))
         {
             Auth::user()->favorites()->detach($githubId);
         }

         if ($request->session()->has('lastSearch')) {
             $repositories = $request->session()->get('lastSearch');
             $repositories[$githubId]['in_favorites'] = 0;
             $request->session()->put('lastSearch', $repositories);
         }

         return redirect(route('favorites.index'));
    }
}
