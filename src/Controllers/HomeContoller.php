<?php

namespace Mariojgt\Castle\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AutenticatorHandle;

class HomeContoller extends Controller
{
    /**
     * Render the page where you are able to ype your email so we can generate the code
     * @return [blade view]
     */
    public function index()
    {
        return view('Castle::content.home.index');
    }

    /**
     * Get the user email and generate the code
     * @param Request $request
     *
     * @return [type]
     */
    public function generate(Request $request)
    {
        $request->validate([
            'email'       => 'required',
        ]);
        // Call the class that generate the gr-code with the screct read for google autneticator
        $autenticatorHandle = new AutenticatorHandle();
        $generatedCode      = $autenticatorHandle->generateCode(Request('email'));
        // Add the secret in a session so we can check later if match
        Session::put('autenticator_key', $generatedCode["secret"]);
        return view('Castle::content.home.code_generated', compact('generatedCode'));
    }

    /**
     * Check if the code that the user type mathc with the autenticator
     * @param Request $request
     *
     * @return [type]
     */
    public function checkCode(Request $request)
    {
        $request->validate([
            'code'       => 'required',
        ]);

        $autenticatorHandle = new AutenticatorHandle();
        $verification       = $autenticatorHandle->checkCode(Request('code'));

        return view('Castle::content.home.check_result', compact('verification'));
    }

    /**
     * Make the user logout so the middlewhere wil ask to login againt
     * @param Request $request
     *
     * @return [type]
     */
    public function logout(Request $request)
    {
        $autenticatorHandle = new AutenticatorHandle();
        $autenticatorHandle->logout();

        return redirect()->route('castle');
    }

    /**
     * The example with the prodcted using the middlewhere
     * @param Request $request
     *
     * @return [type]
     */
    public function protected(Request $request)
    {
        return view('Castle::content.home.autenticate');
    }
}
