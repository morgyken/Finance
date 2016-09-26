<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$patients = $data['patients'];
?>
@extends('layouts.app')
@section('content_title','Receive Payments')
@section('content_description','Receive payments from patients')


@section('content')
<div class="box box-info">
    <div class="box-body">
        Patient Name: <strong><input type="text" id="patient" name="patient"/></strong>
        <div class="box">
            <div class="block" id="accordion">
                <div id="accordion">
                    <h3 class="toggler atStart">Cash Payment </h3>
                    <div class="element atStart">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="20%">Amount:</td>
                                <td width="26%">
                                    <input name="CashAmount" type="text" onchange="CalcBal(PayForm)"  /></td>
                                <td width="24%"></td>
                                <td width="30%">


                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp; </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </div>


                    <h3 class="toggler atStart">Cheque Payment </h3>
                    <div class="element atStart">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="20%">Ac Holder Name: </td>
                                <td width="30%"><input name="Ac_Holder_Name" type="text" size=20 maxlength=100/>
                                </td>
                                <td width="20%">Date on Cheque Leaf: </td>
                                <td width="30%"><input name="ChequeDate" type="text"  size=10 maxlength=20/></td>
                            </tr>
                            <tr>
                                <td width="20%">Amount: </td>
                                <td width="30%"><input name="ChequeAmount" type="text" />
                                </td>
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
                </div>

                <h3 class="toggler atStart">Credit Card Payment </h3>
                <div class="element atStart">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="20%">Card Type:</td>
                            <td width="26%"><select name='card_type'>
                                    <option value='VISA' selected>VISA
                                    <option value='MasterCard'>MasterCard
                                </select></td>
                            <td width="24%">Exact Names On Card</td>
                            <td width="30%">
                                <input name="CardNames" type="text" value="" />


                            </td>
                        </tr>
                        <tr>
                            <td>Card No:</td>
                            <td><input type='text' name='card_number' value='' size=20 maxlength=100></td>
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
                                <input type='text' name='expiry_year' value='2016' size=4 maxlength=4>
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

                <h3 class="toggler atStart">MPESA Payment </h3>
                <div class="element atStart">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="20%">Amount:</td>
                            <td width="26%">
                                <input name="MPESAAmount" type="text" size=4  /></td>
                            <td width="24%">Transaction Number:</td>
                            <td width="30%"><input type='text' name='Transaction_Number' value='' size=20 maxlength=100>


                            </td>
                        </tr>
                        <tr>
                            <td>Paid by (Name):</td>
                            <td><input type='text' name='MPESA_Payer' value='' size=20 maxlength=100></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </div>


                <!-- <h3 class="toggler atStart">Discount</h3>
<div class="element atStart">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                         <tr>
                        <td width="20%">Amount: </td>
                        <td width="30%">
<input name="DiscountAmount" type="text" onchange="CalcBal(PayForm)"/>						</td>
                        <td width="20%">Current Balance: </td>
                        <td width="30%">
<input name="CurrentBalance3" type="text" readonly="readonly" value="-57355" /></td>
                         </tr> -->

                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                </table>
            </div></div>
        </fieldset>
        <p align=center><input name='Create_Payment' type='submit' id='Create_Payment' value='Receive Payment' class='button' />
        </p>

    </div>
</div>
@endsection