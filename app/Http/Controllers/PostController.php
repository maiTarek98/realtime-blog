<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Events\AddPost;
use Auth;
class PostController extends Controller
{
 
    public function index()
    {
        $posts= Post::with('user')->with('comments')->orderBy('id','DESC')->simplePaginate(5);
        return view('posts', compact('posts'));
    }

    public function save_post(Request $request){
        $data=new Post;
        $data->title=$request->title;
        $data->text=$request->text;
        $data->user_id=Auth::user()->id;
        $data->save();

        $arr_data = [
            'user_id' => Auth::user()->name,
            'text' => $request->text,
        ];
        event(new AddPost($arr_data));

        return response()->json([
            'bool'=>true
        ]);
    }

      public function save_comment(Request $request){
        $data=new Comment;
        $data->comment=$request->comment;
        $data->post_id=$request->post_id;
        $data->user_id=Auth::user()->id;
        $data->save();
        return response()->json([
            'bool'=>true
        ]);
    }

}
