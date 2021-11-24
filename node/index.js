const browserObject = require('./browser');
const scraperController = require('./pageController');

// let domains = process.argv[2];
// // let urls = JSON.parse(JSON.stringify(domains));
let urls = ['https://be1.ru/stat/vsegdavkusno.ru', 'https://be1.ru/stat/delo-vcusa.ru'];
// console.log(domains);
// // console.log(urls);
// // let urls = ['https://be1.ru/stat/vsepirojki.ru','https://be1.ru/stat/delo-vcusa.ru'];
// // for (link in urls) {
// //   // const domain = new URL(urls[link]).pathname.replace('stat/', '');
// //   console.log('__'+urls[link]);

// //   // scrapedData[domain] = await pageScraper.scraper(browser, urls[link]);
// // }

// return
//Start the browser and create a browser instance
let browserInstance = browserObject.startBrowser();

// Pass the browser instance to the scraper controller
scraperController(browserInstance, urls)
