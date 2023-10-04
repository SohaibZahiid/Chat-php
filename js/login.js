const form = document.querySelector(".login form");
const continueBtn = form.querySelector(".continue");
const errorText = form.querySelector(".error-text");

form.onsubmit = (e) => {
  e.preventDefault();
};

continueBtn.addEventListener("click", (e) => {
  const formData = new FormData(form);
  login(formData);
});

async function login(formData) {
  const res = await fetch("php/login.php", {
    method: "POST",
    body: formData,
  });
  const data = await res.json();

  console.log(data)

  if (data.message === "success") {
    location.href = "profile.php"
  } else {
    errorText.innerText = data.message;
    errorText.style.display = "block";
  }
}
