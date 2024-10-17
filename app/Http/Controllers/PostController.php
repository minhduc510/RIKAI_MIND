<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public $postModel;

    public function __construct(Post $post)
    {
        $this->postModel = $post;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->postModel->query();


        if ($request->has('keyword') && $request->input('keyword') !== '') {
            $keyword = $request->input('keyword');
            $query->where('title', 'LIKE', "%$keyword%");
        }


        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $query->orderBy('published_at', $sort == '1' ? 'desc' : 'asc');
        } else {
            $query->orderBy('published_at', 'desc');
        }


        $posts = $query->paginate(5);

        return view('pages.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'nullable|date',
        ]);
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at
        ];
        $this->postModel->create($data);
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->postModel->find($id);
        return view('pages.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = $this->postModel->find($id);
        return view('pages.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'nullable|date',
        ]);
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at
        ];
        $this->postModel->find($id)->update($data);
        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->postModel->find($id)->delete();
        return redirect()->route('posts.index');
    }
}
