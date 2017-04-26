<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Credit Bill<</title>
        <link rel="stylesheet" href="style.css" media="all" />

<style>
    body{
        font-weight: bold;
    }
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th{
        border: 1px solid #ddd;
        text-align: left;
        padding: 1px;
        font-size: 90%;
    }

    table tr:nth-child(even){background-color: #f2f2f2}

    table tr:hover {background-color: #ddd;}

    table th{
        padding-top: 1px;
        padding-bottom: 1px;
        background-color: /*#4CAF50*/ #BBBBBB;
        color: black;
        font-size: 90%;
    }
    .left{
        width: 60%;
        float: left;
    }
    .right{
        float: left;
        width: 40%;
    }
    .clear{
        clear: both;
    }
    img{
        width:100%;
        height: auto;
    }
    td{
        font-size: 90%;
    }
    div #footer{
        font-size: 90%;
    }
    th{
        font-size: 90%;
    }
</style>
    </head>
    <body>
        <header class="clearfix">
            <div id="logo">
            </div>
            <h3 class="box-title">{{config('practice.name')}}</h1>
            <br><br>
            
            <div id="project">
            <br>
          
            <table>
    <tbody>
        <tr>
        <td class="col-md-4">
           <div>{{config('practice.building')}}, {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>

        </td>    


        <td class="col-md-4">
           <img style="width:100; height:auto; float: left" src="{{realpath(base_path('/public/reciept.jpg'))}}"/>
        </td>    
        <td class="col-md-4">
        </td>
        </tr>
    </tbody>
</table>


            <h2 class="box-title">INVOICE</h2>
                <div>DATE: {{smart_date($bill->created_at)}}</div>
                <div>Patient: {{$bill->visits->patients->full_name}}</div>
                <div>Invoice No: {{ $bill->id }}</div>
                <div>Insurance Company: {{$bill->company}}</div>
                <div>Scheme: {{$bill->payments}}</div>
            </div>
        </header>
        <main>
            <br><br>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Procedures/Drug</th>
                        <th>Cost (Ksh.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bill->visits->investigations as $item)
                    <tr class="products">
                        <td>{{$loop->iteration}}</td>
                        <td style="text-align: left;">{{$item->procedures->name}}</td>
                        <td>{{$item->price}}</td>
                    </tr>
                    @endforeach
                    @foreach($bill->visits->dispensing as $item)

                    @foreach($item->details as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->drug->name}} <i
                                class="small">(x{{$item->quantity}})</i></td>
                        <td>{{$item->price}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                    <tr>
                        <th style="text-align: right;" colspan="2" class="grand total">TOTAL Amount</th>
                        <th class="grand total">{{ number_format($bill->payment,2) }}</th>
                    </tr>
                </tbody>
            </table>
        </main>
        <footer>
            <!-- This note was created on a computer and is valid without the signature and seal. -->
        </footer>
    </body>
</html>