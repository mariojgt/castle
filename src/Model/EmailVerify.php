<?php

namespace Mariojgt\Castle\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerify extends Model
{
    use HasFactory;

    /**
     * This fuction will return the model related to the code
     * @return [type]
     */
    public function castleModelItem()
    {
        return $this->morphTo('email_verifies', 'model', 'model_id');
    }
}
