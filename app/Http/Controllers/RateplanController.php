<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateplanRequest;
use App\Services\RateplanService;
use Illuminate\Http\Request;

class RateplanController extends Controller
{
    protected RateplanService $rateplanService;

    public function __construct(RateplanService $rateplanService)
    {
        $this->rateplanService = $rateplanService;
    }

    /**
     * Display a listing of rate plans with search and filtering
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);
        $tourId = $request->query('tour_id');

        $rateplans = $this->rateplanService->indexRateplan($search, $perPage, $tourId);
        $tours = \App\Models\Tour::all();

        return view('rateplans.index', compact('rateplans', 'tours'));
    }

    /**
     * Show the form for creating a new rate plan
     */
    public function create()
    {
        $tours = \App\Models\Tour::all();
        return view('rateplans.create', compact('tours'));
    }

    /**
     * Store a newly created rate plan
     */
    public function store(RateplanRequest $request)
    {
        $result = $this->rateplanService->storeRateplan($request->validated());

        return isset($result['message'])
            ? redirect()->route('rateplans.index')->with('success', $result['message'])
            : redirect()->back()->with('error', 'Error occurred while creating rate plan.');
    }

    /**
     * Display the specified rate plan
     */
    public function show($id)
    {
        $rateplan = $this->rateplanService->editRateplan($id);

        if (!$rateplan) {
            return redirect()->route('rateplans.index')->with('error', 'Rate plan not found.');
        }

        return view('rateplans.show', compact('rateplan'));
    }

    /**
     * Show the form for editing the specified rate plan
     */
    public function edit($id)
    {
        $rateplan = $this->rateplanService->editRateplan($id);
        $tours = \App\Models\Tour::all();

        if (!$rateplan) {
            return redirect()->route('rateplans.index')->with('error', 'Rate plan not found.');
        }

        return view('rateplans.edit', compact('rateplan', 'tours'));
    }

    /**
     * Update the specified rate plan
     */
    public function update(RateplanRequest $request, $id)
    {
        $result = $this->rateplanService->updateRateplan($request->validated(), $id);

        return isset($result['message'])
            ? redirect()->route('rateplans.index')->with('success', $result['message'])
            : redirect()->back()->with('error', 'Error occurred while updating rate plan.');
    }

    /**
     * Remove the specified rate plan
     */
    public function destroy($id)
    {
        $result = $this->rateplanService->destroyRateplan($id);

        return isset($result['message'])
            ? redirect()->route('rateplans.index')->with('success', $result['message'])
            : redirect()->back()->with('error', 'Error occurred while deleting rate plan.');
    }
}
