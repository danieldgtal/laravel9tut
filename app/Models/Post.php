<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Eloquent method (ORM) better used for interaction with databases
    protected $fillable = [
      'title','excerpt','body','image_path','is_published','min_to_read'
    ];
    // protected $table = 'posts';

    // protected $primaryKey = 'title';

    // public $timestamps = false;

    // protected $dateTime = 'U';

    // protected $connection = 'sqlite';

    // protected $attributes = [
    //   'is_published' => true,
    // ]; 
}
