<?php
use \VpnTester;

class apiAdminInfoPagesCest
{
    protected function login(VpnTester $I)
    {
        $I->apiAdminLogin();
    }

    /**
     *@before login
     */
    public function getProjectInfo(VpnTester $I)
    {

        $I->apiAdminAddInfoPage();
        $I->apiAdminInfoPages();
        $I->apiAdminEditInfoPage();
        $I->apiAdminInfoPages();
        $I->apiAdminDeleteInfoPage();
        $I->apiAdminInfoPages();

    }
}
