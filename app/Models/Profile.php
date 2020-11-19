<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use  SoftDeletes;

    protected $table = 'profiles';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cpf_cnpj','img','birthdate','cellphone','sex','address_id','user_id'
    ];

    protected $dates = ['created_at', 'deleted_at','birthdate'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
