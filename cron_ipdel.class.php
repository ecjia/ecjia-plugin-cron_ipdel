<?php
/**
 * 定期删除
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('cron_abstract', 'cron', false);

class cron_ipdel extends cron_abstract
{
    /**
     * 获取插件配置信息
     */
    public function configure_config() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        if (is_array($config)) {
            return $config;
        }
        return array();
    }
    
    /**
     * 计划任务执行方法
     */
    public function run() {
        
        empty($this->configure['ipdel_day']) && $cron['ipdel_day'] = 7;
        
        $deltime = gmtime() - $cron['ipdel_day'] * 3600 * 24;
        $sql = "DELETE FROM " . $ecs->table('stats') .
        "WHERE  access_time < '$deltime'";
        $db->query($sql);    
    }

}

// end