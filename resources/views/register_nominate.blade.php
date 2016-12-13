@extends('layouts.register_master')

@section('head')

    <script type="text/javascript" src="/js/register.js"></script>
    <script src="/scripts/toastMessage/jquery.toastmessage.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

    <script type="text/javascript" src="/scripts/showLoading/js/jquery.showLoading.js"></script>
    <link rel="stylesheet" type="text/css" href="/scripts/showLoading/css/showLoading.css" />

    <script type="text/javascript">

    </script>

@endsection

@section('content')
<div class="content">
    <div class="mainContentContainer">
        <div class="regMainContainer">
            <form onsubmit="registerWithNomination(''); return false;">
                <div id="regFormContainer">
                    <table cellspacing="0" cellpadding="0" id="createUserWizard" style="border-collapse:collapse;">
                        <tbody>
                        <tr style="height:100%;">
                        <td>
                        <table cellspacing="0" cellpadding="0" style="height:100%;width:100%;border-collapse:collapse;">
                        <tbody>
                        <tr>
                        <td style="height:100%;width:100%;">
                            <div class="stepContainer">
                                <div class="step1">
                                    <img class="floatLt" src="Images/step1_on.png">
                                    <p class="stepTxtOn">
                                        Registration</p>
                                </div>
                                <div class="step2">
                                    <img class="floatLt" src="Images/step2_off.png">
                                    <p class="stepTxtOff">
                                        Verification</p>
                                </div>
                            </div>
                            <div style="margin-left: 90px;">

                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addHalfMarginTop">Name<span class="required">*</span></label>
                                    <input name="firstname" type="text" id="firstname" class="regFormName" placeholder="First Name">
                                    <input name="lastname" type="text" id="lastname" class="regFormName" placeholder = "Last Name">
                                    <span id="nameRequired" class="requiredMessageCus" style="visibility:hidden;">Name is required.</span>
                                </div>

                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">Zipcode<span class="required">*</span></label>
                                    <input name="zipcode" type="text" id="zipcode" class="regForm">
                                    <span id="zipcodeRequired" class="requiredMessage" style="visibility:hidden;">Zipcode is required.</span>
                                </div>

                                <div class="formRow">
                                    <label class="regForm addMarginTop">Email<span class="required">*</span></label>
                                    <input name="email" type="text" id="email" class="regForm removeMarginBottom">
                                    <span id="revEmail" class="requiredMessage" style="visibility:hidden;">Invalid Email Format</span>
                                    <span id="emailRequired" class="requiredMessageCustom" style="visibility:hidden;">E-mail is required.</span>
                                    <span class="optional">(Note: This will be your Username)</span>
                                </div>

                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">Password<span class="required">*</span></label>
                                    <input name="password" type="password" id="password" class="regForm">
                                    <span id="passwordRequired" class="requiredMessage" style="visibility:hidden;">Password required.</span>
                                </div>

                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">Confirm Password<span class="required">*</span></label>
                                    <input name="passwordAgain" type="password" id="passwordAgain" class="regForm">
                                    <span id="passwordRequired" class="requiredMessage" style="visibility:hidden;">Confirm password required.</span>
                                    <span id="revPassword" class="requiredMessage" style="visibility:hidden;">Password doesn't match</span>
                                </div>

                                <div class="formRow addDoubleMarginBottom" style="display:none;">
                                    <label class="regForm addMarginTop">Security Question<span class="required">*</span></label>
                                    <select name="question" id="question" class="regForm">
                                        <option value=""></option>
                                        <option selected="selected" value="What is the name of this site?">What is the name of this site?</option>
                                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                        <option value="In what city were you born?">In what city were you born?</option>
                                        <option value="What is your favorite sport?">What is your favorite sport?</option>
                                        <option value="What street did you grow up on?">What street did you grow up on?</option>
                                        <option value="What was your first car?">What was your first car?</option>
                                    </select>
                                    <span id="vQuestionRequired" class="requiredMessage" style="visibility:hidden;">Security question is required.</span>
                                </div>

                                <div class="formRow addDoubleMarginBottom" style="display:none;">
                                    <label class="regForm addMarginTop">Security Answer<span class="required">*</span></label>
                                    <input name="answer" type="text" value="Top Ten Percent" id="answer" class="regForm">
                                    <span id="vAnswerRequired" class="requiredMessage" style="visibility:hidden;">Security answer is required.</span>                                
                                </div>  

                                <div style="border-bottom: 2px solid #B28211;">
                                    &nbsp;
                                </div>
                                <div>
                                    <p class="subTitleText">
                                        The First Business You Are Nominating
                                    </p>
                                </div>
                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">
                                        Business Name<span class="required">*</span></label>
                                    <input name="businessName1" type="text" id="businessName1" class="regForm">
                                    <span id="businessName1Required" class="requiredMessage" style="visibility:hidden;">Business Name #1 is required.</span>
                                </div>
                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">
                                        Business City<span class="required">*</span></label>
                                    <input name="businessCity1" type="text" id="businessCity1" class="regForm">
                                    <span id="businessCity1Required" class="requiredMessage" style="visibility:hidden;">Business #1 City is required.</span>
                                </div>
                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">
                                        Business State<span class="required">*</span></label>
                                    <select name="ddlBusinessState1" id="ddlBusinessState1" class="regForm">
                                        <option value=""></option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DC">District of Columbia</option><option value="DE">Delaware</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>
                                    </select>
                                    <span id="businessState1Required" class="requiredMessage" style="visibility:hidden;">Business #1 State is required.</span>
                                </div>
                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">
                                        Business Phone#<span class="required"></span></label>
                                    <input name="businessPhone1" type="text" id="businessPhone1" class="regForm">
                                </div>
                                <div class="formRow">
                                    <label style="color: #ffffff;">
                                        Why do You Feel This Business Should be Included in the Top Ten Percent®?<span class="required">*</span></label>
                                    <textarea name="reason1" rows="5" cols="20" id="reason1" style="width:500px;"></textarea>
                                    <div style="position: relative; top: -20px;">
                                        <span id="reason1Required" class="requiredMessage" style="visibility:hidden;">Reason 1 is required.</span>
                                    </div>
                                </div>
                                <div style="border-bottom: 2px solid #B28211;">
                                    &nbsp;
                                </div>
                                <div>
                                    <p class="subTitleText">
                                        The Second Business You Are Nominating
                                    </p>
                                </div>
                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">
                                        Business Name<span class="required">*</span></label>
                                    <input name="businessName2" type="text" id="businessName2" class="regForm">
                                    <span id="businessName2Required" class="requiredMessage" style="visibility:hidden;">Business Name #2 is required.</span>
                                </div>
                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">
                                        Business City<span class="required">*</span></label>
                                    <input name="businessCity2" type="text" id="businessCity2" class="regForm">
                                    <span id="businessCity2Required" class="requiredMessage" style="visibility:hidden;">Business #2 City is required.</span>
                                </div>
                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">
                                        Business State<span class="required">*</span></label>
                                    <select name="ddlBusinessState2" id="ddlBusinessState2" class="regForm">
                                        <option value=""></option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DC">District of Columbia</option><option value="DE">Delaware</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>
                                    </select>
                                    <span id="businessState2Required" class="requiredMessage" style="visibility:hidden;">Business #2 State is required.</span>
                                </div>
                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">
                                        Business Phone#<span class="required"></span></label>
                                    <input name="businessPhone2" type="text" id="businessPhone2" class="regForm">
                                </div>
                                <div class="formRow">
                                    <label style="color: #ffffff;">
                                        Why do You Feel This Business Should be Included in the Top Ten Percent®?<span class="required">*</span></label>
                                    <textarea name="reason1" rows="5" cols="20" id="reason2" style="width:500px;"></textarea>
                                    <div style="position: relative; top: -20px;">
                                        <span id="reason2Required" class="requiredMessage" style="visibility:hidden;">Reason 2 is required.</span>
                                    </div>
                                </div>
                                <div class="formRow errorText">
                                    
                                    
                                </div>
                            </div>
                        </td>
                                </tr>
                            </tbody></table></td>
                        </tr><tr>
                            <td align="right">
                                <div class="btnNominateAndRegisterContainer">
                                    <input type="submit" name="submit" value="Register" onclick="" id="submit" class="btn btn-warning btn-large">
                                </div>
                            </td>
                        </tr>
                    </tbody></table>
                </div>


            </form>
        </div>
    </div>
</div>

<div class="mobile-only">
    <ul>
        <li class="submenu">                
            <div class="menuText mobileTitle">
                SIGN UP
            </div>
        </li>
    </ul>

    <div class="mobileContentPane" style="padding-bottom:0px;">
        <div class="mobileContent">
            <form onsubmit="registerWithNomination('Mobile'); return false;">
                <div id="regFormContainerMobile">
                    <table cellspacing="0" cellpadding="0" id="createUserWizard" style="border-collapse:collapse;">
                        <tbody>
                        <tr style="height:100%;">
                            <td>
                                <table>
                                    <tr>
                                        <td style="height:100%;">
                                            <div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label class=" addHalfMarginTop">Name<span class="required">*</span></label>
                                                    <span id="nameRequired" class="requiredMessageCus" style="visibility:hidden;">Name is required.</span>
                                                    <input name="firstname" type="text" id="firstnameMobile" class="" placeholder="First Name">
                                                    <input name="lastname" type="text" id="lastnameMobile" class="" placeholder = "Last Name">
                                                </div>

                                                <div style="padding-bottom:10px;">
                                                    <label class=" addMarginTop">Zipcode<span class="required">*</span></label>
                                                    <span id="zipcodeRequired" class="requiredMessage" style="visibility:hidden;">Zipcode is required.</span>
                                                    <input name="zipcode" type="text" id="zipcodeMobile" class="">
                                                </div>

                                                <div style="padding-bottom:10px;">
                                                    <label class="">Email<span class="required">*</span></label>
                                                    <span id="emailRequired" class="requiredMessageCustom" style="visibility:hidden;">E-mail is required.</span>
                                                    <input name="email" type="text" id="emailMobile" class=" removeMarginBottom">
                                                    <span id="revEmail" class="requiredMessage" style="visibility:hidden;">Invalid Email Format</span>
                                                    <div class="optional">(Note: This will be your Username)</div>
                                                </div>

                                                <div style="padding-bottom:10px;">
                                                    <label class="">Password<span class="required">*</span></label>
                                                    <span id="passwordRequired" class="requiredMessage" style="visibility:hidden;">Password required.</span>
                                                    <input name="password" type="password" id="passwordMobile" class="">
                                                </div>

                                                <div style="padding-bottom:10px;">
                                                    <label class="">Confirm Password<span class="required">*</span></label>
                                                    <span id="passwordRequired" class="requiredMessage" style="visibility:hidden;">Confirm password required.</span>
                                                    <input name="passwordAgain" type="password" id="passwordAgainMobile" class="">
                                                    <span id="revPassword" class="requiredMessage" style="visibility:hidden;">Password doesn't match</span>
                                                </div>

                                                <div class="formRow" style="display:none;">
                                                    <label class="regForm">Security Question<span class="required">*</span></label>
                                                    <select name="question" id="question" class="regForm">
                                                        <option value=""></option>
                                                        <option selected="selected" value="What is the name of this site?">What is the name of this site?</option>
                                                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                                        <option value="In what city were you born?">In what city were you born?</option>
                                                        <option value="What is your favorite sport?">What is your favorite sport?</option>
                                                        <option value="What street did you grow up on?">What street did you grow up on?</option>
                                                        <option value="What was your first car?">What was your first car?</option>
                                                    </select>
                                                    <span id="vQuestionRequired" class="requiredMessage" style="visibility:hidden;">Security question is required.</span>
                                                </div>

                                                <div class="formRow" style="display:none;">
                                                    <label class="regForm addMarginTop">Security Answer<span class="required">*</span></label>
                                                    <input name="answer" type="text" value="Top Ten Percent" id="answer" class="regForm">
                                                    <span id="vAnswerRequired" class="requiredMessage" style="visibility:hidden;">Security answer is required.</span>                                
                                                </div>  

                                                <div style="border-bottom: 2px solid #B28211;">
                                                    &nbsp;
                                                </div>
                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <p class="subTitleText">
                                                        The First Business You Are Nominating
                                                    </p>
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label class=" addMarginTop">
                                                        Business Name<span class="required">*</span></label>
                                                    <span id="businessName1Required" class="requiredMessage" style="visibility:hidden;">Business Name #1 is required.</span>
                                                    <input name="businessName1" type="text" id="businessName1Mobile" class="">
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label class=" addMarginTop">
                                                        Business City<span class="required">*</span></label>
                                                    <span id="businessCity1Required" class="requiredMessage" style="visibility:hidden;">Business #1 City is required.</span>
                                                    <input name="businessCity1" type="text" id="businessCity1Mobile" class="">
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label class=" addMarginTop">
                                                        Business State<span class="required">*</span></label>
                                                    <span id="businessState1Required" class="requiredMessage" style="visibility:hidden;">Business #1 State is required.</span>
                                                    <select name="ddlBusinessState1" id="ddlBusinessState1Mobile" class="">
                                                        <option value=""></option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DC">District of Columbia</option><option value="DE">Delaware</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>
                                                    </select>
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label class=" addMarginTop">
                                                        Business Phone#<span class="required">*</span></label>
                                                    <span id="businessPhone1Required" class="requiredMessage" style="visibility:hidden;">Business Phone#1 State is required.</span>
                                                    <input name="businessPhone1" type="text" id="businessPhone1Mobile" class="">
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label style="color: #ffffff;">
                                                        Why do You Feel This Business Should be Included in the Top Ten Percent®?<span class="required">*</span></label>
                                                    <textarea name="reason1" rows="5" cols="20" id="reason1Mobile" style="width:90%;"></textarea>
                                                    <div style="position: relative; top: -20px;">
                                                        <span id="reason1Required" class="requiredMessage" style="visibility:hidden;">Reason 1 is required.</span>
                                                    </div>
                                                </div>

                                                <div style="border-bottom: 2px solid #B28211;">
                                                    &nbsp;
                                                </div>
                                                <div>
                                                    <p class="subTitleText">
                                                        The Second Business You Are Nominating
                                                    </p>
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label class=" addMarginTop">
                                                        Business Name<span class="required">*</span></label>
                                                    <span id="businessName2Required" class="requiredMessage" style="visibility:hidden;">Business Name #2 is required.</span>
                                                    <input name="businessName2" type="text" id="businessName2Mobile" class="">
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label class=" addMarginTop">
                                                        Business City<span class="required">*</span></label>
                                                    <span id="businessCity2Required" class="requiredMessage" style="visibility:hidden;">Business #2 City is required.</span>
                                                    <input name="businessCity2" type="text" id="businessCity2Mobile" class="">
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label class=" addMarginTop">
                                                        Business State<span class="required">*</span></label>
                                                    <span id="businessState2Required" class="requiredMessage" style="visibility:hidden;">Business #2 State is required.</span>
                                                    <select name="ddlBusinessState2" id="ddlBusinessState2Mobile" class="">
                                                        <option value=""></option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DC">District of Columbia</option><option value="DE">Delaware</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>
                                                    </select>
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label class=" addMarginTop">
                                                        Business Phone#<span class="required"></span></label>
                                                    <span id="businessPhone2Required" class="requiredMessage" style="visibility:hidden;">Business Phone #2 State is required.</span>
                                                    <input name="businessPhone2" type="text" id="businessPhone2Mobile" class="">
                                                </div>

                                                <div style="padding-top:10px; padding-bottom:10px;">
                                                    <label style="color: #ffffff;">
                                                        Why do You Feel This Business Should be Included in the Top Ten Percent®?<span class="required">*</span></label>
                                                    <textarea name="reason1" rows="5" cols="20" id="reason2Mobile" style="width:90%;"></textarea>
                                                    <div style="position: relative; top: -20px;">
                                                        <span id="reason2Required" class="requiredMessage" style="visibility:hidden;">Reason 2 is required.</span>
                                                    </div>
                                                </div>
                                                <div class="formRow errorText"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <div class="btnNominateAndRegisterContainer">
                                    <input type="submit" name="submit" value="Register" onclick="" id="submit" class="btn btn-warning btn-large">
                                </div>
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection