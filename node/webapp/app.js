const express = require("express");
const fs = require("fs");
    
const app = express();
const jsonParser = express.json();
  
app.use(express.static(__dirname + "/public"));
  
const filePath = "domains.json";
const filePath1 = "users.json";
app.get("/api/users", function(req, res){
    setTimeout(() => {
        res.send(content);
    }, 5000);
    const content = fs.readFileSync(filePath1,"utf8");
    const users = JSON.parse(content);
});
app.get("/api/domains", function(req, res){
    const content = fs.readFileSync(filePath,"utf8");
    // const content = req.params.domain;
    const users = JSON.parse(content);
    res.send(users.name);
});
app.get("/api/test/:domain", function(req, res){
    // const content = fs.readFileSync(filePath,"utf8");
    const content = req.params.domain;
    const users = JSON.parse(content);
    res.send(users.name);
});

// получение одного пользователя по id
app.get("/api/domains/:id", function(req, res){
    const id = req.params.id; // получаем id
    const content = fs.readFileSync(filePath, "utf8");
    const users = JSON.parse(content);
    let user = null;
    // находим в массиве пользователя по id
    for(var i=0; i<users.length; i++){
        if(users[i].id==id){
            user = users[i];
            break;
        }
    }
    // отправляем пользователя
    if(user){
        res.send(user);
    }
    else{
        res.status(404).send();
    }
});
// получение отправленных данных
app.post("/api/domains", jsonParser, function (req, res) {
      
    if(!req.body) return res.sendStatus(400);
      
    const domainName = req.body.name;
    const domainID = req.body.id;
    // let user = {name: userName, age: userAge};
    let domain = {name: domainName, id: domainID};
      
    let data = fs.readFileSync(filePath, "utf8");
    let domains = JSON.parse(data);
      
    // находим максимальный id
    const id = Math.max.apply(Math,domains.map(function(o){return o.id;}))
    // увеличиваем его на единицу
    domain.id = id+1;
    // добавляем домен в массив
    domains.push(domain);
    data = JSON.stringify(domains);
    // перезаписываем файл с новыми данными
    fs.writeFileSync("domains.json", data);
    res.send(domain);
});
 // удаление пользователя по id
app.delete("/api/domains/:id", function(req, res){
       
    const id = req.params.id;
    let data = fs.readFileSync(filePath, "utf8");
    let users = JSON.parse(data);
    let index = -1;
    // находим индекс пользователя в массиве
    for(var i=0; i < users.length; i++){
        if(users[i].id==id){
            index=i;
            break;
        }
    }
    if(index > -1){
        // удаляем пользователя из массива по индексу
        const user = users.splice(index, 1)[0];
        data = JSON.stringify(users);
        fs.writeFileSync("domains.json", data);
        // отправляем удаленного пользователя
        res.send(user);
    }
    else{
        res.status(404).send();
    }
});
// изменение пользователя
app.put("/api/domains", jsonParser, function(req, res){
    if(!req.body) return res.sendStatus(400);
    const userId = req.body.id;
    const userName = req.body.name.trim();
    const userAge = req.body.age;
      
    let data = fs.readFileSync(filePath, "utf8");
    const users = JSON.parse(data);
    let user;
    for(var i=0; i<users.length; i++){
        if(users[i].id==userId){
            user = users[i];
            break;
        }
    }
    // изменяем данные у пользователя
    if(user){
        // user.age = userAge;
        user.name = userName.trim();
        data = JSON.stringify(users);
        fs.writeFileSync("domains.json", data);
        res.send(user);
    }
    else{
        res.status(404).send(user);
    }
});
   
app.listen(3000, function(){
    console.log("Сервер ожидает подключения...");
});
