<?php

namespace Mariojgt\Castle\Trait;

use Illuminate\Database\Eloquent\Model;
use Mariojgt\Castle\Helpers\AutenticatorHandle;
use Mariojgt\Castle\Model\CastleCode;

trait Castle
{
    /**
     * Get the user autenticator token
     * @return [type]
     */
    public function checkAutenticatorSecret()
    {
        dd($this->getCodes);
    }

    public function syncAutenticator($secret)
    {
        // Call the class
        $autenticatorHandle = new AutenticatorHandle();
        // generate the backup codes
        $syncCode           = $autenticatorHandle->generateBackupCodes($secret);
        // attach the model to the table where have the secret and the codes
        $castleCode           = new CastleCode();
        $castleCode->model    = get_class($this);
        $castleCode->model_id = $this->id;
        $castleCode->secret   = encrypt($syncCode['secret']);
        $castleCode->codes    = $syncCode['back_up_code'];
        $castleCode->save();
    }

    public function getCodes()
    {
        return $this->morphTo('castle_codes', 'model', 'model_id');
    }
}
