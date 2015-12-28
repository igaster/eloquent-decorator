<?php namespace Dimsav\Translatable\Test\Model;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;

class City extends Eloquent
{
    use Translatable;
    public $array = 'article';
    public $fillable = ['title', 'body'];
}