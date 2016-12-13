<div style="padding:0px;">
@foreach ($businesses as $business)
    <div class="sectionContainer alt-border" style="padding:20px; width:90%; text-align:center;" id="business_box_mobile_{{$business->id}}">
        <div style="float:left;">
            <a href="/business/{{ $business->id }}">
                <span class="companyTitle" style="font-size:12pt;font-weight:bold;text-decoration:none;">{{$business->name}}</span>
            </a>
        </div>
        <div style="float:right;">
            <a title="View Ratings" href="/businessratings/{{$business->id}}">
                @if ($business->averageRating === NULL)
                    <img src="/Images/Rating_None.png" alt="Business Ratings" style="height:20px;">
                @elseif ($business->averageRating >= 4.5)
                    <img src="/Images/Rating_5_of_5.png" alt="Business Ratings" style="height:20px;">
                @elseif ($business->averageRating >= 3.5)
                    <img src="/Images/Rating_4_of_5.png" alt="Business Ratings" style="height:20px;">
                @elseif ($business->averageRating >= 2.5)
                    <img src="/Images/Rating_3_of_5.png" alt="Business Ratings" style="height:20px;">
                @elseif ($business->averageRating >= 1.5)
                    <img src="/Images/Rating_2_of_5.png" alt="Business Ratings" style="height:20px;">
                @elseif ($business->averageRating >= 0.5)
                    <img src="/Images/Rating_1_of_5.png" alt="Business Ratings" style="height:20px;">
                @else
                    <img src="/Images/Rating_0_of_5.png" alt="Business Ratings" style="height:20px;">
                @endif
            </a>
        </div>                                                                
        
        <div class="clear">
            <br>
        </div>
        <a href="/business/{{ $business->id }}">
            <img src="{{ $business->logo->url }}">
        </a>
        <div class="clear">
            <br>
        </div>
        <div class="info" style="float:left; padding-top:5px; cursor:pointer;">                                    
            <img title="View Info" src="/Images/info.png" style="width:25px;">
        </div>
        <div style="float:right;">
            @if (currentCoupon($business->coupons) != NULL)
                <a href="/coupon/{{ currentCoupon($business->coupons)->id }}">
            @endif
                <img src="/Images/coupon_tag.png" width="30px" alt="Coupon">
            @if (currentCoupon($business->coupons) != NULL)
            </a>
            @endif
        </div>
        <div class="clear">                                        
        </div>
        <div class="summary" style="text-align:justify; padding:10px; display:block;">
            <span style="color:#C19B41;font-size:0.7em;font-weight:bold;">
                {{shortSummary($business->summary)}}
            </span>    
        </div>
    </div>
    <div class="clear">
        <br>
    </div>
@endforeach
</div>