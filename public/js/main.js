var tDollarSavings = 0, tUsers = 0;

addToHomescreen();

/mobi/i.test(navigator.userAgent) && !location.hash && setTimeout(function () {
	if (!pageYOffset) window.scrollTo(0, 1);
}, 1000);

//setTimeout(refreshCounter(), 6000);


function setCounterValue(totalDollarSavings, totalActiveMember) {
	
	$(document).ready(function () {
		if (navigator.platform == 'iPad' || navigator.platform == 'iPhone' || navigator.platform == 'iPod') {
			$(".bottomTab").css("position", "static");
		};

		$("#counter").flipCounter(
			"startAnimation", // scroll counter from the current number to the specified number
			{
				// number: tDollarSavings, // the number we want to scroll from                    
				end_number: totalDollarSavings, // the number we want the counter to scroll to
				easing: false, // this easing function to apply to the scroll.
				duration: 3000, // number of ms animation should take to complete
				imagePath: "Images/flipCounter-medium.png", // the path to the sprite image relative to your html document                
				onAnimationStarted: false, // the function to call when animation starts
				onAnimationStopped: false, // the function to call when animation stops
				onAnimationPaused: false, // the function to call when animation pauses
				onAnimationResumed: false // the function to call when animation resumes from pause
			}
		);


		$("#counterMember").flipCounter(
				"startAnimation", // scroll counter from the current number to the specified number
				{
					// number: tUsers, // the number we want to scroll from                    
					end_number: totalActiveMember, // the number we want the counter to scroll to
					easing: true, // this easing function to apply to the scroll.
					duration: 3000, // number of ms animation should take to complete
					imagePath: "Images/flipCounter-medium.png", // the path to the sprite image relative to your html document                
					onAnimationStarted: false, // the function to call when animation starts
					onAnimationStopped: false, // the function to call when animation stops
					onAnimationPaused: false, // the function to call when animation pauses
					onAnimationResumed: false // the function to call when animation resumes from pause
				}
		);

		tDollarSavings = Math.round(totalDollarSavings);
		tUsers = Math.round(totalActiveMember);
	});

}


function setCounterValueAndCloseDefineUserLocation(totalDollarSavings, totalActiveMember) {
	
	$(document).ready(function () {
		if (navigator.platform == 'iPad' || navigator.platform == 'iPhone' || navigator.platform == 'iPod') {
			$(".bottomTab").css("position", "static");
		};

		console.log(tDollarSavings)

// 		$("#counter").flipCounter(
// 		"startAnimation", // scroll counter from the current number to the specified number
// 		{
// 			number: tDollarSavings, // the number we want to scroll from                    
// 			end_number: totalDollarSavings, // the number we want the counter to scroll to
// 			easing: false, // this easing function to apply to the scroll.
// 			duration: 2000, // number of ms animation should take to complete
// 			imagePath: "Images/flipCounter-medium.png", // the path to the sprite image relative to your html document                
// 			onAnimationStarted: false, // the function to call when animation starts
// 			onAnimationStopped: false, // the function to call when animation stops
// 			onAnimationPaused: false, // the function to call when animation pauses
// 			onAnimationResumed: false // the function to call when animation resumes from pause
// 		}
// );


// 		$("#counterMember").flipCounter(
// 				"startAnimation", // scroll counter from the current number to the specified number
// 				{
// 					number: tUsers, // the number we want to scroll from                    
// 					end_number: totalActiveMember, // the number we want the counter to scroll to
// 					easing: true, // this easing function to apply to the scroll.
// 					duration: 2000, // number of ms animation should take to complete
// 					imagePath: "Images/flipCounter-medium.png", // the path to the sprite image relative to your html document                
// 					onAnimationStarted: false, // the function to call when animation starts
// 					onAnimationStopped: false, // the function to call when animation stops
// 					onAnimationPaused: false, // the function to call when animation pauses
// 					onAnimationResumed: false // the function to call when animation resumes from pause
// 				}
// 		);

		// tDollarSavings = Math.round(totalDollarSavings);
		// tUsers = Math.round(totalActiveMember);
	});

	closeDefineUserLocation();
}

function setCounterValueAndOpenDefineUserLocation(totalDollarSavings, totalActiveMember) {

	$(document).ready(function () {
		if (navigator.platform == 'iPad' || navigator.platform == 'iPhone' || navigator.platform == 'iPod') {
			$(".bottomTab").css("position", "static");
		};

		console.log(tDollarSavings)

		// $("#counter").flipCounter(
		// 	"startAnimation", // scroll counter from the current number to the specified number
		// 	{
		// 		number: tDollarSavings, // the number we want to scroll from                    
		// 		end_number: totalDollarSavings, // the number we want the counter to scroll to
		// 		easing: false, // this easing function to apply to the scroll.
		// 		duration: 5000, // number of ms animation should take to complete
		// 		imagePath: "Images/flipCounter-medium.png", // the path to the sprite image relative to your html document                
		// 		onAnimationStarted: false, // the function to call when animation starts
		// 		onAnimationStopped: false, // the function to call when animation stops
		// 		onAnimationPaused: false, // the function to call when animation pauses
		// 		onAnimationResumed: false // the function to call when animation resumes from pause
		// 	}
		// );


		// $("#counterMember").flipCounter(
		// 	"startAnimation", // scroll counter from the current number to the specified number
		// 	{
		// 		number: tUsers, // the number we want to scroll from                    
		// 		end_number: totalActiveMember, // the number we want the counter to scroll to
		// 		easing: true, // this easing function to apply to the scroll.
		// 		duration: 5000, // number of ms animation should take to complete
		// 		imagePath: "Images/flipCounter-medium.png", // the path to the sprite image relative to your html document                
		// 		onAnimationStarted: false, // the function to call when animation starts
		// 		onAnimationStopped: false, // the function to call when animation stops
		// 		onAnimationPaused: false, // the function to call when animation pauses
		// 		onAnimationResumed: false // the function to call when animation resumes from pause
		// 	}
		// );

		// tDollarSavings = Math.round(totalDollarSavings);
		// tUsers = Math.round(totalActiveMember);
	});

	openDefineUserLocation();
}

function refreshCounter(){
	$.ajax({
		url : '/ajax/gettotal',
		type : 'get',
		dataType : 'json',
		success: function(data){
			setCounterValue(data.totalSavings, data.totalUsers);
		}
	});
}

$(document).ready(function(){
	setCounterValue(tDollarSavings, tUsers);
	setInterval(refreshCounter, 10000);
});