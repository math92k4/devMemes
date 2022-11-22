function formValidation(callback) {
  event.preventDefault();
  const form = event.target.form;
  if (form.checkValidity()) callback(form);
}

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
      spa: true,
    },
  });

  if (res.status != 200) {
    const err = await res.json();
    console.log(err);
    return;
  }

  const postHtml = await res.text();
  document.querySelector(".posts-container").insertAdjacentHTML("afterbegin", postHtml);

  const modal = document.querySelector(".post-modal");
  modal.classList.remove("show");
  modal.querySelector(".modal-hider").removeEventListener("click", hideModal);
  modal.querySelector("form").reset();
}

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
