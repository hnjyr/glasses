<?php

namespace app\store\controller;

use app\store\service\Auth;
use app\store\service\Menus;
use app\store\model\Setting;
use app\common\exception\BaseException;

use think\Request;
use think\Session;

/**
 * 商户后台控制器基类
 * Class BaseController
 * @package app\store\controller
 */
class Controller extends \think\Controller
{
    /** @var array $store 商家登录信息 */
    protected $store;

    /** @var string $route 当前控制器名称 */
    protected $controller = '';

    /** @var string $route 当前方法名称 */
    protected $action = '';

    /** @var string $route 当前路由uri */
    protected $routeUri = '';

    /** @var string $route 当前路由：分组名称 */
    protected $group = '';

    /** @var array $allowAllAction 登录验证白名单 */
    protected $allowAllAction = [
        // 登录页面
        'passport/login',
        'passport/register',
        'new_order/list',
        'passport/is_user',
        'wxapp.index/index',
        'wxapp.index/login',
        'wxapp.index/smscode',
        'wxapp.index/orderList',
        'wxapp.index/userlist',
        'wxapp.index/indexList',
        'inventory.other/getmodellist',
        'inventory.other/getspeclist',
    ];

    /* @var array $notLayoutAction 无需全局layout */
    protected $notLayoutAction = [
        // 登录页面
        'passport/login',
        'passport/register',
        'passport/is_user',
        'inventory.other/getmodellist',
        'inventory.other/getspeclist',

    ];

    /**
     * 后台初始化
     * @throws BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        // 商家登录信息
        $this->store = Session::get('yoshop_store');
        // 当前路由信息
        $this->getRouteinfo();
        // 验证登录状态
        $this->checkLogin();
        // 验证当前页面权限
        $this->checkPrivilege();
        // 全局layout
        $this->layout();
    }

    /**
     * 验证当前页面权限
     * @throws BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function checkPrivilege()
    {
        if ($this->routeUri === 'index/index') {
            return true;
        }
        if ($this->routeUri === 'wxapp.index/index') {
            return true;
        }
        if ($this->routeUri === 'wxapp.index/login') {
            return true;
        }
        if ($this->routeUri === 'wxapp.index/smscode') {
            return true;
        }
        if ($this->routeUri === 'wxapp.index/userlist') {
            return true;
        }
        if ($this->routeUri === 'wxapp.index/indexList') {
            return true;
        }
        if ($this->routeUri === 'wxapp.index/orderList') {
            return true;
        }
        if ($this->routeUri === 'inventory.other/getmodellist') {
            return true;
        }
        if ($this->routeUri === 'inventory.other/getspeclist') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/getmodellist') {
            return true;
        }
        if ($this->routeUri === 'inventory.other/getbrandlist') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/getbrandlist') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/getrefracitivelist') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/getspeclist') {
            return true;
        }
        if ($this->routeUri === 'inventory.glasses/getbrandlist') {
            return true;
        }
        if ($this->routeUri === 'inventory.glasses/getmodellist') {
            return true;
        }
        if ($this->routeUri === 'inventory.glasses/getspeclist') {
            return true;
        }
        if ($this->routeUri === 'inventory.contact/getbrandlist') {
            return true;
        }
        if ($this->routeUri === 'inventory.contact/getmodellist') {
            return true;
        }
        if ($this->routeUri === 'inventory.contact/getspeclist') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/del_brand') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/del_model') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/del_refracitive') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/del_spec') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/update_brand') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/update_model') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/update_refracitive') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/update_spec') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/add_brand') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/add_refracitive') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/add_model') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/add_spec') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/add_colorspec') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/update_colorspec') {
            return true;
        }
        if ($this->routeUri === 'inventory.contact/getcolor') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/del_color') {
            return true;
        }

        if ($this->routeUri === 'inventory.contact/gettypelist') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/del_type') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/update_type') {
            return true;
        }
        if ($this->routeUri === 'inventory.index/add_type') {
            return true;
        }
        if ($this->routeUri === 'inventory.contact.type/gettype') {
            return true;
        }
        if ($this->routeUri === 'passport/is_user') {
            return true;
        }
//        dump($this->routeUri);
        if (!Auth::getInstance()->checkPrivilege($this->routeUri)) {
            throw new BaseException(['msg' => '很抱歉，没有访问权限!']);
        }
        return true;
    }

    /**
     * 全局layout模板输出
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    private function layout()
    {
        // 验证当前请求是否在白名单
        if (!in_array($this->routeUri, $this->notLayoutAction)) {
            // 输出到view
            $this->assign([
                'base_url' => base_url(),                      // 当前域名
                'store_url' => url('/store'),              // 后台模块url
                'group' => $this->group,                       // 当前控制器分组
                'menus' => $this->menus(),                     // 后台菜单
                'store' => $this->store,                       // 商家登录信息
                'setting' => Setting::getAll() ?: null,        // 当前商城设置
                'request' => Request::instance(),              // Request对象
                'version' => get_version(),                    // 系统版本号
            ]);
        }
    }

    /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    protected function getRouteinfo()
    {
        // 控制器名称
        $this->controller = toUnderScore($this->request->controller());
        // 方法名称
        $this->action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        $groupstr = strstr($this->controller, '.', true);
        $this->group = $groupstr !== false ? $groupstr : $this->controller;
        // 当前uri
        $this->routeUri = $this->controller . '/' . $this->action;
    }

    /**
     * 后台菜单配置
     * @return mixed
     * @throws \think\exception\DbException
     */
    protected function menus()
    {
        static $menus = [];
        if (empty($menus)) {
            $menus = Menus::getInstance()->getMenus($this->routeUri, $this->group);
        }

        return $menus;
    }

    /**
     * 验证登录状态
     * @return bool
     */
    private function checkLogin()
    {
        // 验证当前请求是否在白名单
        if (in_array($this->routeUri, $this->allowAllAction)) {
            return true;
        }
        // 验证登录状态
        if (empty($this->store)
            || (int)$this->store['is_login'] !== 1
//            || !isset($this->store['wxapp'])
//            || empty($this->store['wxapp'])
        )
        {
            $this->redirect('passport/login');
            return false;
        }
        return true;
    }

    /**
     * 获取当前wxapp_id
     */
    protected function getWxappId()
    {
        return $this->store['wxapp']['wxapp_id'];
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }

    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return $this->renderJson(1, $msg, $url, $data);
    }

    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array|bool
     */
    protected function renderError($msg = 'error', $url = '', $data = [])
    {
        if ($this->request->isAjax()) {
            return $this->renderJson(0, $msg, $url, $data);
        }
        $this->error($msg);
        return false;
    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key = null)
    {
        return $this->request->post(is_null($key) ? '' : $key . '/a');
    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function getData($key = null)
    {
        return $this->request->get(is_null($key) ? '' : $key);
    }

}
