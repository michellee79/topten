@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script type="text/javascript" src="/js/admin/import_user.js"></script>
<style type="text/css">
    .pagingContainer ul{
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .pagingContainer li{
        display: inline;
        margin-left: 5px;
        font-size: 12px;
    }

    .pagingContainer li a{
        color: #999;
    }

    .linkBtn{
        color:#999;
    }
    .linkBtn:hover{
        text-decoration: none;
        color: #eee;
    }
</style>


@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div>
                <p class="titleText">
                    Import Users (Admin Only)
                </p>
                <div style="padding-top:10px; padding-bottom:10px; color:#999999; font-size:12pt;">
                    <div>
                        Step 1. Choose the .CSV file to upload<br><br>
                        <input type="file" name="fup" id="fup">
                    </div>
                    <br><br>
                    <div>
                        Step 2. Enter the Promo Code you want this users to be associated with<br><br>
                        <input name="txtPromoCode" type="text" id="txtPromoCode">&nbsp;<span id="rqrdPromo" style="color:#B03535;font-weight:bold;visibility:hidden;">Required!</span>
                    </div>
                    <br><br>
                    <div>
                        Step 3. Click the button below to import users into the Top Ten Percent database<br><br>
                        <a id="lbImportUsers" class="mini-gold" href='javascript:' style="color:Black;" onclick="upload();">Import Users</a>
                    </div>
                    <br><br>
                    <div style="border-bottom:dashed 2px silver;">
                    </div>
                    <br><br>
                    <div>
                                        

                        <br><hr><br>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection