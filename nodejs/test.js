// const puppeteer = require('puppeteer');
const puppeteer = require('puppeteer-extra');
const captchaAPI = require("./config.js");
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

(async () => {
  const browser = await puppeteer.launch({headless: false});
  const page = await browser.newPage();
  const webmaster = `https://webmaster.yandex.ru/siteinfo/?host=otdyhsamostoyatelno.ru`;
  await page.solveRecaptchas();
  await Promise.all([
    page.waitForNavigation(),
    page.click(`.CheckboxCaptcha-Anchor input[type=submit]`)
    // document.querySelector('.CheckboxCaptcha-Anchor input[type=submit]').click()
  ])
  console.log(`Перехожу по адресу: ${webmaster}`);
  // await page.setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36');
  await page.goto(webmaster, {waitUntil: 'domcontentloaded'});
  console.log('Ожидаю селектор: .achievement_type_sqi .achievement__name');
  await page.waitForSelector('.achievement_type_sqi .achievement__name');
  console.log('Копирую дааные селектора: .achievement_type_sqi .achievement__name');
  let IKS = await page.$eval('.achievement_type_sqi .achievement__name', text => text.textContent.replace(/[^0-9/.]/g,""));
  console.log('IKS:' + IKS);
  await page.close();
  await browser.close();
})
();