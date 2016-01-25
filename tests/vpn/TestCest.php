<?php


class TestCest
{

    protected function agencyLogin(VpnTester $I)
    {
        $I->loginAgency();
    }
    protected function agentLogin(VpnTester $I)
    {
        $I->loginAgent1();
    }
    protected function userLogin(VpnTester $I)
    {
        $I->userLogin();
    }

    protected function loginAgency(VpnTester $I)
    {
        $I->loginAgency1();
    }

    protected function moderateAdv($admin)
    {
        $admin->loginAdmin();
        $admin->moderateAdvActive();
    }

    protected function open1stAdvert($list)
    {
        $list->openUserAdvertsList();
        $list->openFirstListAdvert();
    }
    protected function addGarageSaleAdvert($api)
    {
        $api->realtyGarageAddComplex();
        $api->apiAdvertGarageAddPlain();
        $api->apiAdminEditGarageAdvertPlain();

    }

    protected function uploadImages(VpnTester $I)
    {
        $I->uploadAdvImages();
        $I->uploadSchema();
    }
    protected function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }
    /**
     * @before uploadImages
     * @before login
     */
    public function addEditCheckGarageSaleAdvert(VpnTester $api, \Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $he, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $this->addGarageSaleAdvert($api);

        $I->loginAgency();
        $I->openEditGaragePage();
        $I->editGarageAdvert();
        $I->fillInEditGarageAdvertCheckboxes();
        $he->uploadGarageImage();
        $he->clickIamOwnerLink();
        $he->clickCreateAdvertButton();
        $he->acceptModal();

        //todo: add admin function to do 2nd moderate (new functional)
        $this->moderateAdv($admin);

        $this->open1stAdvert($list);

        $I->checkEditedGarageProperties();
    }
//    /**
//     * @before loginAgency
//     */
//    public function createModerateCheckGarageSaleComplex(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
//    {
//        $I->fillInStandardGarageType();
//        $I->fillInGarageAddress();
//        $I->fillInGarageObjPropertiesComplex();
//        $I->checkGarageObjectPropertiesComplex();
//        $I->agreeObjectProperties();
//        $I->fillInGarageAdvertPropertiesComplex();
//        $I->fillInGarageAdvertCheckboxesComplex();
//        $I->uploadGarageImage();
//        $I->clickIamOwnerLink();
//        $I->clickCreateAdvertButton();
//        $I->acceptModal();
//
//        $this->moderateAdv($admin);
//        $this->open1stAdvert($list);
//
//        $I->checkGaragePropertiesComplex();
//    }
//    /**
//     * @before loginAgency
//     */
//    public function createModerateCheckGarageSalePlain(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
//    {
//        $I->fillInStandardGarageType();
//        $I->fillInGarageAddress();
//        $I->fillInGarageObjPropertiesPlain();
//        $I->checkGarageObjectPropertiesPlain();
//        $I->agreeObjectProperties();
//        $I->fillInGarageAdvertPropertiesPlain();
//        $I->clickIamOwnerLink();
//        $I->clickCreateAdvertButton();
//        $I->acceptModal();
//
//        $this->moderateAdv($admin);
//        $this->open1stAdvert($list);
//
//        $I->checkGaragePropertiesPlain();
//    }


//    /**
//     * @before agencyLogin
//     */
//    public function createGroupByAgency(\Step\Vpn\AnnouncementList $I, \Step\Vpn\UserAdvertsList $list)
//    {
//        $I->createAnnouncementList();
//        $list->openUserAdvertsList();
//        $list->openFirstListAdvert();
//        $I->addAdvertToGroupFromAdvPage();
//
//        $list->openUserAdvertsList();
//        $list->openSecondListAdvert();
//        $I->addAdvertToGroupFromAdvPage();
//
//        $list->openUserAdvertsList();
//        $list->openThirdListAdvert();
//        $I->addAdvertToGroupFromAdvPage();
//
//
//        $I->sendGroupToUser();
////        $I->pauseExecution();
//
//    }
//
//    /**
//     * @before userLogin
//     */
//    public function viewAdvert(\Step\Vpn\AnnouncementList $I)
//    {
//        $I->viewAgencyGroup();
//
//    }
//
//    /**
//     * @before agencyLogin
//     */
//    public function editDeleteAdv(\Step\Vpn\AnnouncementList $I)
//    {
//        $I->editGroupSaveInterest();
//        $I->deleteAdvert();
//        $I->deleteGroup();
//    }
//
//
//    /**
//     * @before agentLogin
//     */
//
//    public function createGroup(\Step\Vpn\AnnouncementList $I, \Step\Vpn\Search $search)
//    {
//        $I->createAnnouncementList();
//        $search->searchFlatCategory();
//        $I->addAdvertToGroupFromListResultSearch();
//
//        $search->mapSearchHouseCategory();
//        $I->addAdvertToGroupFromListResultSearch();
//
//        $I->sendGroupToUser();
//
////        $I->pauseExecution();
//    }
//
//    /**
//     * @before userLogin
//     */
//    public function viewAdverts(\Step\Vpn\AnnouncementList $I)
//    {
//        $I->viewAgentGroup();
//
//    }
//    /**
//     * @before agentLogin
//     */
//    public function deleteAgentGroup(\Step\Vpn\AnnouncementList $I)
//    {
//        $I->editGroupResetInterest();
//        $I->deleteAdvert();
//        $I->deleteGroup();
//    }




}