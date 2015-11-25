<?php
use \VpnTester;

class apiTestCest
{
    protected function login(VpnTester $I)
    {
        $I->apiAdminLogin();
    }

    protected function uploadLogo(VpnTester $I)
    {
        $I->uploadLogo();
    }
//
//    protected function addRealty(VpnTester $I)
//    {
//        $I->realtyFlatAddPlain();
//    }
//
//    protected function addAdvert(VpnTester $I)
//    {
//        $I->apiAdvertFlatAddPlain();
//    }
//
    /**
     *@before uploadLogo
     *@before login
     */
    public function getProjectInfo(VpnTester $I)
    {
//        $I->apiGetProjectInfo();
//        $I->apiGetInfoPage();
//        $I->apiEditProjectInfo();
        $I->apiCorrectEditProjectInfo();
    }
}
