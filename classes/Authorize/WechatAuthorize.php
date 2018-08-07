<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/7
 * Time: 9:58 AM
 */

namespace Ecjia\App\Wechat\Authorize;


class WechatAuthorize
{

    const SNSAPI_USERINFO = 'snsapi_userinfo';


    protected $scope;

    public function __construct($scope = self::SNSAPI_USERINFO)
    {
        $this->scope = $scope;
    }


    /**
     * 生成授权网址
     */
    public function getAuthorizeUrl($callback_url = null)
    {
        if (is_null($callback_url)) {
            $callback_url = '';
        }

        $state = md5(uniqid(rand(), true));

        $params = array(
            'redirect_uri'  => $callback_url,
            'scope'         => self::SNSAPI_USERINFO,
            'state'         => $state,
        );

        $_SESSION['wechat_authorize_state'] = $state;

        $code_url = $this->oauth->getQRConnectCodeUrl($params);

        return $code_url;

    }


}