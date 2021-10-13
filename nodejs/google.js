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

const scrapingExample = async (_req) => {
  let { browser, page } = await openConnection();
  let query = process.argv[2];
  let count = process.argv[3];
  let data = [];

    // try {
      for(start = 0; start <= count*10; start=start+10){
        await page.goto('https://google.ru/search?q='+query+'&start='+start, { waitUntil: 'domcontentloaded' });
        const domains = await page.evaluate(() =>
          Array.from(document.querySelectorAll('cite')).map(el => el.firstChild.textContent)
          // document.querySelectorAll('cite')
          // document.querySelectorAll('cite').map(el => el.firstChild.textContent)
        );

        domains.forEach((element) => {
          if (!data.includes(element)) {
            data.push(element);
          }
      });
        // domains.filter(function (item, pos) {return data.indexOf(item) == pos})

        // data.filter(function (item, pos) {return data.indexOf(item) == pos});

        // let unic = domains.filter((element, index) => {
        //   domains = domains.indexOf([element]) === index;
          // return domains
        // });
        // [...new Set(domains)]
        // domains.map(el => el.innerHTML);
        // data = data.concat(uniqueChars)
      }

      function chunk(arr, size) {
        const result = [];
        for (let i = 0; i < Math.ceil(arr.length/size); i++) {
          result.push(arr.slice((i * size), (i * size) + size));
        }
        return result;
      }
      const sql = "INSERT INTO domain (domain) VALUES (?)";
      
  try {
    for(var domain of data) {
      // console.log(domain);
      connection.query(sql, domain, function (error) {
        if (error) console.log(error)
        // else console.log('Домен '+domain+' добавлен');
        // console.log('Домен '+domain+' добавлены');
        // process.exit();
        });
        console.log('Домен '+domain+' добавлен')
      }
    // await connection.commit();
  } catch (err) {
    // await connection.rollback();
    // Throw the error again so others can catch it.
    // return console.log(errno);
  } finally {
    connection.end();
  }
  return
  // process.exit();

      // for(var i in data) {
      //   // console.log(domain);
      //   pool.query(sql, data[i], function (error) {
      //     if (error) console.log(error)
      //     // else console.log('Домен '+domain+' добавлены');
      //     console.log('Домен '+data[i]+' добавлены');
      //     process.exit();
      //     });
      //   // try {
      //   //   } catch (err) {
      //   //       if (err.code === 'ER_DUP_ENTRY') {
      //   //         console.log('Dublicat');
      //   //         // handleHttpErrors(SYSTEM_ERRORS.USER_ALREADY_EXISTS);
      //   //       } else {
      //   //         // handleHttpErrors(err.message);
      //   //         console.log(err.message);
      //   //       }
      //   //   }
      // }
// return



      // pool.query(sql, [chunk(data, 1)], function (err) {
      //   if (err) throw err;
      //   console.log('Данные добавлены');
      //   process.exit();
      // });
  
      // conn.query(sql, [values], function(err) {
      //     if (err) throw err;
      //     conn.end();
      // });
      // console.log(data);
    // } catch (err) {
    //   console.log(err.message);
    // } finally {
    //   await closeConnection(page, browser);
    // }
};

scrapingExample();


// (async () => {
//   const browser = await puppeteer.launch();
//   const page = await browser.newPage();
//   await page.setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36');
//   await page.setViewport({
//     width: 1280,
//     height: 720,
//     deviceScaleFactor: 1,
//   });
//   let query = process.argv[2];

//   await page.goto('https://www.google.ru/search?q='+query+'&start=0', { waitUntil: "networkidle2" });
//   // await page.waitForTimeout(6000);

//   const result = await page.evaluate(() => {
//     let domain = document.querySelector('cite').firstChild.textContent;

//     return {
//       'Домен': domain,
//     }
//   });

//   return result;

//   // let query = process.argv[2];
//   let start = 0;
//   for (let start = 0; start < 9; start = start+10){ // Проходимся в цикле по каждой 10ке выдачи
//     await page.goto('https://www.google.ru/search?q='+query+'&start='+start);
//     await page.waitForSelector('div.g', {visible: true,});
//     let domain = document.querySelector('cite').firstChild.textContent;
//     // let title = document.querySelector('cite').firstChild.textContent;

//     // page.waitForSelector('bar_value').then(() => console.log('First URL with image: ' + domain));

//     const result = await page.evaluate((domain) => {
//       let direct = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[0].children[0].innerText;
//       let organica = document.querySelector('div.d-flex.w-100.wrap2.row.row-cols-3.row-cols-xs-3.row-cols-md-6').childNodes[1].children[0].innerText;

//       return {
//         'Домен': domain,
//         '% c поиска': organica, 
//         'Прямые переходы': direct
//       }
//     }, domain);
//     await browser.close();
//     return result;
//   }
// })();