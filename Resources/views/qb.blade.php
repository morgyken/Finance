<script type="text/javascript" src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere.js"></script>
<script type="text/javascript">
    intuit.ipp.anywhere.setup({
        menuProxy: '<?php print(env('QBO_MENU_URL')); ?>',
        grantUrl: '<?php print(env('QBO_OAUTH_URL')); ?>'
    });
</script>

<?php
$qbo_obj = new Ignite\Finance\Http\Controllers\QuickBooksController();
$qbo_connect = $qbo_obj->qboConnect();
?>
@if(!$qbo_connect)
<ipp:connectToIntuit></ipp:connectToIntuit>
@else
<a href="{{url('qbo/disconnect')}}" title="">Disconnect</a>
@endif