var CurStory = 1;
var interval = "";
var RegStep = 1;
var tab = 1;
var PassName = false;
var PassMail = false;
var PassPass = false; // derp

function TimedNews() {
	var index = CurStory;
	CurStory++;
	index++;
	$("#buttons a").removeClass("selected");
	$(".article").fadeOut("slow");
	$("#buttons a:nth-child(" + index + ")").addClass("selected");
	index++;
	$(".article:nth-child(" + index + ")").fadeIn("slow");
	if (CurStory >= $('#buttons a').size())
		CurStory = 0;
};

function doNameCheck() {
	name = $(".username").val();
	$.post("ajax/register/name.php", {pseudo: name}, function(data) {
		if( $.trim(data) == "0" ) {
			$(".username").removeClass("green");
			$(".username").addClass("red");
			PassName = false;
		} else {
			$(".username").removeClass("red");
			$(".username").addClass("green");
			PassName = true;
		}
	});
}

function validatePasswords()
{
	if ($('.password').val() == '' || $('.password2').val() == '' || $('.password').val() != $('.password2').val())
	{
		$('.password').removeClass('green');
		$('.password').addClass('red');
		$('.password2').removeClass('green');
		$('.password2').addClass('red');
		PassPass = false;
	}
	else
	{
		$('.password').removeClass('red');
		$('.password').addClass('green');
		$('.password2').removeClass('red');
		$('.password2').addClass('green');
		PassPass = true;
	}
}

function validateEmail()
{
	var x=document.forms["registration"]["email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
		$('.email').removeClass('green');
		$('.email').addClass('red');
	}
	else
	{
		$('.email').removeClass('red');
		$('.email').addClass('green');
	}
}

function validateEmail2()
{
	if ($('.email').val() == '' || $('.email').val() != $('.rep_email').val())
	{
		$('.rep_email').removeClass('green');
		$('.rep_email').addClass('red');
		PassMail = false;
	}
	else
	{
		$('.rep_email').removeClass('red');
		$('.rep_email').addClass('green');
		PassMail = true;
	}
}

$(document).ready(function(){
	interval = setInterval("TimedNews()",6000);
	
	// Like a mother-fucking boss
	$('#buttons a').click(function(event){
		if (!$(event.target).hasClass("active")) {
		var index = $("#buttons a").index(this);
		CurStory = index+1;
		index+=2;
		clearInterval(interval);
		interval = setInterval("TimedNews()",6000);
		$("#buttons a").removeClass("selected");
		$(".article").fadeOut("slow");
		$(event.target).addClass("selected");
		$(".article:nth-child(" + index + ")").fadeIn("slow");
		if (CurStory >= $('#buttons a').size())
			CurStory = 0;
		}
	});
	
	$('.email').keypress(function(e){
		if(e.which == 13){
			validateEmail();
		}
	});

	$('.email').blur(function(e){
		validateEmail();
	});

	$('.rep_email').keypress(function(e){
		if(e.which == 13){
			validateEmail2();
		}
	});

	$('.rep_email').blur(function(e){
		validateEmail2();
	});
	
	$('.password').keypress(function(e){
		if(e.which == 13){
			validatePasswords();
		}
	});
	$('.password').blur(function(e){
		validatePasswords();
	});
	$('.password2').keypress(function(e){
		if(e.which == 13){
			validatePasswords();
		}
	});
	$('.password2').blur(function(e){
		validatePasswords();
	});

	$('.username').keypress(function(e){
		if(e.which == 13){
			doNameCheck();
		}
	});
	$('.username').blur(function(e){
		doNameCheck();
	});
	
	$('.column > .proceed').click(function(event)
	{		
		$("form .column:nth-child(" + RegStep + ")").animate({"left": "-=240px"}, "slow");
		$("form .column:nth-child(" + (RegStep + 1) + ")").animate({"left": "-=240px"}, "slow");
		tab = 2;
	});

	$('.column > .complete').click(function(event)
	{
		validateEmail();
		validateEmail2();
		validatePasswords();
		doNameCheck();
		if (PassName && PassMail && PassPass)
			document.forms["registration"].submit();
		else if (tab == 2)
		{
			$("form .column:nth-child(" + RegStep + ")").animate({"left": "+=240px"}, "slow");
			$("form .column:nth-child(" + (RegStep + 1) + ")").animate({"left": "+=240px"}, "slow");
		}
	});

	$("span.joinnow").click(function(){
		if ($("span.joinnow").hasClass("active"))
		{
			$('.barline').animate({
				height: '40px'
			}, 'slow');
			$('span.joinnow').text('Join now');
			$("span.joinnow").removeClass("active");
			$("span.joinnow").css('background', 'url(img/frontpage/joinnow_arrow.png) no-repeat');
			$("span.joinnow").hover(function(){
				$("span.joinnow").css('background', 'url(img/frontpage/joinnow_arrow_over.png) no-repeat');
			},function(){
				$("span.joinnow").css('background', 'url(img/frontpage/joinnow_arrow.png) no-repeat');
			});
			$('.header').animate({
				height: '250px',
				visibility: 'visible'
			}, 'slow');
		}
		else
		{
			$('.barline').animate({
				height: '264px'
			}, 'slow');
			$('span.joinnow').text('Sign-in');
			$("span.joinnow").addClass("active");
			$("span.joinnow").css('background', 'url(img/frontpage/joinnow_arrow_flip.png) no-repeat');
			$("span.joinnow").hover(function(){
				$("span.joinnow").css('background', 'url(img/frontpage/joinnow_arrow_flip_over.png) no-repeat');
			},function(){
				$("span.joinnow").css('background', 'url(img/frontpage/joinnow_arrow_flip.png) no-repeat');
			});
			$('.header').animate({
				height: '220px',
				visibility: 'hidden'
			}, 'slow');
		}
	});
});