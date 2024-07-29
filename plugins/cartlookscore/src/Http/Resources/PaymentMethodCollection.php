<?php

namespace Plugin\CartLooksCore\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Plugin\CartLooksCore\Repositories\PaymentMethodRepository;

class PaymentMethodCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id'          => (int) $data->id,
                    'name'        => $data->name,
                    'logo'     => $this->getLogo($data->id),
                    'instruction'     => $this->getInstruction($data->id),
                ];
            })
        ];
    }
    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }

    public function getLogo($id)
    {
        $logo = NULL;
        if ($id == config('cartlookscore.payment_methods.cod')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'cod_logo');
        }

        if ($id == config('cartlookscore.payment_methods.stripe')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'stripe_logo');
        }

        if ($id == config('cartlookscore.payment_methods.paypal')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'paypal_logo');
        }

        if ($id == config('cartlookscore.payment_methods.paddle')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'paddle_logo');
        }

        if ($id == config('cartlookscore.payment_methods.sslcommerz')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'sslcommerz_logo');
        }

        if ($id == config('cartlookscore.payment_methods.paystack')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'paystack_logo');
        }

        if ($id == config('cartlookscore.payment_methods.razorpay')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'razorpay_logo');
        }

        if ($id == config('cartlookscore.payment_methods.gpay')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'gpay_logo');
        }

        if ($id == config('cartlookscore.payment_methods.mollie')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'mollie_logo');
        }

        if ($id == config('cartlookscore.payment_methods.bank')) {
            $logo = PaymentMethodRepository::configKeyValue($id, 'bank_logo');
        }

        return getFilePath($logo, false);
    }
    public function getInstruction($id)
    {
        $instruction = NULL;
        if ($id == config('cartlookscore.payment_methods.cod')) {
            $instruction = PaymentMethodRepository::configKeyValue($id, 'cod_instruction');
        }

        if ($id == config('cartlookscore.payment_methods.stripe')) {
            $instruction = PaymentMethodRepository::configKeyValue($id, 'stripe_instruction');
        }

        if ($id == config('cartlookscore.payment_methods.paypal')) {
            $instruction = PaymentMethodRepository::configKeyValue($id, 'paypal_instruction');
        }

        if ($id == config('cartlookscore.payment_methods.paddle')) {
            $instruction = PaymentMethodRepository::configKeyValue($id, 'paddle_instruction');
        }

        if ($id == config('cartlookscore.payment_methods.sslcommerz')) {
            $instruction = PaymentMethodRepository::configKeyValue($id, 'sslcommerz_instruction');
        }

        if ($id == config('cartlookscore.payment_methods.paystack')) {
            $instruction = PaymentMethodRepository::configKeyValue($id, 'paystack_instruction');
        }

        if ($id == config('cartlookscore.payment_methods.razorpay')) {
            $instruction = PaymentMethodRepository::configKeyValue($id, 'razorpay_instruction');
        }
        if ($id == config('cartlookscore.payment_methods.mollie')) {
            $instruction = PaymentMethodRepository::configKeyValue($id, 'mollie_instruction');
        }
        if ($id == config('cartlookscore.payment_methods.bank')) {
            $instruction = PaymentMethodRepository::configKeyValue($id, 'bank_instruction');
        }
        return $instruction;
    }
}
