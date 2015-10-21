<?php
namespace Page;

class AdmRealtyObject
{

    public static $objListPageURL = '/admin/realty';

    public static $yandexMap = '#map-canvas';

    public static $statusField = '[ng-model="ctrl.realty.statusSelected"] span';
    public static $objStatus0 = '.cc-object-status0';
    public static $objStatus1 = '.cc-object-status1';

    public static $regionField = '[ng-model="ctrl.realty.address.region"] span';
    public static $region0 = '.cc-region-name0';

    public static $cityField = '[ng-model="ctrl.realty.address.city"] span';
    public static $city4 = '.cc-city-name4';

    public static $districtField = '[ng-model="ctrl.realty.address.district"] span';
    public static $district24 = '.cc-district-name24';
    public static $district3 = '.cc-district-name3';
    public static $district7 = '.cc-district-name7';

    public static $street = '[ng-model="ctrl.realty.address.street"] span';
    public static $typeStreet = '[ng-model="ctrl.realty.address.street"] input';
    public static $chooseStreet = '.cc-street-name';

    public static $flat_number = '#flatNumber';
    public static $house_number = '#houseNumber';
    public static $cadastrNumber = '#cadastrNumber';

    public static $generalArea = '#generalArea';
    public static $areaUnitField = '[ng-model="ctrl.realty.areaUnit"] span';
    public static $areaUnit0 = '.cc-area-size0';
    public static $areaUnit1 = '.cc-area-size1';
    public static $areaUnit2 = '.cc-area-size2';

    public static $wallMaterialField = '[ng-model="ctrl.realty.wallMaterial"] span';
    public static $wallMaterial0 = '.cc-wall-material0';
    public static $wallMaterial1 = '.cc-wall-material1';
    public static $wallMaterial2 = '.cc-wall-material2';
    public static $wallMaterial3 = '.cc-wall-material3';
    public static $wallMaterial4 = '.cc-wall-material4';
    public static $wallMaterial5 = '.cc-wall-material5';
    public static $wallMaterial6 = '.cc-wall-material6';
    public static $wallMaterial7 = '.cc-wall-material7';
    public static $wallMaterial8 = '.cc-wall-material8';
    public static $wallMaterial9 = '.cc-wall-material9';
    public static $wallMaterial10 = '.cc-wall-material10';

    public static $roomСount = '[ng-model="ctrl.realty.roomCount"] input';

    public static $livingArea = '#liveArea';
    public static $kitchenArea = '#kichenArea';

    public static $effectiveArea = '#effectiveArea';

    public static $landArea = '#landArea';
    public static $landAreaUnit = '[ng-model="ctrl.realty.landAreaUnit"] span';

    public static $floors = '#storeys';
    public static $floorNumber = '#floor';
    public static $buildYear = '#buildYear';

    public static $wcField = '[ng-model="ctrl.realty.wc"] span';
    public static $wc0 = '.cc-wc-type0';
    public static $wc1 = '.cc-wc-type1';
    public static $wc2 = '.cc-wc-type2';

    public static $balconyField = '[ng-model="ctrl.realty.balcony"] span';
    public static $balcony0 = '.cc-balcony-type0';
    public static $balcony1 = '.cc-balcony-type1';
    public static $balcony2 = '.cc-balcony-type2';
    public static $balcony3 = '.cc-balcony-type3';

    public static $heatingField = '[ng-model="ctrl.realty.heating"] span';
    public static $heating0 = '.cc-heating-type0';
    public static $heating1 = '.cc-heating-type1';
    public static $heating2 = '.cc-heating-type2';
    public static $heating3 = '.cc-heating-type3';
    public static $heating4 = '.cc-heating-type4';

    public static $waterHeatingField = '[ng-model="ctrl.realty.waterHeating"] span';
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

    public static $editCommunication0 = '[checked="checked"].cc-realty-communications0';
    public static $editCommunication1 = '[checked="checked"].cc-realty-communications1';
    public static $editCommunication2 = '[checked="checked"].cc-realty-communications2';
    public static $editCommunication3 = '[checked="checked"].cc-realty-communications3';
    public static $editCommunication4 = '[checked="checked"].cc-realty-communications4';
    public static $editCommunication5 = '[checked="checked"].cc-realty-communications5';
    public static $editCommunication6 = '[checked="checked"].cc-realty-communications6';
    public static $editCommunication7 = '[checked="checked"].cc-realty-communications7';

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
//    public static $nearObject10 = '.cc-realty-near-objects10';
//    public static $nearObject11 = '.cc-realty-near-objects11';
//    public static $nearObject12 = '.cc-realty-near-objects12';
//    public static $nearObject13 = '.cc-realty-near-objects13';
//    public static $nearObject14 = '.cc-realty-near-objects14';
//    public static $nearObject15 = '.cc-realty-near-objects15';

    public static $checkedNearObject0 = '[checked="checked"].cc-realty-near-objects0';
    public static $checkedNearObject1 = '[checked="checked"].cc-realty-near-objects1';
    public static $checkedNearObject2 = '[checked="checked"].cc-realty-near-objects2';
    public static $checkedNearObject3 = '[checked="checked"].cc-realty-near-objects3';
    public static $checkedNearObject4 = '[checked="checked"].cc-realty-near-objects4';
    public static $checkedNearObject5 = '[checked="checked"].cc-realty-near-objects5';
    public static $checkedNearObject6 = '[checked="checked"].cc-realty-near-objects6';
    public static $checkedNearObject7 = '[checked="checked"].cc-realty-near-objects7';
    public static $checkedNearObject8 = '[checked="checked"].cc-realty-near-objects8';
    public static $checkedNearObject9 = '[checked="checked"].cc-realty-near-objects9';
//    public static $checkedNearObject10 = '[checked="checked"].cc-realty-near-objects10';
//    public static $checkedNearObject11 = '[checked="checked"].cc-realty-near-objects11';
//    public static $checkedNearObject12 = '[checked="checked"].cc-realty-near-objects12';
//    public static $checkedNearObject13 = '[checked="checked"].cc-realty-near-objects13';
//    public static $checkedNearObject14 = '[checked="checked"].cc-realty-near-objects14';
//    public static $checkedNearObject15 = '[checked="checked"].cc-realty-near-objects15';

    public static $schema = '#image';
    public static $removeSchema = '.remove';

    public static $submitBtn = "//button[@type='submit']";




//    public static function route($param)
//    {
//        return static::$URL.$param;
//    }

}
