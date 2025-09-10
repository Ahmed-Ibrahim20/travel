<?php

namespace App\Services;

use App\Models\Tour;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TourService
{
    protected Tour $model;

    public function __construct(Tour $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of tours with search and filtering
     */
public function indexTour($search = null, $perPage = 10, $destinationId = null, $tourType = null)
{
    return $this->model
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("JSON_EXTRACT(title, '$.en') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(title, '$.ar') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(title, '$.fr') LIKE ?", ["%{$search}%"])
                  ->orWhere('capacity', 'like', "%{$search}%")
                  ->orWhere('rating', 'like', "%{$search}%");
            });
        })
        ->when($destinationId, function ($query) use ($destinationId) {
            $query->where('destination_id', $destinationId);
        })
        ->when($tourType, function ($query) use ($tourType) {
            $query->where('tour_type', $tourType);
        })
        ->with(['destination', 'addedByUser'])
        ->paginate($perPage);
}


    /**
     * Store a newly created tour
     */
    public function storeTour(array $requestData)
    {
        try {
            $data = Arr::only($requestData, [
                'destination_id',
                'title',
                'description',
                'capacity',
                'rating',
                'tour_type',
                'hotel_info',
                'package_info',
                'user_add_id',
            ]);

            $data['user_add_id'] = Auth::id();

            // Handle multiple image uploads
            if (!empty($requestData['image']) && is_array($requestData['image'])) {
                $imageUrls = [];
                foreach ($requestData['image'] as $image) {
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $imageUrls[] = $this->storeImage($image);
                    }
                }
                $data['image'] = $imageUrls;
            } else {
                $data['image'] = $requestData['image'] ?? null;
            }

            $tour = $this->model->create($data);
            return [
                'status' => true,
                'message' => 'Tour created successfully',
                'data' => $tour
            ];
        } catch (\Exception $e) {
            Log::error('Tour creation failed: ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Error occurred while creating tour'
            ];
        }
    }

    /**
     * Retrieve tour for editing or display
     */
    public function editTour($tourId)
    {
        return $this->model->with(['destination', 'addedByUser'])->find($tourId);
    }

    /**
     * Update tour data
     */
    public function updateTour(array $requestData, $tourId)
    {
        try {
            $tour = $this->model->find($tourId);

            if (!$tour) {
                return [
                    'status' => false,
                    'message' => 'Tour not found'
                ];
            }

            $data = Arr::only($requestData, [
                'destination_id',
                'title',
                'description',
                'capacity',
                'rating',
                'tour_type',
                'hotel_info',
                'package_info',
            ]);

            // Handle multiple image uploads
            if (isset($requestData['image']) && is_array($requestData['image'])) {
                // Delete old images if exist
                if ($tour->image && is_array($tour->image)) {
                    foreach ($tour->image as $oldImage) {
                        if (file_exists(public_path(parse_url($oldImage, PHP_URL_PATH)))) {
                            unlink(public_path(parse_url($oldImage, PHP_URL_PATH)));
                        }
                    }
                }
                
                $imageUrls = [];
                foreach ($requestData['image'] as $image) {
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $imageUrls[] = $this->storeImage($image);
                    }
                }
                $data['image'] = $imageUrls;
            }

            $tour->update($data);

            return [
                'status' => true,
                'message' => 'Tour updated successfully',
                'data' => $tour
            ];
        } catch (\Exception $e) {
            Log::error('Tour update failed: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error occurred while updating tour'
            ];
        }
    }

    /**
     * Delete tour
     */
    public function destroyTour($tourId)
    {
        try {
            $tour = $this->model->find($tourId);

            if (!$tour) {
                return [
                    'status' => false,
                    'message' => 'Tour not found'
                ];
            }

            // Delete images if exist
            if ($tour->image && is_array($tour->image)) {
                foreach ($tour->image as $image) {
                    if (file_exists(public_path(parse_url($image, PHP_URL_PATH)))) {
                        unlink(public_path(parse_url($image, PHP_URL_PATH)));
                    }
                }
            }

            $tour->delete();

            return [
                'status' => true,
                'message' => 'Tour deleted successfully'
            ];
        } catch (\Exception $e) {
            Log::error('Tour deletion failed: ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Error occurred while deleting tour'
            ];
        }
    }

    /**
     * Store uploaded image
     */
    protected function storeImage(\Illuminate\Http\UploadedFile $image): string
    {
        $folder = 'assets/images/tours';
        $publicPath = public_path($folder);

        // Ensure folder exists
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $fileName = $originalName . '_' . now()->format('Ymd_His') . '.' . $extension;
        $image->move($publicPath, $fileName);
        return url($folder . '/' . $fileName);
    }
}
