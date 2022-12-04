<?php

namespace Mariojgt\Castle\Controllers\Demo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Mariojgt\Castle\Helpers\SystemInfo;
use Mariojgt\Castle\Helpers\EmailAuthenticator;

/**
 * The controller is used only for the demo, it contains the basic to get stated wit the 2 steps verification
 */
class EmailVerificationController extends Controller
{
    /**
     * Render the page where you are able to ype your email so we can generate the code
     */
    public function index()
    {
        $manager = new SystemInfo();
        $version = $manager->systemVersion();

        return view('castle::content.emailDemo.index', compact('version'));
    }

    /**
     * Generate the code send the email and redirect to the check page
     * @param Request $request
     *
     */
    public function generate(Request $request)
    {
        $managerAuthenticator = new EmailAuthenticator();
        $managerAuthenticator->triggerEmail(Request('email'));

        return view('castle::content.emailDemo.code_generated');
    }

    public function check(Request $request)
    {
        DB::beginTransaction();
        // Check if the code is valid if yes return a valid message else no
        $managerAuthenticator = new EmailAuthenticator();
        $response            = $managerAuthenticator->validateCode(Request('code'));
        DB::commit();

        $message = '';
        if ($response) {
            $message = 'Code is valid';
        } else {
            $message = 'Code is not valid';
        }

        return view('castle::content.emailDemo.check_result', compact('message', 'response'));
    }
}
