
<!-- pharmacy queue -->
@foreach($visit->dispensing as $disp)
<input type="hidden" name="dispensing{{$disp->id}}" value="{{$disp->id}}">
@foreach($disp->details as $item)
<tr>
    @if($item->status==1|| $item->invoiced)
    <td><input type="checkbox" disabled/></td>
    <td>
        @if($item->status==1)
        <div class="label label-success">Paid</div>
        @elseif($item->invoiced)
        <div class="label label-warning">Invoiced</div>
        @endif

        {{$item->drug->name}} <i class="small">(dispensed drug)</i>
        Ksh {{$item->price*$item->quantity}}
    </td>
    @else
    <td>
        <input type="hidden" name="disp[]" value="{{$item->id}}">
        <input type="hidden" name="dispensing[]" value="{{$disp->id}}">

        <input type="hidden" value="{{$visit->id}}" name="visits{{$item->id}}" />

        <?php try { ?>
            @if($disp->removed_bills->isEmpty)
                <input type="checkbox" value="{{$item->id}}" name="dispense[]" />
            @else
                <input type="checkbox" disabled="" />
            @endif
        <?php } catch (Exception $ex) { ?>
            <input type="checkbox" value="{{$item->id}}" name="dispense[]" />
        <?php } ?>

    </td>
    <td>
        {{$item->drug->name}}
        <i class="small">
            (dispensed drug) - {{$item->price*$item->quantity}}</i>
        <br>
        <small>
            {{$item->discount}}% discount ({{($item->discount/100)*$item->price*$item->quantity}})</small>
        Ksh <span class="topay">{{ceil($item->price*$item->quantity-($item->discount/100)*$item->price*$item->quantity)}}</span>

        <?php try { ?>
            @if($disp->removed_bills->isEmpty)
            <a href="#" onclick="remove_bill('dispensing', <?php echo $disp->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-danger btn-xs pull-right">
                <i class="fa fa-trash"></i>remove</a>
            @else
            <a href="#" onclick="#" class="btn btn-danger btn-xs">
                <i class="fa fa-trash"></i>bill has been removed</a>

            <a href="#" onclick="undo_remove_bill('dispensing', <?php echo $disp->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-primary btn-xs">
                <i class="fa fa-trash"></i>Undo</a>

            @endif
        <?php } catch (Exception $ex) { ?>
            <!-- <a href="#" onclick="remove_bill('dispensing', <?php echo $disp->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-danger btn-xs pull-right">
                <i class="fa fa-trash"></i>remove</a> -->
        <?php } ?>
    </td>
    @endif
</tr>
@endforeach
@endforeach