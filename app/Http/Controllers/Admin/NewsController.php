<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Photo;

class NewsController extends Controller
{
    /**
     * ==============================
     * PUBLIC METHODS
     * ==============================
     */

    public function publicIndex()
    {
        $news = News::with('photos')->latest()->paginate(9);
        return view('pages.news-list', compact('news'));
    }

    public function publicShow(News $news)
    {
        $news->load('photos');
        return view('pages.news-show', compact('news'));
    }

    /**
     * ==============================
     * ADMIN METHODS
     * ==============================
     */

    // List all news
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    // Show create form
    public function create()
    {
        return view('admin.news.create');
    }

    // Store new news
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $news = News::create($data);

        // Upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = time().'_'.uniqid().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/news'), $imageName);
                $news->photos()->create(['image' => $imageName]);
            }
        }

        return redirect()->route('admin.news.index')->with('success', 'News created successfully.');
    }

    // Show single news
    public function show(News $news)
    {
        $news->load('photos');
        return view('admin.news.show', compact('news'));
    }

    // Show edit form
    public function edit(News $news)
    {
        $news->load('photos');
        return view('admin.news.edit', compact('news'));
    }

    // Update news
    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $news->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);

        // Upload new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = time().'_'.uniqid().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/news'), $imageName);
                $news->photos()->create(['image' => $imageName]);
            }
        }

        return redirect()->back()->with('success', 'News updated successfully.');
    }

    // Delete news
    public function destroy(News $news)
    {
        foreach ($news->photos as $photo) {
            $imagePath = public_path('uploads/news/'.$photo->image);
            if (file_exists($imagePath)) unlink($imagePath);
            $photo->delete();
        }

        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }

    // Delete a single photo (used by edit page)
    public function destroyPhoto(Photo $photo)
    {
        $imagePath = public_path('uploads/news/'.$photo->image);
        if (file_exists($imagePath)) unlink($imagePath);

        $photo->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
}
