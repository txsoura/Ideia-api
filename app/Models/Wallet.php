<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use  SoftDeletes;

    protected $table = 'wallets';
    protected $primaryKey = 'id';
    public $incrementing = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'user_id' ];

    protected $dates = ['created_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
