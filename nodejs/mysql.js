const mysql = require("mysql2");
let config = require("./config.js");
// const data = ["example.com", '30%', '45%', '45000'];
// const sql = "INSERT INTO domain(domain, direct, organica, traffic) VALUES(?, ?, ?, ?)";
 
// connection.query(sql, data, function(err, results) {
//     if(err) console.log(err);
//     else console.log("Данные добавлены");
// });

// console.log(connection);
connection = mysql.createConnection({
  host: config.host,
  user: config.user,
  database: config.database,
  password: config.pass
});
connection.connect(function(err){
  if (err) {
    return console.error("Ошибка: " + err.message);
  }
  else{
    console.log("Подключение к серверу MySQL успешно установлено");
  }
});

connection.end(function(err) {
  if (err) {
    return console.log("Ошибка: " + err.message);
  }
  console.log("Подключение закрыто");
});
