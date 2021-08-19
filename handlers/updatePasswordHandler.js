$(document).ready(function() {
  $('#identicalForm').bootstrapValidator();

  const handleUpdatePassword = async () => {
    const email = localStorage.getItem('email');
    const password = $('#input-password1').val();
    const rePassword = $('#input-password2').val();
    if (rePassword === password) {
      try {
        const dataForm = new FormData();
        dataForm.append('email', email);
        dataForm.append('password', password);
        const res = await $.ajax({
          processData: false,
          contentType: false,
          type: 'POST',
          dataType: 'json',
          url: 'apis/mail/update_password.php',
          cache : false,
          data: dataForm
        });
    
        $('valid-change-toast').toast('show');
        $('#input-password1').val("");
        $('#input-password2').val("");
      } catch (err) {
        console.error('ERROR:', err);
      }
    }
  }
  $('#update-password-btn').on('click', handleUpdatePassword);
});