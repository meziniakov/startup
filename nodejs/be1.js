// const puppeteer = require('puppeteer');
const puppeteer = require('puppeteer-extra');
var captchaAPI = require("./config.js");
const StealthPlugin = require('puppeteer-extra-plugin-stealth');
puppeteer.use(StealthPlugin());
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

// let megaindex = async () => {
//   const browser = await puppeteer.launch();
//   const page = await browser.newPage();
//   await page.setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36');
//   await page.setViewport({
//     width: 1280,
//     height: 720,
//     deviceScaleFactor: 1,
//   });
//   let domain = process.argv[2];
//   await page.goto('https://ru.megaindex.com/info/'+domain, { waitUntil: 'domcontentloaded' });
//   await page.waitForSelector('#serp', {visible: true,});
//   const parse = page.evaluate((domain) => {
//     let traffic = document.querySelector('#serp div:nth-child(1) font');
//     if(traffic) {
//       traffic = (traffic.innerText.indexOf("K") > -1) ? Number.parseFloat(traffic.innerText.replace(/\s/g, 'K'))*1000 : Number.parseFloat(traffic.innerText);
//     } else {
//       traffic = '';
//     }
//     return traffic
//   }, (domain));
//   await browser.close();
// }
// megaindex().then((value) => {
// });

let getBe1 = async () => {
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
    // await page.goto('https://pro.metrica.guru/id?domains='+domain)
    await page.setDefaultNavigationTimeout(0);
    await page.goto('https://be1.ru/stat/'+domain, {waitUntil: 'networkidle0'});
    await page.solveRecaptchas();
    // await Promise.all([
      //   page.waitForNavigation(),
      //   page.click(`#recaptcha-demo-submit`)
      // ])
      // const element = await page.$('.wrapper_line_chart');        // объявляем переменную с ElementHandle
      // await element.screenshot({path: chart_path+domain+'_chart.jpeg', type: 'jpeg', quality: 80});
      await page.screenshot({path: screen_path+domain+'.jpeg', type: 'jpeg', quality: 60});

    // const be1 = await page.evaluate((domain) => {
    //   let traffic = document.querySelector('#similar_attendance text:nth-child(2)');
    //   // traffic = traffic ? Number.parseInt(traffic.textContent.replace(/\s/g, '')) : '';
    //   traffic = Number.parseInt(traffic.textContent.replace(/\s/g, ''));
      
    //   let direct = document.querySelector('#similar_source > div > div:nth-child(1) > div > svg > g:nth-child(4) > text');
    //   direct = direct ? Number.parseInt(direct.textContent.replace(/\s/g, '%'))/100 : '';
      
    //   let organic = document.querySelector('#similar_source div div:nth-child(1) div svg g:nth-child(8) text');
    //   organic = organic ? Number.parseInt(organic.textContent.replace(/\s/g, '%'))/100 : '';

    //   let traffic_season = (traffic !== '') ? (traffic*0.9).toFixed(0) : '';
    //   let project_stage = 10;
    //   let profit_await = (traffic_season === '' || organic === '') ? '' : (traffic_season*organic*0.3+(100-organic)*0.3/2).toFixed(0);
    //   let evaluate_min = profit_await === '' ? '' : (project_stage*profit_await*0.5).toFixed(0);
    //   let evaluate_middle = profit_await === '' ? '' : (project_stage*profit_await*0.75).toFixed(0);
    //   let evaluate_max = profit_await === '' ? '' : (project_stage*profit_await).toFixed(0);

    //   let domain_age = document.querySelector('#set_vozrast');
    //   domain_age = domain_age ? domain_age.textContent : '';

    //   let IKS = document.querySelector('#set_iks');
    //   IKS = IKS ? Number.parseInt(IKS.innerText.replace(/\s/g, '')) : '';

    //   let index_Y = document.querySelector('#set_pages_in_yandex a');
    //   index_Y = index_Y ? index_Y.textContent : '';

    //   let index_G = document.querySelector('#set_pages_in_google a');
    //   index_G = index_G ? index_G.textContent : '';

    //   let megaindexTrustRank = document.querySelector('#set_trust_rank');
    //   megaindexTrustRank = megaindexTrustRank ? megaindexTrustRank.innerText : '';

    //   let megaindexDomainRank = document.querySelector('#set_domain_rank');
    //   megaindexDomainRank = megaindexDomainRank ? megaindexDomainRank.innerText : '';

    //   // let effectiveness = getRandomInRange(1, 100);
    //   // let articles_num = getRandomInRange(10, 400);
    //   let screen = domain+'.jpeg';
    //   let chart = domain+'_chart.jpeg';
         
    //   return {
    //     "domain": domain,
    //     "traffic": traffic, 
    //     "organic": organic,
    //     "direct": direct,
    //     "traffic_season": traffic_season,
    //     "project_stage": project_stage,
    //     "profit_await": profit_await,
    //     "evaluate_min": evaluate_min,
    //     "evaluate_middle": evaluate_middle,
    //     "evaluate_max": evaluate_max,
    //     "domain_age": domain_age,
    //     "IKS": IKS,
    //     "index_Y": index_Y,
    //     "index_G": index_G,
    //     "megaindexTrustRank": megaindexTrustRank,
    //     "megaindexDomainRank": megaindexDomainRank
    //   }
    // }, (domain));
    browser.close();
    console.log(JSON.stringify(be1));
    process.exit();
    } catch(error) {
      console.log(error);
      process.exit();
    }
  // }
}

getBe1().then((value) => {
});