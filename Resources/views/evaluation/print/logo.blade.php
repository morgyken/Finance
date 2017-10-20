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
        <img style="width:100; height:auto; float: right" src="{{realpath(base_path(get_logo()))}}"/>
    @else
        <img style="width:100; height:auto; float: right" src=""/>
    @endif
@else
    <center>
        <?php try{ ?>
        <img style="width:100; height:auto; float: right" src="{{realpath(base_path(get_logo()))}}"/>
        <?php
        }catch(\Exception $e){
        ?>
        <img style="width:100; height:auto; float: right" src=""/>
        <?php
        }
        ?>
    </center>
@endif
