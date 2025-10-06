<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','status','password','email','created_at','updated_at'];
    public $timestamp = true;
}
