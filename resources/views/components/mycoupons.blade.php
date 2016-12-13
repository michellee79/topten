<div class="borderDashedBottom paddingTop10 paddingBottom10">
    <div>
        <table cellspacing="0" cellpadding="8" rules="rows" id="gvCoupons" style="color:#999999; border-color:#999999; border-width:0px; width:100%; border-collapse:collapse;">
        <tbody>
            <tr align="left" style="color:white;">
                <th scope="col">
                    <a onclick="showLoading();" href="" style="color:white;">Business</a>
                </th>
                <th scope="col">
                    <a onclick="showLoading();" href="" style="color:white;">Coupon</a>
                </th>
                <th scope="col">
                    <a onclick="showLoading();" href="" style="color:white;">Discount (%)</a>
                </th>
                <th scope="col">
                    <a onclick="showLoading();" href="" style="color:white;">Location</a>
                </th>
                <th scope="col">&nbsp;</th>
            </tr>
            @foreach($coupons as $coupon)
            <tr>
                <td valign="top">
                    <span>{{$coupon->business->name}}</span>
                </td>
                <td valign="top">
                    <span>{{$coupon->title}}</span>
                </td>
                <td valign="top">
                    <div style="padding-left:30px;"><span>{{$coupon->discount}}</span></div>
                </td>
                <td valign="top">
                    <a title="Get direction to this location" href="http://maps.google.com/maps?saddr=&daddr={{$coupon->business->address}} {{$coupon->business->city}}, {{$coupon->business->state}} {{$coupon->business->zip}}">
                        {{$coupon->business->address}} {{$coupon->business->city}}, {{$coupon->business->state}} {{$coupon->business->zip}}
                    </a>
                </td>
                <td align="center" valign="top" style="width:200px;">
                    <a id="lbDelete" class="mini-red" href="javascript:removeMyCoupon({{$coupon->id}}, false);">Remove</a>
                    &nbsp;&nbsp;&nbsp;
                    <a id="linkToViewCoupon" class="mini-gold" href="/coupon/{{$coupon->id}}" target="_blank">View Coupon</a>
                </td>
            </tr>
            @endforeach
        </tbody>            
        </table>
    </div>
</div>