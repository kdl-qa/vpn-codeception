<?php
use \VpnTester;
use \Page\AddAdvert;
use \Data\Flat;



class AddAdvertCest
{
//    public function _before(VpnTester $I)
//    {
//        $I->login();
//        $I->amOnPage('/new-advert/step1');
//        $I->waitForElement(AddAdvert::$yandexMap);
//    }

    public function createAdvertWithApi(VpnTester $I)
    {
        $I->createAdvert();
        $I->pauseExecution();
    }

    // tests
    public function addFlatSuccessfully(\Step\Vpn\Advert $I, \Step\Vpn\UserAdvertsList $listSteps)
    {
        $I->fillInStandardFlatType();
        $I->fillInStandardFlatAddress();
        $I->click(AddAdvert::$step1_submit);
        $I->seeInModal(AddAdvert::$step1PopUpTitle);
        $I->acceptModal();
        $I->fillInStandardFlatProperties();
        $I->checkFlatObjectProperties();
        $I->agreeFlatObjectProperties();
        $I->fillInFlatAdvertProperties();
        $I->fillInFlatAdvertCheckboxes();
        $I->uploadFlatAdvertImage();
        $I->fillInOwnerContactsData();
        $I->clickCreateAdvertButton();
        $I->acceptModal();
        $listSteps->newFlatAdvertContains();

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

    }

//    public function addRent(\Step\Vpn\Advert $I)
//    {
//        $I->expect('someday it will work');
//    }
}
