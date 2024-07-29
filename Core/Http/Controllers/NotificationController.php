<?php

namespace Core\Http\Controllers;

use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Will return admin notifications
     * 
     * @return mixed
     */
    public function adminNotifications()
    {
        try {
            $notifications = auth()->user()->unreadNotifications;
            $notifications = $notifications->map(function ($item) {
                return [
                    'id' => $item->id,
                    'message' => $item->data['message'],
                    'link' => $item->data['link'],
                    'time' => $this->notificationTime($item->created_at)
                ];
            });

            return response()->json([
                'success' => true,
                'notifications' => $notifications
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
            ]);
        }
    }
    /**
     * Will mark as read single notification
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminNotificationMarkAsRead(Request $request)
    {
        try {
            $notification = auth()->user()->unreadNotifications()->where('id', $request['id'])->first();

            if ($notification != null) {
                $notification->markAsRead();

                //Link for Admin
                if (auth()->user()->user_type != config('cartlookscore.user_type.seller')) {
                    $link = '/' . getAdminPrefix() . $notification->data['link'];
                }

                //Link For Seller 
                if (auth()->user()->user_type == config('cartlookscore.user_type.seller')) {
                    $link = $notification->data['link'];
                }

                $unread_notification = auth()->user()->unreadNotifications;
                $unread_notification = $unread_notification->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'message' => $item->data['message'],
                        'link' => $item->data['link'],
                        'time' => $this->notificationTime($item->created_at)
                    ];
                });

                return response()->json(
                    [
                        'success' => true,
                        'link' => $link,
                        'unread_notification' => $unread_notification
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => false
                    ]
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    /**
     * Will mark as read all notifications
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminAllNotificationMarkAsRead(Request $request)
    {
        try {
            auth()->user()->unreadNotifications->markAsRead();
            return response()->json(
                [
                    'success' => true
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    /**
     * Get notification sending time
     * 
     */
    public function notificationTime($start_time)
    {
        $end_time = now();

        $time1 = new DateTime($start_time);
        $time2 = new DateTime($end_time);
        $interval = $time1->diff($time2);

        $month = $interval->format('%m');
        if ($month > 0) {
            return  $month == 1 || $month == 0 ? $month . ' ' . 'Month' : $month . ' ' . 'Months ago';
        }
        $day = $interval->format('%d');
        if ($day > 0) {
            return $day == 1 || $day == 0 ? $day . ' ' . 'Day ago' : $day . ' ' . 'Days ago';
        }
        $hour = $interval->format('%h');
        if ($hour > 0) {
            return $hour == 1 || $hour == 0 ? $hour . ' ' . 'Hour ago' : $hour . ' ' . 'Hours ago';
        }
        $min = $interval->format('%i');
        if ($min > 0) {
            return $min == 1 || $min == 0 ? $min . ' Minute ago' : $min . ' Minutes ago';
        }
        $sec = $interval->format('%s');
        if ($sec > 0) {
            return  $sec == 1 || $sec == 0 ? $sec . ' ' . 'Second ago' : $sec . ' ' . 'Seconds ago';
        }
        return null;
    }
}
