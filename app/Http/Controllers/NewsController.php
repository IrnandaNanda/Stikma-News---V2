<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');

        $news = News::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                         ->orWhere('content', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(4)->withQueryString();
        return view('pages.news.index', compact('news'));
    }

    public function show($slug) {
        $news = News::where('slug', $slug)->firstOrFail();
        $newests = News::orderBy('created_at', 'desc')->take(4)->get();
        return view('pages.news.show', compact('news', 'newests'));
    }

    public function category($slug) {
        $category = NewsCategory::where('slug', $slug)->firstOr();
        return view('pages.news.category', compact('category'));
    }
}
