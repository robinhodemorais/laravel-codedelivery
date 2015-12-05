<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;

class OauthClients extends Model
{
    protected $fillable = [
        'id',
        'secret',
        'name'
    ];

}
