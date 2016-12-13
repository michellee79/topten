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

<script type="text/javascript" src="/js/admin/nominations.js"></script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            
            <div class="titleText" style="padding-top:15px;">
                Manage Business Nominations (Admin Only)
            </div>

            <div style="padding-bottom:10px;">
                <div style="float: right;"></div>
                <div style="clear:both;"></div>
            </div>

            <div style="color: #999999; padding-top:0px; padding-bottom:100px;">
                
                <div>
                    <div style="text-align: right; padding-bottom: 10px;">
                        <label for="ddlFranchiseCode" style="display:inline;">Franchisee</label>
                        <select name="ddlFranchiseCode" onchange="refreshFranchisee()" id="ddlFranchiseCode" style="font-size:12pt;font-weight:bold;width:400px;">
                            <option value="0" 
                            @if ($fid == 0)
                            selected="selected" 
                            @endif
                            >View Nominations Under All Franchises</option>

                            @foreach ($franchisees as $franchisee)
                            <option value="{{$franchisee->id}}" 
                                @if ($fid == $franchisee->id)
                                selected="selected"
                                @endif
                                >{{$franchisee->code}}
                            </option>

                            @endforeach

                        </select>
                        &nbsp; 
                        <label for="ddlApprovalStatus" style="display:inline">Approval</label>
                        <select name="ddlApprovalStatus" onchange="javascript:refreshApproval();" id="ddlApprovalStatus">
                            <option value="2"
                            @if ($avalue == 2)
                            selected="selected" 
                            @endif
                            >View All</option>
                            <option value="1"
                            @if ($avalue == 1)
                            selected="selected" 
                            @endif
                            >Approved</option>
                            <option value="0"
                            @if ($avalue == 0)
                            selected="selected" 
                            @endif
                            >Not Approved</option>

                        </select>
                    </div>
                    <div id="nominations">
                        @include('components.admin.nominations')
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection