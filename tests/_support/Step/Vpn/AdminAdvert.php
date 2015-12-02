<?php

namespace Step\Vpn;

use Page\AddAdvert;
use Page\AdvertsList;
use Page\AdvPage;
use Page\BackoffAdverts;
use \Data\Flat;
use \Data\House;
use \Data\Parcel;
use \Data\Commercial;
use \Data\Lists;
use \Facebook\WebDriver\WebDriverKeys;

class AdminAdvert extends \VpnTester
{
    public function moderateAdvActive()
    {
        $I=$this;
        $I->amOnPage(BackoffAdverts::$advListURL);
        $I->waitForElement(BackoffAdverts::$advListEditLink0);
        $I->click(BackoffAdverts::$advListEditLink0);
        $I->waitForElement(BackoffAdverts::$advStatusField);
        $I->wait(2);
        $I->click(BackoffAdverts::$advStatusField);
        $I->click(BackoffAdverts::$advStatus1);
        $I->click(BackoffAdverts::$advEditSubmit);
    }

/*========================================Edit Flat===========================================*/

    public function openAdminEditFlatPage()
    {
        $I=$this;
        $advFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $I->amOnPage(BackoffAdverts::$advListURL .'/' .$advFlatId .'/edit');
        $I->waitForElement(BackoffAdverts::$advStatusField);
    }

    public function adminEditFlatAdvProperties()
    {
        $I=$this;
        $I->click(BackoffAdverts::$advStatusField);
        $I->click(BackoffAdverts::$advStatus1);

        $I->click(BackoffAdverts::$advOTSale);
        $I->fillField(BackoffAdverts::$advDescription, Flat::editDescriptionFlatSale);
        $I->fillField(BackoffAdverts::$advPrice, Flat::editPriceFlatSell);
        $I->click(BackoffAdverts::$advCurrencyField);
        $I->click(BackoffAdverts::$advCurrencyUS);
        $I->click(BackoffAdverts::$advAuction);
        $I->fillField(BackoffAdverts::$advCommission, Flat::editCommission);
        $I->doubleClick(BackoffAdverts::$dateField);
        $I->pressKey(BackoffAdverts::$dateField, WebDriverKeys::DELETE);
        $I->fillField(BackoffAdverts::$dateField, Flat::editDate);
        $I->click(BackoffAdverts::$monthField);
        $I->click(BackoffAdverts::$month11);
        $I->doubleClick(BackoffAdverts::$yearField);
        $I->pressKey(BackoffAdverts::$yearField, WebDriverKeys::DELETE);
        $I->fillField(BackoffAdverts::$yearField, Flat::editYear);
        $I->click(BackoffAdverts::$advMarketField);
        $I->click(BackoffAdverts::$advMarket1);
        $I->click(BackoffAdverts::$advRepairField);
        $I->click(BackoffAdverts::$repair2);
        $I->doubleClick(BackoffAdverts::$bedsCount);
        $I->fillField(BackoffAdverts::$bedsCount, Flat::editBeds);
    }

    public function adminFillInFlatAdvCheckboxes()
    {
        $I = $this;
        $I->click(BackoffAdverts::$furniture0);
        $I->click(BackoffAdverts::$furniture1);
        $I->click(BackoffAdverts::$furniture2);
        $I->click(BackoffAdverts::$furniture3);
        $I->click(BackoffAdverts::$furniture4);
        $I->click(BackoffAdverts::$furniture5);
        $I->click(BackoffAdverts::$furniture6);
        $I->click(BackoffAdverts::$furniture7);

        $I->click(BackoffAdverts::$appliance0);
        $I->click(BackoffAdverts::$appliance1);
        $I->click(BackoffAdverts::$appliance2);
        $I->click(BackoffAdverts::$appliance3);
        $I->click(BackoffAdverts::$appliance4);
        $I->click(BackoffAdverts::$appliance5);
        $I->click(BackoffAdverts::$appliance6);
        $I->click(BackoffAdverts::$appliance7);

        $I->click(BackoffAdverts::$additional0);
        $I->click(BackoffAdverts::$additional1);
        $I->click(BackoffAdverts::$additional2);
        $I->click(BackoffAdverts::$additional3);
        $I->click(BackoffAdverts::$additional4);
        $I->click(BackoffAdverts::$additional5);
        $I->click(BackoffAdverts::$additional6);
        $I->click(BackoffAdverts::$additional7);
        $I->click(BackoffAdverts::$additional8);
        $I->click(BackoffAdverts::$additional9);
        $I->click(BackoffAdverts::$additional10);
        $I->click(BackoffAdverts::$additional11);
        $I->click(BackoffAdverts::$additional12);
        $I->click(BackoffAdverts::$additional13);
        $I->click(BackoffAdverts::$additional14);
        $I->click(BackoffAdverts::$additional15);
    }

    public function adminUploadFlatImages()
    {
        $I=$this;
        $I->attachFile(AddAdvert::$galleryFile, '/img/flat_2.jpg');
        $I->wait(2);
        $I->attachFile(AddAdvert::$galleryFile, '/img/flat_3.jpg');
        $I->wait(2);
        $I->attachFile(AddAdvert::$galleryFile, '/img/flat_1.jpg');
        $I->wait(2);
    }

    public function adminAddFlatOwnerAndSubmit()
    {
        $I=$this;
        $I->fillField(BackoffAdverts::$advOwnerName, Flat::editOwnerName);
        $I->fillField(BackoffAdverts::$advOwnerContacts, Flat::editOwnerContacts);
        $I->click(BackoffAdverts::$advEditSubmit);
        $I->wait(2);
    }

    public function openWebFlatAdvPage()
    {
        $I=$this;
        $advFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $regionCities = file_get_contents(codecept_data_dir('cities.json'));
        $cityLatinName = json_decode($regionCities)[4]->latinName;
        $I->amOnPage('/'.$cityLatinName .'/flats/' .$advFlatId);
        $I->waitForElement(AdvPage::$advInfoGallery);
    }

    public function checkEditedFlatProperties() //webUS-6
    {
        $I = $this;
        $I->waitForElement(AdvPage::$advInfoGallery);
        $I->see(Flat::editAvailableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Flat::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Flat::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial0, AdvPage::$advInfoMainProps);
        $I->see(Flat::floorNumber, AdvPage::$advInfoMainProps);
        $I->see(Flat::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Flat::editDescriptionFlatSale, AdvPage::$advInfoDescription);
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
        $I->see(Lists::nearObject2, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject3, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject4, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject5, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject6, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject7, AdvPage::$advPropsTable);

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

/*========================================Edit House===========================================*/

    public function openAdminEditHousePage()
    {
        $I=$this;
        $advHouseId = file_get_contents(codecept_data_dir('advertHouseId.json'));
        $I->amOnPage(BackoffAdverts::$advListURL .'/' .$advHouseId .'/edit');
        $I->waitForElement(BackoffAdverts::$advStatusField);
    }

    public function adminEditHouseAdvProperties()
    {
        $I=$this;
        $I->click(BackoffAdverts::$advStatusField);
        $I->click(BackoffAdverts::$advStatus1);

        $I->click(BackoffAdverts::$advOTRent);
        $I->fillField(BackoffAdverts::$advDescription, House::editDescriptionHouseRent);
        $I->fillField(BackoffAdverts::$advPrice, House::editPriceHouseRent);
        $I->click(BackoffAdverts::$advCurrencyField);
        $I->click(BackoffAdverts::$advCurrencyUA);
        $I->click(BackoffAdverts::$advAuction);
        $I->click(BackoffAdverts::$advPeriodField);
        $I->click(BackoffAdverts::$advPeriodMonth);
        $I->fillField(BackoffAdverts::$advCommission, House::editCommission);
        $I->doubleClick(BackoffAdverts::$dateField);
        $I->pressKey(BackoffAdverts::$dateField, WebDriverKeys::DELETE);
        $I->fillField(BackoffAdverts::$dateField, House::editDate);
        $I->click(BackoffAdverts::$monthField);
        $I->click(BackoffAdverts::$month11);
        $I->doubleClick(BackoffAdverts::$yearField);
        $I->pressKey(BackoffAdverts::$yearField, WebDriverKeys::DELETE);
        $I->fillField(BackoffAdverts::$yearField, House::editYear);
        $I->click(BackoffAdverts::$advRepairField);
        $I->click(BackoffAdverts::$repair1);
    }

    public function adminFillInHouseAdvCheckboxes()
    {
        $I = $this;
        $I->click(BackoffAdverts::$furniture0);
        $I->click(BackoffAdverts::$furniture1);
        $I->click(BackoffAdverts::$furniture2);
        $I->click(BackoffAdverts::$furniture3);
        $I->click(BackoffAdverts::$furniture4);
        $I->click(BackoffAdverts::$furniture5);
        $I->click(BackoffAdverts::$furniture6);
        $I->click(BackoffAdverts::$furniture7);

        $I->click(BackoffAdverts::$appliance0);
        $I->click(BackoffAdverts::$appliance1);
        $I->click(BackoffAdverts::$appliance2);
        $I->click(BackoffAdverts::$appliance3);
        $I->click(BackoffAdverts::$appliance4);
        $I->click(BackoffAdverts::$appliance5);
        $I->click(BackoffAdverts::$appliance6);
        $I->click(BackoffAdverts::$appliance7);

        $I->click(BackoffAdverts::$additional0);
        $I->click(BackoffAdverts::$additional1);
        $I->click(BackoffAdverts::$additional2);
        $I->click(BackoffAdverts::$additional3);
        $I->click(BackoffAdverts::$additional4);
        $I->click(BackoffAdverts::$additional5);
        $I->click(BackoffAdverts::$additional6);
        $I->click(BackoffAdverts::$additional7);
        $I->click(BackoffAdverts::$additional8);
        $I->click(BackoffAdverts::$additional9);
        $I->click(BackoffAdverts::$additional10);
        $I->click(BackoffAdverts::$additional11);
        $I->click(BackoffAdverts::$additional12);
        $I->click(BackoffAdverts::$additional13);
        $I->click(BackoffAdverts::$additional14);
        $I->click(BackoffAdverts::$additional15);
    }

    public function adminUploadHouseImages()
    {
        $I=$this;
        $I->attachFile(AddAdvert::$galleryFile, '/img/house_2.jpg');
        $I->wait(2);
        $I->attachFile(AddAdvert::$galleryFile, '/img/house_1.jpg');
        $I->wait(2);
    }

    public function adminAddHouseOwnerAndSubmit()
    {
        $I=$this;
        $I->fillField(BackoffAdverts::$advOwnerName, House::editOwnerName);
        $I->fillField(BackoffAdverts::$advOwnerContacts, House::editOwnerContacts);
        $I->click(BackoffAdverts::$advEditSubmit);
        $I->wait(2);
    }

    public function openWebHouseAdvPage()
    {
        $I=$this;
        $advHouseId = file_get_contents(codecept_data_dir('advertHouseId.json'));
        $regionCities = file_get_contents(codecept_data_dir('cities.json'));
        $cityLatinName = json_decode($regionCities)[4]->latinName;
        $I->amOnPage('/'.$cityLatinName .'/houses/' .$advHouseId);
        $I->waitForElement(AdvPage::$advInfoGallery);
    }

    public function checkEditedHouseProperties() //webUS-6
    {
        $I = $this;
        $I->waitForElement(AdvPage::$advInfoGallery);

        $I->see(House::editCommission, AdvPage::$advInfoPrice);
        $I->see(House::editAvailableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(House::generalArea, AdvPage::$advInfoMainProps);
        $I->see(House::editRoomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial10, AdvPage::$advInfoMainProps);
        $I->see(House::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(House::editDescriptionHouseRent,AdvPage::$advInfoDescription);
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
        $I->see(House::landArea, AdvPage::$advPropsTable);
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

/*========================================Edit Parcel===========================================*/

    public function openAdminEditParcelPage()
    {
        $I=$this;
        $advParcelId = file_get_contents(codecept_data_dir('advertParcelId.json'));
        $I->amOnPage(BackoffAdverts::$advListURL .'/' .$advParcelId .'/edit');
        $I->waitForElement(BackoffAdverts::$advStatusField);
    }

    public function adminEditParcelAdvProperties()
    {
        $I=$this;
        $I->click(BackoffAdverts::$advStatusField);
        $I->click(BackoffAdverts::$advStatus1);

        $I->click(BackoffAdverts::$advOTSale);
        $I->fillField(BackoffAdverts::$advDescription, Parcel::editDescriptionParcelSell);
        $I->fillField(BackoffAdverts::$advPrice, Parcel::editPriceParcelSell);
        $I->click(BackoffAdverts::$advCurrencyField);
        $I->click(BackoffAdverts::$advCurrencyUS);
        $I->click(BackoffAdverts::$advAuction);
        $I->fillField(BackoffAdverts::$advCommission, Parcel::editCommission);
        $I->doubleClick(BackoffAdverts::$dateField);
        $I->pressKey(BackoffAdverts::$dateField, WebDriverKeys::DELETE);
        $I->fillField(BackoffAdverts::$dateField, Parcel::editDate);
        $I->click(BackoffAdverts::$monthField);
        $I->click(BackoffAdverts::$month0);
        $I->doubleClick(BackoffAdverts::$yearField);
        $I->pressKey(BackoffAdverts::$yearField, WebDriverKeys::DELETE);
        $I->fillField(BackoffAdverts::$yearField, Parcel::editYear);
    }

    public function adminFillInParcelAdvCheckboxes()
    {
        $I = $this;
        $I->click(BackoffAdverts::$additional0);
        $I->click(BackoffAdverts::$additional1);
        $I->click(BackoffAdverts::$additional2);
        $I->click(BackoffAdverts::$additional3);
        $I->click(BackoffAdverts::$additional4);
        $I->click(BackoffAdverts::$additional5);
        $I->click(BackoffAdverts::$additional6);
        $I->click(BackoffAdverts::$additional7);
        $I->click(BackoffAdverts::$additional8);
        $I->click(BackoffAdverts::$additional9);
        $I->click(BackoffAdverts::$additional10);
        $I->click(BackoffAdverts::$additional11);
    }

    public function adminUploadParcelImages()
    {
        $I=$this;
        $I->attachFile(AddAdvert::$galleryFile, '/img/parcel_2.jpg');
        $I->wait(3);
        $I->attachFile(AddAdvert::$galleryFile, '/img/parcel_3.jpg');
        $I->wait(3);
        $I->attachFile(AddAdvert::$galleryFile, '/img/parcel_1.jpg');
        $I->wait(3);
    }

    public function adminAddParcelOwnerAndSubmit()
    {
        $I=$this;
        $I->fillField(BackoffAdverts::$advOwnerName, Parcel::editOwnerName);
        $I->fillField(BackoffAdverts::$advOwnerContacts, Parcel::editOwnerContacts);
        $I->click(BackoffAdverts::$advEditSubmit);
        $I->wait(2);
    }

    public function openWebParcelAdvPage()
    {
        $I=$this;
        $advParcelId = file_get_contents(codecept_data_dir('advertParcelId.json'));
//        $regionCities = file_get_contents(codecept_data_dir('cities.json'));
        $cityLatinName = json_decode(file_get_contents(codecept_data_dir('cities.json')))[4]->latinName;
        $I->amOnPage('/'.$cityLatinName .'/parcels/' .$advParcelId);
        $I->waitForElement(AdvPage::$advInfoGallery);
    }

    public function checkEditedParcelProperties() //webUS-6
    {
        $I = $this;
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

        $I->click(AdvPage::$advSchemaTab);
        $I->seeElement(AdvPage::$advSchemaImg);

    }


/*========================================Edit Commercial===========================================*/

    public function openAdminEditCommercialPage()
    {
        $I=$this;
        $advCommercialId = file_get_contents(codecept_data_dir('advertCommercialId.json'));
        $I->amOnPage(BackoffAdverts::$advListURL .'/' .$advCommercialId .'/edit');
        $I->waitForElement(BackoffAdverts::$advStatusField);
    }

    public function adminEditCommercialAdvProperties()
    {
        $I=$this;
        $I->click(BackoffAdverts::$advStatusField);
        $I->click(BackoffAdverts::$advStatus1);

        $I->click(BackoffAdverts::$advOTRent);
        $I->fillField(BackoffAdverts::$advDescription, Commercial::editDescriptionCommercialRent);
        $I->fillField(BackoffAdverts::$advPrice, Commercial::editPriceCommercialRent);
        $I->click(BackoffAdverts::$advCurrencyField);
        $I->click(BackoffAdverts::$advCurrencyUA);
        $I->click(BackoffAdverts::$advAuction);
        $I->click(BackoffAdverts::$advPeriodField);
        $I->click(BackoffAdverts::$advPeriodMonth);
        $I->fillField(BackoffAdverts::$advCommission, Commercial::editCommission);
        $I->doubleClick(BackoffAdverts::$dateField);
        $I->pressKey(BackoffAdverts::$dateField, WebDriverKeys::DELETE);
        $I->fillField(BackoffAdverts::$dateField, Commercial::editDate);
        $I->click(BackoffAdverts::$monthField);
        $I->click(BackoffAdverts::$month1);
        $I->doubleClick(BackoffAdverts::$yearField);
        $I->pressKey(BackoffAdverts::$yearField, WebDriverKeys::DELETE);
        $I->fillField(BackoffAdverts::$yearField, Commercial::editYear);
        $I->click(BackoffAdverts::$advRepairField);
        $I->click(BackoffAdverts::$repair4);
    }

    public function adminFillInCommercialAdvCheckboxes()
    {
        $I = $this;

        $I->click(BackoffAdverts::$additional0);
        $I->click(BackoffAdverts::$additional1);
        $I->click(BackoffAdverts::$additional2);
        $I->click(BackoffAdverts::$additional3);
        $I->click(BackoffAdverts::$additional4);
        $I->click(BackoffAdverts::$additional5);
        $I->click(BackoffAdverts::$additional6);
        $I->click(BackoffAdverts::$additional7);
    }

    public function adminUploadCommercialImages()
    {
        $I=$this;
        $I->attachFile(AddAdvert::$galleryFile, '/img/commerc_3.jpg');
        $I->wait(2);
        $I->attachFile(AddAdvert::$galleryFile, '/img/commerc_2.jpg');
        $I->wait(2);
        $I->attachFile(AddAdvert::$galleryFile, '/img/commerc_1.jpg');
        $I->wait(2);
    }

    public function adminAddCommercialOwnerAndSubmit()
    {
        $I=$this;
        $I->fillField(BackoffAdverts::$advOwnerName, Commercial::ownerName);
        $I->fillField(BackoffAdverts::$advOwnerContacts, Commercial::ownerContacts);
        $I->click(BackoffAdverts::$advEditSubmit);
        $I->wait(2);
    }

    public function openWebCommercialAdvPage()
    {
        $I=$this;
        $advCommercialId = file_get_contents(codecept_data_dir('advertCommercialId.json'));
//        $regionCities = file_get_contents(codecept_data_dir('cities.json'));
        $cityLatinName = json_decode(file_get_contents(codecept_data_dir('cities.json')))[4]->latinName;
        $I->amOnPage('/'.$cityLatinName .'/commercial-property/' .$advCommercialId);
        $I->waitForElement(AdvPage::$advInfoGallery);
    }

    public function checkEditedCommercialProperties() //webUS-6
    {
        $I = $this;
        $I->waitForElement(AdvPage::$advInfoGallery);

        $I->see(Commercial::editCommission, AdvPage::$advInfoPrice);
        $I->see(Commercial::editAvailableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Commercial::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Commercial::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial0, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floorNumber, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floors, AdvPage::$advInfoMainProps);

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
        $I->see(Commercial::roomCount, AdvPage::$advPropsTable);
        $I->see(Commercial::effectiveArea, AdvPage::$advPropsTable);
        $I->see(Commercial::floors, AdvPage::$advPropsTable);
        $I->see(Commercial::buildYear, AdvPage::$advPropsTable);
        $I->see(Lists::wc2, AdvPage::$advPropsTable);
        $I->see(Lists::heating2, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat2, AdvPage::$advPropsTable);
        $I->see(Lists::repair4, AdvPage::$advPropsTable);

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

        $I->click(AdvPage::$advSchemaTab);
        $I->seeElement(AdvPage::$advSchemaImg);

    }

}