
const puppeteer = require('puppeteer');

// (async () => {
//   const browser = await puppeteer.launch();
//   const page = await browser.newPage();
//   let domain = 'kudago.com';
//   // await page.goto('https://pro.metrica.guru/id?domains=' + domain);
//   page.waitForSelector('bar_value').then(() => console.log('First URL with image: ' + domain));
//   await page.goto('https://pro.metrica.guru/id?domains=' + domain);

//   const result = await page.evaluate((domain) => {
//     let direct = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[0].children[0].innerText;
//     let organica = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[1].children[0].innerText;

//     return {
//       'Домен': domain,
//       '% c поиска': organica, 
//       'Прямые переходы': direct
//     }
//   }, domain);
//   await browser.close();
//   return result;
// })();


let getMetrica = async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.setViewport({
    width: 1280,
    height: 720,
    deviceScaleFactor: 1,
  });
  let domains = ['kudago.com'];
  let data = [];
  for (var domain of domains){ // Проходимся в цикле по каждому товару
    await page.goto('https://'+domain);
    await page.screenshot({path: '../storage/web/screen/'+domain+'.jpeg', type: 'jpeg', quality: 60});    
    await page.goto('https://pro.metrica.guru/id?domains='+domain)
    await page.waitForSelector('.bar_value', {
      visible: true,
    });

    const result = await page.evaluate((domain) => {
      let direct = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[0].children[0].innerText;
      let organica = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[1].children[0].innerText;

      return {
        'Домен': domain,
        '% c поиска': organica, 
        'Прямые переходы': direct
      }
    }, domain);

  data.push(result);
  }
  browser.close();
  return data;
}

getMetrica().then((value) => {
  console.log(value);
});
