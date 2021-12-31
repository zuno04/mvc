const express = require("express");
const app = express();
const http = require("http");
var cors = require("cors");
app.use(cors());

const { Server } = require("socket.io");

const server = http.createServer(app);

// Connexion mysql
var mysql = require("mysql");
var connection = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "djamin_exam_bd",
});

// Connexion à la BD
connection.connect(function (err) {
  if (err) throw err;
  console.log("Connecté à la base de données!");
});

// Init Socket Io
const io = new Server(server, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"],
    allowedHeaders: ["my-custom-header"],
    credentials: true,
  },
});

io.on("connection", (socket) => {
  console.log("Un utilisateur s'est connecté !");
  socket.on("chat_message", (msg) => {
    // Requete SQL d'insertion du message en BD
    let sql =
      "INSERT INTO messages (contenu, emetteur, destinataire) VALUES (" +
      "'" +
      msg.message +
      "', " +
      msg.sender +
      ", " +
      msg.receiver +
      ")";

    // insertion du message en BD
    connection.query(sql, function (err, result) {
      if (err) throw err;
      console.log("1 record inserted");
    });
    console.log(sql);
  });

  socket.on("disconnect", () => {
    console.log("user disconnected");
  });
});

server.listen(3001, () => {
  console.log("listening on *:3001");
});
