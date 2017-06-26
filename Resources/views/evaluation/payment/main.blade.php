@foreach($visit->investigations as $item)
<tr>
    @if($item->is_paid  || $item->invoiced)
    <td>
        <input type="checkbox" disabled/>
    </td>
    <td>
        @if($item->is_paid)
        <div class="label label-success">Paid</div>
        @elseif($item->invoiced)
        <div class="label label-warning">Invoiced</div>
        @endif
        {{$item->procedures->name}} <i class="small">({{ucwords($item->type)}})</i> -
        Ksh {{$item->amount>0?$item->amount:$item->price}}
    </td>
    @else
    <td>
        <?php try { ?>
            @if($item->removed_bills->isEmpty)
            <input type="checkbox" value="{{$item->id}}" name="item{{$item->id}}" />
            @else
            <input disabled="" type="checkbox" value="{{$item->id}}" name="item{{$item->id}}" />
            @endif
        <?php } catch (Exception $ex) { ?>
            <input type="checkbox" value="{{$item->id}}" name="item{{$item->id}}" />
        <?php } ?>
        <input type="hidden" value="{{$visit->id}}" name="visits{{$item->id}}" />
    <td>
        {{$item->procedures->name}}
        <i class="small">({{ucwords($item->type)}})</i> - Ksh <span class="topay">{{$item->amount>0?$item->amount:$item->price}}</span>
        <?php try { ?>
            @if($item->removed_bills->isEmpty)
            <a href="#" onclick="remove_bill('investigation', <?php echo $item->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-danger btn-xs pull-right">
                <i class="fa fa-trash"></i>remove</a>
            @else
            <a href="#" onclick="#" class="btn btn-danger btn-xs">
                <i class="fa fa-trash"></i>bill has been removed</a>

            <a href="#" onclick="undo_remove_bill('investigation', <?php echo $item->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-primary btn-xs">
                <i class="fa fa-trash"></i>Undo</a>

            @endif
        <?php } catch (Exception $ex) { ?>
            <!--
            <a href="#" onclick="remove_bill('investigation', <?php echo $item->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-danger btn-xs pull-right">
                <i class="fa fa-trash"></i>remove</a>
            -->
        <?php } ?>
    </td>
    @endif
</tr>
@endforeach