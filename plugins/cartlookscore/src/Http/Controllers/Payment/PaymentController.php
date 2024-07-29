<?php

namespace Plugin\CartLooksCore\Http\Controllers\Payment;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Core\Exceptions\CurrencyException;
use Plugin\CartLooksCore\Models\Orders;
use Plugin\CartLooksCore\Models\Customers;
use Plugin\CartLooksCore\Models\PaymentMethods;
use Plugin\CartLooksCore\Models\OrderHasProducts;
use Plugin\CartLooksCore\Models\PaymentTransaction;
use Plugin\CartLooksCore\Repositories\EcommerceNotification;
use Plugin\CartLooksCore\Repositories\PaymentMethodRepository;
use Plugin\CartLooksCore\Http\Requests\PaymentMethodCredentialRequest;

class PaymentController extends Controller
{
    /**
     * Convert currency
     */
    public function convertCurrency($convert_to_currency, $amount)
    {
        $system_currency = \Plugin\CartLooksCore\Models\Currency::where('id', \Plugin\CartLooksCore\Repositories\SettingsRepository::getEcommerceSetting('default_currency'))
            ->select('code', 'conversion_rate')
            ->first();
        $to_currency = \Plugin\CartLooksCore\Models\Currency::where('code', $convert_to_currency)
            ->select('code', 'conversion_rate', 'number_of_decimal')
            ->first();

        if ($to_currency != null) {
            $decimal_point = $to_currency->number_of_decimal != null ? $to_currency->number_of_decimal : 2;
            $converted_amount = ($amount / $system_currency->conversion_rate) * $to_currency->conversion_rate;
            return round($converted_amount, $decimal_point);
        }
        throw new CurrencyException("Currency error. $convert_to_currency currency is not configured.");
    }
    /**
     * Order payment process
     */
    public function createPayment(Request $request, $payment_method)
    {

        if ($request->has('success') && $request['success'] == 'failed') {
            return view('plugin/cartlookscore::payments.errors.payment_failed')->with(['gateway' => $payment_method]);
        }
        if (session()->has('payment_type') && session()->has('payable_amount')) {

            if ($payment_method == 'stripe') {
                return (new \Plugin\CartLooksCore\Http\Controllers\Payment\StripeController)->index();
            }

            if ($payment_method == 'paypal') {
                return (new \Plugin\CartLooksCore\Http\Controllers\Payment\PaypalController)->index();
            }

            if ($payment_method == 'paddle') {
                return (new \Plugin\CartLooksCore\Http\Controllers\Payment\PaddleController)->index();
            }

            if ($payment_method == 'sslcommerz') {
                return (new \Plugin\CartLooksCore\Http\Controllers\Payment\SSLCommerzController)->index();
            }

            if ($payment_method == 'paystack') {
                return (new \Plugin\CartLooksCore\Http\Controllers\Payment\PaystackController)->index();
            }

            if ($payment_method == 'razorpay') {
                return (new \Plugin\CartLooksCore\Http\Controllers\Payment\RazorpayController)->index();
            }

            if ($payment_method == 'mollie') {
                return (new \Plugin\CartLooksCore\Http\Controllers\Payment\MollieController)->index();
            }

            if ($payment_method == 'gpay') {
                return (new \Plugin\CartLooksCore\Http\Controllers\Payment\GpayController)->index();
            }
            return redirect('/404');
        } else {
            return redirect('/404');
        }
    }
    /**
     * Payment success
     */
    public function payment_success($payment_info = null)
    {
        try {
            DB::beginTransaction();
            $redirect_url = "/";

            //Checkout payment
            if (session()->get('payment_type') == 'checkout') {
                $order_id = session()->get('order_id');
                $order_info = Orders::where('id', $order_id)->first();
                if ($order_info->customer_id != null) {
                    session()->put('customer', $order_info->customer_id);
                }
                if ($order_info->customer_id == null) {
                    $guest_customer = DB::table('tl_com_guest_customer')->where('order_id', session()->get('order_id'))->select('id')->first();
                    if ($guest_customer != null) {
                        session()->put('guest_customer', $guest_customer->id);
                    }
                }
                //Update order information
                if ($order_info != null) {
                    $order_info->payment_status = config('cartlookscore.order_payment_status.paid');
                    $order_info->save();
                    $orders_items = OrderHasProducts::where('order_id', $order_id)->get();
                    foreach ($orders_items as $item) {
                        $item->total_paid = $item->totalPayableAmount();
                        $item->payment_status = config('cartlookscore.order_payment_status.paid');
                        $item->save();
                    }
                }
                //Send Notification
                $message = "Order payment competed by " . session()->get('payment_method');
                EcommerceNotification::sendCustomerOrderPaymentCompletedNotification($order_id, $message);
                //Redirect order success page
                $redirect_url = '/order-success' . '/' . $order_id;
            }
            //Wallet payment
            if (session()->get('payment_type') == 'wallet_recharge') {
                if (isActivePlugin('wallet-cartlooks')) {
                    $waller_transaction = new \Plugin\Wallet\Models\WalletTransaction;
                    $waller_transaction->entry_type = config('cartlookscore.wallet_entry_type.credit');
                    $waller_transaction->recharge_type = config('cartlookscore.wallet_recharge_type.online');
                    $waller_transaction->customer_id = session()->get('customer');
                    $waller_transaction->added_by = null;
                    $waller_transaction->document = null;
                    $waller_transaction->recharge_amount = session()->get('payable_amount');
                    $waller_transaction->status = config('cartlookscore.wallet_transaction_status.accept');
                    $waller_transaction->payment_method_id = session()->get('payment_method_id');
                    $waller_transaction->transaction_id = null;
                    $waller_transaction->save();

                    //Send Notification
                    $customer = Customers::find(session()->get('customer'));
                    $message = "Online wallet recharge completed by " . session()->get('payment_method');
                    if ($customer != null) {
                        $message = $customer->name . " recharged wallet by " . session()->get('payment_method');
                    }

                    \Plugin\Wallet\Repositories\WalletNotification::sendCustomerWalletRechargeNotification($message);
                    //Redirect wallet recharge success page
                    $redirect_url = '/dashboard/wallet?recharge=success';
                }
            }
            //Store payment info
            $payment = new PaymentTransaction;
            $payment->payment_method = session()->get('payment_method');
            $payment->paid_amount = session()->get('payable_amount');
            $payment->payment_for = session()->get('payment_type');
            $payment->payment_info = $payment_info;
            $payment->guest_customer = session()->has('guest_customer') ? session()->get('guest_customer') : null;
            $payment->customer_id = session()->has('customer') ? session()->get('customer') : null;
            $payment->save();
            $this->clear_payment_session();
            DB::commit();
            return redirect($redirect_url);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->payment_failed();
        }
    }
    /**
     * Payment unsuccessful
     */
    public function payment_failed()
    {
        $redirect_url = session()->get('redirect_url') . '?success=failed';
        $this->clear_payment_session();
        return redirect($redirect_url);
    }

    /**
     * Payment cancel
     */
    public function payment_cancel()
    {
        $redirect_url = session()->get('redirect_url');
        $this->clear_payment_session();
        return redirect($redirect_url);
    }

    public function clear_payment_session()
    {
        session()->forget('payment_type');
        session()->forget('customer_type');
        session()->forget('customer');
        session()->forget('guest_customer');
        session()->forget('order_id');
        session()->forget('payable_amount');
        session()->forget('payment_method');
        session()->forget('redirect_url');
        session()->forget('payment_method_id');
    }

    /**
     * Will return payment transaction history
     * 
     * @return mixed
     */
    public function transactionHistory(Request $request)
    {
        $query = PaymentTransaction::query();

        if ($request->has('payment_method') && $request['payment_method'] != null) {
            $query = $query->where('payment_method', $request['payment_method']);
        }

        //Filter by date
        if ($request->has('transaction_date') && $request['transaction_date'] != null) {
            $date_range = explode(' to ', $request['transaction_date']);
            if (sizeof($date_range) > 1) {
                if ($date_range[0] == $date_range[1]) {
                    $query = $query->whereDate('created_at', $date_range[0]);
                } else {
                    $query = $query->whereBetween('created_at', $date_range);
                }
            }
        }
        //Filter by search key
        if ($request->has('search') && $request['search'] != null) {
            $query = $query->whereHas('customer_info', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request['search'] . '%')
                    ->orWhere('email', 'like', '%' . $request['search'] . '%');
            });
        }

        $transactions = $query->orderBy('id', 'DESC')->paginate(10)->withQueryString();

        $payment_methods = PaymentMethods::whereNotIn('id', [config('cartlookscore.payment_methods.cod')])->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'logo' => getFilePath($item->logo, false),
                'id' => $item->id
            ];
        });
        return view('plugin/cartlookscore::payments.transactions.index')->with(
            [
                'transactions' => $transactions,
                'payment_methods' => $payment_methods
            ]
        );
    }
    /**
     * Will return payment methods
     * 
     * @return mixed
     */
    public function paymentMethods()
    {
        $payment_methods = (new PaymentMethodRepository)->paymentMethods();
        return view('plugin/cartlookscore::payments.gateways.gateway_list')->with(
            [
                'payment_methods' => $payment_methods
            ]
        );
    }
    /**
     * Will update payment method status
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function changePaymentMethodStatus(Request $request)
    {
        $res = (new PaymentMethodRepository)->paymentMethodUpdateStatus($request['id']);
        if ($res) {
            toastNotification('success', translate('Payment method updated successfully'));
        } else {
            toastNotification('error', translate('Action failed'));
        }
    }
    /**
     * Will update payment method credential
     * 
     * @param PaymentMethodCredentialRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePaymentMethodCredential(PaymentMethodCredentialRequest $request)
    {
        $res = (new PaymentMethodRepository)->updatePaymentMethodCredential($request);

        if ($res) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
}
