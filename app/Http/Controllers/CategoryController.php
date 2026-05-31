<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Car::where('status', 'Live')->where('moderation_status', 'published')
            ->whereNotNull('category')
            ->select('category', DB::raw('count(*) as total'), DB::raw('MAX(image_url) as image'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();
        return view('categories.index', compact('categories'));
    }
}
