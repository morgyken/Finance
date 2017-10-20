<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 10/20/17
 * Time: 3:42 AM
 */
?>
<div class="box-header with-border">
    <p style="font-size: 90%; <?php if (!isset($a4)) { ?> text-align: left<?php } ?>">
        @if(!empty($clinic->address))
            P.O Box {{$clinic->address}}, {{$clinic->town}}.<br/>
            Visit us: {{$clinic->location}}<br>
            {{$clinic->street}}<br>
            Email: {{$clinic->email}}<br>
            Call Us: {{$clinic->mobile}}
            <br/> {{$clinic->telephone?"Or: ".$clinic->telephone:''}}<br>
        @else
            P.O Box {{config('practice.address')}}, {{config('practice.town')}}.<br/>
            Visit us: {{config('practice.building')?config('practice.building').'.':''}}<br>
            {{config('practice.street')?config('practice.street').'.':''}}<br>
            Email: {{config('practice.email')}}<br>
            {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br>
        @endif
    </p>
</div>
