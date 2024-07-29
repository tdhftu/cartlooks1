<?php

use Brian2694\Toastr\Facades\Toastr;


if (!function_exists('toastNotification')) {
    /**
     * Set toast message
     *
     * @param String $type
     * @param String $message
     * @param String $header
     * @return void
     */
    function toastNotification($type, $message, $header = null)
    {
        Toastr::$type(translate($message), $header);
    }
}


if (!function_exists('errorMessage')) {
    /**
     * Redirect to error page
     *
     * @param  mixed $title
     * @param  mixed $message
     * @param  mixed $route
     * @return mixed
     */
    function errorMessage($title, $message, $route)
    {
        return response()->view(
            'core::base.errors.500',
            [
                'title' => $title,
                'message' => $message,
                'route' => $route
            ]
        );
    }
}
