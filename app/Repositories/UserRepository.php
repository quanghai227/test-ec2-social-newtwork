<?php
namespace App\Repositories;

use App\Models\User;

//use App\Repositories\EloquentBaseRepository;

class UserRepository extends EloquentBaseRepository {

    protected $user;

    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->user = $user;
        //dd($this->nameModel);
    }

    public function addUser(array $array) {
        return $this->createData($array);  //kế thừ parrent gọi trực tiếp hàm
    }

    public function showUser($id){
        return $this->getById($id);
    }

    public function editUser($id, array $array) {
        // return $this->updateData($id, $array);
        return tap($this->user->where('id', $id))->update($array)->first();
    }
}
