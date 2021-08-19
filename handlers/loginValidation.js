const validationLoginForm = async () => {
  // e.preventDefault();
  const email = $('#login-email').val();
  const password = $('#login-password').val();
  
  if (!email || !password) {
    $('#invalid-login-toast').toast('show');
  } else {
    const dataForm = new FormData();
    dataForm.append('email', email);
    dataForm.append('password', password);
    try {
      const res = await $.ajax({
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json',
        url: `apis/users/verifyUser.php`,
        data: dataForm,
        cache : false,
      });
      if (!res) {
        $('#invalid-login-toast').toast('show');
      } else {
        localStorage.setItem('email', email);
        $('#login-form').submit();
      }
    } catch (err) {
      $('#invalid-login-toast').toast('show');
    }
  }
}
