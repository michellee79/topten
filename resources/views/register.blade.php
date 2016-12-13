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
            <form onsubmit="registerWithPromo(''); return false;">


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
                                                    <img class="floatLt" src="/Images/step1_on.png" />
                                                        <p class="stepTxtOn">Registration</p>
                                                </div>
                                                <div class="step2">
                                                    <img class="floatLt" src="/Images/step2_off.png">
                                                    <p class="stepTxtOff">Verification</p>
                                                </div>
                                            </div>
                                                
                                            <div style="margin-left:90px;">
                                                <div class="formRow addDoubleMarginBottom">
                                                    <label class="regForm addMarginTop">Promo Code<span class="required">*</span></label>
                                                    <input name="promoCode" type="text" id="promoCode" class="regForm">
                                                    <span id="promoRequired" class="requiredMessage" style="visibility:hidden;">Promo code is required.</span>
                                                </div>

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

                                                <div class="formRow errorText">
                                                    
                                                </div>

                                            </div>

                                        </td>
                                    </tr>
                            </tbody></table></td>
                        </tr>
                        <tr>
                            <td align="right">
                                <div class="btnContainer">
                                    <input type="submit" value="Register" onclick="" id="submit" class="btn btn-warning btn-large">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
            <form onsubmit="registerWithPromo('Mobile'); return false;">


                <table cellspacing="0" cellpadding="0" id="regFormContainerMobile" style="width:100%;border-collapse:collapse;">
                <tbody>
                    <tr style="height:100%;">
                        <td>
                            <table cellspacing="0" cellpadding="0" style="height:100%;width:100%;border-collapse:collapse;">
                            <tbody>
                                <tr>
                                    <td style="height:100%;width:100%;">
                                        <div style="width:100%;">
                                            <div style="padding-top:10px; padding-bottom:10px;">
                                                <label style="font-size:12pt;">Promo Code<span class="required">*</span></label>
                                                <span id="promoCodeRequiredMobile" class="required" style="visibility:hidden;">
                                                    Promo Code is required.
                                                </span>
                                                <br>
                                                <input name="promoCode" type="text" id="promoCodeMobile" style="width:95%;">
                                            </div>
                                            <div style="padding-bottom:10px;">
                                                <label style="font-size:12pt;">
                                                    Name<span class="required">*</span>
                                                </label>
                                                <span id="nameRequiredMobile" class="required" style="visibility:hidden;">
                                                    Name is required.
                                                </span><br>
                                                <input name="firstName" type="text" id="firstnameMobile" class="txtFirstname" style="width:45%;" placeholder="First Name">&nbsp;
                                                <input name="lastName" type="text" id="lastnameMobile" class="txtLastname" style="width:45%;" placeholder="Last Name">
                                            </div>
                                            <div style="padding-bottom:10px; text-align:left;">
                                                <label style="font-size:12pt;">Zipcode<span class="required">*</span></label>
                                                <span id="zipcodeRequiredMobile" class="required" style="visibility:hidden;">Zipcode is required.</span><br>
                                                <input name="zipcode" type="text" id="zipcodeMobile" style="width:95%;">
                                            </div>                                
                                            <div style="padding-bottom:10px;">
                                                <label style="font-size:12pt;">Email<span class="required">*</span>
                                                <span style="font-size:7pt; color:#999;">(Note: This will be your Username)</span></label>
                                                <span id="emailRequiredMobile" class="required" style="visibility:hidden;">E-mail is required.</span>
                                                <span id="revEmailMobile" class="required" style="visibility:hidden;">Invalid Email Format</span><br>
                                                <input name="email" type="text" id="emailMobile" style="width:95%;">
                                            </div>

                                            <div style="padding-top:10px; padding-bottom:10px;">
                                                <label style="font-size:12pt;">Password<span class="required">*</span></label>
                                                <span id="passwordRequiredMobile" class="required" style="visibility:hidden;">Password is required.</span><br>
                                                <input name="password" type="text" id="passwordMobile" style="width:95%;">
                                            </div>

                                            <div style="padding-top:10px; padding-bottom:10px;">
                                                <label style="font-size:12pt;">Confirm Password<span class="required">*</span></label>
                                                <span id="passwordAgainRequiredMobile" class="required" style="visibility:hidden;">Confirm Password is required.</span>
                                                <span id="revPasswordAgainMobile" class="required" style="visibility:hidden;">Password doesn't match</span><br>
                                                <input name="passwordAgain" type="text" id="passwordAgainMobile" style="width:95%;">
                                            </div>
                                            
                                            <div style="padding-bottom:10px; display:none;">
                                                <label class="regForm addMarginTop">Security Question<span class="required">*</span></label>
                                                <select name="question" id="mQuestion" class="regForm">
                                                    <option value=""></option>
                                                    <option selected="selected" value="What is the name of this site?">What is the name of this site?</option>
                                                    <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                                    <option value="In what city were you born?">In what city were you born?</option>
                                                    <option value="What is your favorite sport?">What is your favorite sport?</option>
                                                    <option value="What street did you grow up on?">What street did you grow up on?</option>
                                                    <option value="What was your first car?">What was your first car?</option>
                                                </select>
                                                <span id="mQuestionRequired" class="requiredMessage" style="visibility:hidden;">
                                                    Security question is required.
                                                </span>
                                            </div>
                                            <div style="padding-bottom:10px; display:none;">
                                                <label class="regForm addMarginTop">Security Answer<span class="required">*</span></label>
                                                <input name="answer" type="text" value="Top Ten Percent" id="mAnswer" class="regForm">
                                                <span id="mAnswerRequired" class="requiredMessage" style="visibility:hidden;">
                                                    Security answer is required.
                                                </span>
                                            </div>
                                            <div style="padding-bottom:10px;" class="errorText">
                                                
                                                
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <div style="padding-bottom:10px; padding-right:10px; text-align:left;">
                                <input type="submit" value="Register" onclick="" id="mSubmit" class="mini-gold" style="font-size:12pt;">
                            </div>
                        </td>
                    </tr>
                </tbody>
                </table>
            

            </form>
        </div>
    </div>
</div>

@endsection