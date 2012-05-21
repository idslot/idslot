// 1 - START DROPDOWN SLIDER SCRIPTS ------------------------------------------------------------------------

$(document).ready(function () {
    $(".showhide-account").click(function () {
        $(".account-content").slideToggle("fast");
        $(this).toggleClass("active");
        return false;
    });
});

$(document).ready(function () {
    $(".action-slider").click(function () {
        $("#actions-box-slider").slideToggle("fast");
        $(this).toggleClass("activated");
        return false;
    });
});

//  END ----------------------------- 1

// 2 - START LOGIN PAGE SHOW HIDE BETWEEN LOGIN AND FORGOT PASSWORD BOXES--------------------------------------

$(document).ready(function () {
	$(".forgot-pwd").click(function () {
	$("#loginbox").hide();
	$("#forgotbox").show();
	$("#registerbox").hide();
	window.location.hash = '#forgot';
	document.title = forgot_title;
	return false;
	});

});

$(document).ready(function () {
	$(".back-login").click(function () {
	$("#loginbox").show();
	$("#forgotbox").hide();
	$("#registerbox").hide();
	window.location.hash = '#login';
	document.title = login_title;
	return false;
	});
});

$(document).ready(function () {
	$(".register").click(function () {
	$("#registerbox").show();
	$("#loginbox").hide();
	$("#forgotbox").hide();
	window.location.hash = '#register';
	document.title = register_title;
	return false;
	});
});

var check_auth_hash = function () {
    if(window.location.hash){
	var hash = window.location.hash;
    } else {
	var hash = '#login';
    }
    // if there is not any element for this hash
    if($(hash + "box").length == 0){
	var hash = '#login';
    }
    $("#registerbox").hide();
    $("#loginbox").hide();
    $("#forgotbox").hide();
    $(hash + "box").show();
    window.location.hash = hash;

    if (hash == '#forgot') document.title = forgot_title;
    else if (hash == '#login') document.title = login_title;
    else if (hash == '#register') document.title = register_title;
}

// END ----------------------------- 2



// 3 - MESSAGE BOX FADING SCRIPTS ---------------------------------------------------------------------

$(document).ready(function() {
	$(".close-yellow").click(function () {
		$("#message-yellow").fadeOut("slow");
	});
	$(".close-red").click(function () {
		$("#message-red").fadeOut("slow");
	});
	$(".close-blue").click(function () {
		$("#message-blue").fadeOut("slow");
	});
	$(".close-green").click(function () {
		$("#message-green").fadeOut("slow");
	});
});

// END ----------------------------- 3



// 4 - CLOSE OPEN SLIDERS BY CLICKING ELSEWHERE ON PAGE -------------------------------------------------------------------------

$(document).bind("click", function (e) {
    if (e.target.id != $(".showhide-account").attr("class")) $(".account-content").slideUp();
});

$(document).bind("click", function (e) {
    if (e.target.id != $(".action-slider").attr("class")) $("#actions-box-slider").slideUp();
});
// END ----------------------------- 4
 
 
 
// 5 - TABLE ROW BACKGROUND COLOR CHANGES ON ROLLOVER -----------------------------------------------------------------------
/*
$(document).ready(function () {
    $('#product-table	tr').hover(function () {
        $(this).addClass('activity-blue');
    },
    function () {
        $(this).removeClass('activity-blue');
    });
});
 */
// END -----------------------------  5
 
 
 
 // 6 - DYNAMIC YEAR STAMP FOR FOOTER -----------------------------------------------------------------------

 $('#spanYear').html(new Date().getFullYear()); 
 
// END -----------------------------  6 
  

$(document).ready(function(){
    $(".required").each(function(){
        $(this).attr('title', ($(this).attr('title')?$(this).attr('title')+'<br>':'')+required);
    });
});