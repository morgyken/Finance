<?php
$investigations = $visit->investigations;
$prescriptions = $visit->prescriptions;
?>

<div class="modal modal-default fade" id="info{{$visit->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Bill Information</h4>
            </div>
            <div class="modal-body">
                <table class="table table-condensed">
                    <tbody>
                    @foreach($investigations as $item)
                        <tr>
                            <td>{{$item->procedures->name}}</td>
                            <td>{{ucfirst($item->type)}}</td>
                            <td>{{$item->procedures->insurance_charge??$item->procedures->price}}</td>
                            <td><a href="#" class="btn btn-danger btn-xs">Cancel</a></td>
                        </tr>
                    @endforeach
                    @foreach($prescriptions as $item)
                        <tr>
                            <td>{{$item->drugs->name}}</td>
                            <td>Drug</td>
                            <td>{{$item->drugs->insurance_p??$item->drugs->selling_p}}</td>
                            <td><a href="#" class="btn btn-danger btn-xs">Cancel</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->