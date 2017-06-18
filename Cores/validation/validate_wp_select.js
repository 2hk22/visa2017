  $(document).ready(function() {
    $('#wp_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            'wp_check[]': {
                validators: {
                    notEmpty: {
                        message: 'Please Select Your Country'
                    }
                }
            },
           }
        })

});

