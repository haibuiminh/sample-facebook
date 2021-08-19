const fetchUserInfo = async () => {
  const email = localStorage.getItem('email');
  if (email) {
    try {
      const res = await $.ajax({
        processData: false,
        contentType: false,
        type: 'GET',
        dataType: 'json',
        url: `apis/users/getUserDetailByEmail.php?email=${email}`,
        cache : false,
      });
  
      const info = $('#userInformation');
      info.empty();
      info.append(res.firstname);
      info.append(' ');
      info.append(res.lastname);
    } catch (err) {
      console.log(err);
    }
  }
};

$(document).ready(() => {
  fetchUserInfo();
});