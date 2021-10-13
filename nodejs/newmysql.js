var pool = require("./config.js");

const sql = "INSERT INTO domain(domain, traffic, organic, direct, screen, chart) VALUES(?, ?, ?, ?, ?, ?)";
const data = ['exam8.com', '453234', '45%', '21%', 'screen1.jpg', 'chart.jpg'];

try {
  pool.query(sql, data, function (error, results) {
    if (error) throw error;
    console.log('The solution is:');
    process.exit();
  });
} catch(error) {
  console.log(error);
}
// process.exit(1)