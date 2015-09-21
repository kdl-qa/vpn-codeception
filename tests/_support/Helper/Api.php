<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Data\User;

class Api extends \Codeception\Module
{

    /**
     * @var \Codeception\Module\REST
     */
    protected $restModule;

    protected $adIds = [];
    protected $token;

    function _before(\Codeception\TestCase $t)
    {
        $this->restModule = $this->getModule('REST');
    }

    function _after(\Codeception\TestCase $t)
    {
        foreach ($this->adIds as $adId) {
            $this->restModule->sendDELETE('/advert', ['id' => $adId]);
        }
    }

    function createAdvert($data = [])
    {
        $this->apiLogin();
        $this->adIds[] = $this->restModule->sendGET('/get-user');

        codecept_debug('Here is response: '.$this->restModule->response);
    }

    protected function apiLogin()
    {

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login', ['email'=> User::$agencyEmail, 'password' => User::$agencyPass]);
        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $this->debugSection('New Token', $token);
        $this->restModule->haveHttpHeader('token', $token);
    }

}
