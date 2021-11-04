<?php

namespace Mariojgt\Castle\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AutenticatorHandle;

class HomeContoller extends Controller
{
    /**
     * @return [blade view]
     */
    public function index()
    {
        return view('Castle::content.home.index');
    }

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

    public function checkCode(Request $request)
    {
        $request->validate([
            'code'       => 'required',
        ]);

        $autenticatorHandle = new AutenticatorHandle();
        $verification       = $autenticatorHandle->checkCode(Request('code'));

        return view('Castle::content.home.check_result', compact('verification'));
    }

    public function logout(Request $request)
    {
        $autenticatorHandle = new AutenticatorHandle();
        $autenticatorHandle->logout();

        return redirect()->route('castle');
    }

    public function protected(Request $request)
    {
        return view('Castle::content.home.autenticate');
    }
}
