<?php
namespace Step\Vpn;
use Data\Commercial;
use Data\Parcel;
use Page\AddAdvert;
use \Data\Flat;
use \Data\House;
use \Data\Lists;
use \Facebook\WebDriver\WebDriverKeys;
use Page\AdvPage;
use Page\SearchPage;

class Search extends \VpnTester
{
    public function searchFlat()
    {
        $I = $this;
        $I->wantTo('Check UI Search Page');
        $I->amOnPage('/search');
//        $I->see('Продажа', SearchPage::$operationType1);
//        $I->see('Аренда', SearchPage::$operationType2);
        $I->click(SearchPage::$operationType1);
        $I->see('Киевская область', SearchPage::$regionField);
        $I->click(SearchPage::$regionField);
        $I->fillField(SearchPage::$regionType,Flat::region);
//        $I->see(SearchPage::$region0);
        $I->click(SearchPage::$region0);
        $I->click(SearchPage::$cityField);
        $I->fillField(SearchPage::$cityType, Flat::city);
        $I->click(SearchPage::$city0);
        $I->click(SearchPage::$districtField);
        $I->fillField(SearchPage::$districtType, Flat::editDistrict);
        $I->click(SearchPage::$district0);
        $I->click(SearchPage::$streetField);
        $I->fillField(SearchPage::$streetType, Flat::apiStreet);
        $I->click(SearchPage::$street0);
        $I->click(SearchPage::$categoryField);
        $I->click(SearchPage::$flatCategory);
        $I->click(SearchPage::$categoryType);
        $I->click(SearchPage::$flatCatType0);
        $I->fillField(SearchPage::$priseFrom, Flat::priceFlatSearch);
        $I->fillField(SearchPage::$priseTo, Flat::priceFlatSearch);
        $I->click(SearchPage::$currencyField);
        $I->click(SearchPage::$currencyUS);
        $I->click(SearchPage::$auction);
        $I->dontSee(SearchPage::$agencyField);

        $I->click(SearchPage::$characteristicsTab);
        $I->click(SearchPage::$marketTypeField);
        $I->click(SearchPage::$marketType1);
        $I->fillField(SearchPage::$buildYearFrom, Flat::buildYear);
        $I->fillField(SearchPage::$buildYearTo, Flat::buildYear);
        $I->fillField(SearchPage::$bedCountFrom, Flat::beds);
        $I->fillField(SearchPage::$bedCountTo, Flat::beds);
        $I->click(SearchPage::$wallMaterialField);
        $I->click(SearchPage::$wallMaterial1);
        $I->click(SearchPage::$repairField);
        $I->click(SearchPage::$repair1);
        $I->click(SearchPage::$wcField);
        $I->click(SearchPage::$wc2);
        $I->click(SearchPage::$balconyField);
        $I->click(SearchPage::$balcony2);
        $I->click(SearchPage::$heatingField);
        $I->click(SearchPage::$heating2);
        $I->click(SearchPage::$waterHeatingField);
        $I->click(SearchPage::$waterHeating2);

        $I->click(SearchPage::$areaTab);
        $I->fillField(SearchPage::$generalAreaFrom, Flat::generalArea);
        $I->fillField(SearchPage::$generalAreaTo, Flat::generalArea);
        $I->click(SearchPage::$areaUnitField);
        $I->click(SearchPage::$areaUnit0);
        $I->fillField(SearchPage::$livingAreaFrom, Flat::livingArea);
        $I->fillField(SearchPage::$livingAreaTo, Flat::livingArea);
        $I->fillField(SearchPage::$kitchenAreaFrom, Flat::kitchenArea);
        $I->fillField(SearchPage::$kitchenAreaTo, Flat::kitchenArea);

        $I->click(SearchPage::$floorsAndRoomsTab);
        $I->fillField(SearchPage::$roomsCountFrom, Flat::roomCount);
        $I->fillField(SearchPage::$roomsCountTo, Flat::roomCount);
        $I->fillField(SearchPage::$floorFrom, Flat::floorNumber);
        $I->fillField(SearchPage::$floorTo, Flat::floorNumber);
        $I->fillField(SearchPage::$floorNumberFrom, Flat::floors);
        $I->fillField(SearchPage::$floorNumberTo, Flat::floors);

        $I->click(SearchPage::$furnitureTab);
        $I->click(SearchPage::$furniture0);

        $I->click(SearchPage::$applianceTab);
        $I->click(SearchPage::$appliance0);

        $I->click(SearchPage::$additionalTab);
        $I->click(SearchPage::$additional0);

        $I->click(SearchPage::$nearObjectsTab);
        $I->click(SearchPage::$nearObject0);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->waitForElement(SearchPage::$resultPrice);

//        $I->see(Flat::roomCount.' комнаты', SearchPage::$resultRoomCount);
//        $I->see(Flat::generalArea. 'кв. метров', )
        $I->click(SearchPage::$resultPrice);


    }


    public function checkFlatObjectPropertiesSearch()
    {
        $I = $this;
//        $I->amOnPage()
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Flat::priceFlatSell, AdvPage::$advInfoPrice);
        $I->see(Flat::commission, AdvPage::$advInfoPrice);
        $I->see(Flat::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Flat::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Flat::editWallMaterial, AdvPage::$advInfoMainProps);
        $I->see(Flat::floorNumber, AdvPage::$advInfoMainProps);
        $I->see(Flat::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Flat::descriptionFlatSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Flat::category, AdvPage::$advPropsTable);
        $I->see(Flat::categoryType0, AdvPage::$advPropsTable);
        $I->see(Flat::region, AdvPage::$advPropsTable);
        $I->see(Flat::city, AdvPage::$advPropsTable);
        $I->see(Flat::editDistrict, AdvPage::$advPropsTable);
        $I->see(Flat::apiStreet, AdvPage::$advPropsTable);
        $I->see(Flat::generalArea, AdvPage::$advPropsTable);
        $I->see(Flat::livingArea, AdvPage::$advPropsTable);
        $I->see(Flat::kitchenArea, AdvPage::$advPropsTable);
        $I->see(Lists::marketType0, AdvPage::$advPropsTable);
        $I->see(Flat::roomCount, AdvPage::$advPropsTable);
        $I->see(Flat::floorNumber, AdvPage::$advPropsTable);
        $I->see(Flat::floors, AdvPage::$advPropsTable);
        $I->see(Flat::buildYear, AdvPage::$advPropsTable);
        $I->see(Lists::wc1, AdvPage::$advPropsTable);
        $I->see(Lists::balconies1, AdvPage::$advPropsTable);
        $I->see(Lists::heating1, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat1, AdvPage::$advPropsTable);
        $I->see(Lists::repair0, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject0, AdvPage::$advPropsTable);
        $I->see(Lists::appliance0, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat0, AdvPage::$advPropsTable);

    }

    public function searchFlat1()
    {
        $I = $this;
        $I->wantTo('Change operation type');
        $I->amOnPage('/search');
        $I->reloadPage();
        $I->click(SearchPage::$operationType2);
//        $I->see('Киевская область', SearchPage::$regionField);
        $I->click(SearchPage::$regionField);
        $I->fillField(SearchPage::$regionType,Flat::region);
//        $I->see(SearchPage::$region0);
        $I->click(SearchPage::$region0);
        $I->click(SearchPage::$cityField);
        $I->fillField(SearchPage::$cityType, Flat::city);
        $I->click(SearchPage::$city0);
        $I->click(SearchPage::$districtField);
        $I->fillField(SearchPage::$districtType, Flat::editDistrict);
        $I->click(SearchPage::$district0);
        $I->click(SearchPage::$streetField);
        $I->fillField(SearchPage::$streetType, Flat::apiStreet);
        $I->click(SearchPage::$street0);
        $I->click(SearchPage::$categoryField);
        $I->click(SearchPage::$flatCategory);
        $I->click(SearchPage::$categoryType);
        $I->click(SearchPage::$flatCatType0);
        $I->fillField(SearchPage::$priseFrom, Flat::priceFlatSearch);
        $I->fillField(SearchPage::$priseTo, Flat::priceFlatSearch);
        $I->click(SearchPage::$currencyField);
        $I->click(SearchPage::$currencyUS);
        $I->click(SearchPage::$auction);
        $I->dontSee(SearchPage::$agencyField);

        $I->click(SearchPage::$characteristicsTab);
        $I->click(SearchPage::$marketTypeField);
        $I->click(SearchPage::$marketType1);
        $I->fillField(SearchPage::$buildYearFrom, Flat::buildYear);
        $I->fillField(SearchPage::$buildYearTo, Flat::buildYear);
        $I->fillField(SearchPage::$bedCountFrom, Flat::beds);
        $I->fillField(SearchPage::$bedCountTo, Flat::beds);
        $I->click(SearchPage::$wallMaterialField);
        $I->click(SearchPage::$wallMaterial1);
        $I->click(SearchPage::$repairField);
        $I->click(SearchPage::$repair1);
        $I->click(SearchPage::$wcField);
        $I->click(SearchPage::$wc2);
        $I->click(SearchPage::$balconyField);
        $I->click(SearchPage::$balcony2);
        $I->click(SearchPage::$heatingField);
        $I->click(SearchPage::$heating2);
        $I->click(SearchPage::$waterHeatingField);
        $I->click(SearchPage::$waterHeating2);

        $I->click(SearchPage::$areaTab);
        $I->fillField(SearchPage::$generalAreaFrom, Flat::generalArea);
        $I->fillField(SearchPage::$generalAreaTo, Flat::generalArea);
        $I->click(SearchPage::$areaUnitField);
        $I->click(SearchPage::$areaUnit0);
        $I->fillField(SearchPage::$livingAreaFrom, Flat::livingArea);
        $I->fillField(SearchPage::$livingAreaTo, Flat::livingArea);
        $I->fillField(SearchPage::$kitchenAreaFrom, Flat::kitchenArea);
        $I->fillField(SearchPage::$kitchenAreaTo, Flat::kitchenArea);

        $I->click(SearchPage::$floorsAndRoomsTab);
        $I->fillField(SearchPage::$roomsCountFrom, Flat::roomCount);
        $I->fillField(SearchPage::$roomsCountTo, Flat::roomCount);
        $I->fillField(SearchPage::$floorFrom, Flat::floorNumber);
        $I->fillField(SearchPage::$floorTo, Flat::floorNumber);
        $I->fillField(SearchPage::$floorNumberFrom, Flat::floors);
        $I->fillField(SearchPage::$floorNumberTo, Flat::floors);

        $I->click(SearchPage::$furnitureTab);
        $I->click(SearchPage::$furniture0);

        $I->click(SearchPage::$applianceTab);
        $I->click(SearchPage::$appliance0);

        $I->click(SearchPage::$additionalTab);
        $I->click(SearchPage::$additional0);

        $I->click(SearchPage::$nearObjectsTab);
        $I->click(SearchPage::$nearObject0);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

//        $I->see(Flat::roomCount.' комнаты', SearchPage::$resultRoomCount);
//        $I->see(Flat::generalArea. 'кв. метров', )
//        $I->click(SearchPage::$resultPrice);
    }

    public function searchFlat2()
    {
        $I = $this;
        $I->wantTo('Change district');
        $I->click(SearchPage::$operationType1);
        $I->click(SearchPage::$districtField);
        $I->fillField(SearchPage::$districtType, Flat::district);
        $I->click(SearchPage::$district0);
        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);


    }
    public function searchFlat3()
    {
        $I = $this;
        $I->wantTo('Change street');
        $I->click(SearchPage::$districtField);
        $I->fillField(SearchPage::$districtType, Flat::editDistrict);
        $I->click(SearchPage::$district0);
        $I->click(SearchPage::$streetField);
        $I->fillField(SearchPage::$streetType, Flat::street);
        $I->click(SearchPage::$street0);
        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat4()
    {
        $I = $this;
        $I->wantTo('Change city');
        $I->click(SearchPage::$streetField);
        $I->fillField(SearchPage::$streetType, Flat::apiStreet);
        $I->click(SearchPage::$street0);
        $I->click(SearchPage::$cityField);
        $I->fillField(SearchPage::$cityType, Flat::editCity);
        $I->click(SearchPage::$city0);
        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

    }
    public function searchFlat5()
    {
        $I = $this;
        $I->wantTo('Change category');
        $I->click(SearchPage::$cityField);
        $I->fillField(SearchPage::$cityType, Flat::city);
        $I->click(SearchPage::$city0);
        $I->click(SearchPage::$categoryField);
        $I->click(SearchPage::$houseCategory);
        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

    }
    public function searchFlat6()
    {
        $I = $this;
        $I->wantTo('Change category type');
        $I->click(SearchPage::$categoryField);
        $I->click(SearchPage::$flatCategory);
        $I->click(SearchPage::$categoryType);
        $I->click(SearchPage::$flatCatType1);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

    }
    public function searchFlat7()
    {
        $I = $this;
        $I->wantTo('Change price');

        $I->click(SearchPage::$categoryType);
        $I->click(SearchPage::$flatCatType0);
        $I->fillField(SearchPage::$priseFrom, Flat::priceFlatRent);
        $I->fillField(SearchPage::$priseTo, Flat::priceFlatRent);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

    }
    public function searchFlat8()
    {
        $I = $this;
        $I->wantTo('Change currency');
        $I->fillField(SearchPage::$priseFrom, Flat::priceFlatSearch);
        $I->fillField(SearchPage::$priseTo, Flat::priceFlatSearch);
        $I->click(SearchPage::$currencyField);
        $I->click(SearchPage::$currencyUA);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

    }
    public function searchFlat9()
    {
        $I = $this;
        $I->wantTo('Change marketType');
        $I->click(SearchPage::$currencyField);
        $I->click(SearchPage::$currencyUS);
        $I->click(SearchPage::$marketTypeField);
        $I->click(SearchPage::$marketType2);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

    }
    public function searchFlat10()
    {
        $I = $this;
        $I->wantTo('Change build Year');
        $I->click(SearchPage::$marketTypeField);
        $I->click(SearchPage::$marketType1);
        $I->fillField(SearchPage::$buildYearFrom, Flat::editBuildYear);
        $I->fillField(SearchPage::$buildYearTo, Flat::editBuildYear);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

    }
    public function searchFlat11()
    {
        $I = $this;
        $I->wantTo('Change beds count');
        $I->fillField(SearchPage::$buildYearFrom, Flat::buildYear);
        $I->fillField(SearchPage::$buildYearTo, Flat::buildYear);
        $I->fillField(SearchPage::$bedCountFrom, Flat::editBeds);
        $I->fillField(SearchPage::$bedCountTo, Flat::editBeds);
        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

    }
    public function searchFlat12()
    {
        $I = $this;
        $I->wantTo('Change wall material');
        $I->fillField(SearchPage::$bedCountFrom, Flat::beds);
        $I->fillField(SearchPage::$bedCountTo, Flat::beds);
        $I->click(SearchPage::$wallMaterialField);
        $I->click(SearchPage::$wallMaterial2);
        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);

    }
    public function searchFlat13()
    {
        $I = $this;
        $I->wantTo('Change repair');
        $I->click(SearchPage::$wallMaterialField);
        $I->click(SearchPage::$wallMaterial1);
        $I->click(SearchPage::$repairField);
        $I->click(SearchPage::$repair2);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat14()
    {
        $I = $this;
        $I->wantTo('Change wc');
        $I->click(SearchPage::$repairField);
        $I->click(SearchPage::$repair1);
        $I->click(SearchPage::$wcField);
        $I->click(SearchPage::$wc1);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat15()
    {
        $I = $this;
        $I->wantTo('Change balcony');
        $I->click(SearchPage::$wcField);
        $I->click(SearchPage::$wc2);
        $I->click(SearchPage::$balconyField);
        $I->click(SearchPage::$balcony1);


        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat16()
    {
        $I = $this;
        $I->wantTo('Change heating');
        $I->click(SearchPage::$balconyField);
        $I->click(SearchPage::$balcony2);
        $I->click(SearchPage::$heatingField);
        $I->click(SearchPage::$heating1);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat17()
    {
        $I = $this;
        $I->wantTo('Change water heating');
        $I->click(SearchPage::$heatingField);
        $I->click(SearchPage::$heating2);
        $I->click(SearchPage::$waterHeatingField);
        $I->click(SearchPage::$waterHeating1);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat18()
    {
        $I = $this;
        $I->wantTo('Change general area');
        $I->click(SearchPage::$waterHeatingField);
        $I->click(SearchPage::$waterHeating2);
        $I->fillField(SearchPage::$generalAreaFrom, Flat::editGeneralArea);
        $I->fillField(SearchPage::$generalAreaTo, Flat::editGeneralArea);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat19()
    {
        $I = $this;
        $I->wantTo('Change area unit');
        $I->fillField(SearchPage::$generalAreaFrom, Flat::generalArea);
        $I->fillField(SearchPage::$generalAreaTo, Flat::generalArea);
        $I->click(SearchPage::$areaUnitField);
        $I->click(SearchPage::$areaUnit1);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat20()
    {
        $I = $this;
        $I->wantTo('Change living area');
        $I->click(SearchPage::$areaUnitField);
        $I->click(SearchPage::$areaUnit0);
        $I->fillField(SearchPage::$livingAreaFrom, Flat::editLivingArea);
        $I->fillField(SearchPage::$livingAreaTo, Flat::editLivingArea);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat21()
    {
        $I = $this;
        $I->wantTo('Change kitchen area');
        $I->fillField(SearchPage::$livingAreaFrom, Flat::livingArea);
        $I->fillField(SearchPage::$livingAreaTo, Flat::livingArea);
        $I->fillField(SearchPage::$kitchenAreaFrom, Flat::editKitchenArea);
        $I->fillField(SearchPage::$kitchenAreaTo, Flat::editKitchenArea);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat22()
    {
        $I = $this;
        $I->wantTo('Change room count');
        $I->fillField(SearchPage::$kitchenAreaFrom, Flat::kitchenArea);
        $I->fillField(SearchPage::$kitchenAreaTo, Flat::kitchenArea);
        $I->fillField(SearchPage::$roomsCountFrom, Flat::editRoomCount);
        $I->fillField(SearchPage::$roomsCountTo, Flat::editRoomCount);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat23()
    {
        $I = $this;
        $I->wantTo('Change room count');
        $I->fillField(SearchPage::$roomsCountFrom, Flat::roomCount);
        $I->fillField(SearchPage::$roomsCountTo, Flat::roomCount);
        $I->fillField(SearchPage::$floorFrom, Flat::editFloorNumber);
        $I->fillField(SearchPage::$floorTo, Flat::editFloorNumber);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat24()
    {
        $I = $this;
        $I->wantTo('Change floor');
        $I->fillField(SearchPage::$roomsCountFrom, Flat::roomCount);
        $I->fillField(SearchPage::$roomsCountTo, Flat::roomCount);
        $I->fillField(SearchPage::$floorFrom, Flat::editFloorNumber);
        $I->fillField(SearchPage::$floorTo, Flat::editFloorNumber);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat25()
    {
        $I = $this;
        $I->wantTo('Change floor number');
        $I->fillField(SearchPage::$floorFrom, Flat::floorNumber);
        $I->fillField(SearchPage::$floorTo, Flat::floorNumber);
        $I->fillField(SearchPage::$floorNumberFrom, Flat::editFloors);
        $I->fillField(SearchPage::$floorNumberTo, Flat::editFloors);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat26()
    {
        $I = $this;
        $I->wantTo('Change furniture');
        $I->fillField(SearchPage::$floorNumberFrom, Flat::floors);
        $I->fillField(SearchPage::$floorNumberTo, Flat::floors);
        $I->click(SearchPage::$furniture0);
        $I->click(SearchPage::$furniture1);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat27()
    {
        $I = $this;
        $I->wantTo('Change appliance');
//        $I->click(SearchPage::$furniture0);
//        $I->click(SearchPage::$furniture1);
        $I->click(SearchPage::$appliance0);
        $I->click(SearchPage::$appliance1);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat28()
    {
        $I = $this;
        $I->wantTo('Change additional');
        $I->click(SearchPage::$appliance0);
        $I->click(SearchPage::$appliance1);
        $I->click(SearchPage::$additional0);
        $I->click(SearchPage::$additional1);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }
    public function searchFlat29()
    {
        $I = $this;
        $I->wantTo('Change aplience');
        $I->click(SearchPage::$additional0);
        $I->click(SearchPage::$additional1);
        $I->click(SearchPage::$nearObject0);
        $I->click(SearchPage::$nearObject1);

        $I->click(SearchPage::$searchButton);

        //--------------------------Search result------------------------------------------//

        $I->dontSee(SearchPage::$resultPrice);
        $I->dontSee(SearchPage::$resultAdvert);
    }

}