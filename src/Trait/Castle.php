<?php

namespace Mariojgt\Castle\Trait;

use Mariojgt\Castle\Model\CastleCode;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AuthenticatorHandle;

/**
 * [This trait will handle the model authenticator features]
 * will check if the authenticator is enable, return the backup codes and sync the model with the authenticator
 */
trait Castle
{
    /**
     * Get the user authenticator token
     * @return [boolean]
     */
    public function twoStepsEnable()
    {
        // get the user backup codes
        $codes = $this->getCodes;
        // check if the backup codes is not empty
        if (empty($codes)) {
            return false;
        } else {
            // Start the session so we can check the user one time password
            Session::put('authenticator_key', encrypt($codes['secret']));
            return true;
        }
    }

    /**
     * This Function will sync the model(user) to the secret key
     * @param mixed $secret
     *
     * @return [array]
     */
    public function syncAuthenticator($secret)
    {
        // Check if the model already has a authenticator attach
        if ($this->twoStepsEnable() == false) {
            // Call the class
            $AuthenticatorHandle = new AuthenticatorHandle();
            // Generate the backup codes based in the secret
            $syncCode           = $AuthenticatorHandle->generateBackupCodes($secret);
            // Attach the model to the table where have the secret and the codes
            $castleCode           = new CastleCode();
            $castleCode->model    = get_class($this);
            $castleCode->model_id = $this->id;
            $castleCode->secret   = encrypt($syncCode['secret']);
            $castleCode->codes    = $syncCode['back_up_code'];
            $castleCode->save();

            return [
                'message' => 'User authenticator enable',
                'status'  => true,
            ];
        } else {
            return [
                'message' => 'User already have a authenticator enable',
                'status'  => false,
            ];
        }
    }

    /**
     * Return the model codes relation
     * @return collection [CastleCode]
     */
    public function getCodes()
    {
        return $this->morphOne(CastleCode::class, 'castle_codes', 'model', 'model_id');
    }
}
