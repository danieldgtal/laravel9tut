<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Barryvdh\Debugbar\Facades\Debugbar as FacadesDebugbar;
use Illuminate\Support\Facades\Route;

/*
  GET - Request a resource
  POST - Create a new resource
  PUT - Update a resource
  PATCH - Modify a resource
  DELETE - Delete a resource
  OPTIONS - Ask the server which verbs are allowed
*/

// GET

// Route::get('/blog/{id}',[PostsController::class,'show'])->whereNumber('id');
// Route::get('/blog/{id}',[PostsController::class,'show'])->whereAlpha('name');
// Route::get('/blog/{id}',[PostsController::class,'show'])
//   ->where('name','[A-Za-z]+');
// Route::get('/blog/{id}/{name}', [PostsController::class, 'show'])
//   ->whereAlpha('name')
//   ->whereNumber('id');
Route::prefix('/blog')->group(function(){
  
  Route::get('/create',[PostsController::class,'create'])->name('blog.create');

  Route::get('/',[PostsController::class,'index'])->name('blog.index');
  Route::get('/{id}',[PostsController::class,'show'])->name('blog.show');
  
  Route::post('/',[PostsController::class,'store'])->name('blog.store');
  
  Route::get('/edit/{id}',[PostsController::class,'edit'])->name('blog.edit');
  Route::patch('/{id}',[PostsController::class,'update'])->name('blog.update');
  Route::delete('/{id}',[PostsController::class,'destroy'])->name('blog.destroy');
});

// Route::resource('blog',PostsController::class);

// Route for Invoke method
Route::get('/', HomeController::class);

//Multiple HTTP verbs
// Route::match(['GET','POST'],'/blog',[PostsController::class,'index']);
// Route::any('/blog',[PostsController::class,'index']);

// Return view
// Route::view('/blog','blog.index',['name'=> 'Code with Daniel']);

Route::fallback(FallbackController::class);


