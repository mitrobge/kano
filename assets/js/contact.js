$(document).ready(function(){
    

     $("form#f1").validate({
            rules: {
                company_phone_1: {
                    digits: true,
                    required: true,
                    minlength: 10,
                    maxlength: 15
                },
                company_responsible_1: {
                    required: true
                },
                company_email_1: {
                    required: false,
                    email: true},
                "communication_1[]": { 
                    required: false, 
                     minlength: 1 },
                standard_1: "required"
            }
               
        });

        $("form#f2").validate({
            
            
            rules: {
                "field_2[]": { 
                    required: true, 
                     minlength: 1 },
                company_email_2: {
                    required: false,
                    email: true},
                company_responsible_2: "required",
                company_phone_2: {
                    digits: true,
                    required: true,
                    minlength: 10,
                    maxlength: 15
                }
            }
               // errorElement: 'div' // This is to override the label w/ a div
        });
        
        $("form#f3").validate({
            rules: {
                company_responsible_3: "required",
                company_email_3: {
                    required: false,
                    email: true},
                company_phone_3: {
                    digits: true,
                    required: true,
                    minlength: 10,
                    maxlength: 15
                },
                communication_3: "required"
            }
        });
        
    
});
