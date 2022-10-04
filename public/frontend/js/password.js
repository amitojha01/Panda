// password combinations
$('#password').on('keyup', function(){
    var special = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    var upr = /[A-Z]/;
    var lwr = /[a-z]/;
    var number = /[0-9]/;
    
    var inputs = $(this).val();
    
    if(special.test(inputs)){
        $('#mp-symbol').prop('checked', true);
    }else{
        $('#mp-symbol').prop('checked', false);
    }
    if(upr.test(inputs)){
        $('#mp-upper').prop('checked', true);
    }else{
        $('#mp-upper').prop('checked', false);
    }
    if(lwr.test(inputs)){
        $('#mp-lower').prop('checked', true);
    }else{
        $('#mp-lower').prop('checked', false);
    }
    if(number.test(inputs)){
        $('#mp-number').prop('checked', true);
    }else{
         $('#mp-number').prop('checked', false);
    }
    if(inputs.length >= 8){
        $('#mp-len').prop('checked', true);
    }else{
        $('#mp-len').prop('checked', false);
    }
})