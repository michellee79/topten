@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/tinymce/tinymce.min.js"></script>
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
</style>

<script type="text/javascript" src="/js/admin/business_selection.js"></script>


@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div>
                <p class="titleText">
                    Manage Business Selections
                </p>
                <div style="text-align: right; padding-bottom: 20px;">                        
                    <select name="ddlFranchiseCode" onchange="refreshFilter()" id="ddlFranchiseCode" style="font-size:12pt;font-weight:bold;width:400px;">
                        <option value="0" 
                        @if ($fid == 0)
                        selected="selected" 
                        @endif
                        >View Business Selections Under All Franchises</option>
                        @foreach ($franchisees as $franchisee)
                        <option value="{{$franchisee->id}}" 
                        @if ($fid == $franchisee->id)
                        selected="selected"
                        @endif
                        >{{$franchisee->code}}</option>
                        @endforeach

                    </select>
                </div>
                
                <div style="clear:both;"></div>
                <div id="franchisees">
                    @include('components.admin.business_selections')
                </div>

            </div>
        </div>
    </div>
</div>

@endsection