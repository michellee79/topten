@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<style type="text/css">
    .verticalStitchDivider {
        background: url('/Images/img_vertStitching.png') no-repeat;
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

    .Promo{
        color: white;
    }

    .Promo:hover{
        color:white;
    }

    .promoEditor{
        box-sizing: border-box;
        -webkit-box-sizing:border-box;
        -moz-box-sizing: border-box;
        background: #111;
        border-color: #111;
        color: white;
        margin: 0;
    }

</style>

<script type="text/javascript" src="/js/admin/industry.js"></script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            
            <div class="grid">
                <p class="titleText">
                    Manage Industries</p>
                <div style="text-align: right; padding-bottom: 10px;">
                    <a id="AddNewPromo" class="btn btn-warning" style="font-weight: bold; cursor: pointer;" onclick="showFields();">
                        Add New Industry
                    </a>
                    <br><br>
                </div>
                <div id="industries">
                    <table cellspacing="0" cellpadding="8" rules="all" id="gvPromoCodes" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
                    <tbody>
                        <tr align="left" style="color:White;">
                            <th scope="col">
                                <a onclick="showLoading();" href="javascript:" style="color:White;">Industry Name</a>
                            </th>
                            <th scope="col">
                                <a onclick="showLoading();" href="javascript:" style="color:White;">Percentage</a>
                            </th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                        @foreach ($industries as $industry)
                        <tr>
                            <td>
                                <span id="lblIndustry">{{$industry->industry}}</span>
                            </td>
                            <td align="center" style="width:80px;">
                                <span id="lblPercentage">{{$industry->percentage}}</span>
                            </td>
                            <td style="width:120px;" align="center">
                                <a class="mini-grey"  onclick="showEdit({{$industry->id}});" href="javascript:" style="color:White;">Edit</a> &nbsp;
                                <a class="mini-red" onclick="deleteIndustry({{$industry->id}});" href="javascript:" style="color:White;">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>

            <div class="fields" style="display:none;">
                <p class="titleText" style="padding-bottom: 5px;">
                    <span id="AddOrEdit">Add New</span> Industry</p>
                
                <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999;">
                <tbody>
                    <tr>
                        <td style="width: 100px;">
                            Industry Name:
                        </td>
                        <td>
                            <input name="indsutry" type="text" id="industry">&nbsp;<span id="industryRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Percentage:
                        </td>
                        <td>
                            <input name="percentage" type="text" id="percentage">&nbsp;<span id="percentageRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td style="padding-top:10px;">
                            <input type="button" ="btnCancel" class="btn btn-danger" style="font-weight: bold; cursor: pointer;" onclick="hideFields();" value="Cancel" />
                            &nbsp;&nbsp;
                            <input type="button" name="btnSave" value=" Save " onclick="saveIndustry();" id="btnSave" class="btn-warning btn" style="font-weight:bold;" />
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection