@extends('layouts.franchisor_master')

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


@endsection


@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div style="color: #999999; padding-top:0px; padding-bottom:100px;">

                <div id="pnlUpdate">
                    <div class="titleText">
                        Manage Business Selections
                    </div>
                    <div>
                        <table cellspacing="0" cellpadding="8" rules="all" id="gvBusinesses" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
                            <tbody>
                                <tr align="left" style="color:White;cursor:pointer;">
                                    <th scope="col">
                                        <a onclick="setSortColumn('franchise_businessselectionlist', 'id');" id="lbID" style="color:White;cursor:pointer;">
                                        ID
                                        @if ($sort == 'id')
                                        <img src="/Images/up.png">
                                        @elseif ($sort == '-id')
                                        <img src="/Images/down.png">
                                        @endif
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a onclick="setSortColumn('franchise_businessselectionlist', 'businessName');" id="lbBusinessName" style="color:White;cursor:pointer;">
                                        Business Name
                                        @if ($sort == 'businessName')
                                        <img src="/Images/up.png">
                                        @elseif ($sort == '-businessName')
                                        <img src="/Images/down.png">
                                        @endif
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a onclick="setSortColumn('franchise_businessselectionlist', 'consumerNominated');" style="color:White;cursor:pointer;">
                                        Consumer Nominated
                                        @if ($sort == 'consumerNominated')
                                        <img src="/Images/up.png">
                                        @elseif ($sort == '-consumerNominated')
                                        <img src="/Images/down.png">
                                        @endif
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a onclick="setSortColumn('franchise_businessselectionlist', 'businessContract');" id="lbBusinessContact" style="color:White;cursor:pointer;">
                                        Contact
                                        @if ($sort == 'businessContract')
                                        <img src="/Images/up.png">
                                        @elseif ($sort == '-businessContract')
                                        <img src="/Images/down.png">
                                        @endif
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a onclick="setSortColumn('franchise_businessselectionlist', 'passed');" id="lbPassed" style="color:White;cursor:pointer;">
                                        Passed
                                        @if ($sort == 'passed')
                                        <img src="/Images/up.png">
                                        @elseif ($sort == '-passed')
                                        <img src="/Images/down.png">
                                        @endif
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a onclick="setSortColumn('franchise_businessselectionlist', 'dateSubmitted');" id="lbDateSubmitted" style="color:White;cursor:pointer;">
                                        Submitted Date
                                        @if ($sort == 'dateSubmitted')
                                        <img src="/Images/up.png">
                                        @elseif ($sort == '-dateSubmitted')
                                        <img src="/Images/down.png">
                                        @endif
                                        </a>
                                    </th>
                                    <th scope="col">&nbsp;</th>
                                </tr>

                                @foreach($businessSelections as $businessSelection)
                                <tr>
                                    <td>
                                        <span id="lblID">{{ $businessSelection->id }}</span>
                                    </td>
                                    <td>
                                        <span id="lblBusinessName">{{ $businessSelection->businessName }}</span>
                                    </td>
                                    <td>
                                        <span id="lblConsumerNominated">{{ $businessSelection->consumerNominated }}</span>
                                    </td>
                                    <td>
                                        <span id="lblBusinessContact">{{ $businessSelection->businessContact }}</span>
                                    </td>
                                    <td>
                                        <span id="lblPassed">
                                        @if($businessSelection->passed)
                                        True
                                        @else
                                        False
                                        @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span id="lblDateSubmitted">{{ convertDate($businessSelection->dateSubmitted) }}</span>
                                    </td>
                                    <td align="center">
                                        <a id="linkToViewDetail" href="/business-criteria/{{$businessSelection->id}}" target="_blank" style="color:White;cursor:pointer;">
                                            View
                                        </a>                                    
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>

@endsection