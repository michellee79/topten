@extends('layouts.franchisor_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/franchisor/gallery_image.js"></script>

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


@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div style="color: #999999; padding-top:0px; padding-bottom:100px;">
            <p>&nbsp;</p>
                <div id="pnlUpdate">
                    <div class="titleText">
                        Manage Image Gallery (Admin Only)
                    </div>
                    <div style="text-align: right; padding-bottom: 10px;">
                            <div style="float:left; text-align:right; width:790px;">
                                <select name="ddlFilterByCategory" id="ddlFilterByCategory" onchange="setCategory()">
                                    <option value=""
                                    @if ($selcat == '')
                                    selected="selected" 
                                    @endif
                                    >View All</option>
                                    @foreach($groups as $group)
                                    <option value="{{$group->ctGroup}}"
                                    @if ($selcat == $group->ctGroup)
                                    selected="selected"
                                    @endif
                                    >{{ $group->ctGroup }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="float:right; padding-top:5px;">
                            <a id="AddNewImage" class="btn btn-warning" style="font-weight: bold; cursor: pointer;" onclick="showFields();">
                                Add New Image
                            </a>
                        </div>  
                        <div class="clear"></div>                      
                    </div>
                    <div>
                        <div id="images">
                            @include('components.franchisor.images')
                        </div>
                    </div>
                </div>

                <div id="AddImageBox" style="display:none;">
                    <div class="titleText">
                        Add Image (Admin Only)
                    </div>
                    <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999;">
                        <tbody><tr>
                            <td style="width: 150px;">
                                Category:&nbsp;<span id="rqrdAssignedTo" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                            <td style="padding-top:10px;">
                                <select name="ddlImageCategory" id="ddlImageCategory">
                                    <option value="">Select a Category</option>
                                    @foreach($groups as $group)
                                    <option value="{{$group->ctGroup}}">{{ $group->ctGroup }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Image:&nbsp;                                
                            </td>
                            <td style="padding-top:10px;">
                                <div id="fpBusinessImage" class="RadUpload RadUpload_Default">
                                    <input type="file" id="image" accept="image/*" />
                                </div>
                            </td>                            
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td style="padding-top:10px;">
                                <a id="btnCancel" onclick="showGrid();" class="btn btn-danger" style="font-weight: bold; cursor: pointer;">Cancel</a>                                                    
                                &nbsp;&nbsp;
                                <a onclick="upload()" id="btnAddImage" class="btn btn-warning" style="font-weight:bold;">Upload Image</a>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>

            </div>
            
        </div>
    </div>
</div>

@endsection