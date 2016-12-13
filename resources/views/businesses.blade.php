@extends('layouts.businesses_master')

@section('head')

	<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

    <script type="text/javascript">
                
        function showLoading() {
            $('.pgContainer').showLoading();                        
        }

        function hideLoading() {
            $('.pgContainer').hideLoading();            
        }
    
    </script>

    <style type="text/css">
        .validation
        {
            color: #B03535;
            font-size: 10px;
        }
        .stepTxtOn
        {
            color: #B28211;
            font-size: 15px;
            position: relative;
            top: 40px;
            left: 10px;
            float: left;
            border-bottom: 2px solid #B28211;
            width: 190px;
        }
        .stackValidation
        {
            color: #B03535;
            font-size: 10px;
            position: relative;
            top: 5px;
            right: 500px;
            float: right;
        }
        .watermark
        {            
            color: #999 !important;                     
        }
        .content .moveTop{
            position:absolute;
            bottom:20px;
            right:-40px;
            display:none;
        }

        .mobileContent .moveTop{
            position:fixed;
            bottom:60px;
            right:20px;
            display:none;
        }
    </style>
    <script type="text/javascript" src="/js/business.js"></script>
    <script type="text/javascript" src="/js/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo env('GOOGLE_MAP_API_KEY') ?>">
    </script>

    <script type="text/javascript">
        var businessesJson = "<?php echo $businessesJson ?>";
        var businesses = JSON.parse(businessesJson);
        var zip = '{{$location}}';
    </script>

@endsection

@section('content')
<div class="content">
@include('common.sidetab')
    <div class="mainContentContainer">
        <div class="pgMainContainer">
            <div class="pgContainer">
                <div class="ipad-only" style="text-align: right; padding-right: 25px; padding-bottom: 25px;">
                    <div>
                        <a class="mini-gold" href="/page/Consumer%20Sign%20Up%20Options">
                        Sign Up
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="mini-gold" href="http://www.toptenpercentfranchise.com" target="_blank">
                        Franchise
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="mini-gold" href="/page/FAQ">
                            FAQ
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="mini-gold" href="/page/About%20Us">
                            About Us
                        </a>
                    </div>
                </div>

                <div style="width:975px; text-align:right; padding-bottom:20px;">
                    <select name="ddlGroupCategory" id="ddlGroupCategory" style="width:190px;">
                        <option selected="selected" value="">Filter by Main Category</option>
                        @foreach($groups as $group)
                        <option value="{{$group->ctGroup}}">{{$group->ctGroup}}</option>
                        @endforeach
                    </select>&nbsp;

                    <select name="ddlCategory" id="ddlCategory" disabled="disabled" style="width:195px;">

                    </select>&nbsp;

                    <select name="ddlSubCategory" id="ddlSubCategory" disabled="disabled" style="width:165px;">

                    </select>
                    <select name="ddlRadius" id="ddlRadius" style="width:80px;">
                        <option 
                        @if ($radius == 'national')
                        selected="selected" 
                        @endif
                        value="national">national radius</option>
                        <option value="50"
                        @if ($radius == 50)
                        selected = "selected"
                        @endif
                        >50 mile radius</option>
                        <option value="40">40 mile radius</option>
                        <option value="30">30 mile radius</option>
                        <option value="20">20 mile radius</option>
                        <option value="10">10 mile radius</option>
                        <option value="5">&nbsp;&nbsp;5 mile radius</option>

                    </select>
                    <div style="display:inline; ">
                        <input type="text" id="search" placeholder="Search By Business Name" style="width:170px;">
                        <a href="javascript:search('')" style="position:relative; left:-10px; top:-5px; cursor:pointer;">
                            <img src="/Images/find.png" width="25px;">
                        </a>
                    </div>
                    <input type="button" style="width:100px;" value="Show on Map" onclick="toggleMap();" id="toggleMap" 
                    @if ($location==NULL)
                    disabled="disabled" 
                    @endif
                    class="mini-gold" />
                </div>

                <div id="businesses">
                    <div style="position:fixed; width:1000px; height:0px; margin:0 auto; bottom:0;">
                        <div class="moveTop">
                            <a href="#body">
                                <img src="/Images/moveUp.png" width="50px">
                            </a>
                        </div>
                    </div>
                    @include('components.businesses')
                </div>

                <div id="map" style="height:600px; display:none;"></div>
                
            </div>
        </div>
    </div>
</div>

<div class="mobile-only">
    <ul>
        <li class="submenu">
            
            <div class="mobileFilter subSubMenu" style="display:block; padding-top:10px; padding-bottom:10px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td style="width:230px;">
                            <select name="ddlGroupCategoryMobile" id="ddlGroupCategoryMobile" style="width:95%;">
                                <option selected="selected" value="">Filter by Main Category</option>
                                @foreach($groups as $group)
                                    <option value="{{$group->ctGroup}}">{{$group->ctGroup}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="ddlCategoryMobile" id="ddlCategoryMobile" disabled="disabled" style="width:95%;">
                            </select>        
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="ddlSubCategoryMobile" id="ddlSubCategoryMobile" disabled="disabled" style="width:95%;">
                            </select>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="ddlRadiusMobile" id="ddlRadiusMobile" style="width:95%;">
                                <option selected="selected" value="national">national radius</option>
                                <option value="50">50 mile radius</option>
                                <option value="40">40 mile radius</option>
                                <option value="30">30 mile radius</option>
                                <option value="20">20 mile radius</option>
                                <option value="10">10 mile radius</option>
                                <option value="5">&nbsp;&nbsp;5 mile radius</option>
                            </select>
                        </td>
                        <td>
                        </td>
                    </tr>
                </tbody></table>
                <div class="filter" style="display:none; padding-bottom:8px;">
                    Filtering...&nbsp;<img src="/Images/ttpLoading.gif">
                </div>
            </div>
        </li>
        <li class="submenu">
            <a href="javascript:toggleMapMobile()" id="toggleMapMobile" style="float:right; margin:20px;" class="mini-gold">See On Map</a>
        </li>
    </ul>

    <div class="mobileContentPane" style="padding-bottom:50px;">
        <div class="mobileContent">
            <div id="businessesMobile">
                <div class="moveTop">
                    <a href="#body">
                        <img src="/Images/moveUp.png" width="50px">
                    </a>
                </div>
                @include('components.businesses_mobile')
            </div>

            <div id="mapMobile" style="display:none; height: 300px;"></div>
        </div>
    </div>
    @include('common.footer_mobile_widget')
</div>
@endsection