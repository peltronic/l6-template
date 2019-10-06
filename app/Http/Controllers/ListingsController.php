<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;

class ListingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$listings = Listing::paginate();
		return view('listings.index', compact('listings'));
	}

    public function show(Listing $listing)
    {
        return view('listings.show', compact('listing'));
    }

	public function create(Listing $listing)
	{
		return view('listings.create_and_edit', compact('listing'));
	}

	public function store(ListingRequest $request)
	{
		$listing = Listing::create($request->all());
		return redirect()->route('listings.show', $listing->id)->with('message', 'Created successfully.');
	}

	public function edit(Listing $listing)
	{
        $this->authorize('update', $listing);
		return view('listings.create_and_edit', compact('listing'));
	}

	public function update(ListingRequest $request, Listing $listing)
	{
		$this->authorize('update', $listing);
		$listing->update($request->all());

		return redirect()->route('listings.show', $listing->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Listing $listing)
	{
		$this->authorize('destroy', $listing);
		$listing->delete();

		return redirect()->route('listings.index')->with('message', 'Deleted successfully.');
	}
}