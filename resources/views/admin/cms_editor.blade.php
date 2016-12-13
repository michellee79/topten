@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/tinymce/tinymce.min.js"></script>

<script type="text/javascript" src="/js/admin/cms_edit.js"></script>

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
    pId = {{$page->id}};
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
                        Edit Page (Admin Only)
                    </p>
                    <br>
                    <p>
                        <a id="hlBack" class="content" href="/admin_cms">Back</a>
                    </p>
                    <p style="margin-top:20px;">
                    <b>Page Title:</b>&nbsp;<span id="pageTitleRequired" class="error" style="color:Red;font-size:7pt;font-weight:bold;visibility:hidden;">Required!</span><br>
                        <input name="pageTitle" type="text" value="{{$page->pageName}}" id="txtPageTitle" style="width:892px;" class="requiredInput">
                    </p>
                    <p>
                        <b>Meta Keyword:</b>&nbsp;<span id="metaKeywordRequired" class="error" style="color:Red;font-size:7pt;font-weight:bold;visibility:hidden;">Required!</span><br>
                        <input name="metaKeyword" type="text" value="{{$page->metaKeywords}}" id="txtMetaKeyword" style="width:892px;" class="requiredInput">
                    </p>
                    <p>
                        <b>Meta Descritption:</b>&nbsp;<span id="metaDescritpionRequired" class="error" style="color:Red;font-size:7pt;font-weight:bold;visibility:hidden;">Required!</span><br>
                        <input name="metaDescritpion" type="text" value="{{$page->metaDescription}}" id="txtMetaDescritpion" style="width:892px;" class="requiredInput">
                    </p>
                    <p></p>
                    <div style="padding-left: 0px;">
                        <b style="line-height: 20px;">Page Content:</b>
                        <textarea name="content" id="content" style="width:900px;">
                            {!! $page->pageContent !!}
                        </textarea>
                        <p></p>
                    </div>
                    <p></p>
                    <p>
                        <b>Status:</b><br>
                        <select name="ddlStatus" id="ddlStatus" style="width:355px;">
                            <option value="0"
                            @if ($page->isActive == 0)
                            selected="selected"
                            @endif
                            >Disabled</option>
                            <option value="1"
                            @if ($page->isActive == 1)
                            selected="selected"
                            @endif
                            >Active</option>
                        </select>
                    </p>
                    <div style="padding-left: 0px; padding-bottom: 0px;">
                        <input type="button" name="btnCancel" value="Cancel" id="btnCancel" class="mini-grey" onclick="returnToMenu()">&nbsp;
                        <input type="button" name="btnDelete" value="Delete" onclick="deletePage();" id="btnDelete" class="mini-red">&nbsp;
                        <input type="button" name="btnSave" value="Save" onclick="save()" id="btnSave" class="mini-gold">
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@endsection