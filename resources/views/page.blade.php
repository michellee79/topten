@extends('layouts.page_master')

@section('head')
    <meta name="{{$keyword}}" content="{{ $description }}">

    <style type="text/css">
        .validation
        {
            color: #B03535;
            font-size: 10px;
        }
        .stackValidation
        {
            color: #B03535;
            font-size: 10px;
            position: relative;
            top: 5px;
            right: 500px;
            float: right;
        }
        .watermark
        {            
            color: #999 !important;                     
        }
    </style>

@endsection

@section('content')

@include('common.sidetab')

<div class="mainContentContainer content">
    <div class="pgMainContainer">
        <div class="pgContainer">
            <?php
                if (isset($content))
                    echo $content;
            ?>
        </div>
    </div>
</div>

<div class="mobile-only">
    <div class="mobileContentPane">
        <div class="mobileContent">
            <div>
                <?php
                if (isset($mcontent))
                    echo $mcontent;
            ?>
            </div>
        </div>
    </div>
</div>
@endsection