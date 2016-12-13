@extends('layouts.page_master')

@section('head')

	 <!--slideshowBox-->
    <link href="/scripts/slideshowBox/slideshowBox.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/slideshowBox/slideshowBox.js" type="text/javascript"></script>
    <script type="text/javascript">
        Shadowbox.init({
            continuous: true,
            counterType: "skip"
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.moreInfo').click(function () {
                $(this).parent().find('.infoContent').toggle('medium');
                $('.moreInfoText').toggle();
                $('.hideInfoText').toggle();
            });

            ga('send', 'event', 'BusinessProfile', 'click', '{{$business->name}}');
        });

        function gaVisitBusinessSite(sender, name){
            ga('send', 'event', 'BusinessWebsite', 'visit', sender.href);
            $.ajax({
                url: '/ajax/visitbusinesswebsite/' + '{{$business->id}}',
                type: 'get'
            });
        }
    </script>

    <link href="/styles/Buttons.css" rel="stylesheet" type="text/css" />

@endsection

@section('content')
    <div class="content">
        @include('common.sidetab')
        <div class="mainContentContainer">
            <div class="pgMainContainer">
                <div class="pgContainer">
                    <table width="100%" cellpadding="0" cellspacing="0" style="color:#999999;">
                        <tbody>
                            <tr>
                                <td align="right" style="padding-bottom:15px;">
                                    <a title="View other businesses near your location" class="mini-grey" href="/businesses#business_box_{{ $business->id }}">Other Businesses</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td style="width:320px; padding-left:0px; padding-top:10px; vertical-align:top; border:none thin #999999;">
                                            @if (count($business->images) > 0)
                                            <a id="linkToFirstImage" rel="shadowbox[TopTen]" href="/{{$business->images[0]->url}}">
                                                <img src="{{ $business->logo->url }}" style="width:220px;"><br/>
                                                <span style="font-size:8pt; font-weight:normal;">
                                                    <span id="lblViewGallery">
                                                        click on image to view gallery
                                                    </span>
                                                </span>
                                            </a>
                                            <div style="display:none;">
                                            @foreach($images as $image)
                                                <a rel="shadowbox[TopTen]" href="/{{$image->url}}">
                                                    <img src="/{{$image->url}}" style="width:300px;">
                                                </a>
                                            @endforeach
                                            </div>
                                            @else
                                            <img src="{{ $business->logo->url }}" style="width:220px;"><br/>
                                            @endif
                                                <div style="padding-top: 30px; padding-bottom:50px;">
                                                    <a href="/businessratings/{{ $business->id }}" style="font-weight: 100">
                                                    <div style="width:245px;">
                                                        <?php
                                                            foreach($business->ratings as $rating){
                                                                if ($rating->isDisplayed){
                                                                    echo "<h5>Consumer Reviews</h5>";
                                                                    echo '<span id="lblSelectedComment" style="color:#A6832F;font-size:8pt; margin-left: 10px;">';
                                                                    echo "&ldquo;", $rating->comment, "&rdquo;";
                                                                    echo '</span>';
                                                                    break;
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                    <div style="padding-top:10px;">
                                                        <h5 style="margin-bottom: 4px; margin-top: 4px;">Average Rating</h5>
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
                                                        <br>
                                                        <div id="lblSelectedComment" style="color:#A6832F;font-size:8pt; margin-left: 25px;">See All Ratings</div>
                                                    </div>
                                                    </a>
                                                </div>

                                                <div style="padding-bottom:80px;">
                                                    <a title="View Coupons" style="font-size:12pt;" class="mega-btn"
                                                        @if (currentCoupon($business->coupons) != NULL)
                                                            href="/coupon/{{ currentCoupon($business->coupons)->id }}"
                                                        @else
                                                            href="javascript:alert('No coupons!')"
                                                        @endif
                                                    >View Coupons</a>
                                                </div>
                                            </td>
                                            <td style="width:600px; padding:10px; padding-left:20px; vertical-align:top;">
                                                <div style="padding-bottom:10px;">
                                                    <p>
                                                        <a id="linkToBusiness" class="headerText" href="{{ $business->website }}"
                                                        onclick="gaVisitBusinessSite(this, '{{$business->name}}')"
                                                        target="_blank" style="color:#A6832F;font-size:24px;font-weight:normal;">
                                                        {{ $business->name }}
                                                        </a>
                                                    </p>
                                                    <p>
                                                        <a id="linkToBusinessAddress" href="http://maps.google.com/maps?saddr=&amp;daddr={{ $business->address }} {{ $business->city }},{{ $business->state }} {{ $business->zipcode }}" target="_blank" style="font-size:10pt;font-weight:normal;">{{ $business->address }} {{ $business->city }}, {{ $business->state }} {{ $business->zipcode }}</a><br>
                                                        <a id="linkToPhone" href="Tel:{{ $business->phone }}" style="font-size:10pt;font-weight:normal;">{{ $business->phone }}</a><br>
                                                        <a id="linkToBusinessWebsite" 
                                                        onclick="gaVisitBusinessSite(this, '{{$business->name}}')"
                                                        href="{{ $business->website }}" target="_blank" style="font-size:10pt;font-weight:normal;">{{ $business->website }}</a><br>
                                                    </p>
                                                </div>
                                                <div>
                                                    <?php
                                                        if ($business->profileTopRight != null)
                                                            echo $business->profileTopRight;
                                                    ?>
                                                    <br><br>
                                                    <?php
                                                        if ($business->profileBottomLeft != null)
                                                            echo $business->profileBottomLeft;
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-only">
        <div class="mobile-only">
            <ul>
                <li class="submenu">
                    <div class="menuText">

                        <a title="Get Directions" href="http://maps.google.com/maps?saddr=&amp;daddr={{ $business->address }} {{ $business->city }},{{ $business->state }} {{ $business->zipcode }}" target="_blank" style="font-weight:normal;">
                            <img src="/Images/directions.png">
                        </a>&nbsp;&nbsp;
                        <a title="Get Directions" href="http://maps.google.com/maps?saddr=&amp;daddr={{ $business->address }} {{ $business->city }},{{ $business->state }} {{ $business->zipcode }}" target="_blank" style="color:#A6832F;font-size:10pt;font-weight:normal;">
                        {{ $business->address }} {{ $business->city }}, {{ $business->state }} {{ $business->zipcode }}
                        </a>
                    </div>   
                </li>
                <li class="submenu">
                    <div class="menuText">                    
                        <a href="tel:{{ $business->phone }}" target="_blank" style="font-weight:normal;">
                            <img src="/Images/phone.png" width="32px">
                        </a>&nbsp;&nbsp;
                        <a href="tel:{{ $business->phone }}" style="color:#A6832F;font-size:10pt;font-weight:normal;">
                        {{ $business->phone }}
                        </a>
                    </div>   
                </li>
                <li class="submenu">
                    <div class="menuText">                    
                        <a title="Click here to view coupon" 
                        @if (currentCoupon($business->coupons) != NULL)
                            href="/coupon/{{ currentCoupon($business->coupons)->id }}"
                        @else
                            href="javascript:alert('No coupons!')"
                        @endif
                        style="color:#A6832F;font-weight:normal;">
                            <img src="/Images/coupon_tag.png" width="36px">&nbsp;&nbsp;Coupon&nbsp;&nbsp;
                        </a>       
                    </div>   
                </li>    
                <li class="submenu">
                    <div class="menuText">                    
                        <a title="View Ratings" href="/businessratings/{{$business->id}}">
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
                        </a>&nbsp;
                    </div>   
                </li>            
            </ul>

            <div class="mobileContentPane" style="padding-bottom:0px;">
                <div class="mobileContent">                
                    <div class="clear">
                        <br>
                    </div>                
                    <div>
                        <img src="{{ $business->logo->url }}">
                    </div>
                    <div class="clear">
                        <br>
                    </div>                
                    <div>
                        <span id="SelectedCommentMobile" style="color:#A6832F;font-size:0.7em;">
                        <?php
                            foreach($business->ratings as $rating){
                                if ($rating->isDisplayed){
                                    echo "<span style='font-size:11pt;'>&ldquo;</span>", $rating->comment, "<span style='font-size:11pt;'>&rdquo;</span>";
                                    break;
                                }
                            }
                        ?>
                        </span>
                    </div>

                    <div class="clear" style="border-bottom:dashed 1px #111;">
                        <br>
                    </div>

                    <div class="moreInfo" style="padding-top:15px; padding-bottom:20px; cursor:pointer; color:#A6832F; font-size:0.8em;">
                        <img id="imgInfo" title="View Info" src="/Images/info.png" style="width:25px;">&nbsp;
                        <span class="moreInfoText">More Info</span><span class="hideInfoText" style="display:none;">Hide Info</span>
                        
                    </div>

                    <div class="infoContent" style="text-align:justify; display:none;">
                        <div>
                            <?php
                                if ($business->profileTopRight != null)
                                    echo $business->profileTopRight;
                            ?>
                            <br><br>
                            <?php
                                if ($business->profileBottomLeft != null)
                                    echo $business->profileBottomLeft;
                            ?>
                        </div>
                        <div style="padding-top:10px;">
                            <p>
                                <a id="linkToBusinessMobile" class="headerText" href="{{ $business->website }}" target="_blank" style="color:#A6832F;font-weight:normal;">Website</a>    
                            </p>                        
                        </div>

                        <div style="padding-top:10px;">
                            <p>
                                <a id="linkToBusinessMobile" class="headerText" href="{{ $business->website }}" target="_blank" style="color:#A6832F;font-weight:normal;">Website</a>
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            @include('common.footer_mobile_widget')
        </div>
    </div>
@endsection
