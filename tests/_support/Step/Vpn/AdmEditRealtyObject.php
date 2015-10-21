<?php
namespace Step\Vpn;

use Data\Lists;
use \Page\AdmRealtyObject;
use \Data\Flat;
use \Data\House;
use \Data\Parcel;
use \Data\Commercial;


class AdmEditRealtyObject extends \VpnTester
{
/*========================================Edit Flat Object================================*/

    public function openAdmEditFlatObjPage()
    {
        $I=$this;
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
        $I->amOnPage(AdmRealtyObject::$objListPageURL .'/' .$realtyFlatId .'/edit');
        $I->waitForElement(AdmRealtyObject::$yandexMap);
    }

    public function editFlatObject()
    {
        $I=$this;
        $I->waitForElement(AdmRealtyObject::$yandexMap);
        $I->click(AdmRealtyObject::$statusField);
        $I->waitForElement(AdmRealtyObject::$objStatus1);
        $I->click(AdmRealtyObject::$objStatus1);
        $I->click(AdmRealtyObject::$regionField);
        $I->click(AdmRealtyObject::$region0);
        $I->click(AdmRealtyObject::$cityField);
        $I->click(AdmRealtyObject::$city4);
        $I->click(AdmRealtyObject::$districtField);
        $I->click(AdmRealtyObject::$district24);
        $I->click(AdmRealtyObject::$street);
        $I->fillField(AdmRealtyObject::$typeStreet, Flat::editStreet);
        $I->click(AdmRealtyObject::$chooseStreet);
        $I->fillField(AdmRealtyObject::$house_number, Flat::editHouseNumber);
        $I->fillField(AdmRealtyObject::$flat_number, Flat::uniqueFlatNumber());

        $I->fillField(AdmRealtyObject::$generalArea, Flat::editGeneralArea);
        $I->click(AdmRealtyObject::$areaUnitField);
        $I->click(AdmRealtyObject::$areaUnit0);
        $I->click(AdmRealtyObject::$wallMaterialField);
        $I->click(AdmRealtyObject::$wallMaterial0);
        $I->fillField(AdmRealtyObject::$roomСount, Flat::editRoomCount);
        $I->fillField(AdmRealtyObject::$livingArea, Flat::editLivingArea);
        $I->fillField(AdmRealtyObject::$kitchenArea, Flat::editKitchenArea);
        $I->fillField(AdmRealtyObject::$floorNumber, Flat::editFloorNumber);
        $I->fillField(AdmRealtyObject::$floors, Flat::editFloors);
        $I->fillField(AdmRealtyObject::$buildYear, Flat::editBuildYear);
        $I->click(AdmRealtyObject::$wcField);
        $I->click(AdmRealtyObject::$wc2);
        $I->click(AdmRealtyObject::$balconyField);
        $I->click(AdmRealtyObject::$balcony2);
        $I->click(AdmRealtyObject::$heatingField);
        $I->click(AdmRealtyObject::$heating2);
        $I->click(AdmRealtyObject::$waterHeatingField);
        $I->click(AdmRealtyObject::$waterHeat2);

        $I->click(AdmRealtyObject::$nearObject0);
        $I->click(AdmRealtyObject::$nearObject1);
        $I->click(AdmRealtyObject::$nearObject2);
        $I->click(AdmRealtyObject::$nearObject3);
        $I->click(AdmRealtyObject::$nearObject4);
        $I->click(AdmRealtyObject::$nearObject5);
        $I->click(AdmRealtyObject::$nearObject6);
        $I->click(AdmRealtyObject::$nearObject7);
        $I->click(AdmRealtyObject::$nearObject8);
        $I->click(AdmRealtyObject::$nearObject9);

//        $I->seeElement(AdmRealtyObject::$removeSchema);
//        $I->click(AdmRealtyObject::$removeSchema);
//        $I->waitForElement(AdmRealtyObject::$schema);
//        $I->attachFile(AdmRealtyObject::$schema, '/img/flat_2.jpg');
//        $I->wait(2);
        $I->attachFile(AdmRealtyObject::$schema, '/img/flat_2.jpg');
        $I->wait(1);

        $I->click(AdmRealtyObject::$submitBtn);
        $I->wait(3);
    }

    public function checkEditFlatObject()
    {
        $I=$this;
        $I->reloadPage();
        $I->waitForElement(AdmRealtyObject::$yandexMap);
        $I->seeInPageSource(Lists::objStatus1);
        $I->seeInPageSource(Flat::region);
        $I->seeInPageSource(Flat::city);
        $I->seeInPageSource(Flat::editDistrict);
        $I->seeInPageSource(Flat::editStreet);
        $I->seeElement(AdmRealtyObject::$house_number,['value' => Flat::editHouseNumber]);
        $I->seeElement(AdmRealtyObject::$flat_number,['value' => Flat::$currentFlatNumber]);
        $I->seeInPageSource(Flat::editGeneralArea);
        $I->seeInPageSource(Lists::areaUnit0);
        $I->seeInPageSource(Lists::wallMaterial0);
        $I->seeInPageSource(Flat::editRoomCount);
        $I->seeInPageSource(Flat::editLivingArea);
        $I->seeInPageSource(Flat::editKitchenArea);
        $I->seeInPageSource(Flat::editFloorNumber);
        $I->seeInPageSource(Flat::editFloors);
        $I->seeElement(AdmRealtyObject::$buildYear,['value' => Flat::editBuildYear]);
        $I->seeInPageSource(Lists::wc2);
        $I->seeInPageSource(Lists::balconies2);
        $I->seeInPageSource(Lists::heating2);
        $I->seeInPageSource(Lists::waterHeat2);
        $I->seeElement(AdmRealtyObject::$checkedNearObject0);
        $I->seeElement(AdmRealtyObject::$checkedNearObject1);
        $I->seeElement(AdmRealtyObject::$checkedNearObject2);
        $I->seeElement(AdmRealtyObject::$checkedNearObject3);
        $I->seeElement(AdmRealtyObject::$checkedNearObject4);
        $I->seeElement(AdmRealtyObject::$checkedNearObject5);
        $I->seeElement(AdmRealtyObject::$checkedNearObject6);
        $I->seeElement(AdmRealtyObject::$checkedNearObject7);
        $I->seeElement(AdmRealtyObject::$checkedNearObject8);
        $I->seeElement(AdmRealtyObject::$checkedNearObject9);
    }

/*====================================Edit House Object===================================*/

    public function openAdmEditHouseObjPage()
    {
        $I=$this;
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $I->amOnPage(AdmRealtyObject::$objListPageURL .'/' .$realtyHouseId .'/edit');
        $I->waitForElement(AdmRealtyObject::$yandexMap);
    }

    public function editHouseObject()
    {
        $I=$this;
        $I->waitForElement(AdmRealtyObject::$yandexMap);
        $I->click(AdmRealtyObject::$statusField);
        $I->waitForElement(AdmRealtyObject::$objStatus1);
        $I->click(AdmRealtyObject::$objStatus1);
        $I->click(AdmRealtyObject::$regionField);
        $I->click(AdmRealtyObject::$region0);
        $I->click(AdmRealtyObject::$cityField);
        $I->click(AdmRealtyObject::$city4);
        $I->click(AdmRealtyObject::$districtField);
        $I->click(AdmRealtyObject::$district3);
        $I->click(AdmRealtyObject::$street);
        $I->fillField(AdmRealtyObject::$typeStreet, House::editStreet);
        $I->click(AdmRealtyObject::$chooseStreet);
        $I->fillField(AdmRealtyObject::$house_number, House::uniqueHouseNumber());

        $I->fillField(AdmRealtyObject::$generalArea, House::editGeneralArea);
        $I->click(AdmRealtyObject::$areaUnitField);
        $I->click(AdmRealtyObject::$areaUnit0);
        $I->click(AdmRealtyObject::$wallMaterialField);
        $I->click(AdmRealtyObject::$wallMaterial3);
        $I->fillField(AdmRealtyObject::$roomСount, House::editRoomCount);
        $I->fillField(AdmRealtyObject::$livingArea, House::editLivingArea);
        $I->fillField(AdmRealtyObject::$kitchenArea, House::editKitchenArea);
        $I->fillField(AdmRealtyObject::$landArea, House::editLandArea);
        $I->click(AdmRealtyObject::$landAreaUnit);
        $I->click(AdmRealtyObject::$areaUnit1);
        $I->fillField(AdmRealtyObject::$floors, House::editFloors);
        $I->fillField(AdmRealtyObject::$buildYear, House::editBuildYear);
        $I->click(AdmRealtyObject::$wcField);
        $I->click(AdmRealtyObject::$wc2);
        $I->click(AdmRealtyObject::$heatingField);
        $I->click(AdmRealtyObject::$heating3);
        $I->click(AdmRealtyObject::$waterHeatingField);
        $I->click(AdmRealtyObject::$waterHeat3);

        $I->click(AdmRealtyObject::$communication0);
        $I->click(AdmRealtyObject::$communication1);
        $I->click(AdmRealtyObject::$communication2);
        $I->click(AdmRealtyObject::$communication3);
        $I->click(AdmRealtyObject::$communication4);
        $I->click(AdmRealtyObject::$communication5);
        $I->click(AdmRealtyObject::$communication6);
        $I->click(AdmRealtyObject::$communication7);

        $I->click(AdmRealtyObject::$nearObject0);
        $I->click(AdmRealtyObject::$nearObject1);
        $I->click(AdmRealtyObject::$nearObject2);
        $I->click(AdmRealtyObject::$nearObject3);
        $I->click(AdmRealtyObject::$nearObject4);
        $I->click(AdmRealtyObject::$nearObject5);
        $I->click(AdmRealtyObject::$nearObject6);
        $I->click(AdmRealtyObject::$nearObject7);
        $I->click(AdmRealtyObject::$nearObject8);
        $I->click(AdmRealtyObject::$nearObject9);

        $I->attachFile(AdmRealtyObject::$schema, '/img/house_2.jpg');
        $I->wait(1);
        $I->click(AdmRealtyObject::$submitBtn);
        $I->wait(2);
    }

    public function checkEditHouseObject()
    {
        $I=$this;
        $I->reloadPage();
        $I->waitForElement(AdmRealtyObject::$yandexMap);
        $I->seeInPageSource(Lists::objStatus1);
        $I->seeInPageSource(House::region);
        $I->seeInPageSource(House::city);
        $I->seeInPageSource(House::editDistrict);
        $I->seeInPageSource(House::editStreet);
        $I->seeElement(AdmRealtyObject::$house_number,['value' => House::$currentHouseNumber]);
        $I->seeElement(AdmRealtyObject::$generalArea, ['value' => House::editGeneralArea]);
        $I->seeInPageSource(Lists::areaUnit0);
        $I->seeInPageSource(Lists::wallMaterial3);
        $I->seeInPageSource(House::editRoomCount);
        $I->seeInPageSource(House::editLivingArea);
        $I->seeInPageSource(House::editKitchenArea);
        $I->seeInPageSource(House::editLandArea);
        $I->seeInPageSource(Lists::areaUnit1);
        $I->seeInPageSource(House::editFloors);
        $I->seeElement(AdmRealtyObject::$buildYear,['value' => House::editBuildYear]);
        $I->seeInPageSource(Lists::wc2);
        $I->seeInPageSource(Lists::heating3);
        $I->seeInPageSource(Lists::waterHeat3);

        $I->seeElement(AdmRealtyObject::$communication0);
        $I->seeElement(AdmRealtyObject::$communication1);
        $I->seeElement(AdmRealtyObject::$communication2);
        $I->seeElement(AdmRealtyObject::$communication3);
        $I->seeElement(AdmRealtyObject::$communication4);
        $I->seeElement(AdmRealtyObject::$communication5);
        $I->seeElement(AdmRealtyObject::$communication6);
        $I->seeElement(AdmRealtyObject::$communication7);

        $I->seeElement(AdmRealtyObject::$checkedNearObject0);
        $I->seeElement(AdmRealtyObject::$checkedNearObject1);
        $I->seeElement(AdmRealtyObject::$checkedNearObject2);
        $I->seeElement(AdmRealtyObject::$checkedNearObject3);
        $I->seeElement(AdmRealtyObject::$checkedNearObject4);
        $I->seeElement(AdmRealtyObject::$checkedNearObject5);
        $I->seeElement(AdmRealtyObject::$checkedNearObject6);
        $I->seeElement(AdmRealtyObject::$checkedNearObject7);
        $I->seeElement(AdmRealtyObject::$checkedNearObject8);
        $I->seeElement(AdmRealtyObject::$checkedNearObject9);
    }

/*====================================Edit Parcel Object===================================*/

    public function openAdmEditParcelObjPage()
    {
        $I=$this;
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $I->amOnPage(AdmRealtyObject::$objListPageURL .'/' .$realtyParcelId .'/edit');
        $I->waitForElement(AdmRealtyObject::$yandexMap);
    }

    public function editParcelObject()
    {
        $I=$this;
        $I->waitForElement(AdmRealtyObject::$yandexMap);
        $I->click(AdmRealtyObject::$statusField);
        $I->waitForElement(AdmRealtyObject::$objStatus1);
        $I->click(AdmRealtyObject::$objStatus1);
        $I->click(AdmRealtyObject::$regionField);
        $I->click(AdmRealtyObject::$region0);
        $I->click(AdmRealtyObject::$cityField);
        $I->click(AdmRealtyObject::$city4);
        $I->click(AdmRealtyObject::$districtField);
        $I->click(AdmRealtyObject::$district7);
        $I->click(AdmRealtyObject::$street);
        $I->fillField(AdmRealtyObject::$typeStreet, Parcel::editStreet);
        $I->click(AdmRealtyObject::$chooseStreet);
//        $I->click(AdmRealtyObject::$cadastrNumber);
//        $I->fillField(AdmRealtyObject::$cadastrNumber, Parcel::$currentCadastralNumber);
        $I->fillField(AdmRealtyObject::$cadastrNumber, Parcel::uniqueCadastralNumber());
        $I->fillField(AdmRealtyObject::$generalArea, Parcel::editGeneralArea);
        $I->click(AdmRealtyObject::$areaUnitField);
        $I->click(AdmRealtyObject::$areaUnit1);
//        $I->click(AdmRealtyObject::$wallMaterialField);
//        $I->click(AdmRealtyObject::$wallMaterial3);
//        $I->fillField(AdmRealtyObject::$roomСount, House::editRoomCount);
//        $I->fillField(AdmRealtyObject::$livingArea, House::editLivingArea);
//        $I->fillField(AdmRealtyObject::$kitchenArea, House::editKitchenArea);
//        $I->fillField(AdmRealtyObject::$landArea, House::editLandArea);
//        $I->click(AdmRealtyObject::$landAreaUnit);
//        $I->click(AdmRealtyObject::$areaUnit1);
//        $I->fillField(AdmRealtyObject::$floors, House::editFloors);
//        $I->fillField(AdmRealtyObject::$buildYear, House::editBuildYear);
//        $I->click(AdmRealtyObject::$wcField);
//        $I->click(AdmRealtyObject::$wc2);
//        $I->click(AdmRealtyObject::$heatingField);
//        $I->click(AdmRealtyObject::$heating3);
//        $I->click(AdmRealtyObject::$waterHeatingField);
//        $I->click(AdmRealtyObject::$waterHeat3);

        $I->click(AdmRealtyObject::$communication0);
        $I->click(AdmRealtyObject::$communication1);
        $I->click(AdmRealtyObject::$communication2);
        $I->click(AdmRealtyObject::$communication3);
        $I->click(AdmRealtyObject::$communication4);
        $I->click(AdmRealtyObject::$communication5);
        $I->click(AdmRealtyObject::$communication6);
        $I->click(AdmRealtyObject::$communication7);

        $I->click(AdmRealtyObject::$nearObject0);
        $I->click(AdmRealtyObject::$nearObject1);
        $I->click(AdmRealtyObject::$nearObject2);
        $I->click(AdmRealtyObject::$nearObject3);
        $I->click(AdmRealtyObject::$nearObject4);
        $I->click(AdmRealtyObject::$nearObject5);
        $I->click(AdmRealtyObject::$nearObject6);
        $I->click(AdmRealtyObject::$nearObject7);
        $I->click(AdmRealtyObject::$nearObject8);
        $I->click(AdmRealtyObject::$nearObject9);

        $I->attachFile(AdmRealtyObject::$schema, '/img/parcel_3.jpg');
        $I->wait(5);
//        $I->pauseExecution();
        $I->click(AdmRealtyObject::$submitBtn);
        $I->wait(1);
    }

    public function checkEditParcelObject()
    {
        $I=$this;
        $I->reloadPage();
        $I->waitForElement(AdmRealtyObject::$yandexMap);
//        $I->seeInPageSource(AdmRealtyObject::$regionField,['value' => Lists::objStatus1]);
        $I->seeInPageSource(Parcel::region);
        $I->seeInPageSource(Parcel::city);
        $I->seeInPageSource(Parcel::editDistrict);
        $I->seeInPageSource(Parcel::editStreet);
        $I->seeElement(AdmRealtyObject::$cadastrNumber, ['value' => Parcel::$currentCadastralNumber]);
        $I->seeElement(AdmRealtyObject::$generalArea, ['value' => Parcel::editGeneralArea]);
        $I->seeInPageSource(Lists::areaUnit1);
//        $I->seeInPageSource(Lists::wallMaterial3);
//        $I->seeInPageSource(House::editRoomCount);
//        $I->seeInPageSource(House::editLivingArea);
//        $I->seeInPageSource(House::editKitchenArea);
//        $I->seeInPageSource(House::editLandArea);
//        $I->seeInPageSource(Lists::areaUnit1);
//        $I->seeInPageSource(House::editFloors);
//        $I->seeElement(AdmRealtyObject::$buildYear,['value' => House::editBuildYear]);
//        $I->seeInPageSource(Lists::wc2);
//        $I->seeInPageSource(Lists::heating3);
//        $I->seeInPageSource(Lists::waterHeat3);

        $I->seeElement(AdmRealtyObject::$communication0);
        $I->seeElement(AdmRealtyObject::$communication1);
        $I->seeElement(AdmRealtyObject::$communication2);
        $I->seeElement(AdmRealtyObject::$communication3);
        $I->seeElement(AdmRealtyObject::$communication4);
        $I->seeElement(AdmRealtyObject::$communication5);
        $I->seeElement(AdmRealtyObject::$communication6);
        $I->seeElement(AdmRealtyObject::$communication7);

        $I->seeElement(AdmRealtyObject::$checkedNearObject0);
        $I->seeElement(AdmRealtyObject::$checkedNearObject1);
        $I->seeElement(AdmRealtyObject::$checkedNearObject2);
        $I->seeElement(AdmRealtyObject::$checkedNearObject3);
        $I->seeElement(AdmRealtyObject::$checkedNearObject4);
        $I->seeElement(AdmRealtyObject::$checkedNearObject5);
        $I->seeElement(AdmRealtyObject::$checkedNearObject6);
        $I->seeElement(AdmRealtyObject::$checkedNearObject7);
        $I->seeElement(AdmRealtyObject::$checkedNearObject8);
        $I->seeElement(AdmRealtyObject::$checkedNearObject9);
    }

/*====================================Edit Commercial Object===================================*/

    public function openAdmEditCommercialObjPage()
    {
        $I=$this;
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $I->amOnPage(AdmRealtyObject::$objListPageURL .'/' .$realtyCommercialId .'/edit');
        $I->waitForElement(AdmRealtyObject::$yandexMap);
    }

    public function editCommercialObject()
    {
        $I=$this;
        $I->waitForElement(AdmRealtyObject::$yandexMap);
        $I->click(AdmRealtyObject::$statusField);
        $I->waitForElement(AdmRealtyObject::$objStatus1);
        $I->click(AdmRealtyObject::$objStatus1);
        $I->click(AdmRealtyObject::$regionField);
        $I->click(AdmRealtyObject::$region0);
        $I->click(AdmRealtyObject::$cityField);
        $I->click(AdmRealtyObject::$city4);
        $I->click(AdmRealtyObject::$districtField);
        $I->click(AdmRealtyObject::$district3);
        $I->click(AdmRealtyObject::$street);
        $I->fillField(AdmRealtyObject::$typeStreet, Commercial::editStreet);
        $I->click(AdmRealtyObject::$chooseStreet);
        $I->fillField(AdmRealtyObject::$house_number, Commercial::uniqueCommercialNumber());

        $I->fillField(AdmRealtyObject::$generalArea, Commercial::editGeneralArea);
        $I->click(AdmRealtyObject::$areaUnitField);
        $I->click(AdmRealtyObject::$areaUnit0);
        $I->fillField(AdmRealtyObject::$effectiveArea, Commercial::editEffectiveArea);
        $I->click(AdmRealtyObject::$wallMaterialField);
        $I->click(AdmRealtyObject::$wallMaterial1);
        $I->fillField(AdmRealtyObject::$roomСount, Commercial::editRoomCount);
        $I->fillField(AdmRealtyObject::$floors, Commercial::editFloor);
        $I->fillField(AdmRealtyObject::$floorNumber, Commercial::editFloorNumber);
        $I->fillField(AdmRealtyObject::$buildYear, Commercial::editBuildYear);
        $I->click(AdmRealtyObject::$wcField);
        $I->click(AdmRealtyObject::$wc1);
        $I->click(AdmRealtyObject::$heatingField);
        $I->click(AdmRealtyObject::$heating1);
        $I->click(AdmRealtyObject::$waterHeatingField);
        $I->click(AdmRealtyObject::$waterHeat1);

        $I->click(AdmRealtyObject::$communication0);
        $I->click(AdmRealtyObject::$communication1);
        $I->click(AdmRealtyObject::$communication2);
        $I->click(AdmRealtyObject::$communication3);
        $I->click(AdmRealtyObject::$communication4);
        $I->click(AdmRealtyObject::$communication5);
        $I->click(AdmRealtyObject::$communication6);
        $I->click(AdmRealtyObject::$communication7);


        $I->attachFile(AdmRealtyObject::$schema, '/img/commerc_3.jpg');
        $I->wait(1);
        $I->click(AdmRealtyObject::$submitBtn);
        $I->wait(2);
    }

    public function checkEditCommercialObject()
    {
        $I=$this;
        $I->reloadPage();
        $I->waitForElement(AdmRealtyObject::$yandexMap);
        $I->seeInPageSource(Lists::objStatus1);
        $I->seeInPageSource(Commercial::region);
        $I->seeInPageSource(Commercial::city);
        $I->seeInPageSource(Commercial::editDistrict);
        $I->seeInPageSource(Commercial::editStreet);
        $I->seeElement(AdmRealtyObject::$house_number,['value' => Commercial::$currentCommercialNumber]);
        $I->seeElement(AdmRealtyObject::$generalArea, ['value' => Commercial::editGeneralArea]);
        $I->seeInPageSource(Lists::areaUnit0);
        $I->seeInPageSource(Lists::wallMaterial1);
        $I->seeElement(AdmRealtyObject::$effectiveArea, ['value' => Commercial::editEffectiveArea]);
        $I->seeInPageSource(Commercial::editRoomCount);
        $I->seeInPageSource(Commercial::editFloor);
        $I->seeInPageSource(Commercial::editFloorNumber);
        $I->seeElement(AdmRealtyObject::$buildYear,['value' => Commercial::editBuildYear]);
        $I->seeInPageSource(Lists::wc1);
        $I->seeInPageSource(Lists::heating1);
        $I->seeInPageSource(Lists::waterHeat1);

        $I->seeElement(AdmRealtyObject::$communication0);
        $I->seeElement(AdmRealtyObject::$communication1);
        $I->seeElement(AdmRealtyObject::$communication2);
        $I->seeElement(AdmRealtyObject::$communication3);
        $I->seeElement(AdmRealtyObject::$communication4);
        $I->seeElement(AdmRealtyObject::$communication5);
        $I->seeElement(AdmRealtyObject::$communication6);
        $I->seeElement(AdmRealtyObject::$communication7);

    }
}