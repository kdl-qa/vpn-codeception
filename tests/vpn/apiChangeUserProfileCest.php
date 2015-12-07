<?php
use \VpnTester;

class apiChangeUserProfileCest
{
    protected function uploadImages(VpnTester $I)
    {
        $I->uploadUserAvatar();
        $I->uploadLogo();
    }
    protected function uploadEditImages(VpnTester $I)
    {
        $I->uploadEditUserAvatar();
        $I->uploadEditLogo();
    }

    protected function apiAdminLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
    }
    protected function apiAgencyLoginTmp(VpnTester $I)
    {
        $I->apiAgencyLoginTmp();
    }
    protected function apiAgentLogin(VpnTester $I)
    {
        $I->apiAgentLogin();
    }
    protected function apiUserLogin(VpnTester $I)
    {
        $I->apiUserLogin();
    }


    /**
     *@before uploadImages
     *@before uploadEditImages
     *@before apiAdminLogin
     */

    public function checkSubdomain(VpnTester $I)
    {
        $I->checkAgencyDomain();
    }
    public function apiAdminRegistateAgency(VpnTester $I)
    {
        $I->apiAdminRegistrationAgency();
    }

    /**
     *@before apiAgencyLoginTmp
     */

    public function apiEditAgency(VpnTester $I)
    {
        $I->apiEditAgency();
    }


    /**
     *@before apiAgencyLoginTmp
     */
    public function createAgent (VpnTester $I)
    {
        $I->apiAgentRegistration();
    }
    /**
     *@before apiAgentLogin
     */
    public function editAgentProfile(VpnTester $I)
    {
        $I->apiEditAgent();
        $I->apiAgentDelete();
    }
    public function apiDeleteAgency(VpnTester $I)
    {
        $I->apiAgencyDelete();
    }
//todo: change password
//    public function apiUserRegistration(VpnTester $I)
//    {
//        $I->apiUserRegistration();
//    }
//
    /**
     *@before apiUserLogin
     */
    public function apiEditDeleteUser(VpnTester $I)
    {
        $I->apiEditUser();

    }

}
