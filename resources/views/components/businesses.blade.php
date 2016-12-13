<div style="padding-left:25px; background-color:#000000;">

@foreach ($businesses as $business)

    <div style="width:950px; background-color:#000000;" id="business_box_{{ $business->id }}">
        <div style="background:url('Images/bgBusinessTop.png') no-repeat; height:45px;">
            <div style="padding-left:10px; padding-top:10px;">
                <a title="View company profile info" class="companyTitle" href="/business/{{ $business->id }}" style="font-weight:bold;text-decoration:none;">
                    <span class="companyTitle" style="font-size:12pt;font-weight:bold;text-decoration:none;">
                        {{ $business->name }}
                    </span>
                </a>
            </div>
        </div>
        <table width="950px;" cellpadding="0" cellspacing="0" style="color:#999999;">
            <tbody><tr>
                <td style="vertical-align:top; width:210px; padding:10px; padding-top:15px; padding-bottom:15px; height:175px;">
                    <a title="View company profile info" href="/business/{{ $business->id }}">
                        <img src="{{ $business->logo->url }}" style="width:180px;">
                    </a>
                </td>
                <td style="vertical-align:top; padding:30px; padding-top:10px; padding-bottom:0px; width:500px;">
                    <div style="line-height:1.5; width:470px;">
                        <span style="font-size:1.1em;font-weight:bold;">
                        {{shortSummary($business->summary)}}
                        </span>
                    </div>           
                    <div style="padding-top:5px; width:470px;">
                        <a title="View Ratings" href="/businessratings/{{ $business->id }}">
                        @if ($business->averageRating === NULL)
                            <img src="/Images/Rating_None.png" alt="Business Ratings" style="height:25px;">
                        @elseif ($business->averageRating >= 4.5)
                            <img src="/Images/Rating_5_of_5.png" alt="Business Ratings" style="height:25px;">
                        @elseif ($business->averageRating >= 3.5)
                            <img src="/Images/Rating_4_of_5.png" alt="Business Ratings" style="height:25px;">
                        @elseif ($business->averageRating >= 2.5)
                            <img src="/Images/Rating_3_of_5.png" alt="Business Ratings" style="height:25px;">
                        @elseif ($business->averageRating >= 1.5)
                            <img src="/Images/Rating_2_of_5.png" alt="Business Ratings" style="height:25px;">
                        @elseif ($business->averageRating >= 0.5)
                            <img src="/Images/Rating_1_of_5.png" alt="Business Ratings" style="height:25px;">
                        @else
                            <img src="/Images/Rating_0_of_5.png" alt="Business Ratings" style="height:25px;">
                        @endif
                        </a>
                        <br><br>
                        <a title="View company profile info" class="mini-gold" href="/business/{{ $business->id }}">
                            <span style="color:Black;font-size:7pt;text-decoration:none;">Click here for more info</span>
                        </a>
                        <br><br><br>
                    </div>                                                
                </td>
                <td style="vertical-align:top; width:180px;">
                    <div style="padding:15px;">
                        @if (currentCoupon($business->coupons) != NULL)
                            <a title="View Coupons" href="/coupon/{{ currentCoupon($business->coupons)->id }}">
                        @endif
                        <div style="background-image: url('Images/icon_couponCutOut.png'); background-repeat:no-repeat; width:173px; height:175px; position:absolute; right:0;">
                            <div style="position:absolute; top:20px; left:25px; font-size:18pt; font-style:italic; line-height:1.2; display:inline;">
                                Coupons<br>
                                $$$
                            </div>                                                    
                        </div>
                        @if (currentCoupon($business->coupons) != NULL)
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
        </tbody></table>        
        <div>
            <img src="Images/bgBusinessBottom.png">
        </div>
    </div>
    <br/><br/>

@endforeach

</div>