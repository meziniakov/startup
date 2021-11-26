const puppeteer = require('puppeteer');
const chromeOptions = {
    // executablePath:'/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
    headless:true,
    slowMo:10,
    defaultViewport: null,
    args: ["--disable-setuid-sandbox"],
    'ignoreHTTPSErrors': true
  };

async function startBrowser(){
    let browser;
    try {
        console.log("Opening the browser......");
        browser = await puppeteer.launch(chromeOptions);
    } catch (err) {
        console.log("Could not create a browser instance => : ", err);
    }
    return browser;
}

module.exports = {
    startBrowser
};
