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
            <button  type="button" onclick="remove_bill('investigation', <?php echo $item->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-box-tool pull-right" data-widget="remove"><i class="fa fa-times"></i></button>
            @else
            <button type="button" onclick="undo_remove_bill('investigation', <?php echo $item->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-box-tool" data-widget="undo"><i class="fa fa-refresh"></i></button>
            @endif
        <?php } catch (Exception $ex) { ?>
                <button type="button" onclick="remove_bill('investigation', <?php echo $item->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        <?php } ?>
    </td>
    @endif
</tr>
@endforeach