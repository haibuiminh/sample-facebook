$(document).ready(function() {
  const handleChangeFile = event => {
    const files = event.target.files;
    const preview = $('#detail-preview-image');
    if (files) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.attr('src', e.target.result);
      }
      reader.readAsDataURL(files[0]);
    }
  };

  async function handleUpdateNewAvatar() {
    console.log('user click to update data');
    const email = localStorage.getItem('email');
    const fileData = $('#detail-upload-image').prop('files')[0];

    if (email && fileData) {
      const formData = new FormData();
      formData.append('email', email);
      formData.append('image', fileData);

      try {
        const res = await $.ajax({
          url: 'apis/users/updateAvatar.php',
          dataType: 'text',
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          type: 'POST' 
        });
        if (res) {
          fetchUserDetail();
          fetchPostOfUserWithEmail();
        }
      } catch (err) {
        console.error(err);
      }
    }
  }

  const fetchUserDetail = async () => {
    const url = new URL(window.location.href);
    const currentUserEmail = localStorage.getItem('email');
    const email = url.searchParams.get('email');
    if (!email) {
      return;
    }
    try {
      const res = await $.ajax({
        url: `apis/users/getUserDetailByEmail.php?email=${email}`,
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        type: 'GET'
      });
      if (res) {
        const jsonRes = JSON.parse(res);
        const userImage = jsonRes.user_image;
        const detailAvatar = $('#detail-avatar');
        if (currentUserEmail === email) {
          const card = `
          <div class="card" style='margin: 10px;'>
            <div class="card-body">
              <div id="uploadForm">
                <div class="col-md-12 bg-light mb-2 text-center">
                  <div id="targetLayer">
                    <img id='detail-preview-image' src='./userImages/${userImage}' alt='avatar' style='height: 200px; max-width: 200px;'/>
                  </div>
                </div>
                <div class="form-group">
                  <input id='detail-upload-image' accept='image/*' name="userImage" type="file" class="form-controller" style='display: inherit;'/>
                </div>
                <button type="submit" value="Update" class="btn btn-success" id='btn-detail-upload'>Update</button>
              </div>
              </div>
            </div>
            <h2 style='text-align: center;'>${jsonRes.firstname} ${jsonRes.lastname}</h2>
          </div>`;
          detailAvatar.append(card);
          $('#btn-detail-upload').on('click', handleUpdateNewAvatar);
          $('#detail-upload-image').on('change', handleChangeFile);
        } else {
          const onlyViewCard = `
          <div class="card" style='margin: 10px;'>
            <div class="card-body">
              <div id="uploadForm">
                <div class="col-md-12 bg-light mb-2 text-center">
                  <div id="targetLayer">
                    <img src='./userImages/${userImage}' alt='avatar' />
                  </div>
                </div>
              </div>
              </div>
            </div>
            <h2 style='text-align: center;'>${jsonRes.firstname} ${jsonRes.lastname}</h2>
          </div>`;
          detailAvatar.append(onlyViewCard);
        }
        $('#detail-wrapper-background').css('background-image', `url(./cover/${jsonRes.cover})`);
        $('#detail-wrapper-background').css('background-repeat', 'no-repeat');
        $('#detail-wrapper-background').css('background-size', '1300px 340px');
        $('#detail-wrapper-background').css('background-position', 'left 100px top 0');
      }
    } catch (err) {
      console.error(err);
    }
  }

  const fetchPostOfUserWithEmail = async () => {
    const url = new URL(window.location.href);
    const email = url.searchParams.get('email');
    if (!email) {
      return;
    }
    try {
      const res = await $.ajax({
        url: `apis/posts/getPostOnlyFromUser.php?email=${email}`,
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        type: 'GET'
      });
      const content = $('#detail-post-content');
      content.empty();
      const jsonRes = JSON.parse(res);
      if (jsonRes.length) {
        jsonRes.forEach(item => {
          const row = `
            <div class='row'>
              <div class="card" style='margin-top: 20px; width: 100%;'>
                <div class='row' style="padding: 20px 40px;" style="align-items: center;">
                  <img src="./userImages/${item.user_image}" style="height: 40px;" class="mr-4" alt="userImage">
                  <a href="detail.php?email=${item.email}"><h3 style="margin-top: 5px;">${item.firstname} ${item.lastname}</h3></a>
                  <div style='margin-top:13px; margin-left: 10px'>${item.post_date}</div>
                </div>
                <div class='row' style="padding: 20px 40px;">${item.content}</div>
                <img src="./postImages/${item.post_image}" class="card-img" alt="post1">
              <div class="col-sm-2"></div>
            </div>`;
          content.append(row);
        })
      }
    } catch (err) {
      console.error(err);
    }
  }



  fetchUserDetail();
  fetchPostOfUserWithEmail();
});
