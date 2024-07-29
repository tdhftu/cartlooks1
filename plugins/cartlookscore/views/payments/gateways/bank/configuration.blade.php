<div class="border-top2 p-3 payment-method-item-body">
    <div>
        <form id="credential-form-{{ $method->id }}">
            <input type="hidden" name="payment_id" value="{{ $method->id }}">
            <div class="form-group mb-20">
                <label class="black bold mb-2">{{ translate('Logo') }}</label>
                <div class="input-option">
                    @include('core::base.includes.media.media_input', [
                        'input' => 'bank_logo',
                        'data' => \Plugin\CartLooksCore\Repositories\PaymentMethodRepository::configKeyValue(
                            config('cartlookscore.payment_methods.bank'),
                            'bank_logo'),
                    ])
                    @if ($errors->has('bank_logo'))
                        <div class="invalid-input">{{ $errors->first('bank_logo') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group mb-20">
                <label class="black bold mb-2">{{ translate('Instruction') }}</label>
                <div class="input-option">
                    <textarea name="bank_instruction" id="bank_instruction" class="theme-input-style">{{ \Plugin\CartLooksCore\Repositories\PaymentMethodRepository::configKeyValue(config('cartlookscore.payment_methods.bank'), 'bank_instruction') }}</textarea>
                </div>
            </div>
            <div>
                <button class="btn long payment-credental-update-btn"
                    data-payment-btn="{{ $method->id }}">{{ translate('Save Changes') }}</button>
            </div>
        </form>
    </div>
</div>
