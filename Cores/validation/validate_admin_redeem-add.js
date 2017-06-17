  $(document).ready(function() {

    $('#validate_admin_redeem-add').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            code: {
                validators: {
                    notEmpty: {
                        message: 'Please Select Merchant'
                    }
                }
            },
            name: {
                    notEmpty: {
                        message: 'Please Fill name'
                    }
            },
            description: {
                    notEmpty: {
                        message: 'Please Fill description'
                    }
            },
            amount: {
                    integer: {
                        message: 'Please Fill Integer Value ex. 1,2,3...'
                    },
                    notEmpty: {
                        message: 'Please Fill Your Limit'
                    }
            },
            crireria: {
                    integer: {
                        message: 'Please Fill Integer Value ex. 1,2,3...'
                    },
                    notEmpty: {
                        message: 'Please Fill Your Limit'
                    }
            },
            type: {
                validators: {
                    notEmpty: {
                        message: 'Please Select Gift Type'
                    }
                }
            },
            wp_code: {
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
            terms: {
                    validators: {
                        notEmpty: {
                            message: 'Term isrequired and cannot be empty'
                        }
                    }
                }
            }
        })


        });



