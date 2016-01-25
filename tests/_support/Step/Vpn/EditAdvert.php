<?php
namespace Step\Vpn;
use \Data\Flat;
use Data\Garage;
use \Data\House;
use \Data\Parcel;
use \Data\Commercial;
use \Page\AdvertsList;
use \Page\AddAdvert;
use \Page\AdvPage;
use \Data\Lists;
use \Facebook\WebDriver\WebDriverKeys;

class EditAdvert extends \VpnTester
{
/*========================================Flat===========================================*/

    public function openEditFlatPage()
    {
        $I=$this;
        $advFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advFlatId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
    }

    public function editFlatAdvert()
    {
        $I=$this;
        $I->click(AdvertsList::$editAdvTab);

        $I->click(AddAdvert::$editOTRent);
        $I->fillField(AddAdvert::$advDescription, Flat::editDescriptionFlatRent);
        $I->fillField(AddAdvert::$price, Flat::editPriceFlatRent);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUA);
        $I->click(AddAdvert::$auction);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Flat::editDate);
        $I->click(AddAdvert::$monthField);
        $I->click(AddAdvert::$month11);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Flat::editYear);
        $I->click(AddAdvert::$editMarket);
        $I->click(AddAdvert::$market1);
        $I->click(AddAdvert::$repairField);
        $I->click(AddAdvert::$repair2);
        $I->doubleClick(AddAdvert::$bedsCount);
        $I->fillField(AddAdvert::$bedsCount, Flat::editBeds);
    }

    public function fillInEditFlatAdvertCheckboxes()
    {
        $I = $this;
        $I->click(AddAdvert::$furniture0);
        $I->click(AddAdvert::$furniture1);
        $I->click(AddAdvert::$furniture2);
        $I->click(AddAdvert::$furniture3);
        $I->click(AddAdvert::$furniture4);
        $I->click(AddAdvert::$furniture5);
        $I->click(AddAdvert::$furniture6);
        $I->click(AddAdvert::$furniture7);

        $I->click(AddAdvert::$appliance0);
        $I->click(AddAdvert::$appliance1);
        $I->click(AddAdvert::$appliance2);
        $I->click(AddAdvert::$appliance3);
        $I->click(AddAdvert::$appliance4);
        $I->click(AddAdvert::$appliance5);
        $I->click(AddAdvert::$appliance6);
        $I->click(AddAdvert::$appliance7);

        $I->click(AddAdvert::$additional0);
        $I->click(AddAdvert::$additional1);
        $I->click(AddAdvert::$additional2);
        $I->click(AddAdvert::$additional3);
        $I->click(AddAdvert::$additional4);
        $I->click(AddAdvert::$additional5);
        $I->click(AddAdvert::$additional6);
        $I->click(AddAdvert::$additional7);
        $I->click(AddAdvert::$additional8);
        $I->click(AddAdvert::$additional9);
        $I->click(AddAdvert::$additional10);
        $I->click(AddAdvert::$additional11);
        $I->click(AddAdvert::$additional12);
        $I->click(AddAdvert::$additional13);
        $I->click(AddAdvert::$additional14);
        $I->click(AddAdvert::$additional15);
    }

    public function openAdvertPage()
    {
        $I=$this;
        $I->executeJS('window.scrollTo(0,0);');
        $I->click(AdvertsList::$advInfoTab);
        $I->waitForElement(AdvertsList::$advInfoLink);
        $I->click(AdvertsList::$advInfoLink);
        $I->wait(3);
    }

    public function checkEditedFlatProperties() //webUS-6
    {
        $I = $this;
//        $I->amOnPage();
//        $I->click(AdvertsList::$advInfoTab);
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Flat::priceFlatSell, AdvPage::$advInfoPrice);
        $I->see(Flat::editAvailableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Flat::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Flat::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial0, AdvPage::$advInfoMainProps);
        $I->see(Flat::floorNumber, AdvPage::$advInfoMainProps);
        $I->see(Flat::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Flat::editDescriptionFlatRent,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Flat::category, AdvPage::$advPropsTable);
        $I->see(Flat::categoryType0, AdvPage::$advPropsTable);
        $I->see(Flat::region, AdvPage::$advPropsTable);
        $I->see(Flat::city, AdvPage::$advPropsTable);
        $I->see(Flat::editDistrict, AdvPage::$advPropsTable);
        $I->see(Flat::editStreet, AdvPage::$advPropsTable);
        $I->see(Flat::generalArea, AdvPage::$advPropsTable);
        $I->see(Flat::livingArea, AdvPage::$advPropsTable);
        $I->see(Flat::kitchenArea, AdvPage::$advPropsTable);
        $I->see(Flat::market1, AdvPage::$advPropsTable);
        $I->see(Flat::roomCount, AdvPage::$advPropsTable);
        $I->see(Flat::editBeds, AdvPage::$advPropsTable);
        $I->see(Flat::floorNumber, AdvPage::$advPropsTable);
        $I->see(Flat::floors, AdvPage::$advPropsTable);
        $I->see(Flat::buildYear, AdvPage::$advPropsTable);
        $I->see(Lists::wc1, AdvPage::$advPropsTable);
        $I->see(Lists::balconies1, AdvPage::$advPropsTable);
        $I->see(Lists::heating1, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat1, AdvPage::$advPropsTable);
        $I->see(Lists::repair2, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject0, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject1, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject5, AdvPage::$advPropsTable);

        $I->see(Lists::furniture0, AdvPage::$advPropsTable);
        $I->see(Lists::furniture1, AdvPage::$advPropsTable);
        $I->see(Lists::furniture2, AdvPage::$advPropsTable);
        $I->see(Lists::furniture3, AdvPage::$advPropsTable);
        $I->see(Lists::furniture4, AdvPage::$advPropsTable);
        $I->see(Lists::furniture5, AdvPage::$advPropsTable);
        $I->see(Lists::furniture6, AdvPage::$advPropsTable);
        $I->see(Lists::furniture7, AdvPage::$advPropsTable);

        $I->see(Lists::appliance0, AdvPage::$advPropsTable);
        $I->see(Lists::appliance1, AdvPage::$advPropsTable);
        $I->see(Lists::appliance2, AdvPage::$advPropsTable);
        $I->see(Lists::appliance3, AdvPage::$advPropsTable);
        $I->see(Lists::appliance4, AdvPage::$advPropsTable);
        $I->see(Lists::appliance5, AdvPage::$advPropsTable);
        $I->see(Lists::appliance6, AdvPage::$advPropsTable);
        $I->see(Lists::appliance7, AdvPage::$advPropsTable);

        $I->see(Lists::additionalFlat0, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat1, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat2, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat3, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat4, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat5, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat6, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat7, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat8, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat9, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat10, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat11, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat12, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat13, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat14, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat15, AdvPage::$advPropsTable);

        $I->click(AdvPage::$advSchemaTab);
        $I->seeElement(AdvPage::$advSchemaImg);

    }

/*======================================House==============================================*/

    public function openEditHousePage()
    {
        $I=$this;
        $advHouseId = file_get_contents(codecept_data_dir('advertHouseId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advHouseId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
    }

    public function editHouseAdvert()
    {
        $I=$this;
        $I->click(AdvertsList::$editAdvTab);

        $I->click(AddAdvert::$editOTSell);
        $I->fillField(AddAdvert::$advDescription, House::editDescriptionHouseSell);
        $I->fillField(AddAdvert::$price, House::editPriceHouseSell);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUS);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, House::editCommission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, House::editDate);
        $I->click(AddAdvert::$monthField);
        $I->click(AddAdvert::$month11);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, House::editYear);
        $I->click(AddAdvert::$repairField);
        $I->click(AddAdvert::$repair1);
    }

    public function fillInEditHouseAdvertCheckboxes()
    {
        $I = $this;
        $I->click(AddAdvert::$furniture0);
        $I->click(AddAdvert::$furniture1);
        $I->click(AddAdvert::$furniture2);
        $I->click(AddAdvert::$furniture3);
        $I->click(AddAdvert::$furniture4);
        $I->click(AddAdvert::$furniture5);
        $I->click(AddAdvert::$furniture6);
        $I->click(AddAdvert::$furniture7);

        $I->click(AddAdvert::$appliance0);
        $I->click(AddAdvert::$appliance1);
        $I->click(AddAdvert::$appliance2);
        $I->click(AddAdvert::$appliance3);
        $I->click(AddAdvert::$appliance4);
        $I->click(AddAdvert::$appliance5);
        $I->click(AddAdvert::$appliance6);
        $I->click(AddAdvert::$appliance7);

        $I->click(AddAdvert::$additional0);
        $I->click(AddAdvert::$additional1);
        $I->click(AddAdvert::$additional2);
        $I->click(AddAdvert::$additional3);
        $I->click(AddAdvert::$additional4);
        $I->click(AddAdvert::$additional5);
        $I->click(AddAdvert::$additional6);
        $I->click(AddAdvert::$additional7);
        $I->click(AddAdvert::$additional8);
        $I->click(AddAdvert::$additional9);
        $I->click(AddAdvert::$additional10);
        $I->click(AddAdvert::$additional11);
        $I->click(AddAdvert::$additional12);
        $I->click(AddAdvert::$additional13);
        $I->click(AddAdvert::$additional14);
        $I->click(AddAdvert::$additional15);
    }


    public function checkEditedHouseProperties() //webUS-6
    {
        $I = $this;
//        $I->amOnPage();
//        $I->click(AdvertsList::$advInfoTab);
        $I->waitForElement(AdvPage::$advInfoGallery);
        $I->see(House::editCommission, AdvPage::$advInfoPrice);
        $I->see(House::editAvailableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(House::generalArea, AdvPage::$advInfoMainProps);
        $I->see(House::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial10, AdvPage::$advInfoMainProps);
        $I->see(House::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(House::editDescriptionHouseSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(House::category, AdvPage::$advPropsTable);
        $I->see(House::categoryType0, AdvPage::$advPropsTable);
        $I->see(House::region, AdvPage::$advPropsTable);
        $I->see(House::city, AdvPage::$advPropsTable);
        $I->see(House::editDistrict, AdvPage::$advPropsTable);
        $I->see(House::editStreet, AdvPage::$advPropsTable);
        $I->see(House::generalArea, AdvPage::$advPropsTable);
        $I->see(House::livingArea, AdvPage::$advPropsTable);
        $I->see(House::kitchenArea, AdvPage::$advPropsTable);
        $I->see(House::roomCount, AdvPage::$advPropsTable);
        $I->see(House::floors, AdvPage::$advPropsTable);
        $I->see(House::buildYear, AdvPage::$advPropsTable);
        $I->see(Lists::wc0, AdvPage::$advPropsTable);
        $I->see(Lists::heating1, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat1, AdvPage::$advPropsTable);
        $I->see(Lists::repair1, AdvPage::$advPropsTable);

        $I->see(Lists::nearObject0, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject1, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject2, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject3, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject4, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject5, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject6, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject7, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject8, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject9, AdvPage::$advPropsTable);

        $I->see(Lists::furniture0, AdvPage::$advPropsTable);
        $I->see(Lists::furniture1, AdvPage::$advPropsTable);
        $I->see(Lists::furniture2, AdvPage::$advPropsTable);
        $I->see(Lists::furniture3, AdvPage::$advPropsTable);
        $I->see(Lists::furniture4, AdvPage::$advPropsTable);
        $I->see(Lists::furniture5, AdvPage::$advPropsTable);
        $I->see(Lists::furniture6, AdvPage::$advPropsTable);
        $I->see(Lists::furniture7, AdvPage::$advPropsTable);

        $I->see(Lists::appliance0, AdvPage::$advPropsTable);
        $I->see(Lists::appliance1, AdvPage::$advPropsTable);
        $I->see(Lists::appliance2, AdvPage::$advPropsTable);
        $I->see(Lists::appliance3, AdvPage::$advPropsTable);
        $I->see(Lists::appliance4, AdvPage::$advPropsTable);
        $I->see(Lists::appliance5, AdvPage::$advPropsTable);
        $I->see(Lists::appliance6, AdvPage::$advPropsTable);
        $I->see(Lists::appliance7, AdvPage::$advPropsTable);

        $I->see(Lists::additionalHouse0, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse1, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse2, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse3, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse4, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse5, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse6, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse7, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse8, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse9, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse10, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse11, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse12, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse13, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse14, AdvPage::$advPropsTable);
        $I->see(Lists::additionalHouse15, AdvPage::$advPropsTable);

        $I->click(AdvPage::$advSchemaTab);
        $I->seeElement(AdvPage::$advSchemaImg);

    }

/*======================================Parcel==============================================*/

    public function openEditParcelPage()
    {
        $I=$this;
        $advParcelId = file_get_contents(codecept_data_dir('advertParcelId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advParcelId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
    }

    public function editParcelAdvert()
    {
        $I=$this;
        $I->click(AdvertsList::$editAdvTab);

        $I->click(AddAdvert::$editOTSell);
        $I->fillField(AddAdvert::$advDescription, Parcel::editDescriptionParcelSell);
        $I->fillField(AddAdvert::$price, Parcel::editPriceParcelSell);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUS);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, Parcel::editCommission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Parcel::editDate);
        $I->click(AddAdvert::$monthField);
        $I->click(AddAdvert::$month0);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Parcel::editYear);
    }

    public function fillInEditParcelAdvertCheckboxes()
    {
        $I=$this;
        $I->click(AddAdvert::$additional0);
        $I->click(AddAdvert::$additional1);
        $I->click(AddAdvert::$additional2);
        $I->click(AddAdvert::$additional3);
        $I->click(AddAdvert::$additional4);
        $I->click(AddAdvert::$additional5);
        $I->click(AddAdvert::$additional6);
        $I->click(AddAdvert::$additional7);
        $I->click(AddAdvert::$additional8);
        $I->click(AddAdvert::$additional9);
        $I->click(AddAdvert::$additional10);
        $I->click(AddAdvert::$additional11);
    }
    

    public function checkEditedParcelProperties() //webUS-6
    {
        $I = $this;
//        $I->amOnPage();
//        $I->click(AdvertsList::$advInfoTab);
        $I->waitForElement(AdvPage::$advInfoGallery);
        $I->see(Parcel::editCommission, AdvPage::$advInfoPrice);
        $I->see(Parcel::editAvailableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Parcel::generalArea, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Parcel::editDescriptionParcelSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Parcel::category, AdvPage::$advPropsTable);
        $I->see(Parcel::categoryType0, AdvPage::$advPropsTable);
        $I->see(Parcel::region, AdvPage::$advPropsTable);
        $I->see(Parcel::city, AdvPage::$advPropsTable);
        $I->see(Parcel::apiDistrict, AdvPage::$advPropsTable);
        $I->see(Parcel::apiStreet, AdvPage::$advPropsTable);
        $I->see(Parcel::generalArea, AdvPage::$advPropsTable);

        $I->see(Lists::communication0, AdvPage::$advPropsTable);
        $I->see(Lists::communication1, AdvPage::$advPropsTable);
        $I->see(Lists::communication2, AdvPage::$advPropsTable);
        $I->see(Lists::communication3, AdvPage::$advPropsTable);
        $I->see(Lists::communication4, AdvPage::$advPropsTable);
        $I->see(Lists::communication5, AdvPage::$advPropsTable);
        $I->see(Lists::communication6, AdvPage::$advPropsTable);
        $I->see(Lists::communication7, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject0, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject1, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject2, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject3, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject4, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject5, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject6, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject7, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject8, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject9, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel0, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel1, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel2, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel3, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel4, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel5, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel6, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel7, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel8, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel9, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel10, AdvPage::$advPropsTable);
        $I->see(Lists::additionalParcel11, AdvPage::$advPropsTable);

        $I->dontSee(AdvPage::$advSchemaTab);
    }

/*=======================================Commercial============================================*/

    public function openEditCommercialPage()
    {
        $I=$this;
        $advCommercialId = file_get_contents(codecept_data_dir('advertCommercialId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advCommercialId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
    }

    public function editCommercialAdvert()
    {
        $I=$this;
        $I->click(AdvertsList::$editAdvTab);

        $I->click(AddAdvert::$editOTRent);
        $I->fillField(AddAdvert::$advDescription, Commercial::editDescriptionCommercialRent);
        $I->fillField(AddAdvert::$price, Commercial::editPriceCommercialRent);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUA);
        $I->click(AddAdvert::$periodField);
        $I->click(AddAdvert::$editPeriodMonth);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, Commercial::editCommission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Commercial::editDate);
        $I->click(AddAdvert::$monthField);
        $I->click(AddAdvert::$month1);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Commercial::editYear);
        $I->click(AddAdvert::$repairField);
        $I->click(AddAdvert::$repair0);
    }

    public function fillInEditCommercialAdvertCheckboxes()
    {
        $I = $this;

        $I->click(AddAdvert::$additional0);
        $I->click(AddAdvert::$additional1);
        $I->click(AddAdvert::$additional2);
        $I->click(AddAdvert::$additional3);
        $I->click(AddAdvert::$additional4);
        $I->click(AddAdvert::$additional5);
        $I->click(AddAdvert::$additional6);
        $I->click(AddAdvert::$additional7);
    }

    public function checkEditedCommercialProperties() //webUS-6
    {
        $I = $this;
//        $I->amOnPage();
//        $I->click(AdvertsList::$advInfoTab);
        $I->waitForElement(AdvPage::$advInfoGallery);
        $I->see(Commercial::editAvailableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Commercial::editCommission, AdvPage::$advInfoPrice);
        $I->see(Commercial::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Commercial::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial0, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floors, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floorNumber, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Commercial::editDescriptionCommercialRent,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Commercial::category, AdvPage::$advPropsTable);
        $I->see(Commercial::categoryType0, AdvPage::$advPropsTable);
        $I->see(Commercial::region, AdvPage::$advPropsTable);
        $I->see(Commercial::city, AdvPage::$advPropsTable);
        $I->see(Commercial::apiDistrict, AdvPage::$advPropsTable);
        $I->see(Commercial::apiStreet, AdvPage::$advPropsTable);
        $I->see(Commercial::generalArea, AdvPage::$advPropsTable);
        $I->see(Commercial::effectiveArea, AdvPage::$advPropsTable);
        $I->see(Commercial::roomCount, AdvPage::$advPropsTable);
        $I->see(Lists::wc2, AdvPage::$advPropsTable);
        $I->see(Lists::heating2, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat2, AdvPage::$advPropsTable);
        $I->see(Lists::repair0, AdvPage::$advPropsTable);

        $I->see(Lists::communication0, AdvPage::$advPropsTable);
        $I->see(Lists::communication1, AdvPage::$advPropsTable);
        $I->see(Lists::communication2, AdvPage::$advPropsTable);
        $I->see(Lists::communication3, AdvPage::$advPropsTable);
        $I->see(Lists::communication4, AdvPage::$advPropsTable);
        $I->see(Lists::communication5, AdvPage::$advPropsTable);
        $I->see(Lists::communication6, AdvPage::$advPropsTable);
        $I->see(Lists::communication7, AdvPage::$advPropsTable);

        $I->see(Lists::additionalCommercial0, AdvPage::$advPropsTable);
        $I->see(Lists::additionalCommercial1, AdvPage::$advPropsTable);
        $I->see(Lists::additionalCommercial2, AdvPage::$advPropsTable);
        $I->see(Lists::additionalCommercial3, AdvPage::$advPropsTable);
        $I->see(Lists::additionalCommercial4, AdvPage::$advPropsTable);
        $I->see(Lists::additionalCommercial5, AdvPage::$advPropsTable);
        $I->see(Lists::additionalCommercial6, AdvPage::$advPropsTable);
        $I->see(Lists::additionalCommercial7, AdvPage::$advPropsTable);

        $I->dontSee(AdvPage::$advSchemaTab);

    }

    public function openEditGaragePage()
    {
        $I=$this;
        $advGarageId = file_get_contents(codecept_data_dir('advertGarageId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advGarageId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
    }

    public function editGarageAdvert()
    {
        $I=$this;
        $I->click(AdvertsList::$editAdvTab);

        $I->click(AddAdvert::$editOTRent);
        $I->fillField(AddAdvert::$advDescription, Garage::editDescriptionGarageRent);
        $I->fillField(AddAdvert::$price, Garage::editPriceGarageRent);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUA);
        $I->click(AddAdvert::$auction);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Garage::editDate);
        $I->click(AddAdvert::$monthField);
        $I->click(AddAdvert::$month11);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Garage::editYear);

    }

    public function fillInEditGarageAdvertCheckboxes()
    {
        $I = $this;


        $I->click(AddAdvert::$additional0);
        $I->click(AddAdvert::$additional1);
        $I->click(AddAdvert::$additional2);
        $I->click(AddAdvert::$additional3);
        $I->click(AddAdvert::$additional4);
        $I->click(AddAdvert::$additional5);

    }


    public function checkEditedGarageProperties() //webUS-6
    {
        $I = $this;
//        $I->amOnPage();
//        $I->click(AdvertsList::$advInfoTab);
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Flat::priceFlatSell, AdvPage::$advInfoPrice);
        $I->see(Garage::editAvailableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Garage::generalArea, AdvPage::$advInfoMainProps);
        $I->see($this->getTransportTypeName(0), AdvPage::$advInfoMainProps);
        $I->see($this->getInspectionPitName(0), AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Garage::editDescriptionGarageRent,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see($this->getCategoryName(4), AdvPage::$advPropsTable);
        $I->see($this->getGaragesCategoryTypeName(1), AdvPage::$advPropsTable);
        $I->see($this->getRegionName(21), AdvPage::$advPropsTable);
        $I->see($this->getCityName(6), AdvPage::$advPropsTable);
        $I->see($this->getDistrictName(16), AdvPage::$advPropsTable);
        $I->see($this->getStreetName(201), AdvPage::$advPropsTable);
        $I->see(Garage::generalArea, AdvPage::$advPropsTable);
        $I->see(Garage::roomCount, AdvPage::$advPropsTable);
        $I->see(Garage::floorNumber, AdvPage::$advPropsTable);
        $I->see(Garage::floor, AdvPage::$advPropsTable);
        $I->see(Garage::buildYear, AdvPage::$advPropsTable);
        $I->see($this->getHeatingsName(1), AdvPage::$advPropsTable);
        $I->see($this->getInspectionPitName(0), AdvPage::$advPropsTable);
        $I->see($this->getParkingPlaceName(0), AdvPage::$advPropsTable);
        $I->see($this->getTransportTypeName(0), AdvPage::$advPropsTable);

        $I->see($this->getCommunicationsName(0), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(1), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(2), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(3), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(4), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(5), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(6), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(7), AdvPage::$advPropsTable);

        $I->see($this->getNearObjectsName(0), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(1), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(2), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(3), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(4), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(5), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(6), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(7), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(8), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(9), AdvPage::$advPropsTable);

        $I->see($this->getGarageAdditionalsName(0), AdvPage::$advPropsTable);
        $I->see($this->getGarageAdditionalsName(1), AdvPage::$advPropsTable);
        $I->see($this->getGarageAdditionalsName(2), AdvPage::$advPropsTable);
        $I->see($this->getGarageAdditionalsName(3), AdvPage::$advPropsTable);
        $I->see($this->getGarageAdditionalsName(4), AdvPage::$advPropsTable);
        $I->see($this->getGarageAdditionalsName(5), AdvPage::$advPropsTable);


        $I->click(AdvPage::$advSchemaTab);
        $I->seeElement(AdvPage::$advSchemaImg);

    }

}