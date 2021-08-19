
$(document).ready((e) => {
  const handleClickUnfollowPeople = async (event) => {
    console.log('click heree');
    const { userFollowEmail } = event.data;

    const dataForm = new FormData();
    const email = localStorage.getItem('email');
    dataForm.append('emailView', email);
    dataForm.append('emailOwner', userFollowEmail);

    try {
      const res = await $.ajax({
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json',
        url: 'apis/relations/deleteRelation.php',
        cache : false,
        data: dataForm
      });
      if (res) {
        findFriends("");
        getFollowFriends();
      }
    } catch (err) {
      console.error(err)
    }
  };


  const getFollowFriends = async () => {
    const email = localStorage.getItem('email');
    if (email) {
      try {
        const res = await $.ajax({
          processData: false,
          contentType: false,
          type: 'GET',
          dataType: 'json',
          url: `apis/relations/getRelations.php?email=${email}`,
          cache : false,
        });
        console.log('res', res);
        const content = $('#row-follow-list');
        content.empty();
        content.append(`<h2 style='margin-left: 100px; margin-top: 10px; margin-right: 10px;'>Your Friends</h2>`)
        res.forEach(item => {
          const row = `
          <div class='row'>
            <div class='col-sm-1'></div>
            <div class='col-sm-10'>
              <div class="media" style='padding: 10px; margin-bottom: 20px; background: white;'>
                  <img src="./userImages/${item.user_image}" class="align-self-center mr-3" alt="${item.email}" style="height: 100px">
                  <div class="media-body">
                    <h3>${item.firstname} ${item.lastname}</h3>
                    <p>${item.email}</p>
                  </div>
                  <button id="btn-unfollow-${item.id}" type="button" class="btn btn-danger">Unfollow</button>
                </div>
              </div>
            <div class='col-sm-1'></div>
          </div>
          `;
          content.append(row);
          $(`#btn-unfollow-${item.id}`).on('click', { userFollowEmail: item.email }, handleClickUnfollowPeople);

        });
      } catch (err) {
        console.error(err);
      } 
    }
  }

  const handleClickFollowPeople = async (event) => {
    const { userFollowEmail } = event.data;

    const dataForm = new FormData();
    const email = localStorage.getItem('email');
    dataForm.append('emailView', email);
    dataForm.append('emailOwner', userFollowEmail);

    try {
      const res = await $.ajax({
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json',
        url: 'apis/relations/create.php',
        cache : false,
        data: dataForm
      });
      if (res) {
        findFriends("");
        getFollowFriends();
      }
    } catch (err) {
      console.error(err)
    }
  };

  const findFriends = async (searchKey = "") => {
    const currentUserEmail = localStorage.getItem('email');
    if (currentUserEmail) {
      try {
        const res = await $.ajax({
          processData: false,
          contentType: false,
          type: 'GET',
          dataType: 'json',
          url: `apis/users/findFriends.php?search=${searchKey}&currentUserEmail=${currentUserEmail}`,
          cache : false,
        });
        const content = $('#row-friends-list');
        content.empty();
        content.append(`<h2 style='margin-left: 100px; margin-top: 10px; margin-right: 10px;'>You can know them</h2>`)
        res.forEach(item => {
          const row = `
          <div class='row'>
            <div class='col-sm-1'></div>
            <div class='col-sm-10'>
              <div class="media" style='padding: 10px; margin-bottom: 20px; background: white;'>
                  <img src="./userImages/${item.user_image}" class="align-self-center mr-3" alt="${item.email}" style="height: 100px">
                  <div class="media-body">
                    <h3>${item.firstname} ${item.lastname}</h3>
                    <p>${item.email}</p>
                  </div>
                  <button id="btn-follow-${item.id}" type="button" class="btn btn-success">Follow</button>
                </div>
              </div>
            <div class='col-sm-1'></div>
          </div>
          `;
          content.append(row);
          $(`#btn-follow-${item.id}`).on('click', { userFollowEmail: item.email }, handleClickFollowPeople);

        });
      } catch (err) {
        console.log(err);
      }
    }
  };

  findFriends();
  getFollowFriends();
});