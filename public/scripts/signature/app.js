$(function () {

    //Attach and activate jSignature and set stroke counter to 0
    init();

    $("#generate").on("click", function () {
        //On button click, convert image to base64 encoded string
        RenderSignatureToString();
    });

    $("#reset").on("click", function () {
        //On button click, convert image to base64 encoded string
        ResetSignature();
    });

    $("#reset2").on("click", function () {
        //On button click, convert image to base64 encoded string
        ResetSignature2();
    });

    //Listen for the change event, to count strokes for validation
    $("#signature").live("change", function (e) {
        UpdateStrokeCount();
        RenderSignature1ToString();
    });

    $("#signature2").live("change", function (e) {
        UpdateStrokeCount2();
        RenderSignature2ToString();
    });

});

function init()
{
	$("#signature").jSignature();
	$("#strokes").val(0);

	$("#signature2").jSignature();
	$("#strokes2").val(0);
}

function RenderSignature1ToString(){
	var data = $("#signature").jSignature("getData");
	$("#output").val(data);
	$("#hf_EncodedSig1").val(data);	    		

	return true;
}

function RenderSignature2ToString() {    
    var data2 = $("#signature2").jSignature("getData");
    $("#output2").val(data2);
    $("#hf_EncodedSig2").val(data2);

    return true;
}

function ResetSignature() {
	//Resetting jSignature fires a change event, so start at -1 instead of 0
	$("#strokes").val(-1);
	$("#output").val("");
	$("#hf_EncodedSig1").val("");	    	
	$("#signature").jSignature("reset");	
}

function UpdateStrokeCount() {
	var strokeCount = parseInt($("#strokes").val());
	strokeCount++;
	$("#strokes").val(strokeCount);
}


function ResetSignature2() {
    //Resetting jSignature fires a change event, so start at -1 instead of 0
    $("#strokes2").val(-1);
    $("#output2").val("");
    $("#hf_EncodedSig2").val("");	    	
    $("#signature2").jSignature("reset");
}

function UpdateStrokeCount2() {
    var strokeCount = parseInt($("#strokes2").val());
    strokeCount++;
    $("#strokes2").val(strokeCount);
}