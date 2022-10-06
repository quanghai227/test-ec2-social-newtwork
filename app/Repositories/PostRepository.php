<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository extends EloquentBaseRepository {

    protected $post;

    public function __construct(Post $post)
    {
        parent::__construct($post);
        $this->post = $post;
    }

    public function addPost(array $array) {

        return $this->createData($array);  //kế thừ parrent gọi trực tiếp hàm
    }

    public function showPost($id){
        return $this->getById($id);
    }

    public function editPost($id, array $array) {
        return $this->updateData($id, $array);
    }
}
