@extends('layouts.franchisor_master')

@section('head')

<script src="/scripts/jquery-ui.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script src="/js/franchisor/rating.js" type="text/javascript"></script>

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

    .ActiveStatus:hover{
    	color: #999;
    	text-decoration: none;
    }
    .ActiveStatus{
    	color: #999;
    }

</style>


@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div class="grid" style="color: #999999; padding-top:0px; padding-bottom:100px;">

            <div id="pnlUpdate">
                <div class="titleText">
                    Ratings
                </div>
                <div class="fRight">
			        <a id="linkToBusinessProfile" class="mini-gold" href="/franchise_edit_business/{{$business->id}}">Business Profile</a>
			        <a id="linkToBusinessProfile" class="mini-red" href="/franchise_businesses" style="margin-left:10px;">Business List</a>
			    </div>
			    <div class="clear"></div>
                <div style="margin-top:15px;" id="ratings">
                	@include ('components.franchisor.ratings')
				</div>
            </div>

            </div>

        	<div class="fields" style="display: none;">
                <div style="float:left;">
                <p class="titleText" style="padding-bottom: 10px;">
                    Rating Details</p>
                </div>

                <div>
                    <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999; line-height:2;">
                        <tbody><tr>
                            <td style="width: 150px;">
                                Member Info:
                            </td>
                            <td>
                                <span id="lblMemberName"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Rating:
                            </td>
                            <td>
                                <img id="imgRating" style="height:20px;">
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top; padding-top:5px;">
                                Comment:
                            </td>
                            <td style="line-height:1.2; vertical-align:top; padding-top:10px; padding-bottom:15px;">
                                <textarea id="txtComment" textmode="MultiLine" rows="8" style="display:inline-block;width:500px;"></textarea >
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="padding-top:10px;">
                                <input type="submit" name="btnCancel" value=" Cancel " onclick="hideEdit();" id="btnCancel" class="mini-red" style="font-weight:bold;">
                                &nbsp;&nbsp;
                                <input type="submit" name="btnSave" value=" Save " onclick="submit();" id="btnSave" class="mini-gold" style="font-weight:bold;"> 
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection