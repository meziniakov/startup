const scraperObject = {
    async scraper(browser, domain) {
        // let page = await browser.newPage();
        // await page.goto(this.url);
        // let urls = urls;
        let scrapedData = {};
        // let urls = await page.$$eval('section ol > li', links => {
        //     // Make sure the book to be scraped is in stock
        //     links = links.filter(link => link.querySelector('.instock.availability > i').textContent !== "In stock")
        //     // Extract the links from the data
        //     links = links.map(el => el.querySelector('h3 > a').href)
        //     return links;
        // });

        let parseMegaindex = (domain) => new Promise(async (resolve, reject) => {
            try {
                const dataObj = {};
                let page = await browser.newPage();
                // const be1 = `https://be1.ru/stat/${domain}`;
                // const metrica = `https://pro.metrica.guru/id?domains=${domain}`;
                // const webmaster = `https://webmaster.yandex.ru/siteinfo/?host=${domain}`;
                const megaindex = `https://ru.megaindex.com/info/${domain}`;
                console.log(`Перехожу по адресу: ${megaindex}`);
                await page.goto(megaindex, {waitUntil: 'networkidle2'});
                console.log(`Ожидаю загрузки селектора: #serp .count`);
                await page.waitForSelector('#serp .count');
                // await page.waitForTimeout(5000);

                let traffic = await page.$eval('#serp .count', traffic_organic => {
                    if(traffic_organic.textContent.includes('M')) {
                        return traffic_organic.textContent.replace(/[^0-9.,\s]/g,"")*1000000;
                    } else if(traffic_organic.textContent.includes('K')) {
                        return traffic_organic.textContent.replace(/[^0-9.,\s]/g,"")*1000;
                    } else {
                        return parseInt(traffic_organic.textContent);
                    }
                });
                dataObj['traffic'] = traffic ? traffic.toFixed(0) : '';
                console.log('Траффик:' + dataObj['traffic']);

                let traffic_season = (traffic !== '') ? (dataObj['traffic']*0.9).toFixed(0) : '';
                dataObj['traffic_season'] = traffic_season;
                console.log('Сезонный траффик:' + dataObj['traffic_season']);

                let project_stage = 10;
                dataObj['project_stage'] = project_stage;

                let profit_await = (traffic_season === '') ? '' : (traffic_season*0.3).toFixed(0);
                dataObj['profit_await'] = profit_await;
                console.log('Ожидаемый доход:' + dataObj['profit_await']);

                let evaluate_min = profit_await === '' ? '' : (project_stage*profit_await*0.5).toFixed(0);
                dataObj['evaluate_min'] = evaluate_min;

                let evaluate_middle = profit_await === '' ? '' : (project_stage*profit_await*0.75).toFixed(0);
                dataObj['evaluate_middle'] = evaluate_middle;

                let evaluate_max = profit_await === '' ? '' : (project_stage*profit_await).toFixed(0);
                dataObj['evaluate_max'] = evaluate_max;

                // dataObj['domain_age'] = await page.$eval('#set_vozrast', text => text ? text.textContent : '');
        
                // let index_Y = await page.$eval('#set_pages_in_yandex a', text => text.textContent);
                // dataObj['index_Y'] = index_Y ? index_Y : '';
        
                // let index_G = await page.$eval('#set_pages_in_google a', text => text.textContent);
                // dataObj['index_G'] = index_G ? index_G : '';
        
                // let megaindexTrustRank = await page.$eval('#set_trust_rank', text => text.innerText);
                // dataObj['megaindexTrustRank'] = megaindexTrustRank ? megaindexTrustRank : '';
        
                // let megaindexDomainRank = await page.$eval('#set_domain_rank', text => text.innerText);
                // dataObj['megaindexDomainRank'] = megaindexDomainRank ? megaindexDomainRank : '';
                await page.close();
                console.log('Done!');
                resolve(dataObj);

                // try {
                //     console.log('перехожу http://'+domain);
                //     await page.goto('http://'+domain, {waitUntil: 'load'});
                //     const date = new Date();
                //     let screen = `${domain}_${date.getTime()}.jpeg`;
                //     await page.screenshot({path: `../storage/web/screen/${screen}`, fullPage: false });
                //     dataObj['imageUrl'] = screen;
                // } catch(error) {
                //     console.log(error);
                // } finally {
                //     await page.close();
                //     console.log('Done!');
                //     resolve(dataObj);
                // }
            } catch (err) {
                console.log("Ошибка => ", err);
            }
        })
        // let currentPageData = await parseBe1(url);
        // let currentPageData = await parseMetrica(url);
        let currentPageData = await parseMegaindex(domain);
        // scrapedData.push(currentPageData);
        // // console.log(currentPageData);
        // return scrapedData;
        return currentPageData;
        // for (link in urls) {
        //     console.log("Opening "+urls[link])
        //     let currentPageData = await pagePromise('http://'+urls[link]);
        //     scrapedData.push(currentPageData);
        // }
        return scrapedData;
    }
}

module.exports = scraperObject;
