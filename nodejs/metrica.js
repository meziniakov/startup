// const puppeteer = require('puppeteer');
var captchaAPI = require("./config.js");
const puppeteer = require('puppeteer-extra');
const RecaptchaPlugin = require('puppeteer-extra-plugin-recaptcha');
puppeteer.use(
  RecaptchaPlugin({
    provider: {
      id: '2captcha',
      token: captchaAPI // REPLACE THIS WITH YOUR OWN 2CAPTCHA API KEY ⚡
    },
    visualFeedback: true // colorize reCAPTCHAs (violet = detected, green = solved)
  })
)

let getMetrica = async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36');
  await page.setViewport({
    width: 1280,
    height: 720,
    deviceScaleFactor: 1,
  });
  let screen_path = '../storage/web/screen/';
  let chart_path = '../storage/web/chart/';
  let domain = process.argv[2];

  // for (var domain of domains){ // Проходимся в цикле по каждому товару
    try {
    // await page.goto('http://'+domain);
    // await page.screenshot({path: screen_path+domain+'.jpeg', type: 'jpeg', quality: 60});
    // await page.goto('https://pro.metrica.guru/id?domains='+domain)
    await page.goto('https://be1.ru/stat/'+domain, { waitUntil: 'domcontentloaded' });
    await page.solveRecaptchas();
    await page.waitForSelector('#similar_attendance', {visible: true,});
    await page.waitForSelector('#set_pages_in_google', {visible: true,});
    await page.waitForSelector('#similar_source', {visible: true,});
    await page.waitForSelector('#set_trust_rank', {visible: true,});
    await page.waitForSelector('#set_domain_rank', {visible: true,});
    // const element = await page.$('.wrapper_line_chart');        // объявляем переменную с ElementHandle
    // await element.screenshot({path: chart_path+domain+'_chart.jpeg', type: 'jpeg', quality: 80});

    const result = await page.evaluate((domain) => {
      let traffic = document.querySelector('#similar_attendance text:nth-child(2)');
      traffic = traffic ? Number.parseInt(traffic.textContent.replace(/\s/g, '')) : '';

      let direct = document.querySelector('#similar_source > div > div:nth-child(1) > div > svg > g:nth-child(4) > text');
      direct = direct ? Number.parseInt(direct.textContent.replace(/\s/g, '%'))/100 : '';
      
      let organic = document.querySelector('#similar_source div div:nth-child(1) div svg g:nth-child(8) text');
      organic = organic ? Number.parseInt(organic.textContent.replace(/\s/g, '%'))/100 : '';

      let traffic_season = (traffic !== '') ? (traffic*0.9).toFixed(0) : '';
      let project_stage = 10;
      let profit_await = (traffic_season*organic*0.3+(100-organic)*0.3/2).toFixed(0);
      let evaluate_min = (project_stage*profit_await*0.5).toFixed(0);
      let evaluate_middle = (project_stage*profit_await*0.75).toFixed(0);
      let evaluate_max = (project_stage*profit_await).toFixed(0);

      let domain_age = document.querySelector('#set_vozrast');
      domain_age = domain_age ? domain_age.textContent : '';

      let IKS = document.querySelector('#set_iks');
      IKS = IKS ? Number.parseInt(IKS.innerText.replace(/\s/g, '')) : '';

      let index_Y = document.querySelector('#set_pages_in_yandex a');
      index_Y = index_Y ? index_Y.textContent : '';

      let index_G = document.querySelector('#set_pages_in_google a');
      index_G = index_G ? index_G.textContent : '';

      let megaindexTrustRank = document.querySelector('#set_trust_rank');
      megaindexTrustRank = megaindexTrustRank ? megaindexTrustRank.innerText : '';

      let megaindexDomainRank = document.querySelector('#set_domain_rank');
      megaindexDomainRank = megaindexDomainRank ? megaindexDomainRank.innerText : '';

      // let effectiveness = getRandomInRange(1, 100);
      // let articles_num = getRandomInRange(10, 400);
      let screen = domain+'.jpeg';
      let chart = domain+'_chart.jpeg';
         
      return {
        "domain": domain,
        "traffic": traffic, 
        "organic": organic,
        "direct": direct,
        "traffic_season": traffic_season,
        "project_stage": project_stage,
        "profit_await": profit_await,
        "evaluate_min": evaluate_min,
        "evaluate_middle": evaluate_middle,
        "evaluate_max": evaluate_max,
        "domain_age": domain_age,
        "IKS": IKS,
        "index_Y": index_Y,
        "index_G": index_G,
        "megaindexTrustRank": megaindexTrustRank,
        "megaindexDomainRank": megaindexDomainRank
      }
    }, (domain));
    browser.close();
    console.log(JSON.stringify(result));
    process.exit();
    } catch(error) {
      console.log(error);
      process.exit();
    }
  // }
}

getMetrica().then((value) => {
});