const popup = document.querySelector(".chat-popup");
const chatBtn = document.querySelector(".chat-btn");
const chatSendBtn = document.querySelector("#chat_send");
const submitBtn = document.querySelector(".submit");
const chatArea = document.querySelector(".chat-area");
const inputElm = document.querySelector("#chat_input");

//   chat button toggler

chatBtn.addEventListener("click", () => {
  popup.classList.toggle("show");
});

// send msg
submitBtn.addEventListener("click", () => {
  let userInput = inputElm.value;

  let temp = `<div class="out-msg">
    <span class="my-msg">${userInput}</span>
    </div>`;

  chatArea.insertAdjacentHTML("beforeend", temp);
  inputElm.value = "";
});
