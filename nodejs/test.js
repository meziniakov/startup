const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch({headless: false});
  const page = await browser.newPage();
  await page.authenticate({
    username: 'z2941@ya.ru',
    password: '50509891',  
  });

  await page.goto('https://aeroexpress.ru/aero/profile.html?open=history', {waitUntil: 'networkidle0'});
  await page.type('#loginLogin', 'z2941@ya.ru');
  await page.type('#loginPassword', '50509891');

  await page.click('#loginGo');

  await page.waitForNavigation();

  console.log('New Page URL:', page.url());
  await page.waitForTimeout(5000);
  await browser.close();
})
();