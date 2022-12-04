<?php

namespace Mariojgt\Castle\Controllers\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AuthenticatorHandle;
use Mariojgt\Castle\Helpers\SystemInfo;

/**
 * The controller is used only for the demo, it contains the basic to get stated wit the 2 steps verification
 */
class TwoStepsDemoController extends Controller
{
    /**
     * Render the page where you are able to ype your email so we can generate the code
     */
    public function index()
    {
        $manager = new SystemInfo();
        $version = $manager->systemVersion();

        return view('castle::content.home.index', compact('version'));
    }

    /**
     * Get the user email and generate the code
     * @param Request $request
     *
     */
    public function generate(Request $request)
    {
        $request->validate([
            'email'       => 'required',
        ]);

        // Call the class that generate the gr-code with the secret read for google authenticator
        $AuthenticatorHandle = new AuthenticatorHandle();
        $generatedCode      = $AuthenticatorHandle->generateCode(Request('email'));

        // Add the secret in a session so we can check later if match
        Session::put('authenticator_key', encrypt($generatedCode["secret"]));

        return view('castle::content.home.codeGenerated', compact('generatedCode'));
    }

    /**
     * Check if the code that the user type match with the authenticator
     * @param Request $request
     *
     */
    public function checkCode(Request $request)
    {
        $request->validate([
            'code'       => 'required',
        ]);

        $AuthenticatorHandle = new AuthenticatorHandle();
        $verification       = $AuthenticatorHandle->checkCode(Request('code'));

        return view('castle::content.home.checkResult', compact('verification'));
    }

    /**
     * Make the user logout so the middleware wil ask to login against
     * @param Request $request
     *
     */
    public function logout(Request $request)
    {
        $AuthenticatorHandle = new AuthenticatorHandle();
        $AuthenticatorHandle->logout();

        return redirect()->route('castle');
    }

    /**
     * The example with the protected using the middleware
     * @param Request $request
     *
     */
    public function protected(Request $request)
    {
        return view('castle::content.home.authenticate');
    }
}
