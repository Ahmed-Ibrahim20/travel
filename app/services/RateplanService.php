<?php

namespace App\Services;

use App\Models\RatePlan;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RateplanService
{
    protected RatePlan $model;

    public function __construct(RatePlan $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of rate plans with search and filtering
     */
    public function indexRateplan($search = null, $perPage = 10, $tourId = null)
    {
        return $this->model->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("JSON_EXTRACT(name, '$.en') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(name, '$.ar') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(name, '$.fr') LIKE ?", ["%{$search}%"])
                  ->orWhere('price', 'like', "%{$search}%")
                  ->orWhere('currency', 'like', "%{$search}%");
            });
        })->when($tourId, function ($query) use ($tourId) {
            $query->where('tour_id', $tourId);
        })->with('tour')->paginate($perPage);
    }

    /**
     * Store a newly created rate plan
     */
    public function storeRateplan(array $requestData)
    {
        try {
            $data = Arr::only($requestData, [
                'tour_id',
                'name',
                'room_type',
                'start_date',
                'end_date',
                'board_type',
                'transportation',
                'price',
                'currency',
                'details',
            ]);

            $rateplan = $this->model->create($data);

            return [
                'status' => true,
                'message' => 'Rate plan created successfully',
                'data' => $rateplan
            ];
        } catch (\Exception $e) {
            Log::error('Rate plan creation failed: ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Error occurred while creating rate plan'
            ];
        }
    }

    /**
     * Retrieve rate plan for editing or display
     */
    public function editRateplan($rateplanId)
    {
        return $this->model->with('tour')->find($rateplanId);
    }

    /**
     * Update rate plan data
     */
    public function updateRateplan(array $requestData, $rateplanId)
    {
        try {
            $rateplan = $this->model->find($rateplanId);

            if (!$rateplan) {
                return [
                    'status' => false,
                    'message' => 'Rate plan not found'
                ];
            }

            $data = Arr::only($requestData, [
                'tour_id',
                'name',
                'room_type',
                'start_date',
                'end_date',
                'board_type',
                'transportation',
                'price',
                'currency',
                'details',
            ]);

            $rateplan->update($data);

            return [
                'status' => true,
                'message' => 'Rate plan updated successfully',
                'data' => $rateplan
            ];
        } catch (\Exception $e) {
            Log::error('Rate plan update failed: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error occurred while updating rate plan'
            ];
        }
    }

    /**
     * Delete rate plan
     */
    public function destroyRateplan($rateplanId)
    {
        try {
            $rateplan = $this->model->find($rateplanId);

            if (!$rateplan) {
                return [
                    'status' => false,
                    'message' => 'Rate plan not found'
                ];
            }

            $rateplan->delete();

            return [
                'status' => true,
                'message' => 'Rate plan deleted successfully'
            ];
        } catch (\Exception $e) {
            Log::error('Rate plan deletion failed: ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Error occurred while deleting rate plan'
            ];
        }
    }
}
