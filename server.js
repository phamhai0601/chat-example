const app = require("express")();
const http = require("http").Server(app);
const redis = require("redis");
const client = redis.createClient();
const io = require("socket.io")(http, {
  cors: {
    origin: "http://chat-example.demo",
    methods: ["GET", "POST"],
    allowedHeaders: ["*"],
    credentials: true,
  },
  allowEIO3: true,
});
const port = process.env.PORT || 3000;
var userOnline = [];

io.on("connection", (socket) => {
  socket.on("register", (data) => {
    userOnline[socket.id] = data;
    console.log("Register: " + data.username + " kết nối.");
  });
  socket.on("send-message", (data) => {
    if (data.type == "personal") {
      io.to(getKeyByValue(userOnline, data.user_send)).emit(
        "server-send-client",
        data
      );
      console.log("Message: " + JSON.stringify(data));
      client.rpush(data.chat_box, JSON.stringify(data));
    } else {
      socket.broadcast.emit("server-send-client", data);
    }
  });

  socket.on("disconnect", () => {
    console.log(socket.id + " ngắt kết nối");
    delete userOnline[socket.id];
  });
});

http.listen(port, () => {
  console.log(`Socket.IO server running at http://localhost:${port}/`);
});

function getKeyByValue(object, value) {
  return Object.keys(object).find((key) => object[key].id == value);
}
