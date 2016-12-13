function calc1() {
    h6 = parseInt($("#txtCustomerNum").val());
    if (isNaN(h6)) {
        alertMisInput('txtCustomerNum', "Total Average Customers")
        return;
    }
    h7 = parseInt($("#txtCustomerBackNum").val());
    if (isNaN(h7)) {
        alertMisInput('txtCustomerBackNum', "Average Number of Visits");
        return;
    }
    h4 = parseFloat($("#txtCustomerSpend").val());
    if (isNaN(h4)) {
        alertMisInput('txtCustomerSpend', "Average Ticket");
        return;
    }
    h5 = parseFloat($("#txtGrossProfitMargin").val());
    if (isNaN(h5)) {
        alertMisInput('txtGrossProfitMargin', "Profit Margin");
        return;
    }
    c22 = $("#cbIndustry1").val();
    if (c22 == '') {
        alertMisInput('cbIndustry1', "Industry hasn't been selected");
        return;
    }
    h10 = parseFloat($("#txtMonthFee1").val());
    if (isNaN(h10)) {
        alertMisInput('txtMonthFee1', "TTP Fee");
        return;
    }

    h5 = h5 / 100;

    d22 = h4 * h6 * h7;
    e22 = 1;
    if (d22 > 41666)
        e22 = 0.5;
    f22 = 1;
    if (d22 >= 83334)
        f22 = 0.5;
    g22 = c22 * e22 * f22;
    h12 = g22 / 100;

    h16 = d22 * h12; // Additional Monthly Sales
    h17 = (h16 - h10) * h5; // Additional Profit Per Month
    h18 = h17 / h10; // Your Return On Investment

    if (h18 > 0.01) {
        setResult(h16, h17, h10, h18);
        goToResult();
    } else {
        goToError();
    }
}

function calc2() {
    o4 = parseFloat($("#txtExtGrossMargin").val());
    if (isNaN(o4)) {
        alertMisInput('txtExtGrossMargin', "Gross Profit Margin");
        return;
    }
    o5 = parseFloat($("#txtMonthlyGrossRevenue").val());
    if (isNaN(o5)) {
        alertMisInput('txtMonthlyGrossRevenue', "Average Monthly Gross Revenues");
        return;
    }
    o9 = parseFloat($("#txtMonthFee2").val());
    if (isNaN(o9)) {
        alertMisInput('txtMonthFee2', "TTP Fee");
        return;
    }
    l22 = $("#cbIndustry2").val();
    if (l22 == '') {
        alertMisInput('cbIndustry2', "Industry hasn't been selected");
        return;
    }

    o4 = o4 / 100;
    n22 = 1;
    if (o5 >= 41667)
        n22 = 0.5;
    o22 = 1;
    if (o5 >= 83334)
        o22 = 0.5;
    p22 = l22 * n22 * o22;
    o12 = p22 / 100;

    o16 = o5 * o12; // Additional Monthly Sales
    o17 = (o16 - o9) * o4; // Additional Profit Per Month
    o18 = o17 / o9; // Your Return On Investment
    if (o18 > 0.01) {
        setResult(o16, o17, o9, o18);
        goToResult();
    } else {
        goToError();
    }
}

function alertMisInput(id, text) {
    showErrorToast('Check your input - ' + text);
    $("#" + id).focus();
}

function setResult(ms, mp, fee, roi) {
    $("#additionalMonthlySales").html('$' + ms.toLocaleString('us'));
    $("#minusTTPMonthlyFee").html('-$' + fee.toLocaleString('us'));
    $("#additionalProfitPerMonth").html('$' + mp.toLocaleString('us'));
    my = mp * 12;
    $("#additionalProfitPerYear").html('$' + my.toLocaleString('us'));
    roi *= 100;
    $("#resultValue").html(roi.toFixed(2) + '% ROI');
}

function goToResult() {
    $("#CalcBox").slideUp();
    $("#ResultBox").slideDown();
}

function goToError() {
    $("#CalcBox").slideUp();
    $("#ErrorBox").slideDown();
}

function goToCalcBox(error) {
    if (error) {
        showInfoToast('Either the numbers you used are<br> not correct or the business<br> is not doing enough business <br>currently to show the correct ROI.');
        $("#ErrorBox").slideUp();
        $("#CalcBox").slideDown();
    } else {
        $("#ResultBox").slideUp();
        $("#CalcBox").slideDown();
    }
}

function showInfoToast(message) {
    $().toastmessage('showToast', {
        text: message,
        sticky: false,
        type: 'info',
        position: 'top-right',
        stayTime: 8000
    });
}

function showErrorToast(message) {
    $().toastmessage('showToast', {
        text: message,
        sticky: false,
        type: 'error',
        position: 'top-right',
        stayTime: 8000
    });
}