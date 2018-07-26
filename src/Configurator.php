<?php
/**
 * @link https://gitee.com/toshcn/yii2-ant-menu
 * @copyright Copyright (c) 2018 len168.com
 */

namespace toshcn\yii2\configurator;

use toshcn\yii2\configurator\models\Config;
use yii\base\Object;
use yii\caching\Cache;
use yii\di\Instance;

/**
 * This is just an example.
 */
class Configurator extends Object
{
    public $version = '1.0.0';
    
    /**
     * @var string 缓存组件
     */
    public $cache = 'cache';

    /**
     * @var string 缓存key
     */
    public $cacheKey = 'toshcn_yii2_configurator_';

    /**
     * @var int 缓存时间
     */
    public $expire = 36000;

    /**
     * Configurator constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->cache = Instance::ensure($this->cache, Cache::className());
    }

    /**
     * 通过配置名称 获取配置
     * @param string $name 配置名称
     * @return null|static
     */
    public function findConfig($name)
    {
        $key = __CLASS__ . $this->cacheKey . $name;
        $config = $this->cache->get($key);
        if ($config === false) {
            $config = Config::findByConfigName($name);
            $this->cache->set($key, $config, $this->expire);
        }

        return $config;
    }

    /**
     * 通过配置ID 获取配置
     * @param integer $id 配置id
     * @return null|static
     */
    public function findConfigById($id)
    {
        $key = __CLASS__ . $this->cacheKey . $id;
        $config = $this->cache->get($key);
        if ($config === false) {
            $config = Config::findById($id);
            $this->cache->set($key, $config, $this->expire);
        }

        return $config;
    }

    /**
     * 获取单个配置项
     * @param $name 配置名称
     * @param $item 配置项
     * @param string $default 配置项默认值
     * @return string
     */
    public function getConfigItem($name, $item, $default = '')
    {
        if ($config = $this->findConfig($name)) {
            if ($data = json_decode($config->config_content, true)) {
                return isset($data[$item]) ? $data[$item] : $default;
            }
        }

        return $default;
    }

    /**
     * 获取全部配置项
     * @param $name 配置名称
     * @param array $items 配置项数组，键值对【配置项=>配置项默认值】
     * @return array
     */
    public function getConfigItemAll($name, $items = [])
    {
        if ($config = $this->findConfig($name)) {
            $data = json_decode($config->config_content, true);
            foreach ($items as $key => $value) {
                $items[$key] = isset($data[$key]) ? $data[$key] : $value;
            }

            return $items ? $items : $data;
        }

        return $items;
    }

    /**
     * 创建配置
     * @param $name 配置名称
     * @param string $content 配置内容，json字符串
     * @param string $description 配置描述
     * @return Config
     */
    public function createConfig($name, $content, $description = '')
    {
        $model = new Config();
        $model->config_name = $name;
        $model->config_content = $content;
        $model->config_description = $description;
        $model->create_at = date('Y-m-d H:i:s');
        $model->save();

        return $model;
    }

    /**
     * 更新配置
     * @param $name 配置名称
     * @param string $content 配置内容，json字符串
     * @param string $description 配置描述
     * @return bool
     */
    public function updateConfig($name, $content, $description = '')
    {
        if ($model = Config::findByConfigName($name)) {
            $model->config_content     = $content;
            $model->config_description = $description;
            $model->update_at          = date('Y-m-d H:i:s');
            $key = __CLASS__ . $this->cacheKey . $name;
            $this->cache->delete($key);
            return $model->save();
        }

        return false;
    }

    /**
     * 通过配置ID 更新配置
     * @param integer $id 配置ID
     * @param string $content 配置内容，json字符串
     * @param string $description 配置描述
     * @return bool
     */
    public function updateConfigById($id, $content, $description = '')
    {
        if ($model = Config::findById($id)) {
            $model->config_content     = $content;
            $model->config_description = $description;
            $model->update_at          = date('Y-m-d H:i:s');
            $key = __CLASS__ . $this->cacheKey . $id;
            $this->cache->delete($key);
            return $model->save();
        }

        return false;
    }
}
