<?php
use \VpnTester;
use \Page\AddAdvert;
use \Page\BackoffAdverts;
use \Step\Vpn\AdminAdvert;
use \Data\Flat;



class AddAdvertCest
{
    public function _before(VpnTester $I)
    {
//        $I->apiAgencyLogin();



        $I->loginAgency();
    }

    public function createAdvertWithApi(Step\Vpn\UserAdvertsList $I)
    {
        $I->openUserAdvertsList();
        $I->openFirstListAdvert();
    }

    // tests
//    public function webAdmLogin(VpnTester $I, \Step\Vpn\AdminAdvert $check)
//    {
//        $I->loginAdmin();
//        $check->moderateAdvActive();
//    }



//
//    public function admLogin(VpnTester $I)
//    {
//        $I->apiAdminLogin();
//
//    }
//
//    public function admLogout(VpnTester $I)
//    {
//        $I->apiAdminLogout();
//
//    }



//    public function zxc(VpnTester $I)
//    {
//        $I->apiAgencyLogout();
//        $I->apiAgencyLogin();
//    }
//
//    public function asd(VpnTester $I)
//    {
//        $I->uploadUserAvatar();
//        $I->uploadLogo();
//        $I->uploadSchema();
//        $I->uploadAdvImage();
//
//    }

//    public function addFlatSuccessfully(\Step\Vpn\Advert $I, \Step\Vpn\UserAdvertsList $listSteps)
//    {
//
//
//        $I->fillInStandardFlatType();
//        $I->fillInStandardFlatAddress();
//        $I->seeInModal(AddAdvert::$step1PopUpTitle);
//        $I->acceptModal();
//        $I->fillInStandardFlatProperties();
//        $I->checkFlatObjectPropertiesComplex();
//        $I->agreeFlatObjectProperties();
//        $I->fillInFlatAdvertPropertiesComplex();
//        $I->fillInFlatAdvertCheckboxesComplex();
//        $I->uploadFlatAdvertImage();
//        $I->fillInOwnerContactsData();
////        $I->pauseExecution();
//        $I->clickCreateAdvertButton();
//        $I->acceptModal();
//        $listSteps->newFlatAdvertContains();

    // ----------------


        /*$I->click(AddAdvert::$furnitureFirst);
        $I->click(AddAdvert::$furnitureLast);
        $I->click(AddAdvert::$appliancesFirst);
        $I->click(AddAdvert::$appliancesLast);
        $I->click(AddAdvert::$additionalFirst);
        $I->click(AddAdvert::$additionalLast);
        $I->attachFile(AddAdvert::$galleryFile, 'flat_1.jpg');
        $I->wait(1);
        $I->attachFile(AddAdvert::$galleryFile, 'flat_2.jpg');
        $I->wait(1);
        $I->attachFile(AddAdvert::$galleryFile, 'flat_3.jpg');
        $I->wait(1);
        $I->fillField(AddAdvert::$ownerName,Flat::ownerName);
        $I->fillField(AddAdvert::$ownerContacts,Flat::ownerContacts);
        $I->click(AddAdvert::$createAdvertButton);
        $I->wait(2);
        $I->click(AddAdvert::$step3_Good);
*/
//        $I->amOnPage('/user/adverts');
//        $I->wait(3);
//        $I->see(Flat::category, 'html/body/div[1]/div[3]/div[2]/div/ul/li[1]'); //Flat::categoryType1,Flat::city, Flat::street, Flat::houseNumber, Flat::flatNumber]);

//    }

//    public function addRent(\Step\Vpn\Advert $I)
//    {
//        $I->expect('someday it will work');
//    }
}
