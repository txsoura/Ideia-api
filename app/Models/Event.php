<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $table = 'events';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $dates = ['created_at', 'deleted_at', 'start', 'available'];

    protected $fillable = [
        'name', 'description', 'tags', 'start', 'access', 'price', 'type', 'restriction', 'available', 'ticket', 'producer_id', 'address_id', 'imgs'
    ];

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
