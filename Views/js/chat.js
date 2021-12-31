window.onload = function () {
  const popup = document.querySelector(".chat-popup");
  const chatBtn = document.querySelector(".chat-btn");
  // const chatSendBtn = document.querySelector("#chat_send");
  const submitBtn = document.querySelector("#chat_send");
  const chatArea = document.querySelector(".chat-area");
  const inputElm = document.querySelector("#chat_input");

  /**
   * / Connection au serveur NodeJS via socket.io
   */

  // var socket = io("http://localhost:3001");

  var socket = io("http://localhost:3001", {
    transports: ["websocket"],
    transportOptions: {
      polling: {
        extraHeaders: {
          "my-custom-header": "my-custom-header-value",
        },
      },
    },
  });

  socket.on("connect", () => {
    console.log("Connected");
    console.log(socket.connected);
  });

  // socket.on("test", () => {
  //   console.log("In test socket on");
  // });

  // socket.on("news", function (data) {
  //   console.log(data);
  //   socket.emit("my other event", { my: "data" });
  // });

  // End Connection to Socket

  //   chat button toggler
  chatBtn.addEventListener("click", () => {
    popup.classList.toggle("show");
  });

  // send msg
  submitBtn.addEventListener("click", () => {
    let userInput = inputElm.value;

    if (userInput && userInput.length > 0 && submitBtn.dataset.sender != 1) {
      // send msg to server
      socket.emit("chat_message", {
        sender: submitBtn.dataset.sender,
        message: userInput,
        receiver: "1",
      });

      let temp = `<div class="out-msg">
      <span class="my-msg">${userInput}</span>
      </div>`;

      chatArea.insertAdjacentHTML("beforeend", temp);
      inputElm.value = "";
    }
  });
};
