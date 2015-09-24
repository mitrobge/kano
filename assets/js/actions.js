$(document).ready(function() {
     	
    var active = $('#active_lang').val();
     	var lang_url = $('#change').attr('href');
     	if(active=='gr'){
            if (lang_url.toString().indexOf('?') < 0)
                $('#change').attr('href', lang_url+'?lang=en');
            else
                $('#change').attr('href', lang_url+'&lang=en');
     		$('#top_nav li.last a').hover(function(){
	        	$('#lang li.gr').slideUp(0);
	        }, function(){
	        	$('#lang li.gr').slideDown(0);
	        })
     	}else{
            if (lang_url.toString().indexOf('?') < 0)
     		    $('#change').attr('href', lang_url+'?lang=gr');
            else
     		    $('#change').attr('href', lang_url+'&lang=gr');
     		$('#lang li.gr').slideUp(0);
     		$('#top_nav li.last a').hover(function(){

	        	$('#lang li.gr').slideDown(0);
	        }, function(){
	        	
	        	$('#lang li.gr').slideUp(0);
	        })
     	}

    $("#login_btn").fancybox();
		
				$("#change_pass").hide(0);
    
    $("#pass_change").click(function() {
        console.log('ekane klik');
			if($("#pass_change").prop('checked', true)){
				$("#change_pass").show(0);
        console.log('ekane 1');
			}else{
				$("#password_confirm, #password").val("");
				$("#change_pass").hide(0);
        console.log('ekane 2');
			}
		});
    

});
