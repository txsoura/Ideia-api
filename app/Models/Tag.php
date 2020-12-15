<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'tags';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $dates = ['created_at', 'deleted_at'];

    protected $fillable = [
        'name'
    ];

    public function events()
    {
        return  $this->hasMany(Event::class);
    }
}
