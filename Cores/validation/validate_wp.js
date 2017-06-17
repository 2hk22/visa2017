  $(document).ready(function() {
    $('#wp_form').bootstrapValidator({
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

          scaleCaptcha();
          $(window).resize( $.throttle( 100, scaleCaptcha ) );



});

