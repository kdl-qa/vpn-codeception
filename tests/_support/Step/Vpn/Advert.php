<?php
namespace Step\Vpn;
use Data\Commercial;
use Data\Parcel;
use Page\AddAdvert;
use \Data\Flat;
use \Data\House;
use Page\AdvPage;
use \Data\Lists;
use \Helper\Api;
use \Facebook\WebDriver\WebDriverKeys;

class Advert extends \VpnTester
{
/*===================================Flat=======================================*/

    public function fillInStandardFlatType()
    {
        $I = $this;
        $I->amOnPage('/new-advert/step1');
        $I->waitForElement(AddAdvert::$yandexMap);
        $I->click(AddAdvert::$category);
        $I->click(AddAdvert::$flatCategory);
        $I->click(AddAdvert::$category_type);
        $I->click(AddAdvert::$flatCatType0);
    }

    public function fillInFlatAddress()
    {
        $I = $this;
        $I->click(AddAdvert::$region);
        $I->click(AddAdvert::$chooseRegion);
        $I->click(AddAdvert::$city);
        $I->click(AddAdvert::$chooseCity);
        $I->click(AddAdvert::$district);
        $I->fillField(AddAdvert::$typeDistrict,Flat::district);
        $I->click(AddAdvert::$chooseFirstRow);

        $I->click(AddAdvert::$street);
        $I->fillField(AddAdvert::$typeStreet,Flat::street);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->fillField(AddAdvert::$house_number,Flat::houseNumber);
        $I->fillField(AddAdvert::$flat_number,Flat::uniqueFlatNumber());
        $I->click(AddAdvert::$step1_submit);
        $I->seeInModal(AddAdvert::$step1PopUpTitle);
    }

    public function fillInFlatObjPropertiesPlain()
    {
        $I = $this;
        $I->waitForElement(AddAdvert::$generalArea);
        $I->fillField(AddAdvert::$generalArea,Flat::generalArea);
        $I->click(AddAdvert::$generalAreaUnit);
        $I->click(AddAdvert::$generalAreaUnitType);
        $I->click(AddAdvert::$wallMaterial);
        $I->fillField(AddAdvert::$typeWallMaterial,Flat::wallMaterial);
        $I->click(AddAdvert::$chooseFirstRow);
        //$I->pressKey("//a[@class='ui-select-choices-row-inner']",WebDriverKeys::ENTER);

        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,Flat::roomCount);
//        $I->fillField(AddAdvert::$livingArea,Flat::livingArea);
//        $I->fillField(AddAdvert::$kitchenArea,Flat::kitchenArea);
        $I->fillField(AddAdvert::$floors,Flat::floors);
        $I->fillField(AddAdvert::$floorNumber,Flat::floorNumber);
//        $I->fillField(AddAdvert::$buildYear,Flat::buildYear);
//        $I->click(AddAdvert::$wc);
//        $I->fillField(AddAdvert::$typeWC, Flat::wc);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$balcony);
//        $I->fillField(AddAdvert::$typeBalcony, Flat::balcony);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$heating);
//        $I->fillField(AddAdvert::$typeHeating, Flat::heating);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$waterHeating);
//        $I->fillField(AddAdvert::$typeWaterHeating, Flat::waterHeating);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$nearObject0);
//        $I->click(AddAdvert::$nearObject9);
//        $I->attachFile(AddAdvert::$schemaFile,'/img/schema_2.jpg'); //schema
//        $I->wait(2);
        $I->click(AddAdvert::$step2_next);
        $I->wait(2);
    }

    public function fillInFlatObjPropertiesComplex()
    {
        $I = $this;
        $I->waitForElement(AddAdvert::$generalArea);
        $I->fillField(AddAdvert::$generalArea,Flat::generalArea);
        $I->click(AddAdvert::$generalAreaUnit);
        $I->click(AddAdvert::$generalAreaUnitType);
        $I->click(AddAdvert::$wallMaterial);
        $I->fillField(AddAdvert::$typeWallMaterial,Flat::wallMaterial);
        $I->click(AddAdvert::$chooseFirstRow); //$I->pressKey("//a[@class='ui-select-choices-row-inner']",WebDriverKeys::ENTER);
        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,Flat::roomCount);
        $I->fillField(AddAdvert::$livingArea,Flat::livingArea);
        $I->fillField(AddAdvert::$kitchenArea,Flat::kitchenArea);
        $I->fillField(AddAdvert::$floors,Flat::floors);
        $I->fillField(AddAdvert::$floorNumber,Flat::floorNumber);
        $I->fillField(AddAdvert::$buildYear,Flat::buildYear);
        $I->click(AddAdvert::$wc);
        $I->fillField(AddAdvert::$typeWC, Lists::wc0);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$balcony);
        $I->fillField(AddAdvert::$typeBalcony, Lists::balconies1);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$heating);
        $I->fillField(AddAdvert::$typeHeating, Lists::heating1);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$waterHeating);
        $I->fillField(AddAdvert::$typeWaterHeating, Lists::waterHeat2);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$nearObject0);
        $I->click(AddAdvert::$nearObject1);
        $I->click(AddAdvert::$nearObject2);
        $I->click(AddAdvert::$nearObject3);
        $I->click(AddAdvert::$nearObject4);
        $I->click(AddAdvert::$nearObject5);
        $I->click(AddAdvert::$nearObject6);
        $I->click(AddAdvert::$nearObject7);
        $I->click(AddAdvert::$nearObject8);
        $I->click(AddAdvert::$nearObject9);
        $I->attachFile(AddAdvert::$schemaFile,'/img/schema_2.jpg'); //schema
        $I->wait(2);
        $I->click(AddAdvert::$step2_next);
        $I->wait(2);
    }

    public function checkFlatObjectPropertiesPlain()
    {
        $I = $this;
        $I->see(Flat::category,AddAdvert::$objectTable);
        $I->see(Flat::categoryType0,AddAdvert::$objectTable);
        $I->see(Flat::region,AddAdvert::$objectTable);
        $I->see(Flat::city,AddAdvert::$objectTable);
        $I->see(Flat::district,AddAdvert::$objectTable);
        $I->see(Flat::street,AddAdvert::$objectTable);
        $I->see(Flat::houseNumber,AddAdvert::$objectTable);
        $I->see(Flat::uniqueFlatNumber(),AddAdvert::$objectTable);
        $I->see(Flat::generalArea,AddAdvert::$objectTable);
        $I->see(Flat::wallMaterial,AddAdvert::$objectTable);
        $I->see(Flat::roomCount,AddAdvert::$objectTable);
//        $I->see(Flat::livingArea,AddAdvert::$objectTable);
//        $I->see(Flat::kitchenArea,AddAdvert::$objectTable);
        $I->see(Flat::floors,AddAdvert::$objectTable);
        $I->see(Flat::floorNumber,AddAdvert::$objectTable);
//        $I->see(Lists::wc0,AddAdvert::$objectTable);
//        $I->see(Lists::balconies0,AddAdvert::$objectTable);
//        $I->see(Lists::heating0,AddAdvert::$objectTable);
//        $I->see(Lists::waterHeat0,AddAdvert::$objectTable);
    }

    public function checkFlatObjectPropertiesComplex()
    {
        $I = $this;
        $I->see(Flat::category,AddAdvert::$objectTable);
        $I->see(Flat::categoryType0,AddAdvert::$objectTable);
        $I->see(Flat::region,AddAdvert::$objectTable);
        $I->see(Flat::city,AddAdvert::$objectTable);
        $I->see(Flat::district,AddAdvert::$objectTable);
        $I->see(Flat::street,AddAdvert::$objectTable);
        $I->see(Flat::houseNumber,AddAdvert::$objectTable);
        $I->see(Flat::uniqueFlatNumber(),AddAdvert::$objectTable);
        $I->see(Flat::generalArea,AddAdvert::$objectTable);
        $I->see(Flat::wallMaterial,AddAdvert::$objectTable);
        $I->see(Flat::roomCount,AddAdvert::$objectTable);
        $I->see(Flat::livingArea,AddAdvert::$objectTable);
        $I->see(Flat::kitchenArea,AddAdvert::$objectTable);
        $I->see(Flat::floors,AddAdvert::$objectTable);
        $I->see(Flat::floorNumber,AddAdvert::$objectTable);
        $I->see(Lists::wc0,AddAdvert::$objectTable);
        $I->see(Lists::balconies1,AddAdvert::$objectTable);
        $I->see(Lists::heating1,AddAdvert::$objectTable);
        $I->see(Lists::waterHeat2,AddAdvert::$objectTable);
        $I->see(Lists::nearObject0,AddAdvert::$objectTable);
        $I->see(Lists::nearObject1,AddAdvert::$objectTable);
        $I->see(Lists::nearObject2,AddAdvert::$objectTable);
        $I->see(Lists::nearObject3,AddAdvert::$objectTable);
        $I->see(Lists::nearObject4,AddAdvert::$objectTable);
        $I->see(Lists::nearObject5,AddAdvert::$objectTable);
        $I->see(Lists::nearObject6,AddAdvert::$objectTable);
        $I->see(Lists::nearObject7,AddAdvert::$objectTable);
        $I->see(Lists::nearObject8,AddAdvert::$objectTable);
        $I->see(Lists::nearObject9,AddAdvert::$objectTable);

    }

    public function fillInFlatAdvertPropertiesPlain()
    {
        $I = $this;
        $I->click(AddAdvert::$operationTypeSell);
        $I->fillField(AddAdvert::$advertDescription, Flat::descriptionFlatSell);
        $I->fillField(AddAdvert::$price, Flat::priceFlatSell);
        $I->click(AddAdvert::$currency);
        $I->fillField(AddAdvert::$typeCurrency, Flat::currencyUS);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->fillField(AddAdvert::$commission, Flat::commission);
//        $I->click(AddAdvert::$auction);
//        $I->doubleClick(AddAdvert::$date);
//        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
//        $I->fillField(AddAdvert::$date, Flat::date);
//        $I->click(AddAdvert::$month);
//        $I->fillField(AddAdvert::$typeMonth, Flat::month);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->doubleClick(AddAdvert::$year);
//        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
//        $I->fillField(AddAdvert::$year, Flat::year);
//        $I->click(AddAdvert::$market);
//        $I->fillField(AddAdvert::$typeMarket, Flat::market1);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$repair);
//        $I->fillField(AddAdvert::$typeRepair, Flat::repair2);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->doubleClick(AddAdvert::$bedsCount);
//        $I->fillField(AddAdvert::$bedsCount, Flat::beds);
    }

    public function fillInFlatAdvertPropertiesComplex()
    {
        $I = $this;
        $I->click(AddAdvert::$operationTypeSell);
        $I->fillField(AddAdvert::$advertDescription, Flat::descriptionFlatSell);
        $I->fillField(AddAdvert::$price, Flat::priceFlatSell);
        $I->click(AddAdvert::$currency);
        $I->fillField(AddAdvert::$typeCurrency, Flat::currencyUS);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, Flat::commission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Flat::date);
        $I->click(AddAdvert::$month);
        $I->fillField(AddAdvert::$typeMonth, Flat::month);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Flat::year);
        $I->click(AddAdvert::$market);
        $I->fillField(AddAdvert::$typeMarket, Lists::marketType1);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$repair);
        $I->fillField(AddAdvert::$typeRepair, Lists::repair2);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->doubleClick(AddAdvert::$bedsCount);
        $I->fillField(AddAdvert::$bedsCount, Flat::beds);
    }

    public function fillInFlatAdvertCheckboxesComplex()
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
        $I->click(AddAdvert::$additionalFlat0);
        $I->click(AddAdvert::$additionalFlat1);
        $I->click(AddAdvert::$additionalFlat2);
        $I->click(AddAdvert::$additionalFlat3);
        $I->click(AddAdvert::$additionalFlat4);
        $I->click(AddAdvert::$additionalFlat5);
        $I->click(AddAdvert::$additionalFlat6);
        $I->click(AddAdvert::$additionalFlat7);
        $I->click(AddAdvert::$additionalFlat8);
        $I->click(AddAdvert::$additionalFlat9);
        $I->click(AddAdvert::$additionalFlat10);
        $I->click(AddAdvert::$additionalFlat11);
        $I->click(AddAdvert::$additionalFlat12);
        $I->click(AddAdvert::$additionalFlat13);
        $I->click(AddAdvert::$additionalFlat14);
        $I->click(AddAdvert::$additionalFlat15);
    }

    public function uploadFlatImage()
    {
        $I = $this;
        $I->attachFile(AddAdvert::$galleryFile, '/img/flat_1.jpg');
        $I->wait(1);
        $I->attachFile(AddAdvert::$galleryFile, '/img/flat_2.jpg');
        $I->wait(1);
        $I->attachFile(AddAdvert::$galleryFile, '/img/flat_3.jpg');
        $I->wait(1);
    }




/*===================================House=======================================*/

    public function fillInStandardHouseType()
    {
        $I = $this;
        $I->amOnPage('/new-advert/step1');
        $I->waitForElement(AddAdvert::$yandexMap);
        $I->click(AddAdvert::$category);
        $I->click(AddAdvert::$houseCategory);
        $I->click(AddAdvert::$category_type);
        $I->click(AddAdvert::$houseCatType1);
    }

    public function fillInHouseAddress()
    {
        $I = $this;
        $I->click(AddAdvert::$region);
        $I->fillField(AddAdvert::$typeRegion, House::region);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$city);
        $I->fillField(AddAdvert::$typeCity, House::city);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$district);
        $I->fillField(AddAdvert::$typeDistrict,House::district);
        $I->click(AddAdvert::$chooseFirstRow);

        $I->click(AddAdvert::$street);
        $I->fillField(AddAdvert::$typeStreet,House::street);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->fillField(AddAdvert::$house_number,House::uniqueHouseNumber());
        $I->click(AddAdvert::$step1_submit);
        $I->seeInModal(AddAdvert::$step1PopUpTitle);
    }

    public function fillInHouseObjPropertiesPlain()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,House::generalArea);
        $I->click(AddAdvert::$generalAreaUnit);
        $I->click(AddAdvert::$generalAreaUnitType);
        $I->click(AddAdvert::$wallMaterial);
        $I->fillField(AddAdvert::$typeWallMaterial,Lists::wallMaterial10);
        $I->click(AddAdvert::$chooseFirstRow);
        //$I->pressKey("//a[@class='ui-select-choices-row-inner']",WebDriverKeys::ENTER);

        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,House::roomCount);
//        $I->fillField(AddAdvert::$livingArea,House::livingArea);
//        $I->fillField(AddAdvert::$kitchenArea,House::kitchenArea);
//        $I->fillField(AddAdvert::$landArea, House::landArea);
//        $I->click(AddAdvert::$landAreaUnit);
//        $I->click(AddAdvert::$landAreaType);
//        $I->fillField(AddAdvert::$floors,House::floors);
//        $I->fillField(AddAdvert::$buildYear,House::buildYear);
//        $I->click(AddAdvert::$wc);
//        $I->fillField(AddAdvert::$typeWC, Lists::wc0);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$heating);
//        $I->fillField(AddAdvert::$typeHeating, Lists::heating2);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$waterHeating);
//        $I->fillField(AddAdvert::$typeWaterHeating, Lists::waterHeat2);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$communication0);
//        $I->click(AddAdvert::$communication7);
//        $I->click(AddAdvert::$nearObject0);
//        $I->click(AddAdvert::$nearObject9);
//        $I->attachFile(AddAdvert::$schemaFile,'/img/schema_1.jpg'); //schema
//        $I->wait(2);
        $I->click(AddAdvert::$step2_next);
        $I->wait(2);
    }

    public function fillInHouseObjPropertiesComplex()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,House::generalArea);
        $I->click(AddAdvert::$generalAreaUnit);
        $I->click(AddAdvert::$generalAreaUnitType);
        $I->click(AddAdvert::$wallMaterial);
        $I->fillField(AddAdvert::$typeWallMaterial,Lists::wallMaterial10);
        $I->click(AddAdvert::$chooseFirstRow);
        //$I->pressKey("//a[@class='ui-select-choices-row-inner']",WebDriverKeys::ENTER);

        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,House::roomCount);
        $I->fillField(AddAdvert::$livingArea,House::livingArea);
        $I->fillField(AddAdvert::$kitchenArea,House::kitchenArea);
        $I->fillField(AddAdvert::$landArea, House::landArea);
        $I->click(AddAdvert::$landAreaUnit);
        $I->click(AddAdvert::$landAreaType);
        $I->fillField(AddAdvert::$floors,House::floors);
        $I->fillField(AddAdvert::$buildYear,House::buildYear);
        $I->click(AddAdvert::$wc);
        $I->fillField(AddAdvert::$typeWC, Lists::wc0);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$heating);
        $I->fillField(AddAdvert::$typeHeating, Lists::heating2);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$waterHeating);
        $I->fillField(AddAdvert::$typeWaterHeating, Lists::waterHeat2);
        $I->click(AddAdvert::$chooseFirstRow);

        $I->click(AddAdvert::$communication0);
        $I->click(AddAdvert::$communication1);
        $I->click(AddAdvert::$communication2);
        $I->click(AddAdvert::$communication3);
        $I->click(AddAdvert::$communication4);
        $I->click(AddAdvert::$communication5);
        $I->click(AddAdvert::$communication6);
        $I->click(AddAdvert::$communication7);
        $I->click(AddAdvert::$nearObject0);
        $I->click(AddAdvert::$nearObject1);
        $I->click(AddAdvert::$nearObject2);
        $I->click(AddAdvert::$nearObject3);
        $I->click(AddAdvert::$nearObject4);
        $I->click(AddAdvert::$nearObject5);
        $I->click(AddAdvert::$nearObject6);
        $I->click(AddAdvert::$nearObject7);
        $I->click(AddAdvert::$nearObject8);
        $I->click(AddAdvert::$nearObject9);
        $I->attachFile(AddAdvert::$schemaFile,'/img/schema_1.jpg'); //schema
        $I->wait(2);
        $I->click(AddAdvert::$step2_next);
        $I->wait(2);
    }

    public function checkHouseObjectPropertiesPlain()
    {
        $I = $this;
        $I->see(House::category,AddAdvert::$objectTable);
        $I->see(House::categoryType0,AddAdvert::$objectTable);
        $I->see(House::region,AddAdvert::$objectTable);
        $I->see(House::city,AddAdvert::$objectTable);
        $I->see(House::district,AddAdvert::$objectTable);
        $I->see(House::street,AddAdvert::$objectTable);
        $I->see(House::$currentHouseNumber,AddAdvert::$objectTable);
        $I->see(House::generalArea,AddAdvert::$objectTable);
        $I->see(Lists::wallMaterial10,AddAdvert::$objectTable);
        $I->see(House::roomCount,AddAdvert::$objectTable);
//        $I->see(House::livingArea,AddAdvert::$objectTable);
//        $I->see(House::kitchenArea,AddAdvert::$objectTable);
//        $I->see(House::floors,AddAdvert::$objectTable);
//        $I->see(House::buildYear,AddAdvert::$objectTable);
//        $I->see(Lists::wc0,AddAdvert::$objectTable);
//        $I->see(Lists::heating2,AddAdvert::$objectTable);
//        $I->see(Lists::waterHeat2,AddAdvert::$objectTable);
//
//        $I->see(Lists::communication0, AddAdvert::$objectTable);
//        $I->see(Lists::communication7, AddAdvert::$objectTable);
//        $I->see(Lists::nearObject0, AddAdvert::$objectTable);
//        $I->see(Lists::nearObject9, AddAdvert::$objectTable);
    }

    public function checkHouseObjectPropertiesComplex()
    {
        $I = $this;
        $I->see(House::category,AddAdvert::$objectTable);
        $I->see(House::categoryType0,AddAdvert::$objectTable);
        $I->see(House::region,AddAdvert::$objectTable);
        $I->see(House::city,AddAdvert::$objectTable);
        $I->see(House::district,AddAdvert::$objectTable);
        $I->see(House::street,AddAdvert::$objectTable);
        $I->see(House::$currentHouseNumber,AddAdvert::$objectTable);
        $I->see(House::generalArea,AddAdvert::$objectTable);
        $I->see(Lists::wallMaterial10,AddAdvert::$objectTable);
        $I->see(House::roomCount,AddAdvert::$objectTable);
        $I->see(House::livingArea,AddAdvert::$objectTable);
        $I->see(House::kitchenArea,AddAdvert::$objectTable);
        $I->see(House::landArea, AddAdvert::$objectTable);
        $I->see(House::floors,AddAdvert::$objectTable);
        $I->see(House::buildYear,AddAdvert::$objectTable);
        $I->see(Lists::wc0,AddAdvert::$objectTable);
        $I->see(Lists::heating2,AddAdvert::$objectTable);
        $I->see(Lists::waterHeat2,AddAdvert::$objectTable);

        $I->see(Lists::communication0, AddAdvert::$objectTable);
        $I->see(Lists::communication1, AddAdvert::$objectTable);
        $I->see(Lists::communication2, AddAdvert::$objectTable);
        $I->see(Lists::communication3, AddAdvert::$objectTable);
        $I->see(Lists::communication4, AddAdvert::$objectTable);
        $I->see(Lists::communication5, AddAdvert::$objectTable);
        $I->see(Lists::communication6, AddAdvert::$objectTable);
        $I->see(Lists::communication7, AddAdvert::$objectTable);
        $I->see(Lists::nearObject0, AddAdvert::$objectTable);
        $I->see(Lists::nearObject1, AddAdvert::$objectTable);
        $I->see(Lists::nearObject2, AddAdvert::$objectTable);
        $I->see(Lists::nearObject3, AddAdvert::$objectTable);
        $I->see(Lists::nearObject4, AddAdvert::$objectTable);
        $I->see(Lists::nearObject5, AddAdvert::$objectTable);
        $I->see(Lists::nearObject6, AddAdvert::$objectTable);
        $I->see(Lists::nearObject7, AddAdvert::$objectTable);
        $I->see(Lists::nearObject8, AddAdvert::$objectTable);
        $I->see(Lists::nearObject9, AddAdvert::$objectTable);
    }

    public function fillInHouseAdvertPropertiesPlain()
    {
        $I = $this;
        $I->click(AddAdvert::$operationTypeRent);
        $I->fillField(AddAdvert::$advertDescription, House::descriptionHouseRent);
        $I->fillField(AddAdvert::$price, House::priceHouseRent);
        $I->click(AddAdvert::$currency);
        $I->fillField(AddAdvert::$typeCurrency, House::currencyUA);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$period);
        $I->fillField(AddAdvert::$typePeriod, Lists::period1);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->fillField(AddAdvert::$commission, House::commission);
//        $I->click(AddAdvert::$auction);
//        $I->doubleClick(AddAdvert::$date);
//        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
//        $I->fillField(AddAdvert::$date, House::date);
//        $I->click(AddAdvert::$month);
//        $I->fillField(AddAdvert::$typeMonth, House::month);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->doubleClick(AddAdvert::$year);
//        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
//        $I->fillField(AddAdvert::$year, House::year);

//        $I->click(AddAdvert::$repair);
//        $I->fillField(AddAdvert::$typeRepair, Lists::repair0);
//        $I->click(AddAdvert::$chooseFirstRow);
    }

    public function fillInHouseAdvertPropertiesComplex()
    {
        $I = $this;
        $I->click(AddAdvert::$operationTypeRent);
        $I->fillField(AddAdvert::$advertDescription, House::descriptionHouseRent);
        $I->fillField(AddAdvert::$price, House::priceHouseRent);
        $I->click(AddAdvert::$currency);
        $I->fillField(AddAdvert::$typeCurrency, House::currencyUA);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$period);
        $I->fillField(AddAdvert::$typePeriod, Lists::period1);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, House::commission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, House::date);
        $I->click(AddAdvert::$month);
        $I->fillField(AddAdvert::$typeMonth, House::month);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, House::year);

        $I->click(AddAdvert::$repair);
        $I->fillField(AddAdvert::$typeRepair, Lists::repair0);
        $I->click(AddAdvert::$chooseFirstRow);
    }

    public function fillInHouseAdvertCheckboxesComplex()
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

        $I->click(AddAdvert::$additionalHouse0);
        $I->click(AddAdvert::$additionalHouse1);
        $I->click(AddAdvert::$additionalHouse2);
        $I->click(AddAdvert::$additionalHouse3);
        $I->click(AddAdvert::$additionalHouse4);
        $I->click(AddAdvert::$additionalHouse5);
        $I->click(AddAdvert::$additionalHouse6);
        $I->click(AddAdvert::$additionalHouse7);
        $I->click(AddAdvert::$additionalHouse8);
        $I->click(AddAdvert::$additionalHouse9);
        $I->click(AddAdvert::$additionalHouse10);
        $I->click(AddAdvert::$additionalHouse11);
        $I->click(AddAdvert::$additionalHouse12);
        $I->click(AddAdvert::$additionalHouse13);
        $I->click(AddAdvert::$additionalHouse14);
        $I->click(AddAdvert::$additionalHouse15);
    }

    public function uploadHouseImage()
    {
        $I = $this;
        $I->attachFile(AddAdvert::$galleryFile, '/img/house_1.jpg');
        $I->wait(1);
        $I->attachFile(AddAdvert::$galleryFile, '/img/house_2.jpg');
        $I->wait(1);
    }


/*===================================Parcel=======================================*/

    public function fillInStandardParcelType()
    {
        $I = $this;
        $I->amOnPage('/new-advert/step1');
        $I->waitForElement(AddAdvert::$yandexMap);
        $I->click(AddAdvert::$category);
        $I->click(AddAdvert::$parcelCategory);
        $I->click(AddAdvert::$category_type);
        $I->seeElement(AddAdvert::$parcelCatType1);
        $I->click(AddAdvert::$parcelCatType1);
    }

    public function fillInParcelAddress()
    {
        $I = $this;
        $I->click(AddAdvert::$region);
        $I->fillField(AddAdvert::$typeRegion, Parcel::region);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$city);
        $I->fillField(AddAdvert::$typeCity, Parcel::city);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$district);
        $I->fillField(AddAdvert::$typeDistrict,Parcel::district);
        $I->click(AddAdvert::$chooseFirstRow);

        $I->click(AddAdvert::$street);
        $I->fillField(AddAdvert::$typeStreet,Parcel::street);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->fillField(AddAdvert::$cadastr_number,Parcel::uniqueCadastralNumber());
        $I->click(AddAdvert::$step1_submit);
        $I->seeInModal(AddAdvert::$step1PopUpTitle);
    }

    public function fillInParcelObjPropertiesPlain()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,Parcel::generalArea);
        $I->click(AddAdvert::$generalAreaUnit);
        $I->click(Lists::areaUnit1);
        $I->click(AddAdvert::$step2_next);
        $I->wait(2);
    }

    public function fillInParcelObjPropertiesComplex()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,Parcel::generalArea);
        $I->click(AddAdvert::$generalAreaUnit);
        $I->click(Lists::areaUnit1);
        $I->click(AddAdvert::$communication0);
        $I->click(AddAdvert::$communication1);
        $I->click(AddAdvert::$communication2);
        $I->click(AddAdvert::$communication3);
        $I->click(AddAdvert::$communication4);
        $I->click(AddAdvert::$communication5);
        $I->click(AddAdvert::$communication6);
        $I->click(AddAdvert::$communication7);
        $I->click(AddAdvert::$nearObject0);
        $I->click(AddAdvert::$nearObject1);
        $I->click(AddAdvert::$nearObject2);
        $I->click(AddAdvert::$nearObject3);
        $I->click(AddAdvert::$nearObject4);
        $I->click(AddAdvert::$nearObject5);
        $I->click(AddAdvert::$nearObject6);
        $I->click(AddAdvert::$nearObject7);
        $I->click(AddAdvert::$nearObject8);
        $I->click(AddAdvert::$nearObject9);
        $I->attachFile(AddAdvert::$schemaFile,'/img/schema_3.jpg'); //schema
        $I->wait(2);
        $I->click(AddAdvert::$step2_next);
        $I->wait(2);
    }

    public function checkParcelObjectPropertiesPlain()
    {
        $I = $this;
        $I->see(Parcel::category,AddAdvert::$objectTable);
        $I->see(Parcel::categoryType1,AddAdvert::$objectTable);
        $I->see(Parcel::region,AddAdvert::$objectTable);
        $I->see(Parcel::city,AddAdvert::$objectTable);
        $I->see(Parcel::district,AddAdvert::$objectTable);
        $I->see(Parcel::street,AddAdvert::$objectTable);
        $I->see(Parcel::$currentCadastralNumber,AddAdvert::$objectTable);
        $I->see(Parcel::generalArea,AddAdvert::$objectTable);

    }

    public function checkParcelObjectPropertiesComplex()
    {
        $I = $this;
        $I->see(Parcel::category,AddAdvert::$objectTable);
        $I->see(Parcel::categoryType1,AddAdvert::$objectTable);
        $I->see(Parcel::region,AddAdvert::$objectTable);
        $I->see(Parcel::city,AddAdvert::$objectTable);
        $I->see(Parcel::district,AddAdvert::$objectTable);
        $I->see(Parcel::street,AddAdvert::$objectTable);
        $I->see(Parcel::$currentCadastralNumber,AddAdvert::$objectTable);
        $I->see(Parcel::generalArea,AddAdvert::$objectTable);

        $I->see(Lists::communication0, AddAdvert::$objectTable);
        $I->see(Lists::communication1, AddAdvert::$objectTable);
        $I->see(Lists::communication2, AddAdvert::$objectTable);
        $I->see(Lists::communication3, AddAdvert::$objectTable);
        $I->see(Lists::communication4, AddAdvert::$objectTable);
        $I->see(Lists::communication5, AddAdvert::$objectTable);
        $I->see(Lists::communication6, AddAdvert::$objectTable);
        $I->see(Lists::communication7, AddAdvert::$objectTable);
        $I->see(Lists::nearObject0, AddAdvert::$objectTable);
        $I->see(Lists::nearObject1, AddAdvert::$objectTable);
        $I->see(Lists::nearObject2, AddAdvert::$objectTable);
        $I->see(Lists::nearObject3, AddAdvert::$objectTable);
        $I->see(Lists::nearObject4, AddAdvert::$objectTable);
        $I->see(Lists::nearObject5, AddAdvert::$objectTable);
        $I->see(Lists::nearObject6, AddAdvert::$objectTable);
        $I->see(Lists::nearObject7, AddAdvert::$objectTable);
        $I->see(Lists::nearObject8, AddAdvert::$objectTable);
        $I->see(Lists::nearObject9, AddAdvert::$objectTable);
    }


    public function fillInParcelAdvertPropertiesPlain()
    {
        $I = $this;
        $I->click(AddAdvert::$operationTypeSell);
        $I->fillField(AddAdvert::$advertDescription, Parcel::descriptionParcelSell);
        $I->fillField(AddAdvert::$price, Parcel::priceParcelSell);
        $I->click(AddAdvert::$currency);
        $I->fillField(AddAdvert::$typeCurrency, Parcel::currencyUS);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->fillField(AddAdvert::$commission, Parcel::commission);
    }

    public function fillInParcelAdvertPropertiesComplex()
    {
        $I = $this;
        $I->click(AddAdvert::$operationTypeSell);
        $I->fillField(AddAdvert::$advertDescription, Parcel::descriptionParcelSell);
        $I->fillField(AddAdvert::$price, Parcel::priceParcelSell);
        $I->click(AddAdvert::$currency);
        $I->fillField(AddAdvert::$typeCurrency, Parcel::currencyUS);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, Parcel::commission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Parcel::date);
        $I->click(AddAdvert::$month);
        $I->fillField(AddAdvert::$typeMonth, Parcel::month);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Parcel::year);
    }


    public function fillInParcelAdvertCheckboxesComplex()
    {
        $I = $this;
        $I->click(AddAdvert::$additionalParcel0);
        $I->click(AddAdvert::$additionalParcel1);
        $I->click(AddAdvert::$additionalParcel2);
        $I->click(AddAdvert::$additionalParcel3);
        $I->click(AddAdvert::$additionalParcel4);
        $I->click(AddAdvert::$additionalParcel5);
        $I->click(AddAdvert::$additionalParcel6);
        $I->click(AddAdvert::$additionalParcel7);
        $I->click(AddAdvert::$additionalParcel8);
        $I->click(AddAdvert::$additionalParcel9);
        $I->click(AddAdvert::$additionalParcel10);
        $I->click(AddAdvert::$additionalParcel11);
    }

    public function uploadParcelImage()
    {
        $I = $this;
        $I->attachFile(AddAdvert::$galleryFile, '/img/parcel_2.jpg');
        $I->wait(3);
        $I->attachFile(AddAdvert::$galleryFile, '/img/parcel_1.jpg');
        $I->wait(3);
    }


/*===================================Commercial=======================================*/

    public function fillInStandardCommercialType()
    {
        $I = $this;
        $I->amOnPage('/new-advert/step1');
        $I->waitForElement(AddAdvert::$yandexMap);
        $I->click(AddAdvert::$category);
        $I->click(AddAdvert::$commercialCategory);
        $I->click(AddAdvert::$category_type);
        $I->click(AddAdvert::$commercialCatType1);
    }

    public function fillInCommercialAddress()
    {
        $I = $this;
        $I->click(AddAdvert::$region);
        $I->fillField(AddAdvert::$typeRegion, Commercial::region);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$city);
        $I->fillField(AddAdvert::$typeCity, Commercial::city);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$district);
        $I->fillField(AddAdvert::$typeDistrict,Commercial::district);
        $I->click(AddAdvert::$chooseFirstRow);
//        $I->pauseExecution();
        $I->click(AddAdvert::$street);
        $I->fillField(AddAdvert::$typeStreet,Commercial::street);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->fillField(AddAdvert::$house_number,Commercial::uniqueCommercialNumber());
        $I->click(AddAdvert::$step1_submit);
        $I->seeInModal(AddAdvert::$step1PopUpTitle);
    }

    public function fillInCommercialObjPropertiesPlain()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,Commercial::generalArea);
        $I->click(AddAdvert::$generalAreaUnit);
        $I->click(AddAdvert::$generalAreaUnitType);
        $I->click(AddAdvert::$wallMaterial);
        $I->fillField(AddAdvert::$typeWallMaterial,Lists::wallMaterial2);
        $I->click(AddAdvert::$chooseFirstRow);
        //$I->pressKey("//a[@class='ui-select-choices-row-inner']",WebDriverKeys::ENTER);

//        $I->doubleClick(AddAdvert::$roomСount);
//        $I->fillField(AddAdvert::$roomСount,Commercial::roomCount);
        $I->fillField(AddAdvert::$effectiveArea,Commercial::effectiveArea);
        $I->fillField(AddAdvert::$floorNumber,Commercial::floor);
        $I->fillField(AddAdvert::$floors,Commercial::floorNumber);
//        $I->fillField(AddAdvert::$buildYear,Commercial::buildYear);
//        $I->click(AddAdvert::$wc);
//        $I->fillField(AddAdvert::$typeWC, Lists::wc2);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$heating);
//        $I->fillField(AddAdvert::$typeHeating, Lists::heating1);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$waterHeating);
//        $I->fillField(AddAdvert::$typeWaterHeating, Lists::waterHeat3);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->click(AddAdvert::$communication0);
//        $I->click(AddAdvert::$communication4);
//        $I->click(AddAdvert::$communication7);
////        $I->click(AddAdvert::$nearObject0);
////        $I->click(AddAdvert::$nearObject9);
//        $I->attachFile(AddAdvert::$schemaFile,'/img/schema_2.jpg'); //schema
//        $I->wait(2);
        $I->click(AddAdvert::$step2_next);
        $I->wait(2);
    }

    public function fillInCommercialObjPropertiesComplex()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,Commercial::generalArea);
        $I->click(AddAdvert::$generalAreaUnit);
        $I->click(AddAdvert::$generalAreaUnitType);
        $I->click(AddAdvert::$wallMaterial);
        $I->fillField(AddAdvert::$typeWallMaterial,Lists::wallMaterial2);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,Commercial::roomCount);
        $I->fillField(AddAdvert::$effectiveArea,Commercial::effectiveArea);
        $I->fillField(AddAdvert::$floorNumber,Commercial::floor);
        $I->fillField(AddAdvert::$floors,Commercial::floorNumber);
        $I->fillField(AddAdvert::$buildYear,Commercial::buildYear);
        $I->click(AddAdvert::$wc);
        $I->fillField(AddAdvert::$typeWC, Lists::wc2);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$heating);
        $I->fillField(AddAdvert::$typeHeating, Lists::heating1);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$waterHeating);
        $I->fillField(AddAdvert::$typeWaterHeating, Lists::waterHeat3);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$communication0);
        $I->click(AddAdvert::$communication1);
        $I->click(AddAdvert::$communication2);
        $I->click(AddAdvert::$communication3);
        $I->click(AddAdvert::$communication4);
        $I->click(AddAdvert::$communication5);
        $I->click(AddAdvert::$communication6);
        $I->click(AddAdvert::$communication7);
        $I->attachFile(AddAdvert::$schemaFile,'/img/schema_2.jpg'); //schema
        $I->wait(2);
        $I->click(AddAdvert::$step2_next);
        $I->wait(2);
    }

    public function checkCommercialObjectPropertiesPlain()
    {
        $I = $this;
        $I->see(Commercial::category,AddAdvert::$objectTable);
        $I->see(Commercial::categoryType1,AddAdvert::$objectTable);
        $I->see(Commercial::region,AddAdvert::$objectTable);
        $I->see(Commercial::city,AddAdvert::$objectTable);
        $I->see(Commercial::district,AddAdvert::$objectTable);
        $I->see(Commercial::street,AddAdvert::$objectTable);
        $I->see(Commercial::$currentCommercialNumber,AddAdvert::$objectTable);
        $I->see(Commercial::generalArea,AddAdvert::$objectTable);
        $I->see(Lists::wallMaterial2,AddAdvert::$objectTable);
//        $I->see(Commercial::roomCount,AddAdvert::$objectTable);
        $I->see(Commercial::effectiveArea,AddAdvert::$objectTable);
        $I->see(Commercial::floor,AddAdvert::$objectTable);
        $I->see(Commercial::floorNumber,AddAdvert::$objectTable);
//        $I->see(Commercial::buildYear,AddAdvert::$objectTable);
//        $I->see(Lists::wc2,AddAdvert::$objectTable);
//        $I->see(Lists::heating1,AddAdvert::$objectTable);
//        $I->see(Lists::waterHeat3,AddAdvert::$objectTable);
//        $I->see(Lists::communication0, AddAdvert::$objectTable);
//        $I->see(Lists::communication4, AddAdvert::$objectTable);
//        $I->see(Lists::communication7, AddAdvert::$objectTable);
    }

    public function checkCommercialObjectPropertiesComplex()
    {
        $I = $this;
        $I->see(Commercial::category,AddAdvert::$objectTable);
        $I->see(Commercial::categoryType1,AddAdvert::$objectTable);
        $I->see(Commercial::region,AddAdvert::$objectTable);
        $I->see(Commercial::city,AddAdvert::$objectTable);
        $I->see(Commercial::district,AddAdvert::$objectTable);
        $I->see(Commercial::street,AddAdvert::$objectTable);
        $I->see(Commercial::$currentCommercialNumber,AddAdvert::$objectTable);
        $I->see(Commercial::generalArea,AddAdvert::$objectTable);
        $I->see(Lists::wallMaterial2,AddAdvert::$objectTable);
        $I->see(Commercial::roomCount,AddAdvert::$objectTable);
        $I->see(Commercial::effectiveArea,AddAdvert::$objectTable);
        $I->see(Commercial::floor,AddAdvert::$objectTable);
        $I->see(Commercial::floorNumber,AddAdvert::$objectTable);
        $I->see(Commercial::buildYear,AddAdvert::$objectTable);
        $I->see(Lists::wc2,AddAdvert::$objectTable);
        $I->see(Lists::heating1,AddAdvert::$objectTable);
        $I->see(Lists::waterHeat3,AddAdvert::$objectTable);
        $I->see(Lists::communication0, AddAdvert::$objectTable);
        $I->see(Lists::communication1, AddAdvert::$objectTable);
        $I->see(Lists::communication2, AddAdvert::$objectTable);
        $I->see(Lists::communication3, AddAdvert::$objectTable);
        $I->see(Lists::communication4, AddAdvert::$objectTable);
        $I->see(Lists::communication5, AddAdvert::$objectTable);
        $I->see(Lists::communication6, AddAdvert::$objectTable);
        $I->see(Lists::communication7, AddAdvert::$objectTable);
    }

    public function fillInCommercialAdvertPropertiesPlain()
    {
        $I = $this;
        $I->click(AddAdvert::$operationTypeSell);
        $I->fillField(AddAdvert::$advertDescription, Commercial::descriptionCommercialSell);
        $I->fillField(AddAdvert::$price, Commercial::priceСommercialSell);
        $I->click(AddAdvert::$currency);
        $I->fillField(AddAdvert::$typeCurrency, Commercial::currencyUS);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->fillField(AddAdvert::$commission, Commercial::commission);
//        $I->click(AddAdvert::$auction);
//        $I->doubleClick(AddAdvert::$date);
//        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
//        $I->fillField(AddAdvert::$date, Commercial::date);
//        $I->click(AddAdvert::$month);
//        $I->fillField(AddAdvert::$typeMonth, Commercial::month);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->doubleClick(AddAdvert::$year);
//        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
//        $I->fillField(AddAdvert::$year, Commercial::year);

//        $I->click(AddAdvert::$repair);
//        $I->fillField(AddAdvert::$typeRepair, Lists::repair6);
//        $I->click(AddAdvert::$chooseFirstRow);
    }

    public function fillInCommercialAdvertPropertiesComplex()
    {
        $I = $this;
        $I->click(AddAdvert::$operationTypeSell);
        $I->fillField(AddAdvert::$advertDescription, Commercial::descriptionCommercialSell);
        $I->fillField(AddAdvert::$price, Commercial::priceСommercialSell);
        $I->click(AddAdvert::$currency);
        $I->fillField(AddAdvert::$typeCurrency, Commercial::currencyUS);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, Commercial::commission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Commercial::date);
        $I->click(AddAdvert::$month);
        $I->fillField(AddAdvert::$typeMonth, Commercial::month);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Commercial::year);

        $I->click(AddAdvert::$repair);
        $I->fillField(AddAdvert::$typeRepair, Lists::repair6);
        $I->click(AddAdvert::$chooseFirstRow);
    }

    public function fillInCommercialAdvertCheckboxesComplex()
    {
        $I = $this;
        $I->click(AddAdvert::$additionalCommercial0);
        $I->click(AddAdvert::$additionalCommercial1);
        $I->click(AddAdvert::$additionalCommercial2);
        $I->click(AddAdvert::$additionalCommercial3);
        $I->click(AddAdvert::$additionalCommercial4);
        $I->click(AddAdvert::$additionalCommercial5);
        $I->click(AddAdvert::$additionalCommercial6);
        $I->click(AddAdvert::$additionalCommercial7);
    }

    public function uploadCommercialImage()
    {
        $I = $this;
        $I->attachFile(AddAdvert::$galleryFile, '/img/commerc_1.jpg');
        $I->wait(1);
        $I->attachFile(AddAdvert::$galleryFile, '/img/commerc_2.jpg');
        $I->wait(1);
        $I->attachFile(AddAdvert::$galleryFile, '/img/commerc_3.jpg');
        $I->wait(1);
    }

/*===================================Common======================================*/
    // TODO: Improve to insert non-standard data
    public function fillInNonFlatAddress($data = [])
    {
        $I = $this;
        $I->fillField(AddAdvert::$typeDistrict, isset($data['district']) ? $data['district'] : Flat::district);
    }

    public function agreeObjectProperties()
    {
        $I = $this;
        $I->click(AddAdvert::$step2_2_createObject);
        $I->wait(3);
    }

    public function changeObjectProperties()
    {
//        $I = this;
//        $I->click(AddAdvert::$step2_2_createObject);
//        $I->wait(1);
    }

    public function changeFlatAddress()
    {
//        $I = this;

    }


    public function fillInOwnerContactsData()
    {
        $I = $this;
        $owner = $this->agencyChiefFName .' ' .$this->agencyChiefLName;
        $I->fillField(AddAdvert::$ownerName, $owner);
        $I->fillField(AddAdvert::$ownerContacts,$this->agencyEmail);
    }

    public function clickIamOwnerLink()
    {
        $I = $this;
        $I->click(AddAdvert::$ownerLink);
        $I->wait(1);
    }

    public function clickCreateAdvertButton()
    {
        $I = $this;
        $I->click(AddAdvert::$createAdvertButton);
        $I->wait(3);
    }

/*===================================== webUS-6 =======================================*/

    public function checkFlatPropertiesPlain() //webUS-6
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Flat::priceFlatSell, AdvPage::$advInfoPrice);
        $I->see(Flat::commission, AdvPage::$advInfoPrice);
//        $I->see(Flat::availableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Flat::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Flat::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Flat::wallMaterial, AdvPage::$advInfoMainProps);
        $I->see(Flat::floorNumber, AdvPage::$advInfoMainProps);
        $I->see(Flat::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Flat::descriptionFlatSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Flat::category, AdvPage::$advPropsTable);
        $I->see(Flat::categoryType0, AdvPage::$advPropsTable);
        $I->see(Flat::region, AdvPage::$advPropsTable);
        $I->see(Flat::city, AdvPage::$advPropsTable);
        $I->see(Flat::district, AdvPage::$advPropsTable);
        $I->see(Flat::street, AdvPage::$advPropsTable);
        $I->see(Flat::generalArea, AdvPage::$advPropsTable);
//        $I->see(Flat::livingArea, AdvPage::$advPropsTable);
//        $I->see(Flat::kitchenArea, AdvPage::$advPropsTable);
//        $I->see(Flat::market1, AdvPage::$advPropsTable);
//        $I->see(Flat::roomCount, AdvPage::$advPropsTable);
        $I->see(Flat::floorNumber, AdvPage::$advPropsTable);
        $I->see(Flat::floors, AdvPage::$advPropsTable);
//        $I->see(Flat::buildYear, AdvPage::$advPropsTable);
//        $I->see(Flat::wc, AdvPage::$advPropsTable);
//        $I->see(Flat::balcony, AdvPage::$advPropsTable);
//        $I->see(Flat::heating, AdvPage::$advPropsTable);
//        $I->see(Flat::waterHeating, AdvPage::$advPropsTable);
//        $I->see(Flat::repair2, AdvPage::$advPropsTable);
//        $I->see(Lists::nearObject0, AdvPage::$advPropsTable);
//        $I->see(Lists::nearObject9, AdvPage::$advPropsTable);
//        $I->see(Lists::appliance0, AdvPage::$advPropsTable);
//        $I->see(Lists::appliance7, AdvPage::$advPropsTable);
//        $I->see(Lists::additionalFlat0, AdvPage::$advPropsTable);
//        $I->see(Lists::additionalFlat15, AdvPage::$advPropsTable);
        $I->dontSee(AdvPage::$advSchemaTab);
//        $I->seeElement(AdvPage::$advSchemaImg);
    }

    public function checkFlatPropertiesComplex() //webUS-6
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Flat::priceFlatSell, AdvPage::$advInfoPrice);
        $I->see(Flat::commission, AdvPage::$advInfoPrice);
        $I->see(Flat::availableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Flat::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Flat::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Flat::wallMaterial, AdvPage::$advInfoMainProps);
        $I->see(Flat::floorNumber, AdvPage::$advInfoMainProps);
        $I->see(Flat::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Flat::descriptionFlatSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Flat::category, AdvPage::$advPropsTable);
        $I->see(Flat::categoryType0, AdvPage::$advPropsTable);
        $I->see(Flat::region, AdvPage::$advPropsTable);
        $I->see(Flat::city, AdvPage::$advPropsTable);
        $I->see(Flat::district, AdvPage::$advPropsTable);
        $I->see(Flat::street, AdvPage::$advPropsTable);
        $I->see(Flat::generalArea, AdvPage::$advPropsTable);
        $I->see(Flat::livingArea, AdvPage::$advPropsTable);
        $I->see(Flat::kitchenArea, AdvPage::$advPropsTable);
        $I->see(Flat::market1, AdvPage::$advPropsTable);
        $I->see(Flat::roomCount, AdvPage::$advPropsTable);
        $I->see(Flat::floorNumber, AdvPage::$advPropsTable);
        $I->see(Flat::floors, AdvPage::$advPropsTable);
        $I->see(Flat::buildYear, AdvPage::$advPropsTable);
        $I->see(Lists::wc0, AdvPage::$advPropsTable);
        $I->see(Lists::balconies1, AdvPage::$advPropsTable);
        $I->see(Lists::heating1, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat2, AdvPage::$advPropsTable);
        $I->see(Lists::repair2, AdvPage::$advPropsTable);
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


    public function checkHousePropertiesPlain() //webUS-6
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(House::priceHouseRent, AdvPage::$advInfoPrice);
        $I->see(House::commission, AdvPage::$advInfoPrice);
//        $I->see(House::availableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(House::generalArea, AdvPage::$advInfoMainProps);
        $I->see(House::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial10, AdvPage::$advInfoMainProps);
//        $I->see(House::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(House::descriptionHouseRent,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(House::category, AdvPage::$advPropsTable);
        $I->see(House::categoryType0, AdvPage::$advPropsTable);
        $I->see(House::region, AdvPage::$advPropsTable);
        $I->see(House::city, AdvPage::$advPropsTable);
        $I->see(House::district, AdvPage::$advPropsTable);
        $I->see(House::street, AdvPage::$advPropsTable);
        $I->see(House::generalArea, AdvPage::$advPropsTable);
        $I->see(House::wallMaterial, AdvPage::$advPropsTable);
        $I->see(House::roomCount, AdvPage::$advPropsTable);

//        $I->see(House::livingArea, AdvPage::$advPropsTable);
//        $I->see(House::kitchenArea, AdvPage::$advPropsTable);
//        $I->see(House::landArea, AdvPage::$advPropsTable);
//        $I->see(House::floors, AdvPage::$advPropsTable);
//        $I->see(House::buildYear, AdvPage::$advPropsTable);
//        $I->see(Lists::wc0, AdvPage::$advPropsTable);
//        $I->see(Lists::heating2, AdvPage::$advPropsTable);
//        $I->see(Lists::waterHeat2, AdvPage::$advPropsTable);
//        $I->see(Lists::repair0, AdvPage::$advPropsTable);
//        $I->see(Lists::nearObject0, AdvPage::$advPropsTable);
//        $I->see(Lists::nearObject9, AdvPage::$advPropsTable);
//        $I->see(Lists::appliance0, AdvPage::$advPropsTable);
//        $I->see(Lists::appliance7, AdvPage::$advPropsTable);
//        $I->see(Lists::additionalHouse0, AdvPage::$advPropsTable);
//        $I->see(Lists::additionalHouse15, AdvPage::$advPropsTable);
        $I->dontSee(AdvPage::$advSchemaTab);
//        $I->seeElement(AdvPage::$advSchemaImg);

    }

    public function checkHousePropertiesComplex() //webUS-6
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(House::priceHouseRent, AdvPage::$advInfoPrice);
        $I->see(House::commission, AdvPage::$advInfoPrice);
        $I->see(House::availableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(House::generalArea, AdvPage::$advInfoMainProps);
        $I->see(House::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial10, AdvPage::$advInfoMainProps);
        $I->see(House::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(House::descriptionHouseRent,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(House::category, AdvPage::$advPropsTable);
        $I->see(House::categoryType0, AdvPage::$advPropsTable);
        $I->see(House::region, AdvPage::$advPropsTable);
        $I->see(House::city, AdvPage::$advPropsTable);
        $I->see(House::district, AdvPage::$advPropsTable);
        $I->see(House::street, AdvPage::$advPropsTable);
        $I->see(House::generalArea, AdvPage::$advPropsTable);
        $I->see(House::livingArea, AdvPage::$advPropsTable);
        $I->see(House::kitchenArea, AdvPage::$advPropsTable);
        $I->see(House::roomCount, AdvPage::$advPropsTable);
        $I->see(House::landArea, AdvPage::$advPropsTable);
        $I->see(House::floors, AdvPage::$advPropsTable);
        $I->see(House::buildYear, AdvPage::$advPropsTable);
        $I->see(Lists::wc0, AdvPage::$advPropsTable);
        $I->see(Lists::heating2, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat2, AdvPage::$advPropsTable);
        $I->see(Lists::repair0, AdvPage::$advPropsTable);

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


    public function checkParcelPropertiesPlain() //webUS-6
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(House::priceHouseRent, AdvPage::$advInfoPrice);
        $I->see(Parcel::commission, AdvPage::$advInfoPrice);
        $I->see(Parcel::$currentCadastralNumber, AdvPage::$advInfoAddress);
        $I->see(Parcel::generalArea, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Parcel::descriptionParcelSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Parcel::category, AdvPage::$advPropsTable);
        $I->see(Parcel::categoryType1, AdvPage::$advPropsTable);
        $I->see(Parcel::region, AdvPage::$advPropsTable);
        $I->see(Parcel::city, AdvPage::$advPropsTable);
        $I->see(Parcel::district, AdvPage::$advPropsTable);
        $I->see(Parcel::street, AdvPage::$advPropsTable);
        $I->see(Parcel::generalArea, AdvPage::$advPropsTable);
//        $I->see(Lists::nearObject0, AdvPage::$advPropsTable);
//        $I->see(Lists::nearObject9, AdvPage::$advPropsTable);
//        $I->see(Lists::communication0, AdvPage::$advPropsTable);
//        $I->see(Lists::communication7, AdvPage::$advPropsTable);
//        $I->see(Lists::additionalParcel0, AdvPage::$advPropsTable);
//        $I->see(Lists::additionalParcel7, AdvPage::$advPropsTable);
//        $I->see(Lists::additionalParcel11, AdvPage::$advPropsTable);
        $I->dontSee(AdvPage::$advSchemaTab);
//        $I->seeElement(AdvPage::$advSchemaImg);

    }

    public function checkParcelPropertiesComplex() //webUS-6
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(House::priceHouseRent, AdvPage::$advInfoPrice);
        $I->see(Parcel::commission, AdvPage::$advInfoPrice);
        $I->see(Parcel::availableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Parcel::$currentCadastralNumber, AdvPage::$advInfoAddress);
        $I->see(Parcel::generalArea, AdvPage::$advInfoMainProps);

        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Parcel::descriptionParcelSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Parcel::category, AdvPage::$advPropsTable);
        $I->see(Parcel::categoryType1, AdvPage::$advPropsTable);
        $I->see(Parcel::region, AdvPage::$advPropsTable);
        $I->see(Parcel::city, AdvPage::$advPropsTable);
        $I->see(Parcel::district, AdvPage::$advPropsTable);
        $I->see(Parcel::street, AdvPage::$advPropsTable);
        $I->see(Parcel::generalArea, AdvPage::$advPropsTable);

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

        $I->see(Lists::communication0, AdvPage::$advPropsTable);
        $I->see(Lists::communication1, AdvPage::$advPropsTable);
        $I->see(Lists::communication2, AdvPage::$advPropsTable);
        $I->see(Lists::communication3, AdvPage::$advPropsTable);
        $I->see(Lists::communication4, AdvPage::$advPropsTable);
        $I->see(Lists::communication5, AdvPage::$advPropsTable);
        $I->see(Lists::communication6, AdvPage::$advPropsTable);
        $I->see(Lists::communication7, AdvPage::$advPropsTable);

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


    public function checkCommercialPropertiesPlain() //webUS-6
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(House::priceHouseRent, AdvPage::$advInfoPrice);
        $I->see(Commercial::commission, AdvPage::$advInfoPrice);
//        $I->see(Commercial::availableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Commercial::generalArea, AdvPage::$advInfoMainProps);
//        $I->see(Commercial::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial2, AdvPage::$advInfoMainProps);
//        $I->see(Commercial::effectiveArea, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floor, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floorNumber, AdvPage::$advInfoMainProps);

        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Commercial::descriptionCommercialSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Commercial::category, AdvPage::$advPropsTable);
        $I->see(Commercial::categoryType1, AdvPage::$advPropsTable);
        $I->see(Commercial::region, AdvPage::$advPropsTable);
        $I->see(Commercial::city, AdvPage::$advPropsTable);
        $I->see(Commercial::district, AdvPage::$advPropsTable);
        $I->see(Commercial::street, AdvPage::$advPropsTable);
        $I->see(Commercial::generalArea, AdvPage::$advPropsTable);
//        $I->see(Commercial::roomCount, AdvPage::$advPropsTable);
        $I->see(Commercial::effectiveArea, AdvPage::$advPropsTable);
        $I->see(Commercial::floorNumber, AdvPage::$advPropsTable);
        $I->see(Commercial::floor, AdvPage::$advPropsTable);
//        $I->see(Commercial::buildYear, AdvPage::$advPropsTable);
//        $I->see(Lists::wc2, AdvPage::$advPropsTable);
//        $I->see(Lists::heating1, AdvPage::$advPropsTable);
//        $I->see(Lists::waterHeat3, AdvPage::$advPropsTable);
//        $I->see(Lists::repair6, AdvPage::$advPropsTable);
//        $I->see(Lists::communication0, AdvPage::$advPropsTable);
//        $I->see(Lists::communication4, AdvPage::$advPropsTable);
//        $I->see(Lists::communication7, AdvPage::$advPropsTable);

//        $I->see(Lists::additionalCommercial0, AdvPage::$advPropsTable);
//        $I->see(Lists::additionalCommercial7, AdvPage::$advPropsTable);
        $I->dontSee(AdvPage::$advSchemaTab);
//        $I->seeElement(AdvPage::$advSchemaImg);

    }

    public function checkCommercialPropertiesComplex() //webUS-6
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Commercial::priceCommercialRent, AdvPage::$advInfoPrice);
        $I->see(Commercial::commission, AdvPage::$advInfoPrice);
        $I->see(Commercial::availableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Commercial::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Commercial::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial2, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floor, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floorNumber, AdvPage::$advInfoMainProps);

        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Commercial::descriptionCommercialSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Commercial::category, AdvPage::$advPropsTable);
        $I->see(Commercial::categoryType1, AdvPage::$advPropsTable);
        $I->see(Commercial::region, AdvPage::$advPropsTable);
        $I->see(Commercial::city, AdvPage::$advPropsTable);
        $I->see(Commercial::district, AdvPage::$advPropsTable);
        $I->see(Commercial::street, AdvPage::$advPropsTable);
        $I->see(Commercial::generalArea, AdvPage::$advPropsTable);
        $I->see(Commercial::roomCount, AdvPage::$advPropsTable);
        $I->see(Commercial::effectiveArea, AdvPage::$advPropsTable);
        $I->see(Commercial::floorNumber, AdvPage::$advPropsTable);
        $I->see(Commercial::floor, AdvPage::$advPropsTable);
        $I->see(Commercial::buildYear, AdvPage::$advPropsTable);
        $I->see(Lists::wc2, AdvPage::$advPropsTable);
        $I->see(Lists::heating1, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat3, AdvPage::$advPropsTable);
        $I->see(Lists::repair6, AdvPage::$advPropsTable);

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