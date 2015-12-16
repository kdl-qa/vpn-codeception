<?php
namespace Page;
use Data\Flat;
use Data\House;
use Data\Lists;
use Data\Parcel;


class AddAdvert
{
//    public static $chooseFirstRow = "//a[@class='ui-select-choices-row-inner']";

    public static $category ='[ng-model="ctrl.realty.category"] span';
    public static $flatCategory = '.cc-real-estate-category0';
    public static $houseCategory = '.cc-real-estate-category1';
    public static $parcelCategory = '.cc-real-estate-category2';
    public static $commercialCategory = '.cc-real-estate-category3';

    public static $category_type = '[ng-model="ctrl.realty.categoryType"] span';
    public static $flatCatType0 = '.cc-real-estate-type0';
    public static $flatCatType1 = '.cc-real-estate-type1';

    public static $houseCatType0 = '.cc-real-estate-type0';
    public static $houseCatType1 = '.cc-real-estate-type1';
    public static $houseCatType2 = '.cc-real-estate-type2';

    public static $parcelCatType0 = '.cc-real-estate-type0';
    public static $parcelCatType1 = '.cc-real-estate-type1';
    public static $parcelCatType2 = '.cc-real-estate-type2';
    public static $parcelCatType3 = '.cc-real-estate-type3';
    public static $parcelCatType4 = '.cc-real-estate-type4';

    public static $commercialCatType0 = '.cc-real-estate-type0';
    public static $commercialCatType1 = '.cc-real-estate-type1';
    public static $commercialCatType2 = '.cc-real-estate-type2';
    public static $commercialCatType3 = '.cc-real-estate-type3';
    public static $commercialCatType4 = '.cc-real-estate-type4';
    public static $commercialCatType5 = '.cc-real-estate-type5';
    public static $commercialCatType6 = '.cc-real-estate-type6';
    public static $commercialCatType7 = '.cc-real-estate-type7';
    public static $commercialCatType8 = '.cc-real-estate-type8';
    public static $commercialCatType9 = '.cc-real-estate-type9';
    public static $commercialCatType10 = '.cc-real-estate-type10';



    public static $regionField = '[ng-model="ctrl.realty.address.region"] span';
    public static $typeRegion = '[ng-model="ctrl.realty.address.region"] input';
    public static $region0 = '.cc-region-name0';

    public static $cityField = '[ng-model="ctrl.realty.address.city"] span';
    public static $typeCity = '[ng-model="ctrl.realty.address.city"] input';
    public static $chooseCity = '.cc-city-name0'; //cherkassy (dynamic vocabulary);

    public static $district = '[ng-model="ctrl.realty.address.district"] span';
    public static $typeDistrict = '[ng-model="ctrl.realty.address.district"] input';
    public static $chooseDistrict = ".cc-district-name0"; //first district select

    public static $street = '[ng-model="ctrl.realty.address.street"] span';
    public static $typeStreet = '[ng-model="ctrl.realty.address.street"] input';
    public static $chooseStreet = '.cc-street-name0'; //first street select


    public static $flat_number = '#flatNumber';
    public static $house_number = '#houseNumber';
    public static $cadastr_number = '#cadastrNumber';


    public static $buttonSubmit = "button.blue";

    public static $yandexMap = ".//*[@id='map-canvas']/ymaps/ymaps/ymaps[1]";

//    public static $step1PopUp = 'html/body/div[5]/div/div';
//    public static $step1PopUpTitle = 'Новый объект недвижимости';

    /*step 2 ==================================================================================*/

    public static $generalArea = '#generalArea';
    public static $areaUnitField = '[ng-model="ctrl.realty.description.areaUnit"] span';
    public static $areaUnit0 = '.cc-area-size0'; // Кв. метры
    public static $areaUnit1 = '.cc-area-size1'; // Сотки
    public static $areaUnit2 = '.cc-area-size2'; // Гектары


    public static $wallMaterialField = '[ng-model="ctrl.realty.description.wallMaterial"] span';
//    public static $typeWallMaterial = '[ng-model="ctrl.realty.description.wallMaterial"] input';
    public static $wallMaterial0 = '.cc-wall-material-type0';
    public static $wallMaterial1 = '.cc-wall-material-type1';
    public static $wallMaterial2 = '.cc-wall-material-type2';
    public static $wallMaterial3 = '.cc-wall-material-type3';
    public static $wallMaterial4 = '.cc-wall-material-type4';
    public static $wallMaterial5 = '.cc-wall-material-type5';
    public static $wallMaterial6 = '.cc-wall-material-type6';
    public static $wallMaterial7 = '.cc-wall-material-type7';
    public static $wallMaterial8 = '.cc-wall-material-type8';
    public static $wallMaterial9 = '.cc-wall-material-type9';
    public static $wallMaterial10 = '.cc-wall-material-type10';


    public static $roomСount = '[ng-model="ctrl.realty.description.roomCount"] input';

    public static $livingArea = '#liveArea';
    public static $kitchenArea = '#kichenArea';

    public static $effectiveArea = '#effectiveArea';

    public static $landArea = '#landArea';
    public static $landAreaUnit = '[ng-model="ctrl.realty.description.landAreaUnit"] span';

    public static $floors = '#storeys';
    public static $floorNumber = '#floor';
    public static $buildYear = '#buildYear';

    public static $wcField = '[ng-model="ctrl.realty.description.wc"] span';
    public static $wc0 = '.cc-wc-type0';
    public static $wc1 = '.cc-wc-type1';
    public static $wc2 = '.cc-wc-type2';

    public static $balconyField = '[ng-model="ctrl.realty.description.balcony"] span';
    public static $balcony0 = '.cc-balcony-type0';
    public static $balcony1 = '.cc-balcony-type1';
    public static $balcony2 = '.cc-balcony-type2';
    public static $balcony3 = '.cc-balcony-type3';

    public static $heatingField = '[ng-model="ctrl.realty.description.heating"] span';
    public static $heating0 = '.cc-heating-type0';
    public static $heating1 = '.cc-heating-type1';
    public static $heating2 = '.cc-heating-type2';
    public static $heating3 = '.cc-heating-type3';
    public static $heating4 = '.cc-heating-type4';

    public static $waterHeatingField = '[ng-model="ctrl.realty.description.waterHeating"] span';
    public static $waterHeat0 = '.cc-water-heating-type0';
    public static $waterHeat1 = '.cc-water-heating-type1';
    public static $waterHeat2 = '.cc-water-heating-type2';
    public static $waterHeat3 = '.cc-water-heating-type3';
    public static $waterHeat4 = '.cc-water-heating-type4';

    public static $communication0 = '.cc-realty-communications0';
    public static $communication1 = '.cc-realty-communications1';
    public static $communication2 = '.cc-realty-communications2';
    public static $communication3 = '.cc-realty-communications3';
    public static $communication4 = '.cc-realty-communications4';
    public static $communication5 = '.cc-realty-communications5';
    public static $communication6 = '.cc-realty-communications6';
    public static $communication7 = '.cc-realty-communications7';

    public static $nearObject0 = '.cc-realty-near-objects0';
    public static $nearObject1 = '.cc-realty-near-objects1';
    public static $nearObject2 = '.cc-realty-near-objects2';
    public static $nearObject3 = '.cc-realty-near-objects3';
    public static $nearObject4 = '.cc-realty-near-objects4';
    public static $nearObject5 = '.cc-realty-near-objects5';
    public static $nearObject6 = '.cc-realty-near-objects6';
    public static $nearObject7 = '.cc-realty-near-objects7';
    public static $nearObject8 = '.cc-realty-near-objects8';
    public static $nearObject9 = '.cc-realty-near-objects9';

    public static $step2_changeAddress = '.red.bttnArowLeft:nth-child(1)';
    public static $step2_changeObjProps = '.red.bttnArowLeft:nth-child(2)';

    public static $step2_submit = '.blue.bttnArowRight';

//    public static $step2_2_changeAddress = 'html/body/div[1]/div[3]/div/button[1]';
//    public static $step2_2_changeProperties = 'html/body/div[1]/div[3]/div/button[2]';
//    public static $step2_2_createObject = '.blue.bttnArowRight';

    public static $objectPropsTable = 'table.realty';

    /*step 3 ==================================================================================*/
    public static $OTSell = '[ng-model="ctrl.advert.operation"]:first-child';
    public static $OTRent = '[ng-model="ctrl.advert.operation"]:last-child';

    public static $editOTSell = '[ng-model="ctrl.advert.operationType"]:first-child';
    public static $editOTRent = '[ng-model="ctrl.advert.operationType"]:last-child';


    public static $advDescription = '#description';
    public static $price = '#price';
    public static $currencyField = '[ng-model="ctrl.advert.currency"] span';
    public static $currencyUS = '.cc-currency-type0';
    public static $currencyUA = '.cc-currency-type1';

    public static $commission = '#commission';
    public static $periodField = '[ng-model="ctrl.advert.period"] span';
    public static $periodDay = '.cc-advert-period0';
    public static $periodMonth = '.cc-advert-period1';
    public static $editPeriodDay = '.cc-period0';
    public static $editPeriodMonth = '.cc-period1';


    public static $auction = '[ng-model="ctrl.advert.auction"] span';

    public static $date = '[ng-model="date.day"]';
    public static $monthField = '[ng-model="date.month"] span';
    public static $month0 = '.cc-month0';
    public static $month1 = '.cc-month1';
    public static $month2 = '.cc-month2';
    public static $month3 = '.cc-month3';
    public static $month4 = '.cc-month4';
    public static $month5 = '.cc-month5';
    public static $month6 = '.cc-month6';
    public static $month7 = '.cc-month7';
    public static $month8 = '.cc-month8';
    public static $month9 = '.cc-month9';
    public static $month10 = '.cc-month10';
    public static $month11 = '.cc-month11';
    public static $year = '[ng-model="date.year"]';

    public static $marketField = '[ng-model="ctrl.advert.market"] span';
    public static $market0 = '.cc-market-type0';
    public static $market1 = '.cc-market-type1';

    public static $editMarket = '[ng-model="ctrl.advert.marketType"] span';

    public static $repairField = '[ng-model="ctrl.advert.repair"] span';
    public static $repair0 = '.cc-repair-type0';
    public static $repair1 = '.cc-repair-type1';
    public static $repair2 = '.cc-repair-type2';
    public static $repair3 = '.cc-repair-type3';
    public static $repair4 = '.cc-repair-type4';
    public static $repair5 = '.cc-repair-type5';
    public static $repair6 = '.cc-repair-type6';
    public static $repair7 = '.cc-repair-type7';

    public static $bedsCount = '[ng-model="ctrl.advert.beds"] input';

    public static $furniture0 = '.cc-advert-furnitures0';
    public static $furniture1 = '.cc-advert-furnitures1';
    public static $furniture2 = '.cc-advert-furnitures2';
    public static $furniture3 = '.cc-advert-furnitures3';
    public static $furniture4 = '.cc-advert-furnitures4';
    public static $furniture5 = '.cc-advert-furnitures5';
    public static $furniture6 = '.cc-advert-furnitures6';
    public static $furniture7 = '.cc-advert-furnitures7';

    public static $appliance0 = '.cc-advert-appliances0';
    public static $appliance1 = '.cc-advert-appliances1';
    public static $appliance2 = '.cc-advert-appliances2';
    public static $appliance3 = '.cc-advert-appliances3';
    public static $appliance4 = '.cc-advert-appliances4';
    public static $appliance5 = '.cc-advert-appliances5';
    public static $appliance6 = '.cc-advert-appliances6';
    public static $appliance7 = '.cc-advert-appliances7';

    public static $additional0 = '.cc-advert-additional0';
    public static $additional1 = '.cc-advert-additional1';
    public static $additional2 = '.cc-advert-additional2';
    public static $additional3 = '.cc-advert-additional3';
    public static $additional4 = '.cc-advert-additional4';
    public static $additional5 = '.cc-advert-additional5';
    public static $additional6 = '.cc-advert-additional6';
    public static $additional7 = '.cc-advert-additional7';
    public static $additional8 = '.cc-advert-additional8';
    public static $additional9 = '.cc-advert-additional9';
    public static $additional10 = '.cc-advert-additional10';
    public static $additional11 = '.cc-advert-additional11';
    public static $additional12 = '.cc-advert-additional12';
    public static $additional13 = '.cc-advert-additional13';
    public static $additional14 = '.cc-advert-additional14';
    public static $additional15 = '.cc-advert-additional15';

    public static $ownerName = '#ownerName';
    public static $ownerContacts = '#ownerContacts';
    public static $ownerLink = 'a.dottedLink';
//    public static $createAdvertButton = "//button[@type='submit']";
//    public static $step3_Good = 'html/body/div[5]/div/div/div[2]/div/button';

    public static $schemaFile = '#image';
    public static $galleryFile = '#image';



}
