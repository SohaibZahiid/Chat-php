const form = document.querySelector(".typing-area");
const btn = document.querySelector(".typing-area button");
const incoming = form.querySelector(".incoming");
const chatBox = document.querySelector(".chat-box");

setInterval(() => {
  getMessages();
}, 500)

async function getMessages() {
  const res = await fetch(`php/chats.php?user_id=${incoming.value}`);
  const data = await res.json();
  if (data.data) {
    chatBox.innerHTML = createHtml(data);
  } else {
    chatBox.innerHTML = data.message;
  }
}

form.onsubmit = (e) => {
  e.preventDefault();
};

btn.addEventListener("click", () => {
  const formData = new FormData(form);
  sendMessage(formData);
});

async function sendMessage(formData) {
  const res = await fetch(`php/chat.php?user_id=${incoming.value}`, {
    method: "POST",
    body: formData,
  });

  const data = await res.json();

  if (data.message === "success") {
    form.querySelector(".message").value = "";
    // getMessages()
  }
}

function createHtml(data) {
  html = ``;
  data.data.forEach((msg) => {
    html += `
    <div class="message ${
      msg.outgoing == data.outgoing ? "outgoing" : "incoming"
    }">
    ${msg.outgoing != data.outgoing ? `<img src="./images/${msg.img}" />` : ""}
          <div class="details">
            <p>${msg.msg}</p>
          </div>
    </div>
    `;
  });

  return html;
}
