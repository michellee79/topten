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
            <form onsubmit="registerFromNomination(''); return false;">
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
                                    <input name="firstname" type="text" id="firstname" class="regFormName" placeholder="First Name" value="{{$nominator['firstName']}}">
                                    <input name="lastname" type="text" id="lastname" class="regFormName" placeholder = "Last Name" value="{{$nominator['lastName']}}">
                                    <span id="nameRequired" class="requiredMessageCus" style="visibility:hidden;">Name is required.</span>
                                </div>

                                <div class="formRow addDoubleMarginBottom">
                                    <label class="regForm addMarginTop">Zipcode<span class="required">*</span></label>
                                    <input name="zipcode" type="text" id="zipcode" class="regForm" value="{{$nominator['zipcode']}}">
                                    <span id="zipcodeRequired" class="requiredMessage" style="visibility:hidden;">Zipcode is required.</span>
                                </div>

                                <div class="formRow">
                                    <label class="regForm addMarginTop">Email<span class="required">*</span></label>
                                    <input name="email" type="text" id="email" value="{{$nominator['email']}}" class="regForm removeMarginBottom">
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
                                
                            </div>
                        </td>
                                </tr>
                            </tbody></table></td>
                        </tr><tr>
                            <td align="right">
                                <div class="btnNominateAndRegisterContainer">
                                    <br>
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
                                    <br>
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