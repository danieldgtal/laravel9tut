<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //  public function index()
    // Examples here used query builer for outputing data into our views
    // {
        // $posts = DB::statement('SELECT * FROM posts');
        // $posts = DB::select('SELECT * FROM posts WHERE id = :id', ['id' => 1]);
        // $posts = DB::insert('INSERT INTO posts (title,excerpt,body, image_path,is_published,min_to_read) VALUES(?, ?, ?, ?, ?, ?)', [
        //   'Test','test','test','test', true, 1
        // ]);
        // $posts = DB::update('UPDATE posts SET body = ? WHERE id = ?', ['Body 2','99']);
        // $posts = DB::delete('DELETE FROM posts WHERE id = ?', ['102']);
        // $posts = DB::table('posts')
          // ->where('id','>',50)
          // ->where('is_published', true)
          // ->whereBetween('min_to_read',[2,3])
          // ->whereNotBetween('min_to_read',[2,5])
          // ->whereIn('min_to_read',[2,4,8])
          // ->whereNull('created_at') 
          // ->skip(30) //The where and take works together
          // ->take(10) //skips first 30 and returns next 10 ie from 31

          // ->first(100)  // look for row with id of 100
          // ->find(100) // look for row with primary key of 100

          // ->where('id', 100)// select post with id of 100
          // ->value('body');// and return the value in the body

          // ->get();

          // ->where('id', 24)
          // ->value('excerpt'); // grab data based on a particular value

          // ->count();
          // ->min('min_to_read');
          // ->max('min_to_read');
          // ->sum('min_to_read') // sum of all min_to_read
          // ->avg('min_to_read'); // average time to read a blog
          
        // dd($posts);
        // Method 1 (output data to template engine)
        // $posts = DB::table('posts')->find(1);
        // return view('blog.index')->with('posts',$posts); // using the with method

        // Method 2 Output data to template engine
        // $posts = DB::table('posts')->get();
        // return view('blog.index',compact('posts')); // using the compact method 

        // Method 3 Output data to template engine
        // return view('blog.index', [
        //   'posts' => DB::table('posts')->get(),
        // ]);
    //}
    public function index()
    {
      // This method uses eloquent method to output data into our views
      // $posts = Post::orderBy('id','desc')->take(10)->get();
      // $posts = Post::where('min_to_read', '!=', 2)->get();
      // $posts = Post::chunk(25, function($posts){ // get chunk data in smaller sizes
      //   foreach($posts as $post){
      //     echo $post->title . '<br>';
      //   }
      // });
        // $posts = Post::get()->count();count all id
        // $posts = Post::avg('min_to_read');Get average
        // $posts = Post::sum('min_to_read');Get average
      // dd($posts);
      // return view('blog.index');

      // return view('blog.index', [
      //   'posts' => Post::orderBy('update_at','desc'),
      // ]);
      return view('blog.index',[
        'posts' => Post::orderBy('id','desc')->get(),
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   // Procedural Approach to storing data in database
        // $post = new Post();
        // $post->title = $request->title;
        // $post->excerpt = $request->excerpt;
        // $post->body = $request->body;
        // $post->image_path = 'temporary';
        // $post->is_published = $request->is_published === 'on';
        // $post->min_to_read = $request->min_to_read;
        // $post->save();

        $request->validate([
          'title' => 'required|unique:posts|max:255',
          'excerpt' => 'required',
          'body' => 'required',
          'image' => ['required','mimes:jpg,png,jpeg','max:5048'],
          'min_to_read' => 'min:0|max:60',
        ]);

        Post::create([
          'title' =>  $request->title,
          'excerpt' => $request->excerpt,
          'body' => $request->body,
          'image_path' => $this->storeImage($request),
          'is_published' => $request->is_published === 'on',
          'min_to_read' => $request->min_to_read,
        ]);

        return redirect(route('blog.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        // $post = Post::find($id);
        // $post = Post::findOrFail($id);
        
        return view('blog.show',[
          'post' => Post::findOrFail($id),
        ]);
         
        // dd($post);
        // return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('blog.edit', [
          'post' => Post::where('id',$id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
      $request->validate([
        'title' => 'required|max:255|unique:posts,title,'.$id,
        'excerpt' => 'required',
        'body' => 'required',
        'image' => ['mimes:jpg,png,jpeg','max:5048'],
        'min_to_read' => 'min:0|max:60',
      ]);
      Post::where('id', $id)->update($request->except([
        '_token','_method'
      ]));
      
      return redirect(route('blog.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   Post::destroy($id);
        return redirect(route(('blog.index')))->with('message','post has been deleted successfully!');
    }
    
    private function storeImage($request)
    { 
      $newImageName = uniqid(). '-' . $request->title . '.' . $request->image->extension();
      return $request->image->move(public_path('images'), $newImageName);
      
    }
}
