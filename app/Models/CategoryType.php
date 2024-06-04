<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public CONST STATUS_ACTIVE = 'active';
    public CONST STATUS_INACTIVE = 'inactive';

    public const FILE_STORE_PATH = 'category_type';

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
