<?php

namespace App\Http\Controllers\Api;

use App\Models\karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Karyawan\UpdateRequest;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = Post::orderBy('title', 'asc')->paginate(10);
        $data = karyawan::orderBy('name', 'asc')->get();
        return response()->json([
            'status' =>true,
            'message' => 'Data Ditemukan',
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        //
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
             // put image in the public storage
            $filePath = Storage::disk('public')->put('images/karyawan/featured-images', request()->file('avatar'));
            $validated['avatar'] = $filePath;
        }

        // insert only requests that already validated in the StoreRequest
        $create = Karyawan::create($validated);

        // if($create) {
        //     session()->flash('notif.success', 'Post created successfully!');
        //     return redirect()->route('posts.index');
        // }

        // return abort(500);
        return response()->json([
            'status' =>true,
            'message' => 'Berhasil menambahkan Data !',
            'data' => $create,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        //
        $post = Karyawan::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            // delete image
            Storage::disk('public')->delete($post->featured_image);

            $filePath = Storage::disk('public')->put('images/posts/featured-images', request()->file('featured_image'), 'public');
            $validated['featured_image'] = $filePath;
        }

        $update = $post->update($validated);

        if($update) {
            session()->flash('notif.success', 'Post updated successfully!');
            return redirect()->route('posts.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
