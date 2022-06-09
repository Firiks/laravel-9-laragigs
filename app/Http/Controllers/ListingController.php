<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{

  public function __construct() {
    $this->middleware('auth')->except(['index', 'show']);
  }

  /**
   * Display a listings.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request) {
    // dd($request->tag); //?tag=laravel

    return view('listings.index', [
      'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6) // order by latest + paginate -> $listings->links()
      // ->simplePaginate() // show just previous & next
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    return view('listings.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    // dd($request->all());
    // dd($request->file()->logo);

    $validated = $request->validate([
      'title' => 'required',
      'company' => ['required', Rule::unique('listings', 'company')], // table name & field to check if unique
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required'
    ]);

    // check if logo is uploaded
    if( $request->hasFile('logo') ) {
      $validated['logo'] = $request->file('logo')->store('logos', 'public'); // storage/app/public
    }

    // add user id to listing
    $validated['user_id'] = auth()->id();

    $listing = Listing::create($validated);

    return redirect('/')->with('message', 'Listing created successfully.'); // redirect with flash message
  }

  /**
   * Show single listing
   *
   * @param  \App\Models\Listing $listing
   * @return \Illuminate\Http\Response
   */
  public function show(Listing $listing) {
    return view('listings.show', [
      'listing' => $listing
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Listing $listing
   * @return \Illuminate\Http\Response
   */
  public function edit(Listing $listing) {
    return view('listings.edit', [
      'listing' => $listing
    ]);
  }

   /**
   * Show single listing
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function manage(Request $request) {
    return view('listings.manage', [
      'listings' => auth()->user()->listings()->get()
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Listing $listing
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Listing $listing) {
    // prevent user to update other ones listings
    if($listing->user_id != auth()->id()) {
      abort(403, 'Unauthorized Action');
    }

    $validated = $request->validate([
      'title' => 'required',
      'company' => ['required'],
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required'
    ]);

    if($request->hasFile('logo')) {
      $validated['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $listing->update($validated);

    return back()->with('message', 'Listing updated successfully.');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Listing $listing) {
    // prevent user to delete other ones listings
    if($listing->user_id != auth()->id()) {
      abort(403, 'Unauthorized Action');
    }

    $listing->delete();

    return redirect('/')->with('message', 'Listing deleted.');
  }
}
