"use strict";

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("form");
  form.addEventListener("submit", formSend);

  async function formSend(e) {
    e.preventDefault();

    let error = formValidate(form);
    let spinner = document.querySelector(".form__spinner");

    if (error === 0) {
      spinner.classList.remove("d-none");
      let response = await fetch("sendmail.php", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
          "Content-Type": "application/json; charset=UTF-8",
        },
      });
      if (response.ok) {
        let result = await response.text();
        alert(result.message);
        form.reset();
        spinner.classList.add("d-none");
      } else {
        alert("Ошибка");
        spinner.classList.add("d-none");
      }
    } else {
      alert("Заполните обязательные поля");
    }
  }

  function formValidate(form) {
    let error = 0;
    let formReq = document.querySelectorAll("._req");

    for (let index = 0; index < formReq.length; index++) {
      const input = formReq[index];

      formRemoveError(input);

      if (input.classList.contains("_email")) {
        if (emailTest(input)) {
          formAddError(input);
          error++;
        }
      } else if (
        input.getAttribute("type") === "checkbox" &&
        input.checked === false
      ) {
        formAddError(input);
        error++;
      } else {
        if (input.value === "") {
          formAddError(input);
          error++;
        }
      }
    }

    return error;
  }
  function formAddError(input) {
    // input.parentElement.classList.add('_error');
    input.classList.add("is-invalid");
    input.parentElement
      .querySelector(".invalid-feedback")
      .classList.add("d-block");
  }
  function formRemoveError(input) {
    // input.parentElement.classList.remove('_error');
    input.classList.remove("is-invalid");
    input.parentElement
      .querySelector(".invalid-feedback")
      .classList.remove("d-block");
  }
  function emailTest(input) {
    return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
  }
});
