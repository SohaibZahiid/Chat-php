const form = document.querySelector(".signup form");
const continueBtn = form.querySelector(".continue");
const errorText = form.querySelector(".error-text");

form.onsubmit = (e) => {
  e.preventDefault();
};

continueBtn.addEventListener("click", (e) => {
  const formData = new FormData(form);
  signup(formData);
});

async function signup(formData) {
  const res = await fetch("php/signup.php", {
    method: "POST",
    body: formData,
  });

  const data = await res.json();

  if (data.message === "success") {
    location.href = "profile.php"
  } else {
    errorText.innerText = data.message;
    errorText.style.display = "block";
  }
}
