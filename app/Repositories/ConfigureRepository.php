<?php
namespace App\Repositories;

use App\Model\Configmagure;

//use App\Repositories\EloquentBaseRepository;

class ConfigureRepository extends EloquentBaseRepository {

    public function __construct(Configmagure $conf)
    {
        parent::__construct($conf);
    }

    public function addConfigure(array $array) {
        return $this->createData($array);  //kế thừ parrent gọi trực tiếp hàm
    }

    public function showConfigure($id){
        return $this->getById($id);
    }

    public function editConfigure($id, array $array) {
        return $this->updateData($id, $array);
    }
}
