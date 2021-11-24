<?php

namespace backend\models;

use Yii;

class DomainAPI {
    private $token;
  
    // public function __construct($token) {
    //     $this->token = $token;
    // }
  
    // GET-запрос на указанный ресурс с переданными параметрами
    public function get($domain) {
        // $this->enableCsrfValidation = false;
        // $query_string = http_build_query($parameters);
        $curl = curl_init("http://localhost:3000/api/test/".$domain);
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_HTTPHEADER => array(
            //     // 'Authorization: Token '.$this->token,
            //     // 'csrf_param' => \Yii::$app->request->csrfParam,
            //     // 'csrf_token' => \Yii::$app->request->csrfToken,
            //     'Content-Type: application/json'
            // )
        ));
  
        // Получаем данные и закрывааем соединение
        $results = curl_exec($curl);
        curl_close($curl);
  
        return json_decode($results, true);
        // return $results;
    }

    public function getLi($domain) {
        $string = file_get_contents('https://counter.yadro.ru/values?site='.$domain);
        $array1 = [];
        $array2 = explode(';', $string);
        foreach($array2 as $str) {
            echo('<pre>');
            print_r(explode('=', $str));
            echo('</pre>');
    
            // list($key, $value) = explode('=', $str);
            // $array1[$key] = $value;
        }
        die;
        echo('<pre>');
        print_r($array1);
        echo('</pre>');
        die;
        // $this->enableCsrfValidation = false;
        // $query_string = http_build_query($parameters);
        $curl = curl_init("https://counter.yadro.ru/values?site=".$domain);
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_HTTPHEADER => array(
            //     // 'Authorization: Token '.$this->token,
            //     // 'csrf_param' => \Yii::$app->request->csrfParam,
            //     // 'csrf_token' => \Yii::$app->request->csrfToken,
            //     'Content-Type: application/json'
            // )
        ));
  
        // Получаем данные и закрывааем соединение
        $results = curl_exec($curl);
        $results = explode(';', $results);
        // $json = json_encode($results, false);
        var_dump($results);die;
        echo '<pre>';
        print_r($results);die;
        curl_close($curl);
  
        // return json_decode($results, true);
        // return $results;
    }

    public function put($resource, $parameters) {
        $query_string = http_build_query($parameters, '', '&');
        $curl = curl_init("http://localhost:3000/api/$resource");
        curl_setopt_array($curl, array(
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $query_string,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                // 'method' => 'POST',
                'csrf_param' => \Yii::$app->request->csrfParam,
                'csrf_token' => \Yii::$app->request->csrfToken,
                "Accept" => "application/json",
                "Content-Type" => "application/json"        
            )
        ));
  
        // Получаем данные и закрывааем соединение
        $results = curl_exec($curl);
        curl_close($curl);
  
        // Декодируем полученный json
        // параметр true для возвращения ассоциативного массива вместо объекта
        return json_decode($results, true);
    }
}
  
  
/******************************************************
 * Пример 1: Получаем экскурсии в Москве (первые 10)
 ******************************************************/
// $api = new TripsterAPI("xxxxxxxxxx6614887d94913470d64e1775c9a33c");
// $result = $api->get("experiences", array("city__name_ru" => "Москва"));
// print_r($result);
  
// /******************************************************
//  * Пример 2: Получаем все экскурсии в Москве
//  * и складываем в отдельный массив
//  ******************************************************/
// $api = new TripsterAPI("xxxxxxxxxx6614887d94913470d64e1775c9a33c");
// $experiences = array();
  
// $page = 1;
// while(true) {
//     print("Страница $page\n");
  
//     $page_results = $api->get("experiences", array(
//         "city__name_ru" => "Москва",
//         "page_size" => 100,
//         "page" => $page,       
//     ));
  
//     // Добавляем экскурсии к общему массиву экскурсий
//     $experiences = array_merge($experiences, $page_results["results"]);
  
//     // Если это последняя страница — заканчиваем, иначе запрашиваем следующую
//     if (!$page_results["next"]) break;
//     $page++;
// }
  
// // Выводим число экскурсий
// $experiences_count = count($experiences);
// print "Всего экскурсий в Москве: $experiences_count\n";
  
  
// /******************************************************
//  * Пример 3: Получаем все экскурсии в Москве
//  * и складываем рубрики в отдельный массив
//  ******************************************************/
// $api = new TripsterAPI("xxxxxxxxxx6614887d94913470d64e1775c9a33c");
// $tags = array();
  
// $page = 1;
// while(true) {
//     print("Страница $page\n");
  
//     $page_results = $api->get("experiences", array(
//         "city__name_ru" => "Москва",
//         "page_size" => 15,
//         "page" => $page,   
//     ));
  
//     // Вытаскиваем рубрики из каждой экскурсии и добавляем их
//     // в общий ассоциативный массив id => рубрика
//     foreach ($page_results["results"] as $experience) {
//         foreach ($experience["tags"] as $tag) {
//             $tags[$tag["id"]] = $tag;
//         }
//     }
  
//     // Если это последняя страница заканчиваем
//     if (!$page_results["next"]) break;
//     $page++;
// }
  
// // Выводим число рубрик
// $tags_count = count($tags);
// print "Число рубрик в Москве: $tags_count\n";
  
  
// /******************************************************
//  * Пример 4: Получаем рубрики экскурсии в Москве
//  * одним запросом
//  ******************************************************/
// $api = new TripsterAPI("xxxxxxxxxx6614887d94913470d64e1775c9a33c");
// $result = $api->get("citytags", array(
//     "city__name_ru" => "Москва",
//     "page_size" => 30,
// ));
// $tags = $result["results"];
  
// // Выводим число рубрик
// $tags_count = count($tags);
// print "Число рубрик в Москве: $tags_count\n";