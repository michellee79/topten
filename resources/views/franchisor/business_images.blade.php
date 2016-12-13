@extends('layouts.franchisor_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script src="/js/franchisor/business_image.js" type="text/javascript"></script>

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

    .filter{
        padding-right: 10px;    
    }
    .fields
    {
        display: none;
    }
    .noMargin
    {
        margin: 0px;
    }
    .noPadding
    {
        padding: 0px;
    }
    
    .smallPadding
    {
        padding: 2px;
    }

</style>

<script type="text/javascript">
	bId = {{$business->id}};
</script>


@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div class="grid" style="color: #999999; padding-top:0px; padding-bottom:100px;">

	            <div id="pnlUpdate">
	                <div class="titleText">
	                    Image Gallery
	                </div>
	                <div class="fRight">
				        <a id="linkToBusinessProfile" class="mini-gold" href="/franchise_edit_business/{{$business->id}}">Business Profile</a>
				        <a id="linkToBusinessProfile" class="mini-red" href="/franchise_businesses" style="margin-left:10px;">Business List</a>
				    </div>
				    <div class="clear"></div>
	                <div style="margin-top:15px;" id="images">
	                	@include ('components.franchisor.galleryimages')
					</div>
	            </div>

	            <div style="padding-bottom:20px;">
                    <table width="100%" cellpadding="0" cellspacing="0">                                
                        <tbody><tr>
                            <td colspan="2" style="border-bottom:solid 2px silver;">                                             
                            </td>
                        </tr>
                    </tbody></table>
                </div>

                <div class="field">

                    <div id="pnlUpload">

	                    <div class="Upload">
	                        <div style="padding-left:10px;">
	                            <div style="padding-top:5px;">
	                                <div id="fpBusinessImage" class="RadAsyncUpload RadUpload RadUpload_Default">
	                                	<input type="file" id="image" />
									</div>
	                            </div>
	                            <div style="padding-top:30px; font-weight:bold; font-size:12pt; border-top: dashed 2px silver; width:250px;">                                                            
	                                <a id="lbUploadImage" class="mini-gold" href="javascript:upload()">Upload Image</a>
	                            </div>
	                        </div>                            
	                    </div>
                    
					</div>

                </div>

            </div>
        </div>
        	
    </div>
</div>

@endsection