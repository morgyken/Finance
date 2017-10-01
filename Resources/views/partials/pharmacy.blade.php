<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>
<div id="feedback-box"><p>NOTE: Ensure the corresponding check-boxes are checked to proceed</p></div>
@if(!$drug_prescriptions->isEmpty())
    {!! Form::open(['route'=>'evaluation.pharmacy.dispense']) !!}
    <table class="table">
        <tr>
            <th></th>
            <th>Drug</th>
            <th>Prescription</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        @foreach($drug_prescriptions as $item)
            <?php
            $price = 0;
            $stock = 0;
            $cash_price = 0;
            $credit_price = 0;
            foreach ($item->drugs->prices as $p) {
                if ($p->price > $price) {
                    $price = $p->price;
                }
            }

            if (isset($item->drugs->categories->cash_markup)) {
                $cp = (($item->drugs->categories->cash_markup + 100) * $price) / 100;
            } else {
                $cp = $price;
            }

            if (isset($item->drugs->categories->credit_markup)) {
                $crp = (($item->drugs->categories->credit_markup + 100) * $price) / 100;
            } else {
                $crp = $price;
            }

            $cash_price += $cp;
            $credit_price += $crp;
            ?>
            <tr>
                <td>
                    <input type="hidden" name="presc{{$item->id}}" value="{{$item->id}}">
                    <input type="hidden" name="drug{{$item->id}}" value="{{$item->drugs->id}}">
                <!-- <input type="checkbox" id="check{{$item->id}}" onclick="bill(<?php echo $item->id; ?>)" name="item{{$item->id}}"> -->
                    @if($item->status===1)
                        <input type="checkbox" id="check{{$item->id}}" name="item{{$item->id}}" disabled="">
                    @else
                        <input type="checkbox" id="check{{$item->id}}" name="item{{$item->id}}">
                    @endif
                </td>
                <td>
                    {{$item->drugs->name}}<br>
                    <i>{{ $item->drugs->stocks?$item->drugs->stocks->quantity>0?$item->drugs->stocks->quantity:0:0}} in
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
                    if (preg_match('/Insurance/', $visit->mode)) {
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
                           onkeyup="getTotal(<?php echo $item->id; ?>)" name="discount{{$item->id}}" value="0"/></td>
                <td>
                    <input name="qty{{$item->id}}" id="quantity{{$item->id}}"
                           onkeyup="getTotal(<?php echo $item->id; ?>)" class="qty{{$item->id}}" value="0" size="4"
                           type="text" autocomplete="off"></td>
                <td>
                    <input class="txt" size="10" readonly="" id="total{{$item->id}}" type="text" name="txt"/>
                </td>
                <td>
                    <a href="{{route('evaluation.print.prescription', $visit->id)}}" target="_blank"
                       class="btn btn-primary btn-xs">Print</a>
                <!--<a href="#" onclick="cancelPrescription(<?php echo $item->id; ?>)" class="btn btn-danger btn-xs">Cancel</a> -->
                </td>
            </tr>
        @endforeach
        <tr id="summation">
            <td colspan="6" align="right">
                Sum :
            </td>
            <td>
                <input type="text" id='sum1' name="input"/>
                <input type="hidden" name="visit" value="{{$visit->id}}">
                <!-- Total Bill:<input type="text" value="0" name="total_bill" class="total_bill"> -->
            </td>
            <td>
                <button type="submit" class="btn btn-xs btn-primary">
                    <i class="fa fa-hand-o-right"></i>
                    Dispense
                </button>
            </td>
        </tr>
    </table>

    <script>
        $(document).ready(function () {
            //this calculates values automatically
            calculateSum();
            $(".txt").on("keydown keyup", function () {
                calculateSum();
            });
        });

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
            $("#total" + i).val(total)
            //alert(total);
            calculateSum();
        }

        var prescURL = "{{route('evaluation.pharmacy.prescription.cancel')}}";
    </script>
    {!! Form::close()!!}
@else
    <p>No drugs ordered for this patient</p>
@endif