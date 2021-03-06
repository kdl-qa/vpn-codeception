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
        $I->wantTo('Fill in Flat category');
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
        $I->wantTo('Fill in flat address');
        $I->click(AddAdvert::$regionField);
        $I->fillField(AddAdvert::$typeRegion, Flat::region);
        $I->click(AddAdvert::$region0);
        $I->click(AddAdvert::$cityField);
        $I->fillField(AddAdvert::$typeCity, Flat::city);
        $I->click(AddAdvert::$chooseCity);
        $I->click(AddAdvert::$district);
        $I->fillField(AddAdvert::$typeDistrict,Flat::district);
        $I->click(AddAdvert::$chooseDistrict);

        $I->click(AddAdvert::$street);
        $I->fillField(AddAdvert::$typeStreet,Flat::street);
        $I->click(AddAdvert::$chooseStreet);
        $I->fillField(AddAdvert::$house_number,Flat::houseNumber);
        $I->fillField(AddAdvert::$flat_number,Flat::uniqueFlatNumber());
        $I->click(AddAdvert::$buttonSubmit);
        $I->wait(2);
    }

    public function fillInFlatObjPropertiesPlain()
    {
        $I = $this;
        $I->wantTo('Fill in Flat object properties Plain');
        $I->waitForElement(AddAdvert::$generalArea);
        $I->fillField(AddAdvert::$generalArea,Flat::generalArea);
        $I->click(AddAdvert::$areaUnitField);
        $I->click(AddAdvert::$areaUnit0);
        $I->click(AddAdvert::$wallMaterialField);
        $I->click(AddAdvert::$wallMaterial5);

        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,Flat::roomCount);
        $I->fillField(AddAdvert::$floors,Flat::floors);
        $I->fillField(AddAdvert::$floorNumber,Flat::floorNumber);
        $I->click(AddAdvert::$step2_submit);
        $I->wait(2);
    }

    public function fillInFlatObjPropertiesComplex()
    {
        $I = $this;
        $I->wantTo('Fill in Flat object properties Complex');
        $I->waitForElement(AddAdvert::$generalArea);
        $I->fillField(AddAdvert::$generalArea,Flat::generalArea);
        $I->click(AddAdvert::$areaUnitField);
        $I->click(AddAdvert::$areaUnit0);
        $I->click(AddAdvert::$wallMaterialField);
        $I->click(AddAdvert::$wallMaterial5);
        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,Flat::roomCount);
        $I->fillField(AddAdvert::$livingArea,Flat::livingArea);
        $I->fillField(AddAdvert::$kitchenArea,Flat::kitchenArea);
        $I->fillField(AddAdvert::$floors,Flat::floors);
        $I->fillField(AddAdvert::$floorNumber,Flat::floorNumber);
        $I->fillField(AddAdvert::$buildYear,Flat::buildYear);
        $I->click(AddAdvert::$wcField);
        $I->click(AddAdvert::$wc0);
        $I->click(AddAdvert::$balconyField);
        $I->click(AddAdvert::$balcony1);
        $I->click(AddAdvert::$heatingField);
        $I->click(AddAdvert::$heating1);
        $I->click(AddAdvert::$waterHeatingField);
        $I->click(AddAdvert::$waterHeat2);
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
        $I->click(AddAdvert::$step2_submit);
        $I->wait(2);
    }

    public function checkFlatObjectPropertiesPlain()
    {
        $I = $this;
        $I->wantTo('Check Flat object properties Plain');
        $I->see(Flat::category,AddAdvert::$objectPropsTable);
        $I->see(Flat::categoryType0,AddAdvert::$objectPropsTable);
        $I->see(Flat::region,AddAdvert::$objectPropsTable);
        $I->see(Flat::city,AddAdvert::$objectPropsTable);
        $I->see(Flat::district,AddAdvert::$objectPropsTable);
        $I->see(Flat::street,AddAdvert::$objectPropsTable);
        $I->see(Flat::houseNumber,AddAdvert::$objectPropsTable);
        $I->see(Flat::$currentFlatNumber,AddAdvert::$objectPropsTable);
        $I->see(Flat::generalArea,AddAdvert::$objectPropsTable);
        $I->see(Flat::wallMaterial,AddAdvert::$objectPropsTable);
        $I->see(Flat::roomCount,AddAdvert::$objectPropsTable);
        $I->see(Flat::floors,AddAdvert::$objectPropsTable);
        $I->see(Flat::floorNumber,AddAdvert::$objectPropsTable);
        $I->see(Lists::wc0,AddAdvert::$objectPropsTable);
        $I->see(Lists::balconies0,AddAdvert::$objectPropsTable);
        $I->see(Lists::heating0,AddAdvert::$objectPropsTable);
        $I->see(Lists::waterHeat0,AddAdvert::$objectPropsTable);
    }

    public function checkFlatObjectPropertiesComplex()
    {
        $I = $this;
        $I->wantTo('Check Flat object properties Complex');
        $I->see(Flat::category,AddAdvert::$objectPropsTable);
        $I->see(Flat::categoryType0,AddAdvert::$objectPropsTable);
        $I->see(Flat::region,AddAdvert::$objectPropsTable);
        $I->see(Flat::city,AddAdvert::$objectPropsTable);
        $I->see(Flat::district,AddAdvert::$objectPropsTable);
        $I->see(Flat::street,AddAdvert::$objectPropsTable);
        $I->see(Flat::houseNumber,AddAdvert::$objectPropsTable);
        $I->see(Flat::$currentFlatNumber,AddAdvert::$objectPropsTable);
        $I->see(Flat::generalArea,AddAdvert::$objectPropsTable);
        $I->see(Flat::wallMaterial,AddAdvert::$objectPropsTable);
        $I->see(Flat::roomCount,AddAdvert::$objectPropsTable);
        $I->see(Flat::livingArea,AddAdvert::$objectPropsTable);
        $I->see(Flat::kitchenArea,AddAdvert::$objectPropsTable);
        $I->see(Flat::floors,AddAdvert::$objectPropsTable);
        $I->see(Flat::floorNumber,AddAdvert::$objectPropsTable);
        $I->see(Lists::wc0,AddAdvert::$objectPropsTable);
        $I->see(Lists::balconies1,AddAdvert::$objectPropsTable);
        $I->see(Lists::heating1,AddAdvert::$objectPropsTable);
        $I->see(Lists::waterHeat2,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject0,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject1,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject2,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject3,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject4,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject5,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject6,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject7,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject8,AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject9,AddAdvert::$objectPropsTable);

    }

    public function fillInFlatAdvertPropertiesPlain()
    {
        $I = $this;
        $I->wantTo('Fill in Flat advert properties Plain');
        $I->click(AddAdvert::$OTSell);
        $I->fillField(AddAdvert::$advDescription, Flat::descriptionFlatSell);
        $I->fillField(AddAdvert::$price, Flat::priceFlatSell);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUS);
        $I->fillField(AddAdvert::$commission, Flat::commission);
    }

    public function fillInFlatAdvertPropertiesComplex()
    {
        $I = $this;
        $I->wantTo('Fill in Flat advert properties Complex');
        $I->click(AddAdvert::$OTSell);
        $I->fillField(AddAdvert::$advDescription, Flat::descriptionFlatSell);
        $I->fillField(AddAdvert::$price, Flat::priceFlatSell);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUS);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, Flat::commission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Flat::date);
        $I->click(AddAdvert::$monthField);
        $I->click(AddAdvert::$month10);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Flat::year);
        $I->click(AddAdvert::$marketField);
        $I->click(AddAdvert::$market1);
        $I->click(AddAdvert::$repairField);
        $I->click(AddAdvert::$repair2);
        $I->doubleClick(AddAdvert::$bedsCount);
        $I->fillField(AddAdvert::$bedsCount, Flat::beds);
    }

    public function fillInFlatAdvertCheckboxesComplex()
    {
        $I = $this;
        $I->wantTo('Fill in Flat advert checkboxes Complex');
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

    public function uploadFlatImage()
    {
        $I = $this;
        $I->wantTo('Upload Flat images');
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
        $I->wantTo('Fill in House category');
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
        $I->wantTo('Fill in House object address');
        $I->click(AddAdvert::$regionField);
        $I->fillField(AddAdvert::$typeRegion, House::region);
        $I->click(AddAdvert::$region0);
        $I->click(AddAdvert::$cityField);
        $I->fillField(AddAdvert::$typeCity, House::city);
        $I->click(AddAdvert::$chooseCity);
        $I->click(AddAdvert::$district);
        $I->fillField(AddAdvert::$typeDistrict,House::district);
        $I->click(AddAdvert::$chooseDistrict);

        $I->click(AddAdvert::$street);
        $I->fillField(AddAdvert::$typeStreet,House::street);
        $I->click(AddAdvert::$chooseStreet);
        $I->fillField(AddAdvert::$house_number,House::uniqueHouseNumber());
        $I->click(AddAdvert::$buttonSubmit);
        $I->wait(2);
    }

    public function fillInHouseObjPropertiesPlain()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,House::generalArea);
        $I->click(AddAdvert::$areaUnitField);
        $I->click(AddAdvert::$areaUnit0);
        $I->click(AddAdvert::$wallMaterialField);
        $I->click(AddAdvert::$wallMaterial10);

        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,House::roomCount);
        $I->click(AddAdvert::$step2_submit);
        $I->wait(2);
    }

    public function fillInHouseObjPropertiesComplex()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,House::generalArea);
        $I->click(AddAdvert::$areaUnitField);
        $I->click(AddAdvert::$areaUnit0);
        $I->click(AddAdvert::$wallMaterialField);
        $I->click(AddAdvert::$wallMaterial10);

        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,House::roomCount);
        $I->fillField(AddAdvert::$livingArea,House::livingArea);
        $I->fillField(AddAdvert::$kitchenArea,House::kitchenArea);
        $I->fillField(AddAdvert::$landArea, House::landArea);
        $I->click(AddAdvert::$landAreaUnit);
        $I->click(AddAdvert::$areaUnit1);
        $I->fillField(AddAdvert::$floors,House::floors);
        $I->fillField(AddAdvert::$buildYear,House::buildYear);
        $I->click(AddAdvert::$wcField);
        $I->click(AddAdvert::$wc0);
        $I->click(AddAdvert::$heatingField);
        $I->click(AddAdvert::$heating2);
        $I->click(AddAdvert::$waterHeatingField);
        $I->click(AddAdvert::$waterHeat2);

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
        $I->click(AddAdvert::$step2_submit);
        $I->wait(2);
    }

    public function checkHouseObjectPropertiesPlain()
    {
        $I = $this;
        $I->see(House::category,AddAdvert::$objectPropsTable);
        $I->see(House::categoryType0,AddAdvert::$objectPropsTable);
        $I->see(House::region,AddAdvert::$objectPropsTable);
        $I->see(House::city,AddAdvert::$objectPropsTable);
        $I->see(House::district,AddAdvert::$objectPropsTable);
        $I->see(House::street,AddAdvert::$objectPropsTable);
        $I->see(House::$currentHouseNumber,AddAdvert::$objectPropsTable);
        $I->see(House::generalArea,AddAdvert::$objectPropsTable);
        $I->see(Lists::wallMaterial10,AddAdvert::$objectPropsTable);
        $I->see(House::roomCount,AddAdvert::$objectPropsTable);
        $I->see(Lists::wc0,AddAdvert::$objectPropsTable);
        $I->see(Lists::heating0,AddAdvert::$objectPropsTable);
        $I->see(Lists::waterHeat0,AddAdvert::$objectPropsTable);
    }

    public function checkHouseObjectPropertiesComplex()
    {
        $I = $this;
        $I->see(House::category,AddAdvert::$objectPropsTable);
        $I->see(House::categoryType0,AddAdvert::$objectPropsTable);
        $I->see(House::region,AddAdvert::$objectPropsTable);
        $I->see(House::city,AddAdvert::$objectPropsTable);
        $I->see(House::district,AddAdvert::$objectPropsTable);
        $I->see(House::street,AddAdvert::$objectPropsTable);
        $I->see(House::$currentHouseNumber,AddAdvert::$objectPropsTable);
        $I->see(House::generalArea,AddAdvert::$objectPropsTable);
        $I->see(Lists::wallMaterial10,AddAdvert::$objectPropsTable);
        $I->see(House::roomCount,AddAdvert::$objectPropsTable);
        $I->see(House::livingArea,AddAdvert::$objectPropsTable);
        $I->see(House::kitchenArea,AddAdvert::$objectPropsTable);
        $I->see(House::landArea, AddAdvert::$objectPropsTable);
        $I->see(House::floors,AddAdvert::$objectPropsTable);
        $I->see(House::buildYear,AddAdvert::$objectPropsTable);
        $I->see(Lists::wc0,AddAdvert::$objectPropsTable);
        $I->see(Lists::heating2,AddAdvert::$objectPropsTable);
        $I->see(Lists::waterHeat2,AddAdvert::$objectPropsTable);

        $I->see(Lists::communication0, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication1, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication2, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication3, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication4, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication5, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication6, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication7, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject0, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject1, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject2, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject3, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject4, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject5, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject6, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject7, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject8, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject9, AddAdvert::$objectPropsTable);
    }

    public function fillInHouseAdvertPropertiesPlain()
    {
        $I = $this;
        $I->click(AddAdvert::$OTRent);
        $I->fillField(AddAdvert::$advDescription, House::descriptionHouseRent);
        $I->fillField(AddAdvert::$price, House::priceHouseRent);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUA);
        $I->click(AddAdvert::$periodField);
        $I->click(AddAdvert::$periodMonth);
        $I->fillField(AddAdvert::$commission, House::commission);
    }

    public function fillInHouseAdvertPropertiesComplex()
    {
        $I = $this;
        $I->click(AddAdvert::$OTRent);
        $I->fillField(AddAdvert::$advDescription, House::descriptionHouseRent);
        $I->fillField(AddAdvert::$price, House::priceHouseRent);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUA);
        $I->click(AddAdvert::$periodField);
        $I->click(AddAdvert::$periodMonth);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, House::commission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, House::date);
        $I->click(AddAdvert::$monthField);
        $I->click(AddAdvert::$month10);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, House::year);

        $I->click(AddAdvert::$repairField);
        $I->click(AddAdvert::$repair0);
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
        $I->click(AddAdvert::$regionField);
        $I->fillField(AddAdvert::$typeRegion, Parcel::region);
        $I->click(AddAdvert::$region0);
        $I->click(AddAdvert::$cityField);
        $I->fillField(AddAdvert::$typeCity, Parcel::city);
        $I->click(AddAdvert::$chooseCity);
        $I->click(AddAdvert::$district);
        $I->fillField(AddAdvert::$typeDistrict, Parcel::district);
        $I->click(AddAdvert::$chooseDistrict);

        $I->click(AddAdvert::$street);
        $I->fillField(AddAdvert::$typeStreet, Parcel::street);
        $I->click(AddAdvert::$chooseStreet);
        $I->fillField(AddAdvert::$cadastr_number, Parcel::uniqueCadastralNumber());
        $I->click(AddAdvert::$buttonSubmit);
        $I->wait(2);
    }

    public function fillInParcelObjPropertiesPlain()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea, Parcel::generalArea);
        $I->click(AddAdvert::$areaUnitField);
        $I->click(AddAdvert::$areaUnit1);
        $I->click(AddAdvert::$step2_submit);
        $I->wait(2);
    }

    public function fillInParcelObjPropertiesComplex()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea, Parcel::generalArea);
        $I->click(AddAdvert::$areaUnitField);
        $I->click(AddAdvert::$areaUnit1);
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
        $I->click(AddAdvert::$step2_submit);
        $I->wait(2);
    }

    public function checkParcelObjectPropertiesPlain()
    {
        $I = $this;
        $I->see(Parcel::category, AddAdvert::$objectPropsTable);
        $I->see(Parcel::categoryType1, AddAdvert::$objectPropsTable);
        $I->see(Parcel::region, AddAdvert::$objectPropsTable);
        $I->see(Parcel::city, AddAdvert::$objectPropsTable);
        $I->see(Parcel::district, AddAdvert::$objectPropsTable);
        $I->see(Parcel::street, AddAdvert::$objectPropsTable);
        $I->see(Parcel::$currentCadastralNumber, AddAdvert::$objectPropsTable);
        $I->see(Parcel::generalArea, AddAdvert::$objectPropsTable);

    }

    public function checkParcelObjectPropertiesComplex()
    {
        $I = $this;
        $I->see(Parcel::category, AddAdvert::$objectPropsTable);
        $I->see(Parcel::categoryType1, AddAdvert::$objectPropsTable);
        $I->see(Parcel::region, AddAdvert::$objectPropsTable);
        $I->see(Parcel::city, AddAdvert::$objectPropsTable);
        $I->see(Parcel::district, AddAdvert::$objectPropsTable);
        $I->see(Parcel::street, AddAdvert::$objectPropsTable);
        $I->see(Parcel::$currentCadastralNumber, AddAdvert::$objectPropsTable);
        $I->see(Parcel::generalArea, AddAdvert::$objectPropsTable);

        $I->see(Lists::communication0, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication1, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication2, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication3, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication4, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication5, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication6, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication7, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject0, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject1, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject2, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject3, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject4, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject5, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject6, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject7, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject8, AddAdvert::$objectPropsTable);
        $I->see(Lists::nearObject9, AddAdvert::$objectPropsTable);
    }

    public function fillInParcelAdvertPropertiesPlain()
    {
        $I = $this;
        $I->click(AddAdvert::$OTSell);
        $I->fillField(AddAdvert::$advDescription, Parcel::descriptionParcelSell);
        $I->fillField(AddAdvert::$price, Parcel::priceParcelSell);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUS);
        $I->fillField(AddAdvert::$commission, Parcel::commission);
    }

    public function fillInParcelAdvertPropertiesComplex()
    {
        $I = $this;
        $I->click(AddAdvert::$OTSell);
        $I->fillField(AddAdvert::$advDescription, Parcel::descriptionParcelSell);
        $I->fillField(AddAdvert::$price, Parcel::priceParcelSell);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUS);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, Parcel::commission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Parcel::date);
        $I->click(AddAdvert::$monthField);
        $I->click(AddAdvert::$month11);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Parcel::year);
    }

    public function fillInParcelAdvertCheckboxesComplex()
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
        $I->click(AddAdvert::$additional8);
        $I->click(AddAdvert::$additional9);
        $I->click(AddAdvert::$additional10);
        $I->click(AddAdvert::$additional11);
    }

    public function uploadParcelImage()
    {
        $I = $this;
        $I->attachFile(AddAdvert::$galleryFile, '/img/parcel_2.jpg');
        $I->wait(3);
        $I->attachFile(AddAdvert::$galleryFile, '/img/parcel_1.jpg');
        $I->wait(4);
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
        $I->click(AddAdvert::$regionField);
        $I->fillField(AddAdvert::$typeRegion, Commercial::region);
        $I->click(AddAdvert::$region0);
        $I->click(AddAdvert::$cityField);
        $I->fillField(AddAdvert::$typeCity, Commercial::city);
        $I->click(AddAdvert::$chooseCity);
        $I->click(AddAdvert::$district);
        $I->fillField(AddAdvert::$typeDistrict,Commercial::district);
        $I->click(AddAdvert::$chooseDistrict);
        $I->click(AddAdvert::$street);
        $I->fillField(AddAdvert::$typeStreet,Commercial::street);
        $I->click(AddAdvert::$chooseStreet);
        $I->fillField(AddAdvert::$house_number,Commercial::uniqueCommercialNumber());
        $I->click(AddAdvert::$buttonSubmit);
        $I->wait(2);
    }

    public function fillInCommercialObjPropertiesPlain()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,Commercial::generalArea);
        $I->click(AddAdvert::$areaUnitField);
        $I->click(AddAdvert::$areaUnit0);
        $I->click(AddAdvert::$wallMaterialField);
        $I->click(AddAdvert::$wallMaterial2);
        $I->fillField(AddAdvert::$effectiveArea,Commercial::effectiveArea);
        $I->fillField(AddAdvert::$floorNumber,Commercial::floors);
        $I->fillField(AddAdvert::$floors,Commercial::floorNumber);
        $I->click(AddAdvert::$step2_submit);
        $I->wait(2);
    }

    public function fillInCommercialObjPropertiesComplex()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,Commercial::generalArea);
        $I->click(AddAdvert::$areaUnitField);
        $I->click(AddAdvert::$areaUnit0);
        $I->click(AddAdvert::$wallMaterialField);
        $I->click(AddAdvert::$wallMaterial2);
        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,Commercial::roomCount);
        $I->fillField(AddAdvert::$effectiveArea,Commercial::effectiveArea);
        $I->fillField(AddAdvert::$floorNumber,Commercial::floors);
        $I->fillField(AddAdvert::$floors,Commercial::floorNumber);
        $I->fillField(AddAdvert::$buildYear,Commercial::buildYear);
        $I->click(AddAdvert::$wcField);
        $I->click(AddAdvert::$wc2);
        $I->click(AddAdvert::$heatingField);
        $I->click(AddAdvert::$heating1);
        $I->click(AddAdvert::$waterHeatingField);
        $I->click(AddAdvert::$waterHeat3);
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
        $I->click(AddAdvert::$step2_submit);
        $I->wait(2);
    }

    public function checkCommercialObjectPropertiesPlain()
    {
        $I = $this;
        $I->see(Commercial::category,AddAdvert::$objectPropsTable);
        $I->see(Commercial::categoryType1,AddAdvert::$objectPropsTable);
        $I->see(Commercial::region,AddAdvert::$objectPropsTable);
        $I->see(Commercial::city,AddAdvert::$objectPropsTable);
        $I->see(Commercial::district,AddAdvert::$objectPropsTable);
        $I->see(Commercial::street,AddAdvert::$objectPropsTable);
        $I->see(Commercial::$currentCommercialNumber,AddAdvert::$objectPropsTable);
        $I->see(Commercial::generalArea,AddAdvert::$objectPropsTable);
        $I->see(Lists::wallMaterial2,AddAdvert::$objectPropsTable);
        $I->see(Commercial::effectiveArea,AddAdvert::$objectPropsTable);
        $I->see(Commercial::floors,AddAdvert::$objectPropsTable);
        $I->see(Commercial::floorNumber,AddAdvert::$objectPropsTable);
    }

    public function checkCommercialObjectPropertiesComplex()
    {
        $I = $this;
        $I->see(Commercial::category,AddAdvert::$objectPropsTable);
        $I->see(Commercial::categoryType1,AddAdvert::$objectPropsTable);
        $I->see(Commercial::region,AddAdvert::$objectPropsTable);
        $I->see(Commercial::city,AddAdvert::$objectPropsTable);
        $I->see(Commercial::district,AddAdvert::$objectPropsTable);
        $I->see(Commercial::street,AddAdvert::$objectPropsTable);
        $I->see(Commercial::$currentCommercialNumber,AddAdvert::$objectPropsTable);
        $I->see(Commercial::generalArea,AddAdvert::$objectPropsTable);
        $I->see(Lists::wallMaterial2,AddAdvert::$objectPropsTable);
        $I->see(Commercial::roomCount,AddAdvert::$objectPropsTable);
        $I->see(Commercial::effectiveArea,AddAdvert::$objectPropsTable);
        $I->see(Commercial::floors,AddAdvert::$objectPropsTable);
        $I->see(Commercial::floorNumber,AddAdvert::$objectPropsTable);
        $I->see(Commercial::buildYear,AddAdvert::$objectPropsTable);
        $I->see(Lists::wc2,AddAdvert::$objectPropsTable);
        $I->see(Lists::heating1,AddAdvert::$objectPropsTable);
        $I->see(Lists::waterHeat3,AddAdvert::$objectPropsTable);
        $I->see(Lists::communication0, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication1, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication2, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication3, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication4, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication5, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication6, AddAdvert::$objectPropsTable);
        $I->see(Lists::communication7, AddAdvert::$objectPropsTable);
    }

    public function fillInCommercialAdvertPropertiesPlain()
    {
        $I = $this;
        $I->click(AddAdvert::$OTSell);
        $I->fillField(AddAdvert::$advDescription, Commercial::descriptionCommercialSell);
        $I->fillField(AddAdvert::$price, Commercial::priceCommercialSell);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUS);
        $I->fillField(AddAdvert::$commission, Commercial::commission);
    }

    public function fillInCommercialAdvertPropertiesComplex()
    {
        $I = $this;
        $I->click(AddAdvert::$OTSell);
        $I->fillField(AddAdvert::$advDescription, Commercial::descriptionCommercialSell);
        $I->fillField(AddAdvert::$price, Commercial::priceCommercialSell);
        $I->click(AddAdvert::$currencyField);
        $I->click(AddAdvert::$currencyUS);
        $I->click(AddAdvert::$auction);
        $I->fillField(AddAdvert::$commission, Commercial::commission);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Commercial::date);
        $I->click(AddAdvert::$monthField);
        $I->click(AddAdvert::$month0);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Commercial::year);

        $I->click(AddAdvert::$repairField);
        $I->click(AddAdvert::$repair6);
    }

    public function fillInCommercialAdvertCheckboxesComplex()
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
        $I->click(AddAdvert::$step2_submit);
        $I->wait(3);
    }

    //TODO: Improve to change Obj data
    public function changeObjectProperties()
    {
//        $I = this;
//        $I->click(AddAdvert::$step2_2_createObject);
//        $I->wait(1);
    }

    //TODO: Improve to change Obj address
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
        $I->wait(2);
    }

    public function clickCreateAdvertButton()
    {
        $I = $this;
        $I->click(AddAdvert::$buttonSubmit);
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
        $I->see(Flat::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Flat::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Flat::wallMaterial, AdvPage::$advInfoMainProps);
        $I->see(Flat::floorNumber, AdvPage::$advInfoMainProps);
        $I->see(Flat::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Flat::descriptionFlatSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Flat::category, AdvPage::$advPropsTable);
        $I->see(Flat::categoryType0, AdvPage::$advPropsTable);
        $I->see(Flat::region, AdvPage::$advPropsTable);
        $I->see(Flat::city, AdvPage::$advPropsTable);
        $I->see(Flat::district, AdvPage::$advPropsTable);
        $I->see(Flat::street, AdvPage::$advPropsTable);
        $I->see(Flat::generalArea, AdvPage::$advPropsTable);
        $I->see(Lists::marketType0, AdvPage::$advPropsTable);
        $I->see(Flat::floorNumber, AdvPage::$advPropsTable);
        $I->see(Flat::floors, AdvPage::$advPropsTable);
        $I->see(Lists::wc0, AdvPage::$advPropsTable);
        $I->see(Lists::balconies0, AdvPage::$advPropsTable);
        $I->see(Lists::heating0, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat0, AdvPage::$advPropsTable);
        $I->see(Lists::repair0, AdvPage::$advPropsTable);
        $I->dontSee(AdvPage::$advSchemaTab);
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
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
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
        $I->see(Lists::marketType1, AdvPage::$advPropsTable);
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
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(House::descriptionHouseRent,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
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
        $I->see(Lists::wc0, AdvPage::$advPropsTable);
        $I->see(Lists::heating0, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat0, AdvPage::$advPropsTable);
        $I->see(Lists::repair0, AdvPage::$advPropsTable);
        $I->dontSee(AdvPage::$advSchemaTab);
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
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
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
//        $I->see(Parcel::$currentCadastralNumber, AdvPage::$advInfoAddress);
        $I->see(Parcel::generalArea, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Parcel::descriptionParcelSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Parcel::category, AdvPage::$advPropsTable);
        $I->see(Parcel::categoryType1, AdvPage::$advPropsTable);
        $I->see(Parcel::region, AdvPage::$advPropsTable);
        $I->see(Parcel::city, AdvPage::$advPropsTable);
        $I->see(Parcel::district, AdvPage::$advPropsTable);
        $I->see(Parcel::street, AdvPage::$advPropsTable);
        $I->see(Parcel::$currentCadastralNumber, AdvPage::$advPropsTable);
        $I->see(Parcel::generalArea, AdvPage::$advPropsTable);
        $I->dontSee(AdvPage::$advSchemaTab);

    }

    public function checkParcelPropertiesComplex() //webUS-6
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(House::priceHouseRent, AdvPage::$advInfoPrice);
        $I->see(Parcel::commission, AdvPage::$advInfoPrice);
        $I->see(Parcel::availableFrom, AdvPage::$advInfoAvailableFrom);
//        $I->see(Parcel::$currentCadastralNumber, AdvPage::$advInfoAddress);
        $I->see(Parcel::generalArea, AdvPage::$advInfoMainProps);

        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Parcel::descriptionParcelSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Parcel::category, AdvPage::$advPropsTable);
        $I->see(Parcel::categoryType1, AdvPage::$advPropsTable);
        $I->see(Parcel::region, AdvPage::$advPropsTable);
        $I->see(Parcel::city, AdvPage::$advPropsTable);
        $I->see(Parcel::district, AdvPage::$advPropsTable);
        $I->see(Parcel::street, AdvPage::$advPropsTable);
        $I->see(Parcel::$currentCadastralNumber, AdvPage::$advPropsTable);
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
        $I->see(Commercial::commission, AdvPage::$advInfoPrice);
//        $I->see(Commercial::availableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Commercial::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial2, AdvPage::$advInfoMainProps);
        $I->see(Commercial::roomCountDefault, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floors, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floorNumber, AdvPage::$advInfoMainProps);

        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Commercial::descriptionCommercialSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Commercial::category, AdvPage::$advPropsTable);
        $I->see(Commercial::categoryType1, AdvPage::$advPropsTable);
        $I->see(Commercial::region, AdvPage::$advPropsTable);
        $I->see(Commercial::city, AdvPage::$advPropsTable);
        $I->see(Commercial::district, AdvPage::$advPropsTable);
        $I->see(Commercial::street, AdvPage::$advPropsTable);
        $I->see(Commercial::generalArea, AdvPage::$advPropsTable);
        $I->see(Commercial::effectiveArea, AdvPage::$advPropsTable);
        $I->see(Commercial::floorNumber, AdvPage::$advPropsTable);
        $I->see(Commercial::floors, AdvPage::$advPropsTable);
        $I->see(Lists::wc0, AdvPage::$advPropsTable);
        $I->see(Lists::heating0, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat0, AdvPage::$advPropsTable);
        $I->see(Lists::repair0, AdvPage::$advPropsTable);
        $I->dontSee(AdvPage::$advSchemaTab);
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
        $I->see(Commercial::floors, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floorNumber, AdvPage::$advInfoMainProps);

        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Commercial::descriptionCommercialSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
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
        $I->see(Commercial::floors, AdvPage::$advPropsTable);
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