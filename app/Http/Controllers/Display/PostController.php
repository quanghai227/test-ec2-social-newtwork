<?php

namespace App\Http\Controllers\Display;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Traits\UploadImage;

class PostController extends Controller
{
    use UploadImage;

    public function index() {
        return response()->json([
            'data' => Post::with(['user'])->orderBy('updated_at')->paginate(3)
        ]);
    }

    public function searchHome($filter) {
        if(empty($filter)) {
            return response()->json([
                'data' => null
            ]);
        }
        $posts = Post::where(function ($query) use ($filter) {
            $query->orWhere('id','like','%'.$filter.'%')
                  ->orWhere('title','like','%'.$filter.'%')
                  ->orWhere('content','like','%$'.$filter.'%');
            })->paginate(10);

        $users = User::where(function ($query) use ($filter) {
            $query->orWhere('id','like','%'.$filter.'%')
                  ->orWhere('username','like','%'.$filter.'%')
                  ->orWhere('name','like','%'.$filter.'%')
                  ->orWhere('email','like','%'.$filter.'%');
            })->select('id', 'username', 'avatar')
            ->paginate(10);
            

        return response()->json([
            'posts' => $posts,
            'users' => $users
        ]);
    }

    public function getAll() {
        $posts = Post::with(['postUser'])->orderBy('id', 'desc')->paginate(10);
        $user = Auth::user();
        
        foreach($posts as $post) {
            $countLike = count($post->likes);
            $check_user_like_post = Like::where([
                ['post_id', $post->id],
                ['user_id', $user->id]
            ])->first();

            if ($check_user_like_post) {
                $post['user_is_like'] = true;
            } else {
                $post['user_is_like'] = false;
            }
            //comments
            // $comments = $post->comments()->orderBy('id', 'desc')->get();
            // $post['comments'] = $comments;
            $post['count_post_likes'] = $countLike;
            $post['comments'] = [];
        }

        // dd($new_posts);

        return response()->json([
            'data' => $posts
        ]);
    }

    public function addPost(Request $request) {
        $user = Auth::user();
        if ($request->hasFile('image')) {
            $dataUploadImage = $this->storageTraitUploadImg($request, 'image', 'post');
            $image = $dataUploadImage['file_path'];
        } else {
            $image = "";
        }
        
        $post = Post::create([
            'title' => $user->username,
            'content' => $request->post_content,
            'user_id' => $user->id,
            'image'   => $image,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
            'new_post' => $post
        ]);
    }

    public function getLikesByPostID(Request $request) {
        $likes = Like::with(['user'])->where('post_id', $request->post_id)->get();
        
        $count_likes = count($likes);
        $user = Auth::user();
        $user_is_like = false;
        $check_user_like_post = Like::where([
            ['post_id', $request->post_id],
            ['user_id', $user->id]
        ])->first();

        if ($check_user_like_post) {
            $user_is_like = true;
        }
        
        return response()->json([
            'data' => $likes,
            'user_is_like' => $user_is_like,
            'count_likes' => $count_likes
        ]);
    }

    public function likePost(Request $request) {
        $post_id = $request->post_id;
        $is_like = $request->is_like === true;

        $post = Post::find($post_id);
        if (!$post) {
            return 'not found post';
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like && $like->like == $is_like) {
            // like 2 lan thi xoa
            $like->delete();
            return 'delete like';
        }
        $like = new Like();
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post_id;
        $like->save();

        return 'liked';
    }

    public function likeAndDislikePost(Request $request) {
        $post_id = $request->post_id;
        $is_like = $request->is_like === 'true'; // neu nhan dislike $is_like= false

        $update = false;
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like) {
            $already_like = $like->like;
            $update = true;
            if ($already_like == $is_like) {
                // like 2 lan thi xoa
                $like->delete();
                return null;
            }
        }
        $like = new Like();
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post_id;
        if ($update) {
            //dislike $is_like = false se update like = 0
            $like->update();
        } else {
            $like->save();
        }
        return null;
    }
}
