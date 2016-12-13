@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="/js/admin/contract.js"></script>
<style type="text/css">
.mce-edit-area{
    overflow-y:scroll !important;
    max-height: 600px !important;
    height: 600px;
}
</style>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <iframe id="form_target" name="form_target" style="display:none"></iframe>
            <form id="my_form" action="/upload" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input name="image" id="uploadname" type="file" onchange="upload();">

            </form>
            <form>
                <div style="color:#999999;">
                    <p class="titleText">
                        Manage Contract (Admin Only)
                    </p>
                    <br>
                    <p style="margin-top:20px;">
                        <b>Contract Title:</b>&nbsp;<span id="titleRequired" class="error" style="color:Red;font-size:7pt;font-weight:bold;visibility:hidden;">Required!</span><br>
                        <input name="title" type="text" value="{{$contract->title}}" id="txtTitle" style="width:892px;" class="requiredInput">
                    </p>
                    <p style="margin-top:20px;">
                        <b>Enterprise Name:</b>&nbsp;<span id="enterpriseRequired" class="error" style="color:Red;font-size:7pt;font-weight:bold;visibility:hidden;">Required!</span><br>
                        <input name="enterprise" type="text" value="{{$contract->enterprise}}" id="txtEnterprise" style="width:892px;" class="requiredInput">
                    </p>
                    <p style="margin-top:20px;">
                        <b>Corporation Name:</b>&nbsp;<span id="corporationRequired" class="error" style="color:Red;font-size:7pt;font-weight:bold;visibility:hidden;">Required!</span><br>
                        <input name="corporation" type="text" value="{{$contract->corporation}}" id="txtCorporation" style="width:892px;" class="requiredInput">
                    </p>
                    <p></p>
                    <div style="padding-left: 0px;">
                        <b style="line-height: 20px;">Contract Content:</b>
                        <textarea name="content" id="content" style="width:900px;">
                            {!! $contract->content !!}
                        </textarea>
                        <p></p>
                    </div>
                    <p></p>
                    <p>
                        <b>Status:</b><br>
                        <select name="ddlStatus" id="ddlStatus" style="width:355px;">
                            <option value="0"
                            @if ($contract->isActive == 0)
                            selected="selected"
                            @endif
                            >Disabled</option>
                            <option value="1"
                            @if ($contract->isActive == 1)
                            selected="selected"
                            @endif
                            >Active</option>

                        </select>
                    </p>
                    <div style="padding-left: 0px; padding-bottom: 0px;">
                        <input type="button" name="btnCancel" value="Cancel" id="btnCancel" class="mini-grey" onclick="returnToMenu()">&nbsp;
                        <input type="button" name="btnSave" value="Save" onclick="save()" id="btnSave" class="mini-gold">
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@endsection