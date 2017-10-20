<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 10/20/17
 * Time: 3:51 AM
 */
?>


<div class="col-md-12">
    @if(!$payment->deposit)
        <h1>RECEIPT</h1>
    @else
        <h1>Deposit Slip</h1>
    @endif
    <strong>Name:</strong>
    <span class="content">
        {{$payment->patients?$payment->patients->full_name:'Walkin Patient'}}
    </span>
    <br/>
    <strong>No:</strong>
    <span class="content">
        {{$payment->patients?m_setting('reception.patient_id_abr').$payment->patients->id:'Walkin Patient'}}
    </span>
    <br/>
    <strong>Date:</strong>
    <span class="content">
        {{(new Date($payment->created_at))->format('j/m/Y H:i')}}
    </span>
    <br/>
    <br/>
    <strong><?php echo $payment->deposit?'Slip No: ':'Receipt No: '; ?></strong><span>{{$payment->receipt}}</span><br/><br/>
</div>
