<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $guarded = [];
    public CONST STATUS_ACTIVE = 'active';
    public CONST STATUS_INACTIVE = 'inactive';

    public function file()
    {
        return $this->morphTo();
    }
}
