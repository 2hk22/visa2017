  $(document).ready(function() {
    $('#admin_merchant-add').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            code: {
                validators: {
                    stringLength: {
                        min: 3,
                        max: 5,
                        message: 'Merchant Code In Uppercase 3 to 5 Character'
                    },
                    stringCase: {
                        message: 'Merchant Code in uppercase',
                        'case': 'upper'
                    },
                    notEmpty: {
                        message: 'Please Fill name'
                    }

                }
            },
            name: {
                    notEmpty: {
                        message: 'Please Fill name'
                    }
            },
            country: {
                    notEmpty: {
                        message: 'Please Select Zone'
                    }
            },
        }
     })

});

