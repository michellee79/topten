
@if (count($coupons) > 0)
    <table cellspacing="0" cellpadding="8" rules="rows" id="gvRatings" style="color:#999999;border-color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody><tr align="left" style="color:White;">
            <th scope="col">
                <a onclick="showLoading();" id="lbDateCreated" style="color:White;">Date</a>
            </th><th scope="col">
                <a onclick="showLoading();" id="lbTitle" style="color:White;">Name</a>
            </th><th scope="col">
                <a onclick="showLoading();" id="lbAverageValue" style="color:White;">Avg. Value (USD)</a>
            </th><th scope="col">
                <a onclick="showLoading();" id="lbClicks" style="color:White;"># of Clicks</a>
            </th><th scope="col">
                <a onclick="showLoading();" id="lbIsActive" style="color:White;">Is Active</a>
            </th><th scope="col">&nbsp;</th>
        </tr>
        @foreach ($coupons as $c)
        <tr>
            <td>
                <span id="lblDateCreated">{{convertDate($c->dateCreated)}}</span>
            </td><td>
                <span id="lblCouponTitle">{{$c->title}}</span>
            </td><td align="right">
                <div style="position:relative; right: 100px;">
                    <span id="lblAverageValue">{{$c->averageValue}}</span>
                </div>
            </td><td align="right">
                <div style="position:relative; right: 60px;">
                    <span id="lblClicks">{{$c->clicks}}</span>
                </div>
            </td><td align="center" valign="middle" style="width:100px;">                                                                        
                <div style="position:relative; right: 24px;">
                    <a id="lbChangeActiveStatus" title="Activate this coupon" href="javascript:activateCoupon({{$c->id}});" style="color:#999999;font-weight:bold;">
                    @if ($c->isActive)
                    True
                    @else
                    False
                    @endif
                    </a>
                </div>                                            
            </td><td align="center">
                <a id="lbDelete" class="mini-red" href="javascript:deleteCoupon({{$c->id}});" style="color:White;">Delete</a>
                    &nbsp;
                <a id="lbEdit" class="mini-gold" href="javascript:showEdit({{$c->id}})" style="color:White;">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
@else
    <span id="ContentPlaceHolder1_lblNoCoupons" style="color:#B03535;font-weight:bold;">No coupon found</span>
@endif