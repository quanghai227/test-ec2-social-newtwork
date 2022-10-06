<?php
namespace App\Services;

//use Illuminate\Http\Request;

class PostService {

    protected $configureRepository;

    public function __construct(ConfigureRepository $configureRepository) {
        $this->configureRepository = $configureRepository;
    }

    public function addConfigure($filter) {
        $attribute = [
            'name' => $filter->name,
            'phone' => $filter->phone,
            'email' => $filter->email,
            'plate' => $filter->plate
        ];
        $attribute = json_encode($attribute);
        $data = [
            'key' => $filter->key,
            'value' => $attribute
        ];

        $result = $this->configureRepository->addConfigure($data);
        return $result;
    }

    public function showConfigure($id){
        $resutl = $this->configureRepository->showConfigure($id);
        $value = json_decode($resutl->value, false);
        $data = [
            'id' => $id,
            'key' => $resutl->key,
            'name' => $value->name,
            'phone' => $value->phone,
            'email' => $value->email,
            'plate' => $value->plate
        ];

        return $data;
    }

    public function updateConfigure($id, $filter){
        $attribute = [
            'name' => $filter->name,
            'phone' => $filter->phone,
            'email' => $filter->email,
            'plate' => $filter->plate
        ];
        $attribute = json_encode($attribute);
        $data = [
            'key' => $filter->key,
            'value' => $attribute
        ];

        return $this->configureRepository->editConfigure($id, $data);
    }
}
