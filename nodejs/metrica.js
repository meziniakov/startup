const puppeteer = require('puppeteer');
var pool = require("./config.js");

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
  // let domains = ['rosphoto.com'];
  let domains = ['the-village.ru'];
  let screen_path = '../storage/web/screen/';
  let chart_path = '../storage/web/chart/';
  let domain = process.argv[2];

  // for (var domain of domains){ // Проходимся в цикле по каждому товару
    try {
    // await page.goto('http://'+domain);
    // await page.screenshot({path: screen_path+domain+'.jpeg', type: 'jpeg', quality: 60});
    // await page.goto('https://pro.metrica.guru/id?domains='+domain)
    // await page.waitForSelector('.bar_value', {visible: true,});
    // await page.waitForSelector('.wrapper_line_chart');          // дожидаемся загрузки селектора
    // const element = await page.$('.wrapper_line_chart');        // объявляем переменную с ElementHandle
    // await element.screenshot({path: chart_path+domain+'_chart.jpeg', type: 'jpeg', quality: 80});

    const result = await page.evaluate((domain) => {
      function getRandomInRange(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
      }
      // let direct = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[0].children[0].innerText;
      // let organic = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[1].children[0].innerText;
      let traffic = getRandomInRange(30000, 120000);
      let direct = getRandomInRange(1, 100)/100;
      let organic = getRandomInRange(1, 100)/100;
      let traffic_season = traffic*0.9;
      let project_stage = 10;
      let profit_await = traffic_season*organic*0.3+(100-organic)*0.3/2;
      let evaluate_min = project_stage*profit_await*0.5;
      let evaluate_middle = project_stage*profit_await*0.75;
      let evaluate_max = project_stage*profit_await;
      let domain_age = getRandomInRange(1, 10);
      let IKS = getRandomInRange(10, 400);
      let effectiveness = getRandomInRange(1, 100);
      let articles_num = getRandomInRange(10, 400);
      let index_Y = getRandomInRange(10, 400);
      let index_G = getRandomInRange(10, 400);
      let screen = domain+'.jpeg';
      let chart = domain+'_chart.jpeg';
         
      return [domain, traffic, organic, direct, traffic_season, profit_await, evaluate_min, evaluate_middle, evaluate_max, domain_age, IKS, effectiveness, articles_num, index_Y, index_G, screen, chart]
    }, (domain));
    browser.close();
    // return console.log(result);

    // const sql = "INSERT INTO domain(domain, traffic, organic, direct, screen, chart) VALUES(?, ?, ?, ?, ?, ?)";
    const sql = "UPDATE domain SET domain=?, traffic=?, organic=?, direct=?, traffic_season=?, profit_await=?, evaluate_min=?, evaluate_middle=?, evaluate_max=?, domain_age=?, IKS=?, effectiveness=?, articles_num=?, index_Y=?, index_G=?, screen=?, chart=? WHERE domain='"+domain+"'";
    pool.query(sql, result, function (error) {
      if (error) throw error;
      console.log('Данные добавлены');
      process.exit();
    });

    } catch(error) {
      console.log(error);
    }
  // }
}

getMetrica().then((value) => {
  // console.log(value);
});