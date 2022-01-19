<?php

namespace Mariojgt\Castle\Controllers\Demo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\SystemInfo;
use Mariojgt\Castle\Helpers\EmailAutenticator;
use Mariojgt\Castle\Helpers\AutenticatorHandle;

/**
 * The controller is used only for the demo, it cointains the basic to get stated wit the 2 steps verification
 * [Description HomeContoller]
 */
class EmailVerificationController extends Controller
{
    /**
     * Render the page where you are able to ype your email so we can generate the code
     * @return [blade view]
     */
    public function index()
    {
        $manager = new SystemInfo();
        $version = $manager->systemVersion();

        return view('Castle::content.emailDemo.index', compact('version'));
    }

    /**
     * Generate teh code send teh email and redirect to the check page
     * @param Request $request
     *
     * @return [type]
     */
    public function generate(Request $request)
    {
        $managerAutenticator = new EmailAutenticator();
        $managerAutenticator->triggerEmail(Request('email'));

        return view('Castle::content.emailDemo.code_generated');
    }

    public function check(Request $request)
    {
        DB::beginTransaction();
        // Check if the code is valid if yes return a valid message else no
        $managerAutenticator = new EmailAutenticator();
        $response            = $managerAutenticator->validateCode(Request('code'));
        DB::commit();

        $message = '';
        if ($response) {
            $message = 'Code is valid';
        } else {
            $message = 'Code is not valid';
        }

        return view('Castle::content.emailDemo.check_result', compact('message', 'response'));
    }
}
