<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 列出所有文章
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'created_at');
        $order = $request->input('order', 'desc');

        return Post::where('is_active', true)
                    ->orderBy($sortBy, $order)
                    ->get();
    }

    // 儲存新的文章
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_path' => 'nullable|image',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('images', 'public');
        }

        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    // 更新文章
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'is_active' => 'boolean',
            'image_path' => 'nullable|image',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('images', 'public');
        }

        $post->update($validated);
        return response()->json($post);
    }

    // 刪除文章
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }

    // 搜尋文章
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Post::where('title', 'like', "%$query%")
                        ->orWhere('content', 'like', "%$query%")
                        ->get();
        return response()->json($results);
    }

    // 設定文章為啟用
    public function setActive($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $post->update(['is_active' => true]);
        return response()->json(['message' => 'Post activated successfully']);
    }

    // 設定文章為停用
    public function setInactive($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $post->update(['is_active' => false]);
        return response()->json(['message' => 'Post deactivated successfully']);
    }

    // 自訂排序功能
    public function order(Request $request)
    {
        $orderedPosts = $request->input('posts');
        foreach ($orderedPosts as $index => $postId) {
            $post = Post::find($postId);
            if (!$post) {
                return response()->json(['message' => "Post ID $postId not found"], 404);
            }
            $post->update(['created_at' => now()->subSeconds($index)]);
        }

        return response()->json(['message' => 'Posts reordered successfully']);
    }
}
