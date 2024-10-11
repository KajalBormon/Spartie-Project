<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            new Middleware('permission:view articles', only: ['index']),
            new Middleware('permission:edit articles', only: ['edit','update']),
            new Middleware('permission:create articles', only: ['create','store']),
            new Middleware('permission:delete articles', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view("article.list",compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("article.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"=> "required",
            "author" => "required",
        ]);
        if($validator->passes()){
            Article::create([
                "author"=> $request->author,
                "title"=> $request->title,
                "content" => $request->description,
            ]);
            return redirect()->route("article.index")->with("success","Article Added Successfully");
        }else{
            return redirect()->route('article.create')->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        return view('article.edit',compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            "title"=> "required",
            "author" => "required",
        ]);
        $article = Article::findOrFail($id);
        if($validator->passes()){
            $article->update([
                "author"=> $request->author,
                "title"=> $request->title,
                "content" => $request->description,
            ]);
            return redirect()->route("article.index")->with("success","Article Added Successfully");
        }else{
            return redirect()->route('article.edit',$id)->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $article = Article::findOrFail($id);

        if($article ==  null){
            session()->flash('error','Article Not Found');
            return response()->json([
                'status' => false,
            ]);
        }

        $article->delete();
        Session()->flash('success','Article Deleted Successfully');

        return response()->json([
            'status'=> true
        ]);
    }
}
