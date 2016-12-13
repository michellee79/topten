@extends('layouts.login_master')

@section('head')

<style>
    .noMargin
    {
        margin-bottom:0px;                            
        padding:0px;
    }
</style>

<script type="text/javascript">
    redirect = '';
    @if (isset($redirect))
        redirect = "{{$redirect}}";
    @endif
</script>

<script type="text/javascript" src="/js/login.js"></script>
@endsection

@section('content')
<div class="content">
    <div class="mainContentContainer">
        <div class="pgMainContainer">
            <div class="pgContainer">
                <p class="titleText">Forgot Password</p>
                <div style="color:#C19B41;">
                    <div id="step1">
                        <div>                                                                                    
                            <div style="font-size:14pt; font-weight:bold; color: #C19B41;">
                                Step 1. Account Verification
                            </div>
                            <br>
                            Please enter Username&nbsp;<span id="usernameRequired" class="validation" style="visibility:hidden;">Required!</span><br>
                            <input name="userName" type="text" id="userName" class="txtBox input input-round">
                        </div>

                        <div style="padding-top: 20px; padding-left:5px;">
                            <div class="controls">
                                <div class="btn-create-report-no-margin" style="width:250px;">
                                    <a id="lbVerifyUsername" class="mini-gold" href='javascript:verifyUsername("")'>Verify Username</a>
                                </div>
                                <br>
                                <span id="lblVerifyMessage" style="color:Red;font-weight:bold;"></span>
                            </div>
                        </div>
                    </div>

                    <div id="step2" style="display:none;">
                        <div>
                            <div style="font-size:14pt; font-weight:bold; color: #C19B41;">
                                Step 2. Verify You Are Not a Robot
                            </div>
                            <br>
                            
                            <span>What is the name of this site?</span>
                            <br><br>
                            
                            Type in "Top Ten Percent" below:<span id="answerRequired" class="validation" style="visibility:hidden;">Required!</span>
                            <br>
                            <input name="answer" type="text" id="answer" class="txtBox input input-round" style="width:550px;">
                        </div>

                        <div style="padding-top: 20px; padding-left:5px;">
                            <div class="controls">
                                <div class="btn-create-report-no-margin" style="width:250px;">
                                    <a id="lbResetPassword" class="mini-gold" href='javascript:verifyAnswer("")'>Reset Password</a>
                                </div>
                                <br>
                                <span id="lblMessage" style="font-weight:bold;"></span>
                            </div>
                        </div>
                    </div>

                    <div id="step3" style="display:none;">
                        <div>
                            <div style="font-size:14pt; font-weight:bold; color: #C19B41;">
                                Step 3. Password Reset Successsful
                            </div>
                            <br>                                                                
                            <span id="lblSuccess" style="color:White;font-weight:bold;">Password reset. Your new password has been sent to you via email.</span>
                            <br>                                                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

<div class="mobile-only">
    <ul>
        <li class="submenu">                
            <div class="menuText mobileTitle">
                Forgot Password
            </div>
        </li>
    </ul>

    <div class="mobileContentPane">
        <div class="mobileContent">
            <div id="step1">
                <div>                                                                                    
                    <div style="font-size:14pt; font-weight:bold; color: #C19B41;">
                        Step 1. Account Verification
                    </div>
                    <br>
                    Please enter Username&nbsp;<span id="usernameRequiredMobile" class="validation" style="visibility:hidden;">Required!</span><br>
                    <input name="userName" type="text" id="userNameMobile" class="txtBox input input-round">
                </div>

                <div style="padding-top: 20px; padding-left:5px;">
                    <div class="controls">
                        <div class="btn-create-report-no-margin" style="width:250px;">
                            <a id="lbVerifyUsername" class="mini-gold" href='javascript:verifyUsername("Mobile")'>Verify Username</a>
                        </div>
                        <br>
                        <span id="lblVerifyMessageMobile" style="color:Red;font-weight:bold;"></span>
                    </div>
                </div>
            </div>
            <div id="step2" style="display:none;">
                <div>
                    <div style="font-size:14pt; font-weight:bold; color: #C19B41;">
                        Step 2. Verify Security Question
                    </div>
                    <br>
                    
                    Security Question:<br>
                    <input name="question" type="text" value="What is the name of this site?" id="questionMobile" disabled="disabled" class="txtBox input input-round" style="width:550px;">
                    <br><br>
                    
                    Type in "Top Ten Percent" below:<span id="answerRequired" class="validation" style="visibility:hidden;">Required!</span>
                    <br>
                    <input name="answer" type="text" id="answerMobile" class="txtBox input input-round" style="width:550px;">
                </div>

                <div style="padding-top: 20px; padding-left:5px;">
                    <div class="controls">
                        <div class="btn-create-report-no-margin" style="width:250px;">
                            <a id="lbResetPassword" class="mini-gold" href='javascript:verifyAnswer("Mobile")'>Reset Password</a>
                        </div>
                        <br>
                        <span id="lblMessageMessage" style="font-weight:bold;"></span>
                    </div>
                </div>
            </div>

            <div id="step3" style="display:none;">
                <div>
                    <div style="font-size:14pt; font-weight:bold; color: #C19B41;">
                        Step 3. Password Reset Successsful
                    </div>
                    <br>                                                                
                    <span id="lblSuccess" style="color:White;font-weight:bold;">Password reset. Your new password has been sent to you via email.</span>
                    <br>                                                                
                </div>
            </div>
        </div>            
    </div>
</div>
@endsection