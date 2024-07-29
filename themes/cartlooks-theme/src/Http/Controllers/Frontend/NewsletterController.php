<?php

namespace Theme\CartLooksTheme\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Spatie\Newsletter\NewsletterFacade;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     ** Newsletter Subscriber Store
     * @param \Illuminate\Http\Request $request
     * @return Redirect
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => translate('Please Enter a Valid Email', session()->get('api_locale'))
            ]);
        }

        $mailchimp_api_key = env('MAILCHIMP_APIKEY');
        $mailchimp_list_id = env('MAILCHIMP_LIST_ID');
        if ($mailchimp_api_key == '' || $mailchimp_list_id == '') {
            return response()->json([
                'success' => false,
                'message' => translate('Mailchimp Api key Or List id Missing.', session()->get('api_locale'))
            ]);
        }

        if (!NewsletterFacade::isSubscribed($request->email)) {
            NewsletterFacade::subscribePending($request->email);
            return response()->json([
                'success' => true,
                'message' => translate('Please Check your Email to confirm your Subscription', session()->get('api_locale'))
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => translate('This Email is already Subscribed', session()->get('api_locale'))
        ]);
    }
}
