<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = Post::orderBy('title', 'asc')->paginate(10);
        $data = Post::orderBy('title', 'asc')->get();
        return response()->json([
            'status' =>true,
            'message' => 'Data Ditemukan',
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // menangkap isi form
        $newPost = new Post;

        $rules = [
            'author' => 'required',
            'title' => 'required|min:3|max:255',
            'slug' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'Gagal memasukkan data !',
                'data' => $validator->errors(),
            ]);
        }

        //upload image
        $image = $request->file('image');
        $imagePath = $image->storeAs('public/posts', $image->hashName());

        $newPost->author = $request->author;
        $newPost->title = $request->title;
        $newPost->slug = $request->slug;
        $newPost->content = $request->content;
        // $newPost->thumbnail = $image->hashName();
        $newPost->thumbnail = $imagePath ;

        $post = $newPost->save();


        return response()->json([
            'status' =>true,
            'message' => 'Berhasil menambahkan Data !',
            'data' => $post,
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $data = Post::find($id);
        if($data) {
            return response()->json([
                'status' =>true,
                'message' => 'Data Ditemukan',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Data tidak ditemukan !',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $post = Post::find($id);
        if(empty($post)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan !',
            ], 404);
        }

        $rules = [
            'author' => 'nullable',
            'title' => 'nullable|min:3|max:255',
            'slug' => 'nullable',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'Gagal memasukkan data !',
                'data' => $validator->errors(),
            ]);
        }

        //upload image
        $image = $request->file('image');
        $imagePath = $image->storeAs('public/posts', $image->hashName());

        $post->author = $request->author;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->content = $request->content;
        // $post->thumbnail = $image->hashName();
        $post->thumbnail = $imagePath ;

        $newPost = $post->save();


        return response()->json([
            'status' =>true,
            'message' => 'Berhasil memperbarui Data !',
            'data' => $post,
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $findPost = Post::find($id);
        //jika tidak ada beritahu keterangan
        if(empty($findPost)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan !',
            ], 404);
        }
        $post = $findPost->delete();

        return response()->json([
            'status' =>true,
            'message' => 'Berhasil menghapus Data !',
        ]);
    }
}
