<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * قائمة المستخدمين مع إمكانية البحث والتصفية
     */
    public function indexUser($searchUser = null, $perPageUser = 10)
    {
        return $this->model
            ->where('id', '!=', 1) // استبعاد أول مستخدم
            ->when($searchUser, function ($query) use ($searchUser) {
                $query->where(function ($q) use ($searchUser) {
                    $q->where('name', 'like', "%{$searchUser}%")
                        ->orWhere('email', 'like', "%{$searchUser}%")
                        ->orWhere('phone', 'like', "%{$searchUser}%");
                });
            })
            ->paginate($perPageUser);
    }


    /**
     * إنشاء مستخدم جديد
     */
    public function storeUser(array $requestData)
    {
        try {
            $data = Arr::only($requestData, [
                'name',
                'email',
                'phone',
                'password',
                'address',
                'role',
                'user_add_id',
            ]);

            $data['password'] = Hash::make($data['password']);
            $data['user_add_id'] = Auth::id();

            // التحقق من وجود صورة وتم رفعها كـ UploadedFile
            if (!empty($requestData['image']) && $requestData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $this->storeImage($requestData['image']);
            } else {
                $data['image'] = $requestData['image'] ?? null;
            }
            $user = $this->model->create($data);

            return [
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user
            ];
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Error occurred while creating user'
            ];
        }
    }

    /**
     * استرجاع بيانات مستخدم للتعديل
     */
    public function editUser($userId)
    {
        return $this->model->find($userId);
    }

    /**
     * تحديث بيانات مستخدم
     */
    public function updateUser(array $requestData, $userId)
    {
        try {
            $user = $this->model->find($userId);

            if (!$user) {
                return [
                    'status' => false,
                    'message' => 'User not found'
                ];
            }

            $data = Arr::only($requestData, [
                'name',
                'email',
                'phone',
                'address',
                'role',
            ]);

            // إضافة كلمة السر فقط لو موجودة ومدخولة
            if (!empty($requestData['password'])) {
                $data['password'] = Hash::make($requestData['password']);
            }
            if (isset($requestData['image']) && $requestData['image']) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($user->image && file_exists(public_path(parse_url($user->image, PHP_URL_PATH)))) {
                    unlink(public_path(parse_url($user->image, PHP_URL_PATH)));
                }
                $data['image'] = $this->storeImage($requestData['image']);
            }

            $user->update($data);

            return [
                'status' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ];
        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error occurred while updating user'
            ];
        }
    }

    /**
     * حذف مستخدم
     */
    public function destroyUser($userId)
    {
        try {
            $user = $this->model->find($userId);

            if (!$user) {
                return [
                    'status' => false,
                    'message' => 'User not found'
                ];
            }

            $user->delete();

            return [
                'status' => true,
                'message' => 'User deleted successfully'
            ];
        } catch (\Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Error occurred while deleting user'
            ];
        }
    }
    protected function storeImage(\Illuminate\Http\UploadedFile $image): string
    {
        $folder = 'assets/images/users';
        $publicPath = public_path($folder);

        // تأكد أن المجلد موجود، ولو مش موجود أنشئه
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
