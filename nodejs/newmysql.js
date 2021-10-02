var pool = require("./config.js");

const sql = "INSERT INTO domain(domain, traffic, organic, direct, screen, chart) VALUES(?, ?, ?, ?, ?, ?)";
const data = ['exam.com', '453234', '45%', '21%', 'screen1.jpg', 'chart1.jpg'];

pool.query(sql, data, function (error, results) {
  if (error) throw error;
  console.log('The solution is: ', results);
});