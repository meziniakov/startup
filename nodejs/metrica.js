const puppeteer = require('puppeteer');
const mysql = require("mysql2");

// (async () => {
//   const browser = await puppeteer.launch();
//   const page = await browser.newPage();
//   let domain = 'kudago.com';
//   // await page.goto('https://pro.metrica.guru/id?domains=' + domain);
//   page.waitForSelector('bar_value').then(() => console.log('First URL with image: ' + domain));
//   await page.goto('https://pro.metrica.guru/id?domains=' + domain);

//   const result = await page.evaluate((domain) => {
//     let direct = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[0].children[0].innerText;
//     let organica = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[1].children[0].innerText;

//     return {
//       'Домен': domain,
//       '% c поиска': organica, 
//       'Прямые переходы': direct
//     }
//   }, domain);
//   await browser.close();
//   return result;
// })();


let getMetrica = async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36');
  await page.setViewport({
    width: 1280,
    height: 720,
    deviceScaleFactor: 1,
  });
  // let domains = ['buro39.ru', 'shm.ru', 'mosmuseum.ru'];
  let domains = ['bishelp.ru'];
  // let data = [];

  const connection = mysql.createConnection({
    host: "localhost",
    user: "root",
    database: "yii2core",
    password: "root"
  });

  for (var domain of domains){ // Проходимся в цикле по каждому товару
    // try {
    //   const url = new URL(domain)
    // } catch(error) {
    //   console.log(error);
    // }    
    await page.goto('http://'+domain);
    await page.screenshot({path: '../storage/img/screen/'+domain+'.jpeg', type: 'jpeg', quality: 60});
 
    await page.goto('https://pro.metrica.guru/id?domains='+domain)
    await page.waitForSelector('.bar_value', {visible: true,});
    await page.waitForSelector('.wrapper_line_chart');          // дожидаемся загрузки селектора
    const element = await page.$('.wrapper_line_chart');        // объявляем переменную с ElementHandle
    await element.screenshot({path: '../storage/img/screen/'+domain+'_chart.jpeg', type: 'jpeg', quality: 80});
  

    const result = await page.evaluate((domain) => {
      function getRandomInRange(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
      }
      let direct = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[0].children[0].innerText;
      let organica = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[1].children[0].innerText;
      let traffic = getRandomInRange(30000, 120000);
      let screen = domain+'.jpeg';
      let chart = domain+'_chart.jpeg';
         
      return [domain, organica, direct, traffic, screen, chart]
    }, domain);

    const data = result;
    const sql = "INSERT INTO domain(domain, direct, organica, traffic, screen, chart) VALUES(?, ?, ?, ?, ?, ?)";
    connection.query(sql, data, function(err, results) {
        if(err) console.log(err);
        else console.log("Данные добавлены");
    });

  // data.push(result);
  }
  connection.end();
  browser.close();
  // return data;
}

getMetrica().then((value) => {
  console.log(value);
});