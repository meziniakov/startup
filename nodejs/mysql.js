const mysql = require("mysql2");


const connection = mysql.createConnection({
  host: "localhost",
  user: "root",
  database: "yii2core",
  password: "root"
});

// const data = ["example.com", '30%', '45%', '45000'];
// const sql = "INSERT INTO domain(domain, direct, organica, traffic) VALUES(?, ?, ?, ?)";
 
// connection.query(sql, data, function(err, results) {
//     if(err) console.log(err);
//     else console.log("Данные добавлены");
// });

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
