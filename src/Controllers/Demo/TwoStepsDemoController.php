<?php

namespace Mariojgt\Castle\Controllers\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AutenticatorHandle;
use Mariojgt\Castle\Helpers\SystemInfo;

/**
 * The controller is used only for the demo, it cointains the basic to get stated wit the 2 steps verification
 * [Description HomeContoller]
 */
class TwoStepsDemoController extends Controller
{
    /**
     * Render the page where you are able to ype your email so we can generate the code
     * @return [blade view]
     */
    public function index()
    {
        $manager = new SystemInfo();
        $version = $manager->systemVersion();

        return view('Castle::content.home.Index', compact('version'));
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
        Session::put('autenticator_key', encrypt($generatedCode["secret"]));

        return view('Castle::content.home.CodeGenerated', compact('generatedCode'));
    }

    /**
     * Check if the code that the user type match with the autenticator
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

        return view('Castle::content.home.CheckResult', compact('verification'));
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
        return view('Castle::content.home.Autenticate');
    }
}
