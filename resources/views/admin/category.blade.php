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

    .item{
        color:white;
        font-weight: 0;
        cursor: pointer;
    }

    .item:hover{
        text-decoration: none;
        color:white;
    }

    .selected{
        color:white;
        font-weight: bold!important;
    }
</style>

<script type="text/javascript" src="/js/admin/category.js"></script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            
            <div class="grid">
                <p class="titleText">
                    Manage Categories</p>
                <div id="grids">
                    <table cellspacing="0" cellpadding="8" rules="all" id="gvPromoCodes" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <th>
                                Group
                            </th>
                            <th>
                                Category
                            </th>
                            <th>
                                Sub Category
                            </th>
                        </tr>
                        <tr align="left" style="color:White;">
                            <td scope="col" valign="top" width="33%" id="group_box">
                                @include('components.admin.category_group')
                            </td>
                            <td scope="col" valign="top" width="33%" id="cat_box">
                                @include('components.admin.category')
                            </td>
                            <td scope="col" valign="top" width="33%" id="subcat_box">
                                @include('components.admin.subcategory')
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>

            <div class="fields" style="display:none;">
                <p class="titleText" style="padding-bottom: 5px;">
                    Add New Group
                </p>
                
                <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999;">
                <tbody>
                    <tr>
                        <td style="width: 100px;">
                            Name:
                        </td>
                        <td>
                            <input name="name" type="text" id="name">&nbsp;<span id="nameRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td style="padding-top:10px;">
                            <input type="button" ="btnCancel" class="btn btn-danger" style="font-weight: bold; cursor: pointer;" onclick="hideFields();" value="Cancel" />
                            &nbsp;&nbsp;
                            <input type="button" name="btnSave" value=" Save " onclick="saveCategory();" id="btnSave" class="btn-warning btn" style="font-weight:bold;" />
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection