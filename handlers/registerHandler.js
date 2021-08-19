const submitRegisterForm = async (e) => {
  e.preventDefault();
  const firstname = $("#firstname").val();
  const lastname = $("#lastname").val();
  const email = $("#email").val();
  const verifyEmail = $("#remail").val();
  const password = $("#password").val();
  const male = $("#male:checked").val();
  const female = $("#female:checked").val();
  const gender = male || female;
  const birthday = $("#birthday").val();

  const dataForm = new FormData();
  dataForm.append('firstname', firstname);
  dataForm.append('lastname', lastname);
  dataForm.append('email', email);
  dataForm.append('password', password);
  dataForm.append('gender', gender);
  dataForm.append('birthday', birthday);

  if ((email === verifyEmail) && firstname && lastname && email && password && birthday && gender) {
    try {
      const res = await $.ajax({
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json',
        url: `apis/users/create.php`,
        data: dataForm,
        cache : false,
      });
      if (res) {
        $('#successful-register-toast').toast('show');
        $("#firstname").val("");
        $("#lastname").val("");
        $("#email").val("");
        $("#remail").val("");
        $("#password").val("");
        $("#birthday").val("");
      }
    } catch (e) {
      console.error(e);
      $('#invalid-register-toast').toast('show');  
    }
  } else {
    $('#invalid-register-toast').toast('show');
  }
};

$('#register-form').on('submit', submitRegisterForm);
