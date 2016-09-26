<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<div class="row">
    <input name="patient" type="hidden" value="{{$patient->patient_id}}"/>
    <div class="col-md-12">
        @if($patient->is_insured)
        <h3>Insurance</h3>
        <div class="element atStart">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="20%">Scheme:</td>
                    <td width="26%">
                        {!! Form::select('InsuranceScheme',get_patient_insurance_schemes($patient->patient_id), old('InsuranceScheme'), ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                    </td>
                    <td width="24%">Amount:</td>
                    <td width="30%"><input type="text" name="InsuranceAmount" size="20"/></td>
                </tr>
            </table>
        </div>
        @endif
        <h3 class="toggler atStart">Cash Payment </h3>
        <div class="element atStart">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="20%">Amount:</td>
                    <td width="26%">
                        <input name="CashAmount" type="text" /></td>
                    <td width="24%"></td>
                    <td width="30%">
                    </td>
                </tr>
                <tr>
                    <td>&nbsp; </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;<input type="hidden" name="mode" value="1"/></td>
                </tr>

            </table>
        </div>
        <h3 class="toggler atStart">MPESA Payment </h3>
        <div class="element atStart">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="24%">Transaction Number:</td>
                    <td width="30%"><input type='text' name='MpesaRef' value='' size=20 maxlength=100/>  </td>
                    <td width="20%">Amount:</td>
                    <td width="26%"><input name="MpesaAmount" type="text" size=4  /></td>
                </tr>
            </table>
        </div>
        <h3 class="toggler atStart">Cheque Payment </h3>
        <div class="element atStart">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="20%">Ac Holder Name: </td>
                    <td width="30%"><input name="ChequeName" type="text" size=20 maxlength=100/></td>
                    <td width="20%">Date on Cheque Leaf: </td>
                    <td width="30%"><input name="ChequeDate" type="text"  size=20 class="datepicker"/></td>
                </tr>
                <tr>
                    <td width="20%">Amount: </td>
                    <td width="30%"><input name="ChequeAmount" type="text" /></td>
                    <td width="20%">Cheque Number: </td>
                    <td width="30%"><input name="ChequeNumber" type="text" /></td>
                </tr>

                <tr>
                    <td>Bank</td>
                    <td><input name="Bank" type="text" /></td>
                    <td>Branch:</td>
                    <td><input type='text' name='Branch' value='' size=20 maxlength=100></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
        <h3 class="toggler atStart">Credit Card Payment </h3>
        <div class="element atStart">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="20%">Card Type:</td>
                    <td width="26%">
                        <select name='CardType'>
                            <option value='VISA' selected>VISA
                            <option value='MasterCard'>MasterCard
                        </select>
                    </td>
                    <td width="24%">Exact Names On Card</td>
                    <td width="30%">
                        <input name="CardNames" type="text" value="" />
                    </td>
                </tr>
                <tr>
                    <td>Card No:</td>
                    <td><input type='text' name='CardNumber' value='' size=20 maxlength=100></td>
                    <td>Expiry Date:</td>
                    <td><select name='expiry_month'>
                            <option value='01' selected>01
                            <option value='02'>02
                            <option value='03'>03
                            <option value='04'>04
                            <option value='05'>05
                            <option value='06'>06
                            <option value='07'>07
                            <option value='08'>08
                            <option value='09'>09
                            <option value='10'>10
                            <option value='11'>11
                            <option value='12'>12
                        </select>
                        <input type='text' name='expiry_year' value='2016' size=4 maxlength=4/>
                    </td>
                </tr>
                <tr>
                    <td>Security Digits at back of card: (Can be 3 or 4 Digits)</td>
                    <td><input type='text' name='security_code' value='' size=4 maxlength=4></td>
                    <td>Payment Amount</td>
                    <td><input name="CardAmount" type="text" size=4/></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
        <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button><span id="all" class="pull-right"></span>
    </div>

</div>