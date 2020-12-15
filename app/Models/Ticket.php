<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $table = 'tickets';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $dates = ['created_at', 'deleted_at'];

    protected $fillable = [
        'price',   'customer_id', 'event_id'
    ];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
