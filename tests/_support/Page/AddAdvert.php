<?php
namespace Page;
use Data\Flat;
use Data\House;
use Data\Lists;
use Data\Parcel;


class AddAdvert
{
    public static $chooseFirstRow = "//a[@class='ui-select-choices-row-inner']";

    public static $category ='[ng-model="ctrl.realty.category"] span'; //html/body/div[1]/div[3]/form/dl/dd[1]/div/div/span
    public static $flatCategory = "//div[contains(.,'" . Flat::category . "')]";
    public static $houseCategory = ".//*[@id='ui-select-choices-row-0-1']/a";
    public static $parcelCategory = ".//*[@id='ui-select-choices-row-0-2']/a";
    public static $commercialCategory = ".//*[@id='ui-select-choices-row-0-3']/a";

    public static $category_type = '[ng-model="ctrl.realty.categoryType"] span';
    public static $flatCatType0 = "//div[contains(.,'" .Flat::categoryType0. "')]";
    public static $flatCatType1 = "//div[contains(.,'" .Flat::categoryType1. "')]";

    public static $houseCatType0 = "//div[contains(.,'" .House::categoryType0 ."')]"; //div[contains(.,'Дом')]
    public static $houseCatType1 = "//div[contains(.,'" .House::categoryType1 ."')]";
    public static $houseCatType2 = "//div[contains(.,'" .House::categoryType2 ."')]";

    public static $parcelCatType0 = ".//*[@id='ui-select-choices-row-1-0']/a";
    public static $parcelCatType1 = ".//*[@id='ui-select-choices-row-1-1']/a";
    public static $parcelCatType2 = ".//*[@id='ui-select-choices-row-1-2']/a";
    public static $parcelCatType3 = ".//*[@id='ui-select-choices-row-1-3']/a";
    public static $parcelCatType4 = "//div[contains(.,'" .Parcel::categoryType4 ."')]";

    public static $commercialCatType0 = ".//*[@id='ui-select-choices-row-1-0']/a";
    public static $commercialCatType1 = ".//*[@id='ui-select-choices-row-1-1']/a";
    public static $commercialCatType2 = ".//*[@id='ui-select-choices-row-1-2']/a";
    public static $commercialCatType3 = ".//*[@id='ui-select-choices-row-1-3']/a";
    public static $commercialCatType4 = ".//*[@id='ui-select-choices-row-1-4']/a";
    public static $commercialCatType5 = ".//*[@id='ui-select-choices-row-1-5']/a";
    public static $commercialCatType6 = ".//*[@id='ui-select-choices-row-1-6']/a";
    public static $commercialCatType7 = ".//*[@id='ui-select-choices-row-1-7']/a";
    public static $commercialCatType8 = ".//*[@id='ui-select-choices-row-1-8']/a";
    public static $commercialCatType9 = ".//*[@id='ui-select-choices-row-1-9']/a";
    public static $commercialCatType10 = ".//*[@id='ui-select-choices-row-1-10']/a";



    public static $region = '[ng-model="ctrl.realty.address.region"] span';
    public static $typeRegion = '[ng-model="ctrl.realty.address.region"] input';
    public static $chooseRegion = "//div[contains(.,'".Flat::region."')]";

    public static $city = '[ng-model="ctrl.realty.address.city"] span';
    public static $typeCity = '[ng-model="ctrl.realty.address.city"] input';

    public static $chooseCity = "//div[contains(.,'".Flat::city."')]";

    public static $district = '[ng-model="ctrl.realty.address.district"] span';
    public static $typeDistrict = '[ng-model="ctrl.realty.address.district"] input';
    public static $chooseDistrict = "//div[@id='ui-select-choices-row-4-0']/a/div";

    public static $street = '[ng-model="ctrl.realty.address.street"] span';
    public static $typeStreet = '[ng-model="ctrl.realty.address.street"] input';
    public static $chooseStreet = "//div[@id='ui-select-choices-row-5-0']/a/div";


    public static $flat_number = '#flatNumber';
    public static $house_number = '#houseNumber';
    public static $cadastr_number = '#cadastrNumber';


    public static $step1_submit = "//button[@type='submit']";

    public static $yandexMap = ".//*[@id='map-canvas']/ymaps/ymaps/ymaps[1]";

    public static $step1PopUp = 'html/body/div[5]/div/div';
    public static $step1PopUpTitle = 'Новый объект недвижимости';
//    public static $step1PopUpYes = 'html/body/div[5]/div/div/div[2]/div/button[2]';
//    public static $step1PopUpCancel = 'html/body/div[5]/div/div/div[2]/div/button[1]';

    /*step 2 ==================================================================================*/

    public static $generalArea = '#generalArea';
    public static $generalAreaUnit = '[ng-model="ctrl.realty.description.areaUnit"] span';
    public static $generalAreaUnitType = Lists::areaUnit0;

    public static $wallMaterial = '[ng-model="ctrl.realty.description.wallMaterial"] span';
    public static $typeWallMaterial = '[ng-model="ctrl.realty.description.wallMaterial"] input'; //Силикатный

//        public static $chooseWallMaterial = "//a[@class='ui-select-choices-row-inner']";


    public static $roomСount = '[ng-model="ctrl.realty.description.roomCount"] input';

    public static $livingArea = '#liveArea';
    public static $kitchenArea = '#kichenArea';

    public static $effectiveArea = '#effectiveArea';

    public static $landArea = '#landArea';
    public static $landAreaUnit = '[ng-model="ctrl.realty.description.landAreaUnit"] span';
    public static $landAreaType = House::landAreaUnit;

    public static $floors = '#storeys';
    public static $floorNumber = '#floor';
    public static $buildYear = '#buildYear';

    public static $wc = '[ng-model="ctrl.realty.description.wc"] span';
    public static $typeWC = '[ng-model="ctrl.realty.description.wc"] input';
//        public static $chooseWC = "//a[@class='ui-select-choices-row-inner']";

    public static $balcony = '[ng-model="ctrl.realty.description.balcony"] span';
    public static $typeBalcony = '[ng-model="ctrl.realty.description.balcony"] input';
//        public static $chooseBalcony = "//a[@class='ui-select-choices-row-inner']";

    public static $heating = '[ng-model="ctrl.realty.description.heating"] span';
    public static $typeHeating = '[ng-model="ctrl.realty.description.heating"] input';
//        public static $chooseHeating = "//a[@class='ui-select-choices-row-inner']";

    public static $waterHeating = '[ng-model="ctrl.realty.description.waterHeating"] span';
    public static $typeWaterHeating = '[ng-model="ctrl.realty.description.waterHeating"] input';
//        public static $chooseWaterHeating = "//a[@class='ui-select-choices-row-inner']";

    public static $communication0 = '[value="'. Lists::communication0 .'"]';
    public static $communication1 = '[value="'. Lists::communication1 .'"]';
    public static $communication2 = '[value="'. Lists::communication2 .'"]';
    public static $communication3 = '[value="'. Lists::communication3 .'"]';
    public static $communication4 = '[value="'. Lists::communication4 .'"]';
    public static $communication5 = '[value="'. Lists::communication5 .'"]';
    public static $communication6 = '[value="'. Lists::communication6 .'"]';
    public static $communication7 = '[value="'. Lists::communication7 .'"]';


    public static $nearObject0 = "//span[contains(.,'" .Lists::nearObject0 ."')]";  //[value="Остановка общественного транспорта"]
    public static $nearObject1 = "//span[contains(.,'" .Lists::nearObject1 ."')]";
    public static $nearObject2 = "//span[contains(.,'" .Lists::nearObject2 ."')]";
    public static $nearObject3 = "//span[contains(.,'" .Lists::nearObject3 ."')]";
    public static $nearObject4 = "//span[contains(.,'" .Lists::nearObject4 ."')]";
    public static $nearObject5 = "//span[contains(.,'" .Lists::nearObject5 ."')]";
    public static $nearObject6 = "//span[contains(.,'" .Lists::nearObject6 ."')]";
    public static $nearObject7 = "//span[contains(.,'" .Lists::nearObject7 ."')]";
    public static $nearObject8 = "//span[contains(.,'" .Lists::nearObject8 ."')]";
    public static $nearObject9 = "//span[contains(.,'" .Lists::nearObject9 ."')]";

    public static $step2_previous = '.red.bttnArowLeft';
    public static $step2_next = '.blue.bttnArowRight';

//    public static $communication0 = ;
//    public static $communication7 = ;



    public static $step2_2_changeAddress = 'html/body/div[1]/div[3]/div/button[1]';
    public static $step2_2_changeProperties = 'html/body/div[1]/div[3]/div/button[2]';
    public static $step2_2_createObject = '.blue.bttnArowRight';

    public static $objectTable = 'table.realty';

    /*step 3 ==================================================================================*/
    public static $operationTypeRent = '[ng-model="ctrl.advert.operation"]:first-child';
    public static $operationTypeSell = '[ng-model="ctrl.advert.operation"]:last-child';
    public static $editOperationType0 = '[ng-model="ctrl.advert.operationType"]:first-child';
    public static $editOperationType1 = '[ng-model="ctrl.advert.operationType"]:last-child';


    public static $advertDescription = '#description';
    public static $price = '#price';
    public static $currency = '[ng-model="ctrl.advert.currency"] span';
    public static $typeCurrency = '[ng-model="ctrl.advert.currency"] input';
//        public static $chooseCurrency = "//a[@class='ui-select-choices-row-inner']";
    public static $commission = '#commission';
    public static $period = '[ng-model="ctrl.advert.period"] span';
    public static $typePeriod = '[ng-model="ctrl.advert.period"] input';
    public static $auction = '[ng-model="ctrl.advert.auction"] span';
//        public static $choosePeriod = "//a[@class='ui-select-choices-row-inner']";
    public static $date = '[ng-model="date.day"]';
    public static $month = '[ng-model="date.month"] span';
    public static $typeMonth = '[ng-model="date.month"] input';
//        public static $chooseDate = "//a[@class='ui-select-choices-row-inner']";
    public static $year = '[ng-model="date.year"]';

    public static $market = '[ng-model="ctrl.advert.market"] span';
    public static $typeMarket = '[ng-model="ctrl.advert.market"] input';
    public static $editMarket = '[ng-model="ctrl.advert.marketType"] span';
    public static $editTypeMarket = '[ng-model="ctrl.advert.marketType"] input';


    public static $repair = '[ng-model="ctrl.advert.repair"] span';
    public static $typeRepair = '[ng-model="ctrl.advert.repair"] input';
    public static $bedsCount = '[ng-model="ctrl.advert.bads"] input';

    public static $furniture0 = "//span[contains(.,'" .Lists::furniture0 ."')]";
    public static $furniture1 = "//span[contains(.,'" .Lists::furniture1 ."')]";
    public static $furniture2 = "//span[contains(.,'" .Lists::furniture2 ."')]";
    public static $furniture3 = "//span[contains(.,'" .Lists::furniture3 ."')]";
    public static $furniture4 = "//span[contains(.,'" .Lists::furniture4 ."')]";
    public static $furniture5 = "//span[contains(.,'" .Lists::furniture5 ."')]";
    public static $furniture6 = "//span[contains(.,'" .Lists::furniture6 ."')]";
    public static $furniture7 = "//span[contains(.,'" .Lists::furniture7 ."')]";

    public static $appliance0 = "//span[contains(.,'" .Lists::appliance0 ."')]";
    public static $appliance1 = "//span[contains(.,'" .Lists::appliance1 ."')]";
    public static $appliance2 = "//span[contains(.,'" .Lists::appliance2 ."')]";
    public static $appliance3 = "//span[contains(.,'" .Lists::appliance3 ."')]";
    public static $appliance4 = "//span[contains(.,'" .Lists::appliance4 ."')]";
    public static $appliance5 = "//span[contains(.,'" .Lists::appliance5 ."')]";
    public static $appliance6 = "//span[contains(.,'" .Lists::appliance6 ."')]";
    public static $appliance7 = "//span[contains(.,'" .Lists::appliance7 ."')]";

    public static $additionalFlat0 = "//span[contains(.,'" .Lists::additionalFlat0 ."')]";
    public static $additionalFlat1 = "//span[contains(.,'" .Lists::additionalFlat1 ."')]";
    public static $additionalFlat2 = "//span[contains(.,'" .Lists::additionalFlat2 ."')]";
    public static $additionalFlat3 = "//span[contains(.,'" .Lists::additionalFlat3 ."')]";
    public static $additionalFlat4 = "//span[contains(.,'" .Lists::additionalFlat4 ."')]";
    public static $additionalFlat5 = "//span[contains(.,'" .Lists::additionalFlat5 ."')]";
    public static $additionalFlat6 = "//span[contains(.,'" .Lists::additionalFlat6 ."')]";
    public static $additionalFlat7 = "//span[contains(.,'" .Lists::additionalFlat7 ."')]";
    public static $additionalFlat8 = "//span[contains(.,'" .Lists::additionalFlat8 ."')]";
    public static $additionalFlat9 = "//span[contains(.,'" .Lists::additionalFlat9 ."')]";
    public static $additionalFlat10 = "//span[contains(.,'" .Lists::additionalFlat10 ."')]";
    public static $additionalFlat11 = "//span[contains(.,'" .Lists::additionalFlat11 ."')]";
    public static $additionalFlat12 = "//span[contains(.,'" .Lists::additionalFlat12 ."')]";
    public static $additionalFlat13 = "//span[contains(.,'" .Lists::additionalFlat13 ."')]";
    public static $additionalFlat14 = "//span[contains(.,'" .Lists::additionalFlat14 ."')]";
    public static $additionalFlat15 = "//span[contains(.,'" .Lists::additionalFlat15 ."')]";

    public static $additionalHouse0 = "//span[contains(.,'" .Lists::additionalHouse0 ."')]";
    public static $additionalHouse1 = "//span[contains(.,'" .Lists::additionalHouse1 ."')]";
    public static $additionalHouse2 = "//span[contains(.,'" .Lists::additionalHouse2 ."')]";
    public static $additionalHouse3 = "//span[contains(.,'" .Lists::additionalHouse3 ."')]";
    public static $additionalHouse4 = "//span[contains(.,'" .Lists::additionalHouse4 ."')]";
    public static $additionalHouse5 = "//span[contains(.,'" .Lists::additionalHouse5 ."')]";
    public static $additionalHouse6 = "//span[contains(.,'" .Lists::additionalHouse6 ."')]";
    public static $additionalHouse7 = "//span[contains(.,'" .Lists::additionalHouse7 ."')]";
    public static $additionalHouse8 = "//span[contains(.,'" .Lists::additionalHouse8 ."')]";
    public static $additionalHouse9 = "//span[contains(.,'" .Lists::additionalHouse9 ."')]";
    public static $additionalHouse10 = "//span[contains(.,'" .Lists::additionalHouse10 ."')]";
    public static $additionalHouse11 = "//span[contains(.,'" .Lists::additionalHouse11 ."')]";
    public static $additionalHouse12 = "//span[contains(.,'" .Lists::additionalHouse12 ."')]";
    public static $additionalHouse13 = "//span[contains(.,'" .Lists::additionalHouse13 ."')]";
    public static $additionalHouse14 = "//span[contains(.,'" .Lists::additionalHouse14 ."')]";
    public static $additionalHouse15 = "//span[contains(.,'" .Lists::additionalHouse15 ."')]";

    public static $additionalParcel0 = "//span[contains(.,'" .Lists::additionalParcel0 ."')]";
    public static $additionalParcel1 = "//span[contains(.,'" .Lists::additionalParcel1 ."')]";
    public static $additionalParcel2 = "//span[contains(.,'" .Lists::additionalParcel2 ."')]";
    public static $additionalParcel3 = "//span[contains(.,'" .Lists::additionalParcel3 ."')]";
    public static $additionalParcel4 = "//span[contains(.,'" .Lists::additionalParcel4 ."')]";
    public static $additionalParcel5 = "//span[contains(.,'" .Lists::additionalParcel5 ."')]";
    public static $additionalParcel6 = "//span[contains(.,'" .Lists::additionalParcel6 ."')]";
    public static $additionalParcel7 = "//span[contains(.,'" .Lists::additionalParcel7 ."')]";
    public static $additionalParcel8 = "//span[contains(.,'" .Lists::additionalParcel8 ."')]";
    public static $additionalParcel9 = "//span[contains(.,'" .Lists::additionalParcel9 ."')]";
    public static $additionalParcel10 = "//span[contains(.,'" .Lists::additionalParcel10 ."')]";
    public static $additionalParcel11 = "//span[contains(.,'" .Lists::additionalParcel11 ."')]";

    public static $additionalCommercial0 = "//span[contains(.,'" .Lists::additionalCommercial0 ."')]";
    public static $additionalCommercial1 = "//span[contains(.,'" .Lists::additionalCommercial1 ."')]";
    public static $additionalCommercial2 = "//span[contains(.,'" .Lists::additionalCommercial2 ."')]";
    public static $additionalCommercial3 = "//span[contains(.,'" .Lists::additionalCommercial3 ."')]";
    public static $additionalCommercial4 = "//span[contains(.,'" .Lists::additionalCommercial4 ."')]";
    public static $additionalCommercial5 = "//span[contains(.,'" .Lists::additionalCommercial5 ."')]";
    public static $additionalCommercial6 = "//span[contains(.,'" .Lists::additionalCommercial6 ."')]";
    public static $additionalCommercial7 = "//span[contains(.,'" .Lists::additionalCommercial7 ."')]";

    public static $ownerName = '#ownerName';
    public static $ownerContacts = '#ownerContacts';
    public static $ownerLink = "//a[@class='dottedLink']";
    public static $createAdvertButton = "//button[@type='submit']";
//    public static $step3_Good = 'html/body/div[5]/div/div/div[2]/div/button';

    public static $schemaFile = '#image';
    public static $galleryFile = '#image';



}
