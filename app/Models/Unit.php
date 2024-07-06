<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'base_unit_id',
        'operator',
        'operator_value',
        'status',
    ];

    public const OPERATORS = ['*', '/'];

    public CONST STATUS_ACTIVE = 'active';
    public CONST STATUS_INACTIVE = 'inactive';

    public function parent(){
        return $this->belongsTo(Unit::class, 'base_unit_id');
    }

    public function allChildren(){
        return $this->childrens()->with('allChildren');
    }
    public function childrens(){
        return $this->hasMany(Unit::class, 'base_unit_id');
    }

    public function scopeBaseUnit(){
        return $this->where('base_unit_id', null);
    }
}
