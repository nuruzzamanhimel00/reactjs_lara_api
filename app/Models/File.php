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
    public const FILE_STORE_PATH = 'files';


    protected $appends = [
        'path'
    ];

    public function file()
    {
        return $this->morphTo();
    }

    public function getPathAttribute(){
        return getStorageImage(self::FILE_STORE_PATH, $this->name, false);
    }
}
