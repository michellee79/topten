<div class="borderDashedBottom paddingTop10 paddingBottom10">
    <div>
        <table cellspacing="0" cellpadding="8" rules="rows" id="gvCoupons" style="color:#999999; border-color:#999999; border-width:0px; width:100%; border-collapse:collapse;">
        <tbody>
            <tr align="left" style="color:white;">
                <th scope="col">
                    <div style="padding-bottom:10px;">
                        <span onclick="showLoading();" id="lbBusinessName" style="color:#A6832F;">My Coupons</span>
                    </div>
                </th>
            </tr>
            @foreach($coupons as $coupon)
            <tr>
                <td valign="top">
                    <div>
                        <div style="padding-top:10px; padding-bottom:10px;">
                            <span id="lblBusinessName">{{$coupon->business->name}}</span>
                            &nbsp;-&nbsp;
                            <span id="lblBusinessTitle">{{$coupon->title}}</span>
                        </div>
                        <div style="padding-bottom:10px;">
                            Discount&nbsp;<span id="lblDiscount">{{$coupon->discount}}</span>%
                        </div>
                        <div style="padding-bottom:10px;">
                            <a title="Get direction to this location" href="http://maps.google.com/maps?saddr=&daddr={{$coupon->business->address}} {{$coupon->business->city}}, {{$coupon->business->state}} {{$coupon->business->zip}}">
                                <span id="lblCity">{{$coupon->business->address}}</span><br/>
                                <span id="lblCity">{{$coupon->business->city}}</span>,&nbsp;<span id="lblState">{{$coupon->business->state}}</span><br>
                                <span id="lblZip">{{$coupon->business->zipcode}}</span>
                            </a>
                        </div>
                        <div style="padding-bottom:20px;">
                            <a id="linkToDirectionBottom" title="Get direction to this location" href="http://maps.google.com/maps?saddr=&daddr={{$coupon->business->address}} {{$coupon->business->city}}, {{$coupon->business->state}} {{$coupon->business->zip}}" style="font-weight:normal;">
                                <img src="/Images/directions.png">
                            </a>
                            &nbsp;
                            <a id="linkToViewCoupon" title="View coupon" href="/coupon/22" target="_blank">
                                <img src="/Images/coupon_tag.png" width="40px">
                            </a>
                            &nbsp;                                        
                            <a id="lbDelete" title="Delete this coupon" href="javascript:removeMyCoupon({{$coupon->id}}, true)">
                                <img src="/Images/crossOrange.png">
                            </a>
                        </div>                                    
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>            
        </table>
    </div>
</div>