<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Database\Eloquent\Factories\HasFactory ;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{   
    use HasFactory , SoftDeletes;
    protected $table = 'product';
    protected $fillable = ["name","description","price","category_id"];


    protected $hidden =  [
        "created_at","updated_at"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

}
