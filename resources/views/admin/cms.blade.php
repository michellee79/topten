@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<style type="text/css">
    .verticalStitchDivider {
        background: url('../Images/img_vertStitching.png') no-repeat;
        width: 1px;
        height: 330px;
        float: left;
        margin: 0px 0 0 0;
    }

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

</style>

<script type="text/javascript" src="/js/admin/cms.js"></script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <p class="titleText">
                CMS (Admin Only)
            </p>
            <br>
            <p style="color: #999999;">
                Edit Existing Page:<br>
                <br>
                <select name="ddlEditPage" onchange="javascript:navigateToEditor()" id="ddlEditPage" style="width:400px;">
                    <option selected="selected" value="0">Select a Page</option>
                    @foreach($pages as $page)
                    <option value="{{$page->id}}">{{$page->pageName}}</option>
                    @endforeach
                </select>
            </p>
        </div>
    </div>
</div>

@endsection