<?php

namespace Plugin\Refund\Repositories;

use Illuminate\Support\Facades\Mail;
use Plugin\CartLooksCore\Models\Customers;
use Plugin\Refund\Mail\ReturnStatusUpdateMail;
use Plugin\Refund\Notifications\RefundRequestStatusUpdateNotification;

class RefundNotification
{

    /**
     * Will send refund request status change notification to customer
     * 
     * @param String $message
     * @param Int $customer_id
     * @return void
     */
    public static function sendRefundRequestStatusUpdateNotification($request_id, $message, $customer_id, $mail_title)
    {
        $link = '/dashboard/refund/details/' . $request_id;
        $data = [
            'message' => $message,
            'link' => $link
        ];
        $customer = Customers::where('id', $customer_id)->first();
        if ($customer != null) {
            $customer->notify(new RefundRequestStatusUpdateNotification($data));

            //Send mail to customer
            $mail_data = [
                'template_id' => 12,
                'keywords' => getEmailTemplateVariables(12, true),
                'subject' => $mail_title,
                '_tracking_url_' => url('/') . '/dashboard/refund/details/' . $request_id,
                '_customer_name_' => $customer->name,
                '_message_' => $message,
                '_mail_title_' => $mail_title,
            ];
            Mail::to($customer->email)->send(new ReturnStatusUpdateMail($mail_data));
        }
    }
}
