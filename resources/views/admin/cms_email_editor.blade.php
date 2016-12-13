@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/tinymce/tinymce.min.js"></script>

<script type="text/javascript" src="/js/admin/cms_email_edit.js"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<style type="text/css">
.mce-edit-area{
    overflow-y:scroll !important;
    max-height: 900px !important;
    height: 900px;
}
</style>

<script type="text/javascript">
    eId = {{$email->id}};
</script>

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
                        Edit Email Template (Admin Only)
                    </p>
                    <br>
                    <p>
                        <a id="hlBack" class="content" href="/admin_cms_email">Back</a>
                    </p>
                    <p style="margin-top:20px;">
                    <b>Email Title:</b>&nbsp;<span id="pageTitleRequired" class="error" style="color:Red;font-size:7pt;font-weight:bold;visibility:hidden;">Required!</span><br>
                        <input name="title" type="text" value="{{$email->title}}" id="txtTitle" style="width:892px;" class="requiredInput">
                    </p>
                    <p>
                        <b>Necessary variables:</b>&nbsp;<br>
                        <p>{{$email->variables}}</p>
                    </p>
                    <p></p>
                    <div style="padding-left: 0px;">
                        <b style="line-height: 20px;">Email Content:</b>
                        <textarea name="content" id="content" style="width:900px;">
                            {!! $email->content !!}
                        </textarea>
                        <p></p>
                    </div>
                    <p></p>
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