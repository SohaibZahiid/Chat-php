const list = document.querySelector(".users-list");
const searchBar = document.querySelector(".search input")


searchBar.onkeyup = () => {
  let searchTerm = searchBar.value
  searchUsers(searchTerm)
}

async function searchUsers(search) {
  const res = await fetch(`php/search.php?search=${search}`)
  const data = await res.json()
  if(data.data) {
    list.innerHTML = createHtml(data.data);
  } else {
    list.innerHTML = data.message
  }
}

async function getUsers() {
  const res = await fetch("php/users.php");
  const data = await res.json();

  list.innerHTML = createHtml(data);
}

function createHtml(data) {
  html = ``;

  data.forEach((user) => {
    html += `
    <a href="chat.php?user_id=${user.id}" class="user">
      <div class="content">
        <img src="./images/${user.img}" alt="user image" class="image"/>
        <div class="details">
          <h4>${user.fname} ${user.lname}</h4>
          <p class="sm-text last-msg">[Not implemented...]</p>
        </div>
      </div>
      <div class="status ${user.status == "Active now" ? "online" : ""}">
        <i class="fa-solid fa-circle"></i>
      </div>
    </a>
    `;
  });

  return html;
}

getUsers();