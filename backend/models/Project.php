<?php

namespace backend\models;

use Codeception\Lib\Interfaces\ActiveRecord;
use creocoder\taggable\TaggableBehavior;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ClientException;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use GuzzleHttp\Psr7;
use common\models\User;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string $keywords
 * @property int|null $user_id
 * @property int|null $created_at
 */
class Project extends \yii\db\ActiveRecord
{    
    public static $headers = [
        // 'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36',
        // 'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; America Online Browser 1.1; rev1.2; Windows NT 5.1; SV1; .NET CLR 1.1.4322)',
        // 'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 8.0; AOL 9.6; AOLBuild 4340.122; Windows NT 5.1; Trident/4.0; FunWebProducts)',
        // 'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36',
        
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'Accept-Encoding: identity',
        'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cache-Control: no-cache',
        'Connection: keep-alive',
        // 'Host: '.parse_url($url)['host'],
        'Pragma: no-cache',
        'Sec-Fetch-Dest: document',
        'Sec-Fetch-Mode: navigate',
        'Sec-Fetch-Site: none',
        'Sec-Fetch-User: ?1',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36',
  
        
        'Content-type' => 'text/html',
        // 'Accept' => 'text/html',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
      ];
  
      public static $proxy = [
            'http' => '45.158.15.198:808',
            // 'https' => '168.176.55.16:8080',
            // 'https' => '194.233.73.108:443',
            // 'https' => '164.132.56.66:8080',
      ];  

    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'project';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => 'updater_id',
            ],
            'taggable' => [
                'class' => TaggableBehavior::class,
                // 'tagValuesAsArray' => false,
                'tagRelation' => 'domains',
                'tagValueAttribute' => 'domain',
                // 'tagFrequencyAttribute' => 'frequency',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'keywords'], 'required'],
            [['author_id', 'created_at', 'updated_at', 'total'], 'integer'],
            [['name', 'keywords'], 'string', 'max' => 255],
            ['updated_at', 'default',
                'value' => function () {
                    return date(DATE_ATOM);
                }
            ],
            ['tagValues', 'safe'],
            ['author_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            // [['name'], 'unique'],
            [['created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название проекта',
            'keywords' => 'Ключевые слова',
            'author_id' => 'User ID',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'total' => 'Количество страниц выдачи'
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }
    
    public static function client($url, $subrequest = null, array$query = null)
    {
      // print_r(self::$proxy);die;
      $jar = new CookieJar();
      $client = new Client();
      try {
        $res = $client->request('GET', $url . $subrequest, [
          'headers' => self::$headers,
        //   'headers' => [
        //     // 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        //     // 'Accept-Encoding: identity',
        //     'Content-type: text/html; charset=utf-8',
        //     // 'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
        //     // 'Cache-Control: no-cache',
        //     // 'Connection: keep-alive',
        //     // 'Host: '.parse_url($url)['host'],
        //     // 'Pragma: no-cache',
        //     // 'Sec-Fetch-Dest: document',
        //     // 'Sec-Fetch-Mode: navigate',
        //     // 'Sec-Fetch-Site: none',
        //     // 'Sec-Fetch-User: ?1',
        //     // 'Upgrade-Insecure-Requests: 1',
        //     'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36',      
        //   ],
        //   'proxy' => self::$proxy,
          'query' => $query,
          // 'form_params' => [
          //   'field_name' => 'abc',
          //   'other_field' => '123',
          // ],
        ['connect_timeout' => 5, 'timeout' => 5],
        ['http_errors' => true],
        'cookies' => $jar,
        // 'debug' => true
        ]);
      } catch (ClientException $e) {
          echo Psr7\Message::toString($e->getRequest());
          echo Psr7\Message::toString($e->getResponse());
      }
      $body = iconv('windows-1251//IGNORE', 'utf-8//IGNORE', $res->getBody());
      $document = \phpQuery::newDocumentHTML($body);
      return $document;
      // var_dump($res);die;
    }

    public function getDomains()
    {
        return $this->hasMany(Domain::class, ['id' => 'domain_id'])
            ->viaTable('{{%domain_project}}', ['project_id' => 'id']);
    }
}
