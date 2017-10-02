<?php
extract($data);
?>
@extends('layouts.app')
@section('content_title','Pharmacy Payment')
@section('content_description','Pharmacy Payment')

@section('content')
    <div class="box box-info">
        <div class="box-body">
            <h4>Patient: {{$patient->full_name}}</h4>
            <div id="feedback-box"><p>NOTE: Ensure the corresponding check-boxes are checked to proceed</p></div>
            @if(!$drugs->isEmpty())
                {!! Form::open(['route'=>'evaluation.pharmacy.dispense']) !!}
                <table class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Drug</th>
                        <th>Prescription</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($drugs as $item)
                        <?php
                        $price = 0;
                        $stock = 0;

                        $cash_price = $item->drugs->cash_price;
                        $credit_price = $item->drugs->credit_price;
                        $visit = $item->visits;
                        ?>
                        <tr>
                            <td>
                                <input type="hidden" name="presc{{$item->id}}" value="{{$item->id}}">
                                <input type="hidden" name="drug{{$item->id}}" value="{{$item->drugs->id}}">
                                @if($item->status===1)
                                    <input type="checkbox" id="check{{$item->id}}" name="item{{$item->id}}" disabled="">
                                @else
                                    <input type="checkbox" id="check{{$item->id}}" name="item{{$item->id}}">
                                @endif
                            </td>
                            <td>
                                {{$item->drugs->name}}<br>
                                <i>{{ $item->drugs->stocks?$item->drugs->stocks->quantity>0?$item->drugs->stocks->quantity:0:0}}
                                    in
                                    store</i>
                            </td>
                            <td>
                                <dl class="dl-horizontal">
                                    <dt>Dose:</dt>
                                    <dd>{{$item->dose}}</dd>
                                    <dt>Date:</dt>
                                    <dd>{{smart_date_time($item->created_at)}}</dd>
                                    <dt>Prescribed By:</dt>
                                    <dd> {{$item->users->profile->full_name}} </dd>
                                    <!-- <b>Payment Mode: </b> Cash<br> -->
                                </dl>
                            </td>
                            <td>
                                <?php
                                if (preg_match('/Insurance/', $item->visits->mode)) {
                                $price = $credit_price;
                                ?>
                                <code>{{number_format($credit_price,2)}}</code>
                                <?php
                                } else {
                                $price = $cash_price;
                                ?>
                                <code>{{number_format($cash_price,2)}}</code>
                                <?php
                                }
                                ?>
                                <input type="hidden" value="{{$price}}" name="prc{{$item->id}}" id="prc{{$item->id}}">
                            </td>
                            <td><input size="5" class="discount" id="discount{{$item->id}}" type="text"
                                       onkeyup="getTotal(<?php echo $item->id; ?>)" name="discount{{$item->id}}"
                                       value="0"/>
                            </td>
                            <td>
                                <input name="qty{{$item->id}}" id="quantity{{$item->id}}"
                                       onkeyup="getTotal(<?php echo $item->id; ?>)" class="qty{{$item->id}}"
                                       value="{{$item->payment->quantity}}"
                                       size="4"
                                       type="text" autocomplete="off"></td>
                            <td>
                                <input class="txt" size="10" readonly="" id="total{{$item->id}}" type="text"
                                       name="txt"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr id="summation">
                        <td colspan="6" align="right">
                            Sum :
                        </td>
                        <td>
                            <input type="text" id='sum1' name="input"/>
                            <input type="hidden" name="visit" value="{{$item->visits->id}}">
                            <!-- Total Bill:<input type="text" value="0" name="total_bill" class="total_bill"> -->
                        </td>
                        <td>
                            <button type="submit" class="btn btn-xs btn-primary">
                                <i class="fa fa-hand-o-right"></i>
                                Dispense
                            </button>
                        </td>
                    </tr>
                    </tfoot>
                </table>

                <script>
                    $(document).ready(function () {
                        //this calculates values automatically
//                        calculateSum();
                        $(".txt").on("keydown keyup", function () {
                            doMaths();
                        });
                        doMaths();
                    });

                    function doMaths() {
                        var sum = 0;
                        $('tbody').find('tr').each(function () {
                            var price = parseFloat($(this).find("[id^='prc']").val());
                            var quantity = parseFloat($(this).find("[id^='quantity']").val());
                            var discount = parseFloat($(this).find("[id^='discount']").val());
                            var total = (price * quantity) - ((discount / 100) * (price * quantity));
                            $(this).find("[id^='total']").val(total);
                            sum += parseFloat(total);
                        });
                        $("input#sum1").val(sum.toFixed(2));
                    }

                    /*
                                        function calculateSum() {
                                            var sum = 0;
                                            //iterate through each textboxes and add the values
                                            $(".txt").each(function () {
                                                //add only if the value is number
                                                if (!isNaN(this.value) && this.value.length != 0) {
                                                    sum += parseFloat(this.value);
                                                    $(this).css("background-color", "#FEFFB0");
                                                } else if (this.value.length != 0) {
                                                    $(this).val(0);//css("background-color", "red");
                                                }
                                            });

                                            $("input#sum1").val(sum.toFixed(2));
                                        }

                                        function getTotal(i) {
                                            var price = parseFloat($("#prc" + i).val());
                                            var quantity = parseFloat($("#quantity" + i).val());
                                            var discount = parseFloat($("#discount" + i).val());
                                            var total = (price * quantity) - ((discount / 100) * (price * quantity));
                                            $("#total" + i).val(total);
                                            //alert(total);
                                            calculateSum();
                                        }
                    */
                    var prescURL = "{{route('evaluation.pharmacy.prescription.cancel')}}";
                </script>
                {!! Form::close()!!}
            @else
                <p>No drugs ordered for this patient</p>
            @endif
        </div>
    </div>
@endsection