$(document).ready(function(){
    

     $("form#submitsurveyForm").validate({
            rules: {
                company_phone_1: {
                    digits: true,
                    required: true,
                    minlength: 10,
                    maxlength: 15
                },
                tel: {
                    required: true
                },
                email: {
                    required: true,
                    email: true},
                "communication_1[]": { 
                    required: false, 
                     minlength: 1 },
                standard_1: "required"
            }
               
        });

        
    
});
