const express = require("express");
const fs = require("fs");
const { resolve } = require("path");
const browserObject = require('./browser');
const scraperController = require('./pageController');
const pageScraper = require('./pageScraper');

const app = express();
const jsonParser = express.json();

app.use(express.static(__dirname + "/public"));

const filePath = "domains.json";
app.get("/api/test/:domain", async function (req, res) {
  // const content = fs.readFileSync(filePath,"utf8");
  const url = req.params.domain;
  // const urls = JSON.parse(content);
  // console.log('urls: '+url);
  // res.send(content);
  // let urls = JSON.parse(JSON.stringify(domains));

  //Start the browser and create a browser instance
  let browserInstance = browserObject.startBrowser();

  let scrapeAll = (browserInstance, url) => new Promise(async (resolve, reject) => {
    let browser;
    try {
        browser = await browserInstance;
        let scrapedData = {};
        // for (link in urls) {
            // console.log('Получил домен: '+urls[link]);
            // console.log('Получил домен: '+url);
            // const domain = `https://be1.ru/stat/${new URL(urls[link]).hostname}`;
            // const url = urls[link];
            const domain = url.replace('www.', '');
            // const domain = `https://be1.ru/stat/${url.replace('www.', '')}`;
            // const domain = `https://pro.metrica.guru/id?domains=${url.replace('www.', '')}`;
            const parse_url = `https://ru.megaindex.com/info/${domain}`;
            // const domain = `https://lasovtsov.ru/russianfood.html`;
            // scrapedData[urls[link]] = await pageScraper.scraper(browser, domain);
            scrapedData[domain] = await pageScraper.scraper(browser, parse_url);
        // }
        await browser.close();
        resolve(scrapedData);
    }
    catch (err) {
        console.log("Could not resolve the browser instance => ", err);
    }
  });

  let result = await scrapeAll(browserInstance, url);
  res.send(result);
  // scrapeAll(browserInstance, url);

  // res.send(JSON.stringify(scrapedData));
  // })

  // // Pass the browser instance to the scraper controller
  // let result = scraperController(browserInstance, url);
  // setTimeout(() => {
  //   res.send(result);
  // }, 15000);

  // res.send(result);
  // res.send(urls);
});

app.listen(3000, function () {
  console.log("Сервер ожидает подключения...");
});