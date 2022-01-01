window.onload = function () {
  const popup = document.querySelector(".chat-popup");
  const chatBtn = document.querySelector(".chat-btn");
  // const chatSendBtn = document.querySelector("#chat_send");
  const submitBtn = document.querySelector("#chat_send");
  const chatArea = document.querySelector(".chat-area");
  const inputElm = document.querySelector("#chat_input");
  let rootReceived = { hasReceived: false, message: {} };

  /**-------------------------------------------------------------------------------------------
   * / Connection au serveur NodeJS via socket.io
   --------------------------------------------------------------------------------------------*/

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

  socket.on("message_for_root", (msg) => {
    rootReceived.hasReceived = true;
    rootReceived.message = msg;

    if (popup.dataset.user !== msg.sender) {
      console.log("Message reçu du Root");
      temp = `<div class="income-msg mt-2">
      <img src="./Views/img/user.jpg" class="avatar" alt="user">
      <span class="msg">${window.atob(msg.message)}</span>
      </div>`;

      chatArea.insertAdjacentHTML("beforeend", temp);
    }
  });

  socket.on("message_from_root", (msg) => {
    if (popup.dataset.user === msg.receiver) {
      temp = `<div class="income-msg mt-2">
          <img src="./Views/img/root.jpg" class="avatar" alt="user">
          <span class="msg">${window.atob(msg.message)}</span>
          </div>`;

      chatArea.insertAdjacentHTML("beforeend", temp);
    }
  });

  /**-----------------------------------------------------------------------------------
   *  End Connection to Socket
   *  ---------------------------------------------------------------------------------*/

  // Chat button toggler
  if (chatBtn) {
    chatBtn.addEventListener("click", () => {
      popup.classList.toggle("show");
    });
  }

  /*----------------------------------------------------------------------------
  * send chat msg
  ----------------------------------------------------------------------------*/

  if (submitBtn) {
    submitBtn.addEventListener("click", () => {
      let userInput = inputElm.value;
      let temp = "";

      if (userInput && userInput.length > 0) {
        // send msg to server
        if (submitBtn.dataset.sender == 1) {
          // Cas du Root
          if (rootReceived.hasReceived) {
            socket.emit("root_message", {
              sender: "1",
              message: window.btoa(userInput),
              receiver: rootReceived.message.sender,
            });

            temp = `<div class="out-msg">
            <span class="my-msg">${userInput}</span>
            </div>`;
          }
        } else {
          // Les autre utilisateurs
          socket.emit("user_message", {
            sender: submitBtn.dataset.sender,
            message: window.btoa(userInput),
            receiver: "1",
          });

          temp = `<div class="out-msg">
          <span class="my-msg">${userInput}</span>
          </div>`;
        }

        chatArea.insertAdjacentHTML("beforeend", temp);
        inputElm.value = "";
      }
    });
  }
};
