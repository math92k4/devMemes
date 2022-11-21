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
