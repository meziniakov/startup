const scraperObject = {
    async scraper(browser, url) {
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
        let pagePromise = (url) => new Promise(async (resolve, reject) => {
            const dataObj = {};
            let page = await browser.newPage();
            console.log(`Перехожу по адресу: ${url}...`);
            await page.goto(url, {waitUntil: 'networkidle2'});
            console.log(`Ожидаю селектор #similar_attendance`);
            await page.waitForTimeout(5000);
            await page.waitForSelector('#similar_attendance');
            // let domain = new URL(url).pathname.replace('/stat/', '');
            // console.log(`Ожидаю сбор домена ${domain}`);

            dataObj['title'] = await page.$eval('#set_title', text => text.textContent);
            console.log(`Sobral title: ${dataObj['title']}`);

            let traffic = await page.$eval('#similar_attendance text:nth-child(2)', text => text ? text.textContent : '');
            dataObj['traffic']  = traffic ? Number.parseInt(traffic.replace(/\s/g, '')) : '';
            console.log(`Sobral traffic: ${dataObj['traffic']}`);
            
            let direct = await page.$$eval('#similar_source tbody tr', similarSourceArr => {
                similarSourceArr = similarSourceArr.filter(source => source.textContent.includes('Директ'));
                similarSourceArr = similarSourceArr.map(source => source.textContent.replace('Директ', ''));
                return similarSourceArr[0];
            });

            let organic = await page.$$eval('#similar_source tbody tr', similarSourceArr => {
                similarSourceArr = similarSourceArr.filter(source => source.textContent.includes('Поиск'));
                similarSourceArr = similarSourceArr.map(source => source.textContent.replace('Поиск', ''));
                return similarSourceArr[0];
            });     
            
            dataObj['organic'] = organic ? parseFloat(organic.replace(',','.')) : '--';
            console.log(`Sobral organic: ${dataObj['organic']}`);
            dataObj['direct'] = direct ? parseFloat(direct.replace(',','.')) : '--';
            console.log(`Sobral direct: ${dataObj['direct']}`);
            
            let traffic_season = (traffic !== '') ? (dataObj['traffic']*0.9).toFixed(0) : '';
            dataObj['traffic_season'] = traffic_season;

            let project_stage = 10;
            dataObj['project_stage'] = project_stage;

            let profit_await = (traffic_season === '' || organic === '') ? '' : (traffic_season*dataObj['organic']*0.3+(100-dataObj['organic'])*0.3/2).toFixed(0);
            dataObj['profit_await'] = profit_await;
            
            let evaluate_min = profit_await === '' ? '' : (project_stage*profit_await*0.5).toFixed(0);
            dataObj['evaluate_min'] = evaluate_min;

            let evaluate_middle = profit_await === '' ? '' : (project_stage*profit_await*0.75).toFixed(0);
            dataObj['evaluate_middle'] = evaluate_middle;

            let evaluate_max = profit_await === '' ? '' : (project_stage*profit_await).toFixed(0);
            dataObj['evaluate_max'] = evaluate_max;

            dataObj['domain_age'] = await page.$eval('#set_vozrast', text => text ? text.textContent : '');
      
            dataObj['IKS'] = await page.$eval('#set_iks', text => Number.parseInt(text.innerText.replace(/\s/g, '')));

            let index_Y = await page.$eval('#set_pages_in_yandex a', text => text.textContent);
            dataObj['index_Y'] = index_Y ? index_Y : '';
      
            let index_G = await page.$eval('#set_pages_in_google a', text => text.textContent);
            dataObj['index_G'] = index_G ? index_G : '';
      
            let megaindexTrustRank = await page.$eval('#set_trust_rank', text => text.innerText);
            dataObj['megaindexTrustRank'] = megaindexTrustRank ? megaindexTrustRank : '';
      
            let megaindexDomainRank = await page.$eval('#set_domain_rank', text => text.innerText);
            dataObj['megaindexDomainRank'] = megaindexDomainRank ? megaindexDomainRank : '';

            dataObj['imageUrl'] = await page.$eval('#set_screenshot_desktop img', img => img.src);

            const element = await page.$('#set_visrep_site_counters_yandex');        // объявляем переменную с ElementHandle
            let date = new Date().getTime();
            let screen_path = `../storage/web/screen/${date}.jpeg`;
            await element.screenshot({path: screen_path, type: 'jpeg', quality: 80});
            dataObj['visrep_site_counters'] = screen_path;
            await page.close();
            // resolve(JSON.stringify(be1));
            resolve(dataObj);
        });
        let currentPageData = await pagePromise(url);
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
