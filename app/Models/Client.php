<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Client extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
        'state',
        'zipcode'
    ];

    public function user(){
        //...User::class, 'id', 'user_id'
        //vai pegar o id da tabela user e relacionar com o user_id da tabela client desse Model
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
