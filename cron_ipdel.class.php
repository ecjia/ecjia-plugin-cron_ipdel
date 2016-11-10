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
        $limit = !empty($this->configure['ipdel_day']) ? $this->configure['ipdel_day'] : 7;
        $deltime = RC_Time::gmtime() - $this->configure['ipdel_day'] * 3600 * 24;
        RC_DB::table('stats')->where('access_time', '<', $deltime)->delete();
    }
}

// end