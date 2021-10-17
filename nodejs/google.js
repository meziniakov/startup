const puppeteer = require('puppeteer');
var pool = require("./config.js");
const connection = require("./config.js");

const PUPPETEER_OPTIONS = {
  headless: true,
  args: [
    // '--disable-gpu',
    // '--disable-dev-shm-usage',
    // '--disable-setuid-sandbox',
    // '--timeout=30000',
    // '--no-first-run',
    // '--no-sandbox',
    // '--no-zygote',
    // '--single-process',
    // "--proxy-server='direct://'",
    // '--proxy-bypass-list=*',
    // '--deterministic-fetch',
  ],
};

const openConnection = async () => {
  const browser = await puppeteer.launch(PUPPETEER_OPTIONS);
  const page = await browser.newPage();
  await page.setUserAgent(
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36'
  );
  await page.setViewport({ width: 1680, height: 1050 });
  return { browser, page };
};

const closeConnection = async (page, browser) => {
  page && (await page.close());
  browser && (await browser.close());
};

function chunk(arr, size) {
  const result = [];
  for (let i = 0; i < Math.ceil(arr.length/size); i++) {
    result.push(arr.slice((i * size), (i * size) + size));
  }
  return result;
}

const scrapingExample = async (_req) => {
  let { browser, page } = await openConnection();
  let query = process.argv[2];
  let count = process.argv[3];
  let data = [];

  for(start = 0; start <= count*10; start=start+10){
    await page.goto('https://google.ru/search?q='+query+'&start='+start, { waitUntil: 'domcontentloaded' });
    const domains = await page.evaluate(() =>
      Array.from(document.querySelectorAll('cite')).map(el => el.firstChild.textContent)
    );

    domains.forEach((element) => {
      if (!data.includes(element)) {
        data.push(element);
      }
    });
  }
  await closeConnection(page, browser);
  const sql = "INSERT IGNORE INTO domain (domain) VALUES ?";

  pool.query(sql, [chunk(data, 1)], function (err) {
    if (err) throw err;
    console.log('Данные добавлены');
    process.exit();
  });
};
scrapingExample();