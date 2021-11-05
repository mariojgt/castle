<?php

namespace Mariojgt\Castle\Trait;

use Mariojgt\Castle\Model\CastleCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AutenticatorHandle;

trait Castle
{
    /**
     * Get the user autenticator token
     * @return [type]
     */
    public function twoStepsEnable()
    {
        $codes = $this->getCodes;
        if (empty($codes)) {
            return false;
        } else {
            // Start the session so we can check the user one time password
            Session::put('autenticator_key', $codes['secret']);
            return true;
        }
    }

    /**
     * This fuction attach the model to that autenticator secrete and generate backup codes
     * @param mixed $secret
     *
     * @return [type]
     */
    public function syncAutenticator($secret)
    {
        // Call the class
        $autenticatorHandle = new AutenticatorHandle();
        // Generate the backup codes based in the secret
        $syncCode           = $autenticatorHandle->generateBackupCodes($secret);
        // Attach the model to the table where have the secret and the codes
        $castleCode           = new CastleCode();
        $castleCode->model    = get_class($this);
        $castleCode->model_id = $this->id;
        $castleCode->secret   = encrypt($syncCode['secret']);
        $castleCode->codes    = $syncCode['back_up_code'];
        $castleCode->save();
    }

    /**
     * Return the model codes relation
     * @return [type]
     */
    public function getCodes()
    {
        return $this->morphOne(CastleCode::class, 'castle_codes', 'model', 'model_id');
    }
}
