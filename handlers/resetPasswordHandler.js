$(document).ready(function() {
  $('#emailForm').bootstrapValidator({
    feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      email: {
        validators: {
          notEmpty: 'Please enter your email address'
        },
        emailAddress: {
          message: 'Please enter a valid email address'
        }
      }
    }
  });
});