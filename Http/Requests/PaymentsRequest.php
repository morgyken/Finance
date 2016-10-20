<?php

namespace Ignite\Finance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentsRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected $rules;

    public function rules() {
        $this->rules['patient'] = 'required';
        $this->mpesa_rules();
        $this->cash_rules();
        $this->card_rules();
        $this->cheque_rules();
        return $this->rules;
    }

    private function mpesa_rules() {
        if ($this->has('MpesaAmount')) {
            $this->rules['MpesaAmount'] = 'required|numeric';
            $this->rules['MpesaCode'] = 'required';
        }
    }

    private function cash_rules() {
        if ($this->has('CashAmount')) {
            $this->rules['CashAmount'] = 'required|numeric';
        }
    }

    private function card_rules() {
        if ($this->has('CardAmount')) {
            $this->rules['CardAmount'] = 'required|numeric';
            $this->rules['CardType'] = 'required';
            $this->rules['CardNames'] = 'required';
            $this->rules['CardNumber'] = 'digits:16';
            $this->rules['CardExpiry'] = 'required';
        }
    }

    private function cheque_rules() {
        if ($this->has('ChequeAmount')) {
            $this->rules['ChequeName'] = 'required';
            $this->rules['ChequeDate'] = 'required';
            $this->rules['ChequeAmount'] = 'required|numeric';
            $this->rules['ChequeBank'] = 'required';
            $this->rules['ChequeBankBranch'] = 'required';
            $this->rules['ChequeNumber'] = 'required|numeric';
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}
