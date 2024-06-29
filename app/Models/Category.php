<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_type_id',
        'parent_id',
        'status',
    ];
    public CONST STATUS_ACTIVE = 'active';
    public CONST STATUS_INACTIVE = 'inactive';


    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function categories(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function allCategories(){
        return $this->categories()->with('allCategories');
    }
      // Define the relationship to the category type
      public function categoryType()
      {
          return $this->belongsTo(CategoryType::class,'category_type_id','id');
      }

      public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
