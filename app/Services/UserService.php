<?php
namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Http\Request;
use App\Traits\UploadImage;

use Carbon\Carbon;

class UserService {

    use UploadImage;
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function addUser($filter) {
        $attribute = [
            'name' => $filter->name,
            'username' => $filter->userName,
            'email' => $filter->email,
            'password' => Hash::make($filter->password),
            'gender' => $filter->gender,
            'country' => $filter->country,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        
        if ($filter->gender == 1) {
            $attribute['avatar'] = '/img/avatar/boy1.png';
        } else {
            $attribute['avatar'] = '/img/avatar/girl1.png';
        }

        $result = $this->userRepository->addUser($attribute);

        if ($result) {
            return response()->json([
                'meta' => [
                    'authenticated' => true,
                    'token' => 'token',
                ],
                'data' => [
                    'user' => $result
                ]
            ], 200);
        }

        return response()->json([
            'data' => [
                'status' => false
            ]
        ], 422);
    }

    public function showUser($id){
        return $this->userRepository->showUser($id);
    }

    public function updateProfile($id, $filter){
        $attribute = [
            'name' => $filter->name,
            'username' => $filter->username,
            'gender' => $filter->gender,
            'country' => $filter->country,
            'updated_at' => Carbon::now()
        ];
        
        if ($filter->hasFile('avatar')) {
            $dataUploadImage = $this->storageTraitUploadImg($filter, 'avatar', 'img_avatar');
            $attribute['avatar'] = $dataUploadImage['file_path'];
            if($filter->oldavatar && !is_null($filter->oldavatar)) {
                $rms = $this->removeImage($filter->oldavatar);
            }
            
        } else {
            $attribute['avatar'] = $filter->oldavatar;
        }
        
        return $this->userRepository->editUser($id, $attribute);
    }
}
