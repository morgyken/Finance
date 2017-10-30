<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 10/20/17
 * Time: 3:37 AM
 */
?>
@if(isset($a4))
    @if(get_logo())
        <img style="width:100; height:auto; float: right" src="{{URL::to(get_logo_image())}}"/>
    @else
        <img style="width:100; height:auto; float: right" src=""/>
    @endif
@else
    <center>
        <?php try{ ?>
        <img style="width:100; height:auto; float: right" src="{{URL::to(get_logo_image())}}"/>
        <?php
        }catch(\Exception $e){
        ?>
        <img style="width:100; height:auto; float: right" src=""/>
        <?php
        }
        ?>
    </center>
@endif
