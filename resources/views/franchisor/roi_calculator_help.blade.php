@extends('layouts.franchisor_master')

@section('head')

<script src="/Scripts/toastMessage/jquery.toastmessage.js" type="text/javascript"></script>
<link href="/Scripts/toastMessage/css/jquery.toastmessage.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .pgContainer{
        padding-bottom:0 !important;
    }
</style>

<script type="text/javascript" src="/js/franchisor/roi.js"></script>
<link rel="stylesheet" type="text/css" href="/css/roi.css" />

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div id="HelpBox">
            <h2 class="center">TTP Mathematical Equations & Assumptions Used</h2>
            <div style="text-align:right; padding-right:20px;">
                    <input type="button" value="Close" class="mini-gold" onclick="window.close()" />
                </div>
            <div style="text-align:center;color:#a0a0a0;margin-top:40px;">
                <h3 style="color:#a0a0a0;">By Customers</h3>
                <p style="font-size:18px; margin:20px 60px;">
                    (Customers * Visits * Average Ticket * Gross Profit Margin * TTP Industry AVg*)<br /> - TTP Fee = <u>Additional Profit Per Month</u>
                </p>
                <h3 style="color:#a0a0a0; margin-top:35px;">By Revenues</h3>
                <p style="font-size:18px; margin:20px 60px;">
                    (Average Monthly Revenues * Gross Profit Margin * TTP Industry Avg*)<br /> - TTP Fee = <u>Additional Profit Per Month</u>
                </p>
            </div>
            <p style="color:#a0a0a0; padding:50px 70px; font-style:italic; font-size:14px;">
                *The TTP Industry Avg. was estimated by using the average increase in revenues that VIP Business Members have seen who have been utilizing the TTP mobile marketing program. These estimates are broken down specific to industry type as certain industries will see a larger increase than others. The increase ranges from a low of 2% to a high of 8% specific to industry. Since not all business owners track the number of coupons redeemed, the TTP industry Avg. calculation uses an assumption that approximately 33% of coupons downloaded by Consumer Members are actually redeemed. TTP does track the number of coupons downloaded by Consumer Members. While The TTP Industry Avg. calculation has been based upon actual tracked results of downloaded coupons, it should be considered an estimate only. Your individual results may differ.
            </p>
        </div>

    </div>
</div>

@endsection