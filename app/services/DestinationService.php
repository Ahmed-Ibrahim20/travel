<?php

namespace App\Services;

use App\Models\Destination;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DestinationService
{
    protected Destination $model;

    public function __construct(Destination $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of destinations with search and filtering
     */
    public function indexDestination($search = null, $perPage = 10)
    {
        return $this->model->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("JSON_EXTRACT(name, '$.en') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(name, '$.ar') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(name, '$.fr') LIKE ?", ["%{$search}%"])
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        })->with('addedByUser')->paginate($perPage);
    }

    /**
     * Store a newly created destination
     */
    public function storeDestination(array $requestData)
    {
        try {
            $data = Arr::only($requestData, [
                'name',
                'description',
                'slug',
                'user_add_id',
            ]);

            $data['user_add_id'] = Auth::id();

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($requestData['name']['en'] ?? 'destination');
            }

            // Handle image upload
            if (!empty($requestData['image']) && $requestData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $this->storeImage($requestData['image']);
            } else {
                $data['image'] = $requestData['image'] ?? null;
            }

            $destination = $this->model->create($data);

            return [
                'status' => true,
                'message' => 'Destination created successfully',
                'data' => $destination
            ];
        } catch (\Exception $e) {
            Log::error('Destination creation failed: ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Error occurred while creating destination'
            ];
        }
    }

    /**
     * Retrieve destination for editing or display
     */
    public function editDestination($destinationId)
    {
        return $this->model->with('addedByUser')->find($destinationId);
    }

    /**
     * Update destination data
     */
    public function updateDestination(array $requestData, $destinationId)
    {
        try {
            $destination = $this->model->find($destinationId);

            if (!$destination) {
                return [
                    'status' => false,
                    'message' => 'Destination not found'
                ];
            }

            $data = Arr::only($requestData, [
                'name',
                'description',
                'slug',
            ]);

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($requestData['name']['en'] ?? 'destination');
            }

            // Handle image upload
            if (isset($requestData['image']) && $requestData['image']) {
                // Delete old image if exists
                if ($destination->image && file_exists(public_path(parse_url($destination->image, PHP_URL_PATH)))) {
                    unlink(public_path(parse_url($destination->image, PHP_URL_PATH)));
                }
                $data['image'] = $this->storeImage($requestData['image']);
            }

            $destination->update($data);

            return [
                'status' => true,
                'message' => 'Destination updated successfully',
                'data' => $destination
            ];
        } catch (\Exception $e) {
            Log::error('Destination update failed: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error occurred while updating destination'
            ];
        }
    }

    /**
     * Delete destination
     */
    public function destroyDestination($destinationId)
    {
        try {
            $destination = $this->model->find($destinationId);

            if (!$destination) {
                return [
                    'status' => false,
                    'message' => 'Destination not found'
                ];
            }

            // Delete image if exists
            if ($destination->image && file_exists(public_path(parse_url($destination->image, PHP_URL_PATH)))) {
                unlink(public_path(parse_url($destination->image, PHP_URL_PATH)));
            }

            $destination->delete();

            return [
                'status' => true,
                'message' => 'Destination deleted successfully'
            ];
        } catch (\Exception $e) {
            Log::error('Destination deletion failed: ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Error occurred while deleting destination'
            ];
        }
    }

    /**
     * Store uploaded image
     */
    protected function storeImage(\Illuminate\Http\UploadedFile $image): string
    {
        $folder = 'assets/images/destinations';
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
