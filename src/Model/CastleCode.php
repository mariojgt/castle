<?php

namespace Mariojgt\Castle\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CastleCode extends Model
{
    use HasFactory;

    public function modelItem()
    {
        return $this->morphTo('castle_codes', 'model', 'model_id');
    }

    // public function autenticatedModel()
    // {
    //     return $this->morphOne(OrderItem::class, 'order_items', 'model', 'model_id');
    // }
}
