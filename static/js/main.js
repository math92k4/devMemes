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
  const form = document.querySelector("#update-info-form");
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
    showErrorModal(err);
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
    showErrorModal(err);
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
    showErrorModal(err);
    return;
  }

  form.reset();
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
    showErrorModal(err);
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
    showErrorModal(err);
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
    showErrorModal(err);
    return;
  }
  // SUCCES

  main = document.querySelector("main");
  if (main.dataset.can_append_post) {
    // Get the post as text and append to DOM
    const postHtml = await res.text();
    document.querySelector(".posts-container").insertAdjacentHTML("afterbegin", postHtml);
  }
  // Close modal
  const modal = document.querySelector(".post-modal");
  modal.classList.remove("show");
  modal.querySelector(".modal-hider").removeEventListener("click", hideModal);
  if (modal.querySelector(modal.querySelector(".load-image-container"))) modal.querySelector(".load-image-container").remove();
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
    showErrorModal(err);
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
    showErrorModal(err);
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
    const err = await res.json();
    showErrorModal(err);
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
  if (modal.querySelector(".load-image-container")) {
    modal.querySelector(".load-image-container").remove();
  }
}

//####################
//####################
// IMAGE LOAD HANDLING

function loadPostImage() {
  const input = event.target;
  const image = URL.createObjectURL(input.files[0]);
  const html = `
  <div class="load-image-container">
    <button onclick="removeLoadPostImage();" >⨉</button>
    <img src="${image}">
  </div>
  `;
  input.insertAdjacentHTML("afterend", html);
}

function removeLoadPostImage() {
  event.preventDefault();
  const btn = event.target;
  const form = btn.form;
  form.querySelector('[type="file"]').value = null;
  btn.parentElement.remove();
}

function loadUserImage() {
  const input = event.target;
  const image = URL.createObjectURL(input.files[0]);
  const html = `
  <div class="load-image-container">
    <button onclick="removeLoadUserImage()" >⨉</button>
    <img src="${image}">
  </div>
  `;
  input.insertAdjacentHTML("afterend", html);
}

function removeLoadUserImage() {
  event.preventDefault();
  const btn = event.target;
  const form = btn.form;
  form.querySelector('[type="file"]').value = null;
  btn.parentElement.remove();
  infoValidation();
}

//####################
//####################
// ERROR modal - the bad UX :)
function showErrorModal(message) {
  const html = `
  <div class="modal show error-modal">
    <div class="modal-hider" onclick="hideModal('.error-modal')"></div>
    <div>
      <p>${message.info}</p>
      <button onclick="hideErrorModal()">Ok</button>
    </div>
  </div>
  `;
  document.querySelector("body").insertAdjacentHTML("beforeend", html);
}

function hideErrorModal() {
  document.querySelector(".error-modal").remove();
}


//####################
//####################
//SPA - Single page app
// Init spa setup for the first loaded page
history.replaceState({ spaUrl: location.pathname }, "", location.pathname);
document.querySelector("main").dataset.spa_url = location.pathname;
let memoUrl = location.pathname;

async function spa(spaUrl, doPushState = true) {
  // if new and current url are same - end
  if (spaUrl == memoUrl) return;

  // Fetch spaUrl if not in DOMM
  if (!document.querySelector(`[data-spa_url="${spaUrl}"]`)) {
    const conn = await fetch(spaUrl, {
      method: "GET",
      headers: { spa: true },
    });

    if (!conn.status == 200) {
      console.log("Can't connect to endpoint");
      return;
    }
    const html = await conn.text();

    // Remove old data
    document.querySelector(`[data-spa_url="${memoUrl}"]`).remove();
    // Append the new data and set dataset-spa_url
    document.querySelector("#spa").insertAdjacentHTML("afterbegin", html);
    document.querySelector('main').dataset.spa_url = spaUrl;
  }

  // Toggle spa pages
  // document.querySelector(`[data-spa_url="${memoUrl}"]`).style.display = "none";
  // document.querySelector(`[data-spa_url="${spaUrl}"]`).style.display = "block";

  // Get and set title
  const title = document.querySelector(`[data-spa_url="${spaUrl}"]`).dataset.page_title;
  document.querySelector("title").textContent = title;

  // Memo the appended url
  memoUrl = spaUrl;

  // Push state
  if (doPushState) {
    history.pushState({ spaUrl: spaUrl }, "", spaUrl);
  }
}

// History back/forth
window.addEventListener("popstate", (e) => {
  spa(e.state.spaUrl, false);
});
