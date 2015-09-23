<?php
namespace Step\Vpn;
use Page\AddAdvert;
use \Data\Flat;

class Advert extends \VpnTester
{

    public function fillInStandardFlatType()
    {
        $I = $this;
        $I->click(AddAdvert::$category);
        $I->click(AddAdvert::$flatCategory);
        $I->click(AddAdvert::$category_type);
        $I->click(AddAdvert::$catTypeFlat);

    }


    public function fillInStandardFlatAddress()
    {
        $I = $this;
        $I->click(AddAdvert::$region);
        $I->click(AddAdvert::$chooseRegion);
        $I->click(AddAdvert::$city);
        $I->click(AddAdvert::$chooseCity);
        $I->click(AddAdvert::$district);
        $I->fillField(AddAdvert::$typeDistrict,Flat::district);
        $I->click(AddAdvert::$chooseDistrict);

        $I->click(AddAdvert::$street);
        $I->fillField(AddAdvert::$typeStreet,Flat::street);
        $I->click(AddAdvert::$chooseStreet);
        $I->fillField(AddAdvert::$house_number,Flat::houseNumber);
        $I->fillField(AddAdvert::$flat_number,Flat::uniqueFlatNumber());
    }

    // TODO: Improve to insert non-standard data
    public function fillInFlatAddress($data = [])
    {
        $I = $this;
        $I->fillField(AddAdvert::$typeDistrict, isset($data['district']) ? $data['district'] : Flat::district);
    }

    public function fillInStandardFlatProperties()
    {
        $I = $this;
        $I->fillField(AddAdvert::$generalArea,Flat::generalArea);
        $I->click(AddAdvert::$generalAreaUnit);
        $I->click(AddAdvert::$generalAreaUnitType);
        $I->click(AddAdvert::$wallMaterial);
        $I->fillField(AddAdvert::$typeWallMaterial,Flat::wallMaterial);
        $I->click(AddAdvert::$chooseFirstRow);
        //$I->pressKey("//a[@class='ui-select-choices-row-inner']",WebDriverKeys::ENTER);

        $I->doubleClick(AddAdvert::$roomСount);
        $I->fillField(AddAdvert::$roomСount,AddAdvert::$typeRoomCount);
        $I->fillField(AddAdvert::$livingArea,Flat::livingArea);
        $I->fillField(AddAdvert::$kitchenArea,Flat::kitchenArea);
        $I->fillField(AddAdvert::$floors,Flat::floors);
        $I->fillField(AddAdvert::$floorNumber,Flat::floorNumber);
        $I->fillField(AddAdvert::$buildYear,Flat::buildYear);
        $I->click(AddAdvert::$wc);
        $I->fillField(AddAdvert::$typeWC, Flat::wc);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$balcony);
        $I->fillField(AddAdvert::$typeBalcony, Flat::balcony);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$heating);
        $I->fillField(AddAdvert::$typeHeating, Flat::heating);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$waterHeating);
        $I->fillField(AddAdvert::$typeWaterHeating, Flat::waterHeating);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$nearObjectsFirst);
        $I->click(AddAdvert::$nearObjectsLast);
        $I->attachFile(AddAdvert::$schemaFile,'standart.jpg'); //schema
        $I->wait(2);
        $I->click(AddAdvert::$step2_next);
        $I->wait(2);
    }

    public function checkFlatObjectProperties()
    {
        $I = $this;
        $I->see(Flat::category,AddAdvert::$objectTable);
        $I->see(Flat::categoryType1,AddAdvert::$objectTable);
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
        $I->see(Flat::wc,AddAdvert::$objectTable);
        $I->see(Flat::balcony,AddAdvert::$objectTable);
        $I->see(Flat::heating,AddAdvert::$objectTable);
        $I->see(Flat::waterHeating,AddAdvert::$objectTable);
    }

    public function agreeFlatObjectProperties()
    {
        $I = $this;
        $I->click(AddAdvert::$step2_2_createObject);
        $I->wait(1);
    }

    public function changeFlatObjectProperties()
    {
//        $I = this;
//        $I->click(AddAdvert::$step2_2_createObject);
//        $I->wait(1);
    }

    public function changeFlatAddress()
    {
//        $I = this;

    }

    public function fillInFlatAdvertProperties()
    {
        $I = $this;
        $I->click(AddAdvert::$operationTypeSell);
        $I->fillField(AddAdvert::$advertDescription, Flat::descriptionFlatSell);
        $I->fillField(AddAdvert::$price, Flat::priceFlatSell);
//        $I->click(AddAdvert::$month);
//        $I->fillField(AddAdvert::$typeMonth, Flat::month);
        $I->click(AddAdvert::$auction);
//        $I->fillField(AddAdvert::$date, Flat::date);
//        $I->click(AddAdvert::$month);
//        $I->fillField(AddAdvert::$typeMonth, Flat::month);
//        $I->click(AddAdvert::$chooseFirstRow);
//        $I->fillField(AddAdvert::$year, Flat::year);
        $I->click(AddAdvert::$market);
        $I->fillField(AddAdvert::$typeMarket, Flat::market);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$repair);
        $I->fillField(AddAdvert::$typeRepair, Flat::repair);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->doubleClick(AddAdvert::$bedsCount);
        $I->fillField(AddAdvert::$bedsCount, Flat::beds);
    }

    public function fillInFlatAdvertCheckboxes()
    {
        $I = $this;
        $I->click(AddAdvert::$furnitureFirst);
        $I->click(AddAdvert::$furnitureLast);
        $I->click(AddAdvert::$appliancesFirst);
        $I->click(AddAdvert::$appliancesLast);
        $I->click(AddAdvert::$additionalFirst);
        $I->click(AddAdvert::$additionalLast);
    }

    public function uploadFlatAdvertImage()
    {
        $I = $this;
        $I->attachFile(AddAdvert::$galleryFile, 'flat_1.jpg');
        $I->wait(1);
        $I->attachFile(AddAdvert::$galleryFile, 'flat_2.jpg');
        $I->wait(1);
        $I->attachFile(AddAdvert::$galleryFile, 'flat_3.jpg');
        $I->wait(1);
    }

    public function fillInOwnerContactsData()
    {
        $I = $this;
        $I->fillField(AddAdvert::$ownerName,Flat::ownerName);
        $I->fillField(AddAdvert::$ownerContacts,Flat::ownerContacts);
    }

    public function clickIamOwnerLink()
    {
        $I = $this;
        $I->click(AddAdvert::$ownerLink);
    }

    public function clickCreateAdvertButton()
    {
        $I = $this;
        $I->click(AddAdvert::$createAdvertButton);
        $I->wait(1);
    }


}