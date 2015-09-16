$(document).ready(function() {

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
