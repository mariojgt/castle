<?php

namespace Mariojgt\Castle\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CastleCode extends Model
{
    use HasFactory;

    /**
     * This function will return the model related to the code
     */
    public function castleModelItem()
    {
        return $this->morphTo('castle_codes', 'model', 'model_id');
    }
}
