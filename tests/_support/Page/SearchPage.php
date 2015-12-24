<?php
namespace Page;

class SearchPage
{

    public static $search_url = 'http://uhome.co/search';

    public static $operationType1 = 'label:nth-child(1)';
    public static $operationType2 = 'label:nth-child(2)';

    public static $regionField = '[ng-model="ctrl.filters.region"] span';
    public static $regionType = '[ng-model="ctrl.filters.region"] input';
    public static $region0 = '.cc-region-name0';

    public static $cityField ='[ng-model="ctrl.filters.city"] span';
    public static $cityType ='[ng-model="ctrl.filters.city"] input';
    public static $city0 = '.cc-city-name0';

    public static $districtField = '[ng-model="ctrl.filters.district"] span';
    public static $districtType = '[ng-model="ctrl.filters.district"] input';
    public static $district0 = '.cc-district-name0';

    public static $streetField = '[ng-model="ctrl.filters.street"] span';
    public static $streetType = '[ng-model="ctrl.filters.street"] input';
    public static $street0 = '.cc-street-name0';

    public static $categoryField = '[ng-model="ctrl.filters.category"] span';
    public static $flatCategory = '.cc-category-name0';
    public static $houseCategory = '.cc-category-name1';
    public static $parcelCategory = '.cc-category-name2';
    public static $commercialCategory = '.cc-category-name3';

    public static $categoryType = '[ng-model="ctrl.filters.categoryType"] span';
    public static $flatCatType0 = '.cc-category-type0';
    public static $flatCatType1 = '.cc-category-type1';

    public static $houseCatType0 = '.cc-category-type0';
    public static $houseCatType1 = '.cc-category-type1';
    public static $houseCatType2 = '.cc-category-type2';

    public static $parcelCatType0 = '.cc-category-type0';
    public static $parcelCatType1 = '.cc-category-type1';
    public static $parcelCatType2 = '.cc-category-type2';
    public static $parcelCatType3 = '.cc-category-type3';
    public static $parcelCatType4 = '.cc-category-type4';

    public static $commercialCatType0 = '.cc-category-type0';
    public static $commercialCatType1 = '.cc-category-type1';
    public static $commercialCatType2 = '.cc-category-type2';
    public static $commercialCatType3 = '.cc-category-type3';
    public static $commercialCatType4 = '.cc-category-type4';
    public static $commercialCatType5 = '.cc-category-type5';
    public static $commercialCatType6 = '.cc-category-type6';
    public static $commercialCatType7 = '.cc-category-type7';
    public static $commercialCatType8 = '.cc-category-type8';
    public static $commercialCatType9 = '.cc-category-type9';
    public static $commercialCatType10 = '.cc-category-type10';

    public static $priseFrom = '[ng-model="ctrl.filters.minPrice"]';
    public static $priseTo = '[ng-model="ctrl.filters.maxPrice"]';
    public static $currencyField = '[ng-model="ctrl.filters.currency"] span';
    public static $currencyUS = '.cc-currency-type0';
    public static $currencyUA = '.cc-currency-type1';
    public static $auction = '.cc-filters-auction';

    public static $periodField ='[ng-model="ctrl.filters.period"]';
    public static $period0 = '.cc-period0';
    public static $period1 ='.cc-period1';

    public static $agencyField = '[ng-model="ctrl.filters.selectedAgencies"] span';
    public static $agencyType = '[ng-model="ctrl.filters.selectedAgencies"] input';
    public static $agency0 = '.agency0';

    //----------------------------------------Характеристики объекта недвижимости-----------------//

    public static $characteristicsTab = '.cc-sidebar-characteristic-of-object';
    public static $characteristicsMapTab = '.cc-sidebar-characteristic-of-object';

    public static $marketTypeField = '[ng-model="ctrl.filters.market"] span';
    public static $marketType0 = '.cc-market-type0';
    public static $marketType1 = '.cc-market-type1';
    public static $marketType2 = '.cc-market-type2';

    public static $buildYearFrom = '[ng-model="ctrl.filters.minBuildYear"]';
    public static $buildYearTo = '[ng-model="ctrl.filters.maxBuildYear"]';

    public static $bedCountFrom ='[ng-model="ctrl.filters.minBedCount"]';
    public static $bedCountTo = '[ng-model="ctrl.filters.maxBedCount"]';

    public static $wallMaterialField = '[ng-model="ctrl.filters.wallMaterial"] span';
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
    public static $wallMaterial11 = '.cc-wall-material-type11';

    public static $repairField ='[ng-model="ctrl.filters.repair"] span';
    public static $repair0 = '.cc-repair-type0';  //Любое
    public static $repair1 = '.cc-repair-type1';
    public static $repair2 = '.cc-repair-type2';
    public static $repair3 = '.cc-repair-type3';
    public static $repair4 = '.cc-repair-type4';
    public static $repair5 = '.cc-repair-type5';
    public static $repair6 = '.cc-repair-type6';
    public static $repair7 = '.cc-repair-type7';
    public static $repair8 = '.cc-repair-type8';

    public static $wcField = '[ng-model="ctrl.filters.wc"] span';
    public static $wc0 = '.cc-wc-type0';
    public static $wc1 = '.cc-wc-type1';
    public static $wc2 = '.cc-wc-type2';
    public static $wc3 = '.cc-wc-type3';

    public static $balconyField = '[ng-model="ctrl.filters.balcony"] span';
    public static $balcony0 = '.cc-balcony-type0';
    public static $balcony1 = '.cc-balcony-type1';
    public static $balcony2 = '.cc-balcony-type2';
    public static $balcony3 = '.cc-balcony-type3';
    public static $balcony4 = '.cc-balcony-type4';

    public static $heatingField = '[ng-model="ctrl.filters.heating"] span';
    public static $heating0 = '.cc-heating-type0';
    public static $heating1 = '.cc-heating-type1';
    public static $heating2 = '.cc-heating-type2';
    public static $heating3 = '.cc-heating-type3';
    public static $heating4 = '.cc-heating-type4';
    public static $heating5 = '.cc-heating-type5';

    public static $waterHeatingField = '[ng-model="ctrl.filters.waterHeating"] span';
    public static $waterHeating0 = '.cc-water-heating-type0';
    public static $waterHeating1 = '.cc-water-heating-type1';
    public static $waterHeating2 = '.cc-water-heating-type2';
    public static $waterHeating3 = '.cc-water-heating-type3';
    public static $waterHeating4 = '.cc-water-heating-type4';
    public static $waterHeating5 = '.cc-water-heating-type5';

    public static $areaTab = '.cc-sidebar-area-size';
    public static $areaParcelTab = '.cc-sidebar-area-size';
    public static $areaParcelMapTab = '.cc-sidebar-area-size';
    public static $areaMapTab ='.cc-sidebar-area-size';



    public static $generalAreaFrom = '[ng-model="ctrl.filters.minGeneralArea"]';
    public static $generalAreaTo = '[ng-model="ctrl.filters.maxGeneralArea"]';
    public static $areaUnitField = '[ng-model="ctrl.filters.areaUnit"] span';
    public static $areaUnit0 = '.cc-area-size0';
    public static $areaUnit1 = '.cc-area-size1';
    public static $areaUnit2 = '.cc-area-size2';
    public static $areaLandFrom = '[ng-model="ctrl.filters.minLandArea"]';
    public static $areaLandTo = '[ng-model="ctrl.filters.maxLandArea"]';
    public static $areaLandUnit = '[ng-model="ctrl.filters.landAreaUnit"] span';
    public static $areaLand0 ='.cc-land-area-size0';
    public static $areaLand1 ='.cc-land-area-size1';
    public static $areaLand2 ='.cc-land-area-size2';
    public static $effectiveAreaFrom = '[ng-model="ctrl.filters.minEffectiveArea"]';
    public static $effectiveAreaTo = '[ng-model="ctrl.filters.maxEffectiveArea"]';

    public static $livingAreaFrom = '[ng-model="ctrl.filters.minLiveArea"]';
    public static $livingAreaTo = '[ng-model="ctrl.filters.maxLiveArea"]';
    public static $kitchenAreaFrom = '[ng-model="ctrl.filters.minKichenArea"]';
    public static $kitchenAreaTo = '[ng-model="ctrl.filters.maxKichenArea"]';

    public static $floorsAndRoomsTab = '.cc-sidebar-floor';
    public static $floorsAndRoomsMapTab = '.cc-sidebar-floor';
    public static $roomsCountFrom = '[ng-model="ctrl.filters.minRoomCount"]';
    public static $roomsCountTo = '[ng-model="ctrl.filters.maxRoomCount"]';
    public static $floorFrom = '[ng-model="ctrl.filters.minFloor"]';
    public static $floorTo = '[ng-model="ctrl.filters.maxFloor"]';
    public static $floorNumberFrom = '[ng-model="ctrl.filters.minFloorCount"]';
    public static $floorNumberTo = '[ng-model="ctrl.filters.maxFloorCount"]';

    //-------------------------Furniture-----------------------------------//
    public static $furnitureTab = '.cc-sidebar-furniture >div';
    public static $furniture0 ='.cc-furnitures0';
    public static $furniture1 ='.cc-furnitures1';
    public static $furniture2 ='.cc-furnitures2';
    public static $furniture3 ='.cc-furnitures3';
    public static $furniture4 ='.cc-furnitures4';
    public static $furniture5 ='.cc-furnitures5';
    public static $furniture6 ='.cc-furnitures6';
    public static $furniture7 ='.cc-furnitures7';

    //-------------------------Appliances-----------------------------------//
    public static $applianceTab = '.cc-sidebar-electrical >div';
    public static $appliance0 ='.cc-appliances0';
    public static $appliance1 ='.cc-appliances1';
    public static $appliance2 ='.cc-appliances2';
    public static $appliance3 ='.cc-appliances3';
    public static $appliance4 ='.cc-appliances4';
    public static $appliance5 ='.cc-appliances5';
    public static $appliance6 ='.cc-appliances6';

    //----------------------Communications---------------------------------//
    public static $communicationTab ='.cc-sidebar-communications >div';
    public static $communication0 ='.cc-communications0';
    public static $communication1 ='.cc-communications1';
    public static $communication2 ='.cc-communications2';
    public static $communication3 ='.cc-communications3';
    public static $communication4 ='.cc-communications4';
    public static $communication5 ='.cc-communications5';
    public static $communication6 ='.cc-communications6';
    public static $communication7 ='.cc-communications7';

    //-----------------------Additionals-------------------------------------//
    public static $additionalTab ='.cc-sidebar-additionally >div';
    public static $additional0 ='.cc-additional0';
    public static $additional1 ='.cc-additional1';
    public static $additional2 ='.cc-additional2';
    public static $additional3 ='.cc-additional3';
    public static $additional4 ='.cc-additional4';
    public static $additional5 ='.cc-additional5';
    public static $additional6 ='.cc-additional6';
    public static $additional7 ='.cc-additional7';
    public static $additional8 ='.cc-additional8';
    public static $additional9 ='.cc-additional9';
    public static $additional10 ='.cc-additional10';
    public static $additional11 ='.cc-additional11';
    public static $additional12 ='.cc-additional12';
    public static $additional13 ='.cc-additional13';
    public static $additional14 ='.cc-additional14';
    public static $additional15 ='.cc-additional15';

    //-----------------------Near objects-------------------------------------//
    public static $nearObjectsTab ='.cc-sidebar-near-objects >div';
    public static $nearObject0 = '.cc-nearObject0';
    public static $nearObject1 = '.cc-nearObject1';
    public static $nearObject2 = '.cc-nearObject2';
    public static $nearObject3 = '.cc-nearObject3';
    public static $nearObject4 = '.cc-nearObject4';
    public static $nearObject5 = '.cc-nearObject5';
    public static $nearObject6 = '.cc-nearObject6';
    public static $nearObject7 = '.cc-nearObject7';
    public static $nearObject8 = '.cc-nearObject8';
    public static $nearObject9 = '.cc-nearObject9';

    public static $listAdvertButton = '.listWhite';

    public static $mapAdvertButton = '.mapDark';
    public static $backupFilterLink = '[ng-click="ctrl.reset()"]';
    public static $cancelBackupFilterLink = '[ng-click="ctrl.reset(true)"]';

    //------------------------Sort filter------------------------------//
    public static $sortField = '[ng-model="ctrl.filters.sort"] span';
    public static $sort0 = '.cc-sort-type0';
    public static $sort1 = '.cc-sort-type1';
    public static $sort2 = '.cc-sort-type2';
    public static $sort3 = '.cc-sort-type3';
    public static $sort4 = '.cc-sort-type4';
    public static $addToGroup = '[ng-click="ctrl.addToGroup()"]';
    public static $searchButton = '[ng-show="!ctrl.isSearching"]';
    public static $checked ='[checked="checked"]';


    //------------------------------Search by map-------------------------------------//
    public static $yandexMap = '.search-map';
    public static $advertsCount = '[ng-show="ctrl.isResultVisible"]';
    public static $markerTitle = '.yMarkerTitle';
    public static $mark = '.ymaps-2-1-34-places-pane';
    public static $cluster = 'ymaps.ymaps-2-1-34-events-pane.ymaps-2-1-34-user-selection-none';

    public static $listAdvertButton1 = '.listDark';
    public static $mapAdvertButton1 = '.mapWhite';


    //-------------------------------------------Search by Agency--------------------------------------//

    public static $agencyNameField = '[ng-model="ctrl.filters.name"]';
    public static $agencyRegionField = '[ng-model="ctrl.filters.region"] span';
    public static $agencyRegionType = '[ng-model="ctrl.filters.region"] input';
    public static $agencyRegion0 = '.cc-region-name0';
    public static $agencyCityField = '[ng-model="ctrl.filters.city"] span';
    public static $agencyCityType = '[ng-model="ctrl.filters.city"] input';
    public static $agencyCity0 = '.cc-city-name0';

    //-------------------------------Search list result-------------------------//
    public static $resultPrice = '.price';
    public static $resultCategory = '.categoryType';
    public static $resultRoomCount = '[ng-if="item.realty.category.type != ctrl.const.realtyTypes.parcel"]';
    public static $resultAdvert = '.advertPreview';
    public static $countSearchResult = '.cc-advertisements-count';





}
