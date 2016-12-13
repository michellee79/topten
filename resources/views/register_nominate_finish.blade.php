@extends('layouts.register_master')

@section('head')

@endsection

@section('content')

    <div class="mainContentContainer">
        <div class="regMainContainer">
 
            <div id="regFormContainer">
                <table cellspacing="0" cellpadding="0" id="ContentPlaceHolder1_CreateUserWizard1" style="border-collapse:collapse;">
                <tbody><tr style="height:100%;"><td>
                    <table cellspacing="0" cellpadding="0" style="height:100%;width:100%;border-collapse:collapse;">
                    <tbody>
                    <tr>
                    <td style="height:100%;width:100%;">
                        <div class="stepContainer">
                            <div class="step1">
                                <img class="floatLt" src="/Images/step1_off.png" />
                                    <p class="stepTxtOff">Registration</p>
                            </div>
                            <div class="step2">
                                <img class="floatLt" src="/Images/step2_on.png">
                                <p class="stepTxtOn">Verification</p>
                            </div>
                        </div>
                            
                        <div class="formRow">
                
                            <div id="ContentPlaceHolder1_CreateUserWizard1_CompleteStepContainer_pnlWelcome">
                                <p class="widText" style="text-align:left;">
                                     An email has been sent to you. Please open this email and click the link to officially
                                        authorize your <strong>FREE LIFETIME CHARTER MEMBERSHIP</strong></p>
                                </p>
                            </div>
                            <p style="text-align:center; padding-top:50px;">
                               <a id="linkToHome" class="btn btn-warning btn-large" href="./" style="font-weight:bold;">Back to Home</a>
                            </p>
                        </div>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                </td></tr></tbody></table>
            </div>

        </div>
    </div>

@endsection