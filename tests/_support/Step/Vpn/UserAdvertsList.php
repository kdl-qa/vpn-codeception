<?php
namespace Step\Vpn;
use \Data\Flat;
use \Page\AdvertsList;
//use \Helper\Api;

class UserAdvertsList extends \VpnTester
{
    public function openUserAdvertsList()
    {
        $I=$this;
        $I->amOnPage('/user/adverts');
        $I->wait(3);
//        $I->see(Flat::category, 'html/body/div[1]/div[3]/div[2]/div/ul/li[1]/div[2]'); //Flat::categoryType1,Flat::city, Flat::street, Flat::houseNumber, Flat::flatNumber]);
    }

    public function openFirstListAdvert()
    {
        $I=$this;
        $I->waitForElement(AdvertsList::$firstListAdvert);
        $I->doubleClick(AdvertsList::$firstListAdvertTitle);
        $I->wait(3);
    }
    public function openSecondListAdvert()
    {
        $I  =$this;
        $I->waitForElement(AdvertsList::$firstListAdvert);
        $I->doubleClick(AdvertsList::$secondListAdvertTitle);
        $I->wait(3);
    }
    public function openThirdListAdvert()
    {
        $I  =$this;
        $I->waitForElement(AdvertsList::$firstListAdvert);
        $I->doubleClick(AdvertsList::$thirdListAdvertTitle);
        $I->wait(3);
    }

    public function newFlatAdvertContains()
    {
        $I=$this;
        $I->amOnPage(AdvertsList::$URL);
        $I->waitForElement(AdvertsList::$firstListAdvert);
        $I->see(Flat::category, AdvertsList::$firstListAdvert);
        $I->see(Flat::categoryType1, AdvertsList::$firstListAdvert);
        $I->see(Flat::city, AdvertsList::$firstListAdvert);
        $I->see(Flat::street, AdvertsList::$firstListAdvert);
        $I->see(Flat::houseNumber, AdvertsList::$firstListAdvert);
        $I->see(Flat::$currentFlatNumber, AdvertsList::$firstListAdvert);

    }

    public function checkAdvFlatProperties()
    {
        $I=$this;
        $advFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advFlatId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
        $I->see(Flat::status0, AdvertsList::$editAdvStatus);
        $I->click(AdvertsList::$editAdvObjInfoTab);
        $I->see(Flat::category, AdvertsList::$editAdvObjTable);
        $I->see(Flat::categoryType0, AdvertsList::$editAdvObjTable);
        $I->see(Flat::region, AdvertsList::$editAdvObjTable);
        $I->see(Flat::city, AdvertsList::$editAdvObjTable);
        $I->see(Flat::houseNumber, AdvertsList::$editAdvObjTable);
        $I->see(Flat::$currentFlatNumber, AdvertsList::$editAdvObjTable);
        $I->click(AdvertsList::$editAdvTab);
        $I->waitForElement(AdvertsList::$editAdvDescription);
        $I->see(Flat::operationType1, AdvertsList::$editAdvOperationType);
        $desVal = $I->grabValueFrom(AdvertsList::$editAdvDescription);
        codecept_debug($desVal);
        if($desVal !== Flat::descriptionFlatSell) {
            $I->see('error!!!');
        }
//        $I->see(Flat::descriptionFlatSell, AdvertsList::$editAdvDescription);
//        $I->seeInFormFields('form[name=createAdvertForm]',['description' => Flat::descriptionFlatSell]);
//        $I->seeInField(AdvertsList::$editAdvDescription, Flat::descriptionFlatSell);
        $priceVal = $I->grabValueFrom(AdvertsList::$editAdvPrice);
        codecept_debug($priceVal);
        if($priceVal !== Flat::priceFlatSell) {
            $I->see('error!!!');
        }
//        $I->see(Flat::priceFlatSell, AdvertsList::$editAdvPrice);
        $I->see(Flat::market1, AdvertsList::$editAdvMarketType);
        $I->see(Flat::repair0, AdvertsList::$editAdvRepair);
        $ownNameVal = $I->grabValueFrom(AdvertsList::$editAdvOwnerName);
        codecept_debug($ownNameVal);
        if($ownNameVal !== Flat::ownerName) {
            $I->see('error!!!');
        }
//        $I->see(Flat::ownerName, AdvertsList::$editAdvOwnerName);
        $ownContactVal = $I->grabValueFrom(AdvertsList::$editAdvOwnerContacts);
        codecept_debug($ownContactVal);
        if($ownContactVal !== Flat::ownerContacts) {
            $I->see('error!!!');
        }
//        $I->see(Flat::ownerContacts, AdvertsList::$editAdvOwnerContacts);

        $I->see('Я владелец', AdvertsList::$editAdvOwnerLink);
        $I->see('Сохранить', AdvertsList::$editAdvSubmit);
    }

}