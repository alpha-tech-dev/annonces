<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Category, Region, Ad };
use App\Models\AdRepository;

class AdController extends Controller
{
    /**
     * Ad repository.
     *
     * @var App\Models\AdRepository
     */
    protected $adRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdRepository $adRepository)
    {
        $this->adRepository = $adRepository;
    }

    /**
     * Search ads.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $slug
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        setlocale (LC_TIME, 'fr_FR');

        $ads = $this->adRepository->search($request);

        return view('partials.ads', compact('ads'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $regionSlug
     * @param  Integer  $departementCode
     * @param  Integer  $communeCode
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $regionSlug = null, $departementCode = null, $communeCode = null) {

        // On va avoir besoin de toutes les catégories dans la vue alors on les récupère dans l’ordre alphabétique (oldest) 
        $categories = Category::select('name', 'id', 'slug')->oldest('name')->get();
        // La liste complète des régions, la aussi dans l’ordre alphabétique
        $regions = Region::select('id','code','name','slug')->oldest('name')->get();
        // Si un slug est présent pour la région (ça sera le cas quand on va cliquer sur une région de la carte) on la récupère, sinon on garde le null
        $region = $regionSlug ? Region::whereSlug($regionSlug)->firstOrFail() : null;        
        // Si il y a une pagination et on renvoie le numéro de la page
        $page = $request->query('page', 0);
        return view('adsvue', compact('categories', 'regions', 'region', 'departementCode', 'communeCode', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        $this->authorize('show', $ad);
        $photos = $this->adRepository->getPhotos($ad);
        return view('ad', compact('ad', 'photos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
