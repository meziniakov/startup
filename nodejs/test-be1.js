// const puppeteer = require('puppeteer');
const puppeteer = require('puppeteer-extra');
const captchaAPI = require("./config.js");
// const StealthPlugin = require('puppeteer-extra-plugin-stealth');
// puppeteer.use(StealthPlugin());
const RecaptchaPlugin = require('puppeteer-extra-plugin-recaptcha');

puppeteer.use(
  RecaptchaPlugin({
    provider: {
      id: '2captcha',
      token: captchaAPI
    },
    visualFeedback: true
  })
)

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

  try {
    // await page.goto('https://be1.ru/stat/'+domain);
    await page.goto('https://pro.metrica.guru/id?domains='+domain, {
      waitUntil: 'load',
      timeout: 0
  });
    await page.screenshot({path: screen_path+domain+'_'+new Date().getTime()+'.jpg', type: 'jpeg', quality: 80});
    browser.close();
    process.exit();
  } catch(error) {
    console.log(error);
    process.exit();
  }
}

getBe1().then((value) => {
});