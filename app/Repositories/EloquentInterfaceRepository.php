<?php
namespace App\Repositories;



/**
 * Interface BaseRepositoryInterface
 *
 * @package App\Repositories
 */
interface EloquentInterfaceRepository
{
    public function getAllOrFind($array = []);

    public function createData(array $array);

    public function getById($id);

    public function updateData($id, array $array);

    public function deleteData(array $id);

}
