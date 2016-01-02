<?php namespace igaster\EloquentDecorator\Tests\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Article extends Eloquent
{
    public $array = 'article';
    public $fillable = ['title', 'body'];
}