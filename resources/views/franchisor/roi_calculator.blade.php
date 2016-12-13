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

        <div id="CalcBox">
            <h1 class="center">Top Ten Percent ROI Calculator</h1>
            <div style="width:840px; margin-left:40px;">
                <table style="width:840px; text-align:center">
                    <tr>
                        <td style="width:375px" class="titleText">By Customers</td>
                        <td style="width:50px;">&nbsp;</td>
                        <td style="width:375px" class="titleText">By Revenue</td>
                    </tr>
                    <tr>
                        <td class="inputBox">
                            <div style="position:relative;">
                                <div style="margin-top:10px; position:relative;">
                                    <label for="txtCustomerNum">How many customers come in per month?</label>
                                    <input type="text" id="txtCustomerNum" placeholder="Total Average Customers" class="parameter1"/>
                                </div>
                                <div style="position:relative;">
                                    <label for="txtCustomerBackNum">How many times do they come back in a month?</label>
                                    <input type="text" id="txtCustomerBackNum" placeholder="Average Number of Visits" class="parameter1"/>
                                </div>
                                <div style="position:relative;">
                                    <label for="txtCustomerSpend">How much does the average customer spend?</label>
                                    <input type="text" id="txtCustomerSpend" placeholder="Average Ticket" class="parameter1"/>
                                    <span style="position:absolute; left:96px; top:26px; font-size:18px;">$</span>
                                </div>
                                <div style="position:relative;">
                                    <label for="txtGrossProfitMargin">What is your gross profit margin?</label>
                                    <input type="text" id="txtGrossProfitMargin" placeholder="Profit Margin" class="parameter1"/>
                                    <span style="position:absolute; right:96px; top:26px; font-size:18px;">%</span>
                                </div>
                                <div style="position:relative;">
                                    <label for="cbIndustry1">Please select a similar industry?</label>
                                    <select ID="cbIndustry1" class="parameter1">
                                        <option Value="">Select Similar Industry</option>
                                        @foreach ($industries as $industry)
                                        <option Value="{{$industry->percentage}}">{{$industry->industry}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="margin-bottom:10px; position:relative;">
                                    <label for="txtMonthFee1">What is your TTP Monthly Fee?</label>
                                    <input type="text" id="txtMonthFee1" placeholder="TTP Fee" class="parameter1"/>
                                    <span style="position:absolute; left:96px; top:26px; font-size:18px;">$</span>
                                </div>
                            </div>
                        </td>
                        <td class="titleText">
                            OR
                        </td>
                        <td class="inputBox">
                                <div style="margin-top:20px; position:relative;">
                                    <label for="txtEstGrossMargin">What is your estimated gross profit margin?</label>
                                    <input type="text" id="txtExtGrossMargin" placeholder="Gross Profit Margin" />
                                    <span style="position:absolute; right:96px; top:26px; font-size:18px;">%</span>
                                </div>
                                <div style="position:relative; margin-top:30px;">
                                    <label for="txtMonthlyGrossRevenue">What is your average monthly gross revenues?</label>
                                    <input type="text" id="txtMonthlyGrossRevenue" placeholder="Monthly Revenues" />
                                </div>
                                <div style="position:relative; margin-top:30px;">
                                    <label for="txtMonthFee2">What is your TTP Monthly Fee?</label>
                                    <input type="text" id="txtMonthFee2" placeholder="TTP Fee" />
                                    <span style="position:absolute; left:96px; top:26px; font-size:18px;">$</span>
                                </div>
                                <div style="margin-bottom:20px; margin-top:30px; position:relative;">
                                    <label for="cbIndustry2">Please select a similar industry?</label>
                                    <select runat="server" ID="cbIndustry2">
                                        <option Value="">Select Similar Industry</option>
                                        @foreach ($industries as $industry)
                                        <option Value="{{$industry->percentage}}">{{$industry->industry}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <input type="button" value="Calculate ROI" id="btnCalculate1" class="btnCalc" onclick="calc1()" />
                            </div>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <div>
                                <input type="button" value="Calculate ROI" id="btnCalculate2" class="btnCalc" onclick="calc2()"/>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="ResultBox" style="display:none;">
            <h1 class="center" style="margin-top:15px;">Top Ten Percent Estimated ROI</h1>
            <div style="text-align:right; padding-right:20px;">
                <input type="button" value="Back" class="mini-gold" onclick="goToCalcBox(false)" />
            </div>
            <div style="width:100%;">
                <table width="600px;" style="margin:20px auto;">
                    <tr class="resultRow">
                        <td class="labelCell">Additional Monthly Sales:</td>
                        <td class="valueCell">
                            <div id="additionalMonthlySales">$375.48</div>
                        </td>
                    </tr>
                    <tr class="resultRow">
                        <td class="labelCell">Minus TTP Monothly Fee</td>
                        <td class="valueCell">
                            <div id="minusTTPMonthlyFee">$375.48</div>
                        </td>
                    </tr>
                    <tr class="resultRow">
                        <td class="labelCell">Additional Profit Per Month:</td>
                        <td class="valueCell">
                            <div id="additionalProfitPerMonth">$375.48</div>
                        </td>
                    </tr>
                    <tr class="resultRow">
                        <td class="labelCell">Additional Profit Per Year</td>
                        <td class="valueCell">
                            <div id="additionalProfitPerYear">$375.48</div>
                        </td>
                    </tr>
                </table>
                <div class="center">
                    <div style="color:#b18237; font-weight:bold">
                        <span style="font-size:18px; margin:2px; line-height:26px;">Your Return On Investment*</span><br />
                        <span style="font-size:16px;">(Even after TTP Fees Have Been Removed.)</span>
                    </div>
                    <br />
                    <div>
                        <div class="resultValue" id="resultValue">
                            152% ROI
                        </div>
                    </div>
                    <div style="margin-top:20px;">
                        <a class="navHint" href="/franchise_roi_calculator_help" target="_blank">(To see how the calculations were made click here)</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="ErrorBox" style="display:none;">
            <h1 class="center" style="margin-top:15px;">Top Ten Percent Estimate ROI</h1>
            <div style="text-align:right; padding-right:20px;">
                <input type="button" value="Back" class="mini-gold" onclick="goToCalcBox(true)" />
            </div>
            <div style="margin:100px 40px;">
                <h2>We&#39;re sorry, something went wrong with this calculation. Please click 'Back' and re-check your figures for inaccurancies.</h2>
            </div>
        </div>

    </div>
</div>

@endsection