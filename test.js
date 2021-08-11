const redis = require("redis");
const client = redis.createClient();

client.rpush(
  "chat_example",
  "{ type: 'personal', content: 'asasdsa', userID: 8, userSend: 7 }"
);
