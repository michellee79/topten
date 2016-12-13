@extends('layouts.businesses_master')

@section('head')

@endsection

@section('content')

<div class="content">
    <div class="mainContentContainer">
        <div class="regMainContainer">
 
            <div style="height:600px; width:900px; margin:0 auto;">
                <p class="widText" style="text-align:center; padding-top:200px;">
                    {{$message}}
                </p>
            </div>

        </div>
    </div>
</div>

<div class="mobile-only">
    <ul>
        <li class="submenu">                
            <div class="menuText mobileTitle">
                Review
            </div>
        </li>
    </ul>

    <div class="mobileContentPane" style="padding-bottom:0px;">
        <div class="mobileContent">
            <table cellspacing="0" cellpadding="0" style="width:100%;border-collapse:collapse;">
            <tbody>
            <tr style="height:100%;">
            <td>
            <table cellspacing="0" cellpadding="0" style="height:100%;width:100%;border-collapse:collapse;">
            <tbody>
            <tr>
            <td style="height:100%;width:100%;">
                <div>
                    <div style="padding-top:10px; padding-bottom:10px;">
                                        
                        <div>
                            <p class="widText" style="text-align:left;">
                                {{$message}}
                            </p>
                        </div>
                        <p style="text-align:center; padding-top:50px;">
                            <a class="btn btn-warning btn-large" href="./" style="font-weight:bold;">Back to Home</a>                                  
                        </p>
                    </div>
                </div>                                                                                                                    
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>

@endsection