<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestinationRequest;
use App\Services\DestinationService;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    protected DestinationService $destinationService;

    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;
    }

    /**
     * Display a listing of destinations with search and filtering
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);

        $destinations = $this->destinationService->indexDestination($search, $perPage);

        return view('destinations.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new destination
     */
    public function create()
    {
        return view('destinations.create');
    }

    /**
     * Store a newly created destination
     */
    public function store(DestinationRequest $request)
    {
        $result = $this->destinationService->storeDestination($request->validated());

        return isset($result['message'])
            ? redirect()->route('destinations.index')->with('success', $result['message'])
            : redirect()->back()->with('error', 'Error occurred while creating destination.');
    }

    /**
     * Display the specified destination
     */
    public function show($id)
    {
        $destination = $this->destinationService->editDestination($id);

        if (!$destination) {
            return redirect()->route('destinations.index')->with('error', 'Destination not found.');
        }

        return view('destinations.show', compact('destination'));
    }

    /**
     * Show the form for editing the specified destination
     */
    public function edit($id)
    {
        $destination = $this->destinationService->editDestination($id);

        if (!$destination) {
            return redirect()->route('destinations.index')->with('error', 'Destination not found.');
        }
        
        return view('destinations.edit', compact('destination'));
    }

    /**
     * Update the specified destination
     */
    public function update(DestinationRequest $request, $id)
    {
        $result = $this->destinationService->updateDestination($request->validated(), $id);

        return isset($result['message'])
            ? redirect()->route('destinations.index')->with('success', $result['message'])
            : redirect()->back()->with('error', 'Error occurred while updating destination.');
    }

    /**
     * Remove the specified destination
     */
    public function destroy($id)
    {
        $result = $this->destinationService->destroyDestination($id);

        return isset($result['message'])
            ? redirect()->route('destinations.index')->with('success', $result['message'])
            : redirect()->back()->with('error', 'Error occurred while deleting destination.');
    }
}
