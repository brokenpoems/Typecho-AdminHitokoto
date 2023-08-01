<?php
/**
 * AdminHitokoto
 *
 * @package AdminHitokoto
 * @author brokenpoems
 * @version 1.0.0
 * @link https://github.com/brokenpoems/Typecho-Admin-hitokoto
 */

class AdminHitokoto_Plugin implements Typecho_Plugin_Interface
{
    /* 激活插件方法 */
    public static function activate()
    {
        Typecho_Plugin::factory('admin/menu.php')->navBar = __CLASS__ . '::render';
    }
    
    /* 禁用插件方法 */
    public static function deactivate()
    {
    }
    /**
     *
     * a   动画
     * b   漫画
     * c   游戏
     * d   文学
     * e   原创
     * f   来自网络
     * g   其他
     * h   影视
     * i   诗词
     * j   网易云
     * k   哲学
     * l   抖机灵
     */
    /* 插件配置方法 */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        // 一言API设置
        $api_url = new Typecho_Widget_Helper_Form_Element_Text('api_url', NULL, 'http://v1.hitokoto.cn/', _t('一言API'));
        $form->addInput($api_url);
        
        // 句子类型设置
        $sentence_type = new Typecho_Widget_Helper_Form_Element_Checkbox('sentence_type', array(
            'a' => _t('动画'),
            'b' => _t('漫画'),
            'c' => _t('游戏'),
            'd' => _t('文学'),
            'e' => _t('原创'),
            'f' => _t('来自网络'),
            'g' => _t('其他'),
            'h' => _t('影视'),
            'i' => _t('诗词'),
            'j' => _t('网易云'),
            'k' => _t('哲学'),
            'l' => _t('抖机灵')
        ), array(
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l'
        ), _t('句子类型'), _t('如果什么都没选按照v1的api请求是全选的意思'));
        $form->addInput($sentence_type);
    }
    
    /* 个人用户的配置方法 */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }
    
    /* 插件实现方法 */
    public static function render()
    {
        $plugin = Typecho_Widget::widget('Widget_Options')->Plugin('AdminHitokoto');
        $apiurl = $plugin->api_url . '?encode=text';
        if ($plugin->sentence_type) {
            if (is_array($plugin->sentence_type)) {
                $sentence = $plugin->sentence_type;
                foreach ($sentence as $opt) {
                    $apiurl = $apiurl . '&c=' . $opt;
                }
            }
        }
        $hitokoto = file_get_contents($apiurl);
        
        echo '<span class="message success">' . $hitokoto . '</span>';
        //echo $apiurl;
    }
    
}
