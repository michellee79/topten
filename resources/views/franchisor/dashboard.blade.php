@extends('layouts.franchisor_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/franchisor/dashboard.js"></script>

<script src="/scripts/jquery-ui.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

@if ($user->role == 2)
<script type="text/javascript" src="/scripts/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="/js/franchisor/dashboard_editor.js"></script>
@endif

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

    #search_result ul{
        list-style-type: none;
        font-size: 16px;
        color: white;
        cursor: pointer;
        text-decoration: underline;
    }

    #search_result ul li{
        line-height: 30px;
    }
</style>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            
            <div class="titleText" style="padding-top:15px;">
                FRANCHISE DASHBOARD
            </div>

        @if ($user->role == 2)
            <div style="position:absolute; top:35px; right:10px; text-align:right;">                        
                <div id="ContentPlaceHolder1_pnlEditButton">
                    <a id="lbEdit" class="mini-gold" style="cursor: pointer;" onclick="showEditor();">Edit</a>
                </div>
            </div>
            <div id="NewsEditorBox" style="display:none;">
                <textarea id="NewsEditor">
                    {!! $news !!}
                </textarea>
                <div style="margin-top:10px;">
                    <a id="btnCancel" class="mini-red" style="font-weight: bold; cursor: pointer;" onclick="hideEditor();">Cancel</a>
                    <a id="lbSave" class="mini-gold" href="javascript:submitNews()">Save</a>
                </div>
            </div>
        @endif

            <div style="padding-bottom:10px;">
                <div style="float: right;">
                    
                </div>
                <div style="clear:both;"></div>
            </div>

            <div style="color: #999999; padding-top:0px; padding-bottom:100px;">
                
                <div id="pnlUpdate">
                    <div class="dashboard" style="position:relative;">
                        <div class="ctNews" style="width:100%; font-size:1.2em; padding-left:10px; padding-top:20px; padding-bottom:50px;">
                            <p></p>
                            <p class="bodyText justify">
                                {!! $news !!}
                            </p>
                            <p></p>
                        </div>        
                    </div>
                </div>
                <div>
                    <p class="subTitleText">
                        TTP Knowledge Center
                    </p>
                    <div style="position: relative;">
                        <p style="color: #C19B41; float: left; width: 320px;">
                            Search TTP Operations, Manuals, Top Ideas, emails, etc. via keyword search items. Enter keywords or phrase here:
                        </p>
                        <div style="float: left; display: inline;">
                            <input type="text" id="help_search_key">
                            <input type="submit" class="mini-gold" onclick="searchHelp()">
                        </div>
                        <div style="clear: both;"></div>
                        <div id="search_container" style="display: none;">
                            <div style="float:right; cursor: pointer;" onclick="closeSearch();">[Close]</div>
                            <div id="search_result"></div>
                        </div>
                        <br>
                        <div id="help_container" style="display: none; color: #ccc">
                            <div style="float:right; cursor: pointer;" onclick="closeHelp();">[Close]</div>
                            <div id="help_content" style="background-color: #333; color: #ccc; padding: 10px;"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="titleText">
                       My Nominations
                    </p>
                    <div style="text-align: right; padding-bottom: 10px;">
                        <select name="ddlApprovalStatus" onchange="refreshApproval();" id="ddlApprovalStatus" class="FilterSelect">
                            <option 
                            @if ($approval == 3)
                            selected="selected" 
                            @endif
                            value="3">View All</option>
                            <option 
                            @if ($approval == 1)
                            selected="selected" 
                            @endif
                            value="1">Approved</option>
                            <option 
                            @if ($approval == 0)
                            selected="selected" 
                            @endif
                            value="0">Not Approved</option>
                        </select>
                    </div>

                    {!! filter_form($filters, $hasFilter) !!}
                    
                    <div id="nominations">
                        @include('components.franchisor.nominations')
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection