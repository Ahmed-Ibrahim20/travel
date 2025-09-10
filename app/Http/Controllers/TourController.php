<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Services\TourService;
use Illuminate\Http\Request;

class TourController extends Controller
{
    protected TourService $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }

    /**
     * Display a listing of tours with search and filtering
     */
   public function index(Request $request)
{
    $search = $request->query('search');
    $perPage = $request->query('perPage', 10);
    $destinationId = $request->query('destination_id');
    $tourType = $request->query('tour_type'); // ✅ جديد

    $tours = $this->tourService->indexTour($search, $perPage, $destinationId, $tourType);
    $destinations = \App\Models\Destination::all();

    return view('tours.index', compact('tours', 'destinations'));
}


    /**
     * Show the form for creating a new tour
     */
    public function create()
    {
        $destinations = \App\Models\Destination::all();
        return view('tours.create', compact('destinations'));
    }

    /**
     * Store a newly created tour
     */
    public function store(TourRequest $request)
    {
        $result = $this->tourService->storeTour($request->validated());

        return isset($result['message'])
            ? redirect()->route('tours.index')->with('success', $result['message'])
            : redirect()->back()->with('error', 'Error occurred while creating tour.');
    }

    /**
     * Display the specified tour
     */
    public function show($id)
    {
        $tour = $this->tourService->editTour($id);

        if (!$tour) {
            return redirect()->route('tours.index')->with('error', 'Tour not found.');
        }

        return view('tours.show', compact('tour'));
    }

    /**
     * Show the form for editing the specified tour
     */
    public function edit($id)
    {
        $tour = $this->tourService->editTour($id);
        $destinations = \App\Models\Destination::all();

        if (!$tour) {
            return redirect()->route('tours.index')->with('error', 'Tour not found.');
        }

        return view('tours.edit', compact('tour', 'destinations'));
    }

    /**
     * Update the specified tour
     */
    public function update(TourRequest $request, $id)
    {
        $result = $this->tourService->updateTour($request->validated(), $id);

        return isset($result['message'])
            ? redirect()->route('tours.index')->with('success', $result['message'])
            : redirect()->back()->with('error', 'Error occurred while updating tour.');
    }

    /**
     * Remove the specified tour
     */
    public function destroy($id)
    {
        $result = $this->tourService->destroyTour($id);

        return isset($result['message'])
            ? redirect()->route('tours.index')->with('success', $result['message'])
            : redirect()->back()->with('error', 'Error occurred while deleting tour.');
    }
}
