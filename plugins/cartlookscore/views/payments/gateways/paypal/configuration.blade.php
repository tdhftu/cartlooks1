@php
    $currencies = getAllCurrencies();
    $selecected_currency = \Plugin\CartLooksCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'paypal_currency');
    $default_currency = $selecected_currency == null ? getDefaultCurrency() : $selecected_currency;
@endphp
<div class="border-top2 p-3 payment-method-item-body">
    <div class="configuration">
        <form id="credential-form-{{ $method->id }}">
            <input type="hidden" name="payment_id" value="{{ $method->id }}">
            <div class="form-group mb-20">
                <label class="black bold mb-2">{{ translate('Logo') }}</label>
                <div class="input-option">
                    @include('core::base.includes.media.media_input', [
                        'input' => 'paypal_logo',
                        'data' => \Plugin\CartLooksCore\Repositories\PaymentMethodRepository::configKeyValue(
                            $method->id,
                            'paypal_logo'),
                    ])
                    @if ($errors->has('paypal_logo'))
                        <div class="invalid-input">{{ $errors->first('paypal_logo') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group mb-20">
                <label class="black bold">{{ translate('Currency') }}</label>
                <div class="mb-2">
                    <a href="/admin/ecommerce-settings/add-currency"
                        class="mt-2">({{ translate('Please setup exchange rate for the choosed currency') }})</a>
                </div>
                <div class="input-option">
                    <select name="paypal_currency" class="theme-input-style selectCurrency">
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->code }}" class="text-uppercase"
                                {{ $currency->code == $default_currency ? 'selected' : '' }}>
                                {{ $currency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group mb-20">
                <label class="black bold mb-2">{{ translate('Client ID') }}</label>
                <div class="input-option">
                    <input type="text" class="theme-input-style" name="paypal_client_id" placeholder="*************"
                        value="{{ \Plugin\CartLooksCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'paypal_client_id') }}" />
                </div>
            </div>
            <div class="form-group mb-20">
                <label class="black bold mb-2">{{ translate('Client Secret') }}</label>
                <div class="input-option">
                    <input type="text" class="theme-input-style" name="paypal_client_secret"
                        placeholder="*************"
                        value="{{ \Plugin\CartLooksCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'paypal_client_secret') }}" />
                </div>
            </div>
            <div class="form-group mb-20">
                <div class="d-flex">
                    <label class="black bold">{{ translate('Sandbox mode') }}</label>
                    <label class="switch glow primary medium ml-2">
                        <input type="checkbox" name="sandbox" @if (
                            \Plugin\CartLooksCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'sandbox') ==
                                config('settings.general_status.active')) checked @endif />
                        <span class="control"></span>
                    </label>

                </div>
            </div>
            <div class="form-group mb-20">
                <label class="black bold mb-2">{{ translate('Instruction') }}</label>
                <div class="input-option">
                    <textarea name="paypal_instruction" class="theme-input-style">{{ \Plugin\CartLooksCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'paypal_instruction') }}</textarea>
                </div>
            </div>
            <div>
                <button class="btn long payment-credental-update-btn"
                    data-payment-btn="{{ $method->id }}">{{ translate('Save Changes') }}</button>
            </div>
        </form>
    </div>
    <div class="ml-5 instruction">
        <a href="https://www.paypal.com/" target="_blank">Paypal</a>
        <p>
            Customer can buy product and pay directly using
            Paypal
        </p>
        <p class="semi-bold">
            Configuration instruction for Paypal
        </p>
        <p>To use Paypal, you need:</p>
        <ol>
            <li style="list-style-type: decimal">
                <a href="https://www.paypal.com/us/webapps/mpp/account-selection" target="_blank">
                    Register with Paypal
                </a>
            </li>
            <li style="list-style-type: decimal">
                <p>
                    After registration at Paypal, you will have
                    client id,client Secret
                </p>
            </li>
            <li style="list-style-type: decimal">
                <p>
                    Enter client id,client Secret into the box in left
                    hand
                </p>
            </li>
            <li style="list-style-type: decimal">
                <p>
                    See paypal supported currency list, <a
                        href="https://developer.paypal.com/docs/reports/reference/paypal-supported-currencies">here</a>
                </p>
            </li>
        </ol>
    </div>
</div>
