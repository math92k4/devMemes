// ####################
// ####################
// FORM  VALIDATION
function formValidation(callback) {
  event.preventDefault();
  const form = event.target.form;
  if (form.checkValidity()) callback(form);
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

async function postPost(form) {
  const res = await fetch("/posts", {
    method: "POST",
    body: new FormData(form),
    headers: {
      spa: true, // API will now respond with html - not json
    },
  });

  if (res.status == 401) {
    window.location.href = "/sign-out";
  }

  if (res.status != 200) {
    const err = await res.json();
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
  modal.querySelector("form").reset();
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
  document.querySelector("#post-" + postId).remove;
}

async function postLike() {
  event.preventDefault();
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
}

async function deleteLike(likeId) {
  event.preventDefault();
  const form = event.target.form;
  const postId = form.post_id.value;

  const res = await fetch("/likes", {
    method: "DELETE",
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
}

//####################
//####################
// MODALS
function showModal(modalClass) {
  const modal = document.querySelector(modalClass);
  modal.classList.add("show");
  modal.querySelector(".modal-hider").addEventListener("click", hideModal);
}
function hideModal() {
  this.removeEventListener("click", hideModal);
  const modal = this.parentElement;
  modal.classList.remove("show");
  modal.querySelector("form").reset();
}
