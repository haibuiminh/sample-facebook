let myTimer = null;
let isHomeOpenChat = false;

const handleCreatePost = (e) => {
  e.preventDefault();
  const email = localStorage.getItem('email');
  if (!email) {
    return;
  }

  const formData = new FormData();
  formData.append('email', email);
  if ($('#file').prop('files')) {
    const fileData = $('#file').prop('files')[0];
    
    const type = fileData && fileData.type;
    
    const match = ["image/gif", "image/png", "image/jpg", "image/jpeg"];
    if (match.indexOf(type)) {
      formData.append('image', fileData);
    }
  }
  
  const content = $('#content').val();
  formData.append('content', content);
  try {
    const res = $.ajax({
      url: 'apis/posts/create.php',
      dataType: 'text',
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: 'POST' 
    });
    if (res) {
      fetchPost();
      $('#successful-register-toast').toast('show');
    }

  } catch (err) {
    console.error(e);
    $('#invalid-register-toast').toast('show');  
  }
};

const fetchPost = async () => {
  const email = localStorage.getItem('email');
  if (email) {
    try {
      const res = await $.ajax({
        processData: false,
        contentType: false,
        type: 'GET',
        dataType: 'json',
        url: `apis/posts/getPostByUser.php?email=${email}`,
        cache : false,
      });
      const content = $('#row-posts');
      content.empty();
      
      res.forEach(item => {
        const image = item.post_image ? `<img src="./postImages/${item.post_image}" class="card-img" alt="post1">` : '';
        const row = `
        <div class='row'>
          <div class="col-sm-2"></div>
            <div class='col-sm-8'>
              <div class="card" style='margin-top: 20px;'>
                <div class='row' style="padding: 20px 40px;" style="align-items: center;">
                  <img src="./userImages/${item.user_image}" style="height: 40px;" class="mr-4" alt="userImage">
                  <a href="detail.php?email=${item.email}"><h3 style="margin-top: 5px;">${item.firstname} ${item.lastname}</h3></a>
                  <div style='margin-top:13px; margin-left: 10px'>${item.post_date}</div>
                </div>
                <div class='row' style="padding: 20px 40px;">${item.content}</div>
                ${image}
              </div>
            </div>
          <div class="col-sm-2"></div>
        </div>`;
       content.append(row);
      });
    } catch (err) {
      console.error(err);
    }
  }
};

function openChatWindow(event) {
  isHomeOpenChat = true;
  const { user } = event.data;
  const { email } = user;
  
  localStorage.setItem('emailTo', email);
  fetchMessage(user.email);
}

const closeWindow = () => {
  isHomeOpenChat = false;
  if (myTimer) {
    clearInterval(myTimer);
  }
  const content = $('#list-chat-windows');
  content.empty();
};

const fetchFriends = async () => {
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
  
      const content = $('#list-friends');
      content.empty();
      
      res.forEach(item => {
        const row = `
        <li id='user-chat-${item.id}' class='list-group-item list-group-item-action' key='${item.email}'>
          <img src='userImages/${item.user_image}' height='32px' alt='${item.id}'/>
          <span style='margin-left: 10px'>${item.firstname} ${item.lastname}</span>
        </li>`;
       content.append(row);
       $(`#user-chat-${item.id}`).on('click', { user: item }, openChatWindow);
      });
    } catch (err) {
      console.log(err);
    }
  }
};

const sendMessageByKey = (e) => {
  if (e.key === 'Enter') {
    e.preventDefault();
    sendMessage()
  }
}

const fetchMessage = async (emailTo) => {
  const email = localStorage.getItem('email');
  
  if (email && emailTo) {
    try {
      const [resMessage, resUserInfo] = await Promise.all([
        $.ajax({
          processData: false,
          contentType: false,
          type: 'GET',
          dataType: 'json',
          url: `apis/messages/getMessageByUserId.php?emailFrom=${email}&emailTo=${emailTo}`,
          cache : false,
        }),
        $.ajax({
          processData: false,
          contentType: false,
          type: 'GET',
          dataType: 'json',
          url: `apis/users/getUserDetailByEmail.php?email=${emailTo}`,
          cache : false,
        })
    ]);
      let messageList = '';
      resMessage.forEach(message => {
        const justifyContent = message.user_id_to !== resUserInfo.id ? 'flex-start' : 'flex-end';
        const background = message.user_id_to !== resUserInfo.id ? 'white' : '#6c757d';
        const color = message.user_id_to !== resUserInfo.id ? 'black' : 'white';
        const image = message.message_image ? `<div style='display: flex; justify-content: ${justifyContent}'><img style='height: 100px;' src='messageImages/${message.message_image}' alt='message'/> </div>` : '';
        const row = `<div title='${message.createdAt}' style='display: flex; justify-content: ${justifyContent};'>
          <span style='padding: 10px; background: ${background}; color: ${color};'>${message.message}</span>
        </div>
        ${image}
        `;
        messageList += row;
      });


      const content = $('#list-chat-windows');
      content.empty();
      const keyId = [ ...email.split('@'), ...emailTo.split('@')].join();
      const card = `
        <li id="${keyId}" class="card" style="width: 20rem; height: 450px;">
          <div style='display: flex; flex-direction: row; justify-content: space-between; background: #3d5b99; color: white; padding: 10px; align-items: center;'>
            <div class='row' style="margin: 0; align-items: center;">
              <img style='height: 32px; width: 32px;' src="./userImages/${resUserInfo.user_image}" alt="user-image">
              <a href='#' style='margin-left: 10px; color: white;'>${resUserInfo.firstname} ${resUserInfo.lastname}</a>
            </div>
            <svg onclick="closeWindow()" style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
            </svg>
          </div>
          <div class="card-body" id='message-content' style='display: flex; flex-direction: column-reverse; color: black; height: 300px; overflow: auto;'>
            ${messageList}
          </div>
          <form style='display: flex; padding: 5px;'>
            <div style='width: 100%;'>
              <input type="text" class="form-control" id="input-message" placeholder="Type here ...">
              <label class="btn btn-warning">Select Image
                <input type="file" name="message-upload-image" size="30" id="message-upload-image">
              </label>
            </div>  
            <button id='send-message-button' type="button" class="btn btn-primary" style='height: 40px;'>Send</button>
          </form>
        </li>`;
      
      content.append(card);
      $('#input-message').on('keydown', sendMessageByKey)
      $('#send-message-button').on('click', sendMessage);
    } catch (err) {
      console.error(err);
    }
  }
};

const sendMessage = async () => {
  const contentMessage = $('#input-message').val() || '';
  const emailTo = localStorage.getItem('emailTo');
  const emailFrom = localStorage.getItem('email');
  const fileData = $('#message-upload-image').prop('files')[0];
  
  if (emailFrom && emailFrom && (contentMessage || fileData)) {
    const formData = new FormData();
    formData.append('emailFrom', emailFrom);
    formData.append('emailTo', emailTo);
    formData.append('message', contentMessage);
    if (fileData) {
      const type = fileData.type;
      const match = ["image/gif", "image/png", "image/jpg", "image/jpeg"];
      if (match.includes(type)) {
        formData.append('image', fileData);
      }
    }

    try {
      const res = await $.ajax({
        url: 'apis/messages/create.php',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'POST' 
      });
      if (res) {
        fetchMessage(emailTo);
      }
    } catch (err) {
      console.error(err);
    }
  }
};

const handleFocus = () => {
  if (myTimer) {
    clearInterval(myTimer);
  }
  if (isHomeOpenChat) {
    const emailTo = localStorage.getItem('emailTo');
    fetchMessage(emailTo);
    myTimer = setInterval(() => {
      const emailTo = localStorage.getItem('emailTo');
      fetchMessage(emailTo);
    }, 7000);
  }
};

const handleBlur = () => {
  if (myTimer) {
    clearInterval(myTimer);
  }
  if (isHomeOpenChat) {
    myTimer = setInterval(() => {
      const emailTo = localStorage.getItem('emailTo');
      fetchMessage(emailTo);
    }, 1500);
  }
};

$(document).ready((e) => {
  console.log('fetch post?');
  fetchPost();
  fetchFriends();
  $('#post-form').on('submit', handleCreatePost);
  window.addEventListener('focus', handleFocus);
  window.addEventListener('blur', handleBlur);
});

