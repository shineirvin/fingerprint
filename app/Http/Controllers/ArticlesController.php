<?php

namespace App\Http\Controllers;

use Auth;
use App\Tag;
use App\Article;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\Controller;


class ArticlesController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index()
    {
    	$articles = Article::latest('published_at')->published()->get();

    	return view('articles.index', compact('articles'));
    }

    public function show($id)
    {
    	$article = Article::findOrFail($id);

    	return view('articles.show', compact('article'));
    }

    public function create()
    {
    	$tags = Tag::lists('name', 'id');
    	return view('articles.create', compact('tags'));
    }

    public function store(ArticleRequest $request)
    {
    	$article = Auth::User()->articles()->create($request->All());

        if ( ! is_null($request->input('tag_list')))
        {
            $article->tags()->sync($request->input('tag_list'));
        }

    	$article->tags()->attach($request->input('tag_list'));

    	return redirect('articles')->with('flash_message', 'Your article has been created!');
    }

    public function edit($id)
    {
    	$article = Article::findOrFail($id);
    	$tags = Tag::lists('name', 'id');
    	return view('articles.edit', compact('article', 'tags'));
    }

    public function update($id, ArticleRequest $request)
    {
    	$article = Article::findOrFail($id);
    	$article->update($request->All());

        if ( ! is_null($request->input('tag_list')))
        {
            $article->tags()->sync($request->input('tag_list'));
        }

    	return redirect('articles');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->tags()->detach();
        $article->delete();
        return redirect('articles')->with('flash_message', 'Deleted!');
    }


    public function practice(Request $request)
    {
        $xml = simplexml_load_string($request->input('xml'));
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $data = json_encode($array);
            $tc = 0;        //tab count
    $r = '';        //result
    $q = false;     //quotes
    $t = "\t";      //tab
    $nl = "\n";     //new line

    for($i=0;$i<strlen($json);$i++){
        $c = $json[$i];
        if($c=='"' && $json[$i-1]!='\\') $q = !$q;
        if($q){
            $r .= $c;
            continue;
        }
        switch($c){
            case '{':
            case '[':
                $r .= $c . $nl . str_repeat($t, ++$tc);
                break;
            case '}':
            case ']':
                $r .= $nl . str_repeat($t, --$tc) . $c;
                break;
            case ',':
                $r .= $c;
                if($json[$i+1]!='{' && $json[$i+1]!='[') $r .= $nl . str_repeat($t, $tc);
                break;
            case ':':
                $r .= $c . ' ';
                break;
            default:
                $r .= $c;
        }
    }


        return view('practice.xmltojson')->with('tests', $r);
    }

}
