// ####################
// ####################
// FORM  VALIDATION
function formValidation(callback) {
  event.preventDefault();
  const form = event.target.form;
  if (form.checkValidity()) callback(form);
}

function passwordValidation() {
  event.preventDefault();
  const form = event.target.form;
  if (form.checkValidity()) return; // error here
}

function postValidation() {
  const textElm = document.querySelector(".post-modal [name='text']");
  const text = textElm.value;
  const imageElm = document.querySelector(".post-modal [name='image']");
  const image = imageElm.value;

  textElm.required = true;
  imageElm.required = true;

  if (!text && !image) return;
  if (image && imageElm.checkValidity() == false) return;
  if (text && textElm.checkValidity() == false) return;

  textElm.required = false;
  imageElm.required = false;
}

function infoValidation() {
  const form = event.target.form;
  const submitter = form.querySelector(".submitter");
  const currentEmail = form.email.dataset.current;
  const currentAlias = form.alias.dataset.current;
  const newEmail = form.email.value;
  const newAlias = form.alias.value;
  const newImage = form.image.value;

  // Nothing is updated
  if (newEmail === currentEmail && newAlias === currentAlias && !newImage) {
    submitter.classList.add("invalid");
    return;
  }
  submitter.classList.remove("invalid");
}

// ####################
// ####################
// API REQUESTS
async function postUser(form) {
  const res = await fetch("/users", {
    method: "POST",
    body: new FormData(form),
  });
  if (res.status != 200) {
    const err = await res.json();
    console.log(err);
    return;
  }
  // SUCCES redir to frontpage
  window.location.href = "/";
}

async function updateUserInfo() {
  event.preventDefault();
  const form = event.target.form;
  const alias = form.alias.value;

  const formData = new FormData(form);
  if (!form.image.value) formData.delete("image");

  const res = await fetch(`/users/update/info`, {
    method: "POST",
    body: formData,
  });

  if (res.status == 204) return;

  if (res.status !== 200) {
    const err = await res.json();
    console.log(err);
    return;
  }

  //SUCCES reload page to update detail everywhere
  window.location.href = `/user/${alias}/settings`;
}

async function updateUserPassword() {
  event.preventDefault();
  form = event.target.form;
  oldPwd = form.old_password.value;
  newPwd = form.new_password.value;
  if (oldPwd === newPwd) return;

  const res = await fetch(`/users/update/password`, {
    method: "POST",
    body: new FormData(form),
  });

  if (res.status !== 200) {
    const err = await res.text();
    console.log(err);
    return;
  }

  form.reset();
  console.log("Password updated");
}

async function deleteUser() {
  const res = await fetch("/users/", {
    method: "DELETE",
  });

  if (res.status == 401) {
    window.location.href = "/sign-out";
  }

  if (res.status != 200) {
    const err = await res.json();
    console.log(err);
  }

  window.location.href = "/sign-out";
}

async function postSession(form) {
  const res = await fetch("/sessions", {
    method: "POST",
    body: new FormData(form),
  });

  if (res.status != 200) {
    const err = await res.json();
    console.log(err);
    return;
  }

  window.location.href = "/";
}

async function postPost() {
  event.preventDefault();
  const form = event.target.form;
  const formData = new FormData(form);
  if (!form.image.value) formData.delete("image");
  const res = await fetch("/posts", {
    method: "POST",
    body: formData,
    headers: {
      spa: true, // API will now respond with html - not json
    },
  });

  if (res.status == 401) {
    window.location.href = "/sign-out";
  }

  if (res.status != 200) {
    const err = await res.text();
    console.log(err);
    return;
  }
  // SUCCES
  // Get the post as text and append to DOM
  const postHtml = await res.text();
  document.querySelector(".posts-container").insertAdjacentHTML("afterbegin", postHtml);
  // Close modal
  const modal = document.querySelector(".post-modal");
  modal.classList.remove("show");
  modal.querySelector(".modal-hider").removeEventListener("click", hideModal);
  form.reset();
  postValidation();
}

async function deletePost(postId) {
  const res = await fetch("/posts/" + postId, {
    method: "DELETE",
  });

  if (res.status == 401) {
    window.location.href = "/sign-out";
  }

  if (res.status != 200) {
    const err = await res.json();
    console.log(err);
    return;
  }

  // SUCCES remove the post from DOM
  document.querySelector("#post-" + postId).remove();
}

async function postLike() {
  event.preventDefault();
  const btn = event.target;
  const form = event.target.form;
  const postId = form.post_id.value;

  const res = await fetch("/likes", {
    method: "POST",
    body: new FormData(form),
  });

  if (res.status == 401) {
    window.location.href = "/sign-out";
  }

  if (res.status != 200) {
    const err = await res.json();
    console.log(err);
    return;
  }

  const likesElm = document.querySelector(`#post-${postId} .likes span`);
  const likes = parseInt(likesElm.textContent);
  likesElm.textContent = likes + 1;
  btn.insertAdjacentHTML("afterend", `<button onclick="deleteLike()">Unlike</button>`);
  btn.remove();
}

async function deleteLike() {
  event.preventDefault();
  const btn = event.target;
  const postId = event.target.form.post_id.value;
  const res = await fetch(`/likes/${postId}`, {
    method: "DELETE",
  });

  if (res.status == 401) {
    window.location.href = "/sign-out";
  }

  if (res.status != 200) {
    const err = await res.text();
    console.log(err);
    return;
  }

  const likesElm = document.querySelector(`#post-${postId} .likes span`);
  const likes = parseInt(likesElm.textContent);
  likesElm.textContent = likes - 1;
  btn.insertAdjacentHTML("afterend", `<button onclick="postLike()">Like</button>`);
  btn.remove();
}

//####################
//####################
// MODALS
function showModal(modalClass) {
  const modal = document.querySelector(modalClass);
  modal.classList.add("show");
}

function hideModal(modalClass) {
  const modal = document.querySelector(modalClass);
  modal.classList.remove("show");
  if (modal.querySelector("form")) {
    modal.querySelector("form").reset();
  }
}
