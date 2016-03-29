<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function show($name)
    {
    	$tags = Tag::where('name', $name)->firstOrFail();
    	$articles =  $tags->articles()->published()->get();
    	return view('articles.index', compact('articles'));
    }
}
