  $(document).ready(function() {
    $('#redeeem_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            country: {
                validators: {
                    notEmpty: {
                        message: 'Please Select Your Country'
                    }
                }
            },
            spending: {
                validators: {
                    between: {
                            min: 1000,
                            max: 999999999,
                            message: 'your purchase amount is not qualified'
                    },
                    notEmpty: {
                        message: 'Please Fill Your Purchase Amount in THB'
                    },
                    numeric: {
                            message: 'The value is not a number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                    }
                }
            },
            approval_code: {
                validators: {
                     stringLength: {
                        min: 1,
                        max: 6, ////6digit
                        message: 'Please Fill Your Valid Aproval Code'
                    },
                    notEmpty: {
                        message: 'Please Fill Your Aproval Code'
                    }
                }
            },
            captcha: {
                validators:{
                    stringLength: {
                        min: 4,
                        max: 4, ////4digit
                        message: 'Please Fill Your Valid Captcha'
                    },
                    notEmpty: {
                        message: 'Please Fill Your Captcha'
                    },
                    numeric: {
                        message: 'The value is not a number'
                    }
                }
            }
           }
        })


        function scaleCaptcha(elementWidth) {

          var reCaptchaWidth = 304;
            var containerWidth = $('.capcha-container').width();

          if(reCaptchaWidth > containerWidth) {
            var captchaScale = containerWidth / reCaptchaWidth;

            $('.g-recaptcha').css({
              'transform':'scale('+captchaScale+')'
            });
          }
        }


        function checkRecaptcha() {
            res = $('#g-recaptcha-response').val();
            if (res == "" || res == undefined || res.length == 0)
                return false;
            else
                return true;

        }

        scaleCaptcha();
        $(window).resize( $.throttle( 100, scaleCaptcha ) );

        //$('#redeeem_form').submit(function(e) {
        //    if(!checkRecaptcha()) {
        //        $( "#frm-wp-result2" ).addClass('test');
        //        return false;
        //    }
        //});


});s
