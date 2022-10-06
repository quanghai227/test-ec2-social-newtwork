<?php
namespace App\Repositories;

//use App\Repositories\EloquentInterfaceRepository;
use Illuminate\Database\Eloquent\Model;

class EloquentBaseRepository implements EloquentInterfaceRepository {
    protected $nameModel;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->nameModel = $model;
    }

    public function getAllOrFind($array = []) {

    }

    public function createData(array $array) {
        return $this->nameModel->create($array);
    }

    public function getById($id) {
        return $this->nameModel->find($id);
    }

    public function updateData($id, array $array) {
        return $this->nameModel->where('id', $id)->update($array);
    }

    public function deleteData(array $id) {

    }

}
