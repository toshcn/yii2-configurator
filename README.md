yii2-configurator
=================
一个简单的配置管理组件

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist toshcn/yii2-configurator "*"
```

or add

```
"toshcn/yii2-configurator": "*"
```

to the require section of your `composer.json` file.


Usage
-----

配置组件:

```php
'components' => [
    'config' => [
        'class' => 'toshcn\yii2\configurator\Configurator',
    ],
]

```

添加配置：基础模板在config->console.php，高级模板在console->config->main.php
```php
Yii::$app->config->createConfig('myconfig', json_encode(['key' => 'value']), 'my first config');
```

获取配置项:
```php
Yii::$app->config->getConfigItem('myconfig', 'key', 'defaultValue');
//返回 key对应的值 value, 如果key不存在，返回 'defaultValue'
```

获取全部配置项:
```php
Yii::$app->config->getConfigItemAll('myconfig', ['key' => 'defaultValue']);
//返回 myconfig 配置的全部项, 可以指定配置项的默认值，如果key不存在，key的值会设为'defaultValue'
```

