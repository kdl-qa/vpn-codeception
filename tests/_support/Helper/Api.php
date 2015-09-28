<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Data\User;
use Data\Flat;
use Data\House;
use Data\Parcel;
use Data\Commercial;


class Api extends \Codeception\Module
{

    /**
     * @var \Codeception\Module\REST
     */
    protected $restModule;

    protected $adIds = [];
    protected $token;

    function _before(\Codeception\TestCase $t)
    {
        $this->restModule = $this->getModule('REST');
    }

    function _after(\Codeception\TestCase $t)
    {
        foreach ($this->adIds as $adId) {
            $this->restModule->sendDELETE('/advert', ['id' => $adId]);
        }
    }


    function createAdvert($data = [])
    {
        $this->apiLogin();
        $this->adIds[] = $this->restModule->sendGET('/get-user');

        codecept_debug('Here is response: '.$this->restModule->response);
    }

    protected function apiLogin()
    {

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login', ['email'=> User::$agencyEmail, 'password' => User::$agencyPass]);
        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $this->debugSection('New Token', $token);
        $this->restModule->haveHttpHeader('token', $token);
    }

    function apiAgencyLogin()
    {

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login', ['email'=> User::$agencyEmail, 'password' => User::$agencyPass]);
        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $this->debugSection('New Token', $token);
//        $this->restModule->haveHttpHeader('token', $token);
        $agencyToken = file_put_contents(codecept_data_dir('agency_token.json'), $token);
    }


    function apiAgencyLogout()
    {

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $agencyToken = $this->restModule->getResponseFromFile();
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->sendPOST('/logout');
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();

    }

    /*================================================ API LISTS =====================================================*/

    function getCountry()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/countries');
        $country = $this->restModule->grabResponse();
        $countryId = json_decode($country)[0]->id;
//        $countryId = $this->restModule->grabDataFromResponseByJsonPath('$.[0].id');
        $this->debugSection('Country ID', $countryId);
        $c = file_put_contents(codecept_data_dir('countries.json'), $country);
        return $countryId;


    }

    function getRegion($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/regions');
        $regions = $this->restModule->grabResponse();
        $regId = json_decode($regions)[$id]->id;
//        $regId= $this->restModule->grabDataFromResponseByJsonPath('$.[0].id');
        $this->debugSection('Reg ID', $regId);
        $file = file_put_contents(codecept_data_dir('regions.json'), $regions);
        return $regId;
    }

    function getCity($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $reg = $this->getRegion(0);
        $this->restModule->sendGET('/lists/cities/'.$reg);
        $cities = $this->restModule->grabResponse();
        $cityId = json_decode($cities)[$id]->id;
        $this->debugSection('City ID', $cityId);
        $file = file_put_contents(codecept_data_dir('cities.json'), $cities);
        return $cityId;
    }

    function getDistrict($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $city = $this->getCity(0);
        $this->restModule->sendGET('/lists/districts/'.$city);
        $districts = $this->restModule->grabResponse();
        $districtId = json_decode($districts)[$id]->id;
        $this->debugSection('District ID', $districtId);
        $file = file_put_contents(codecept_data_dir('districts.json'), $districts);
        return $districtId;
    }

    function getStreet($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $city = $this->getCity(0);
        $this->restModule->sendGET('/lists/streets/'.$city);
        $streets = $this->restModule->grabResponse();
        $streetId = json_decode($streets)[$id]->id;
        $this->debugSection('Street ID', $streetId);
        $file = file_put_contents(codecept_data_dir('streets.json'), $streets);
        return $streetId;
    }

    function getCategories($id) //0..3
    {

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/categories');
        $categories = $this->restModule->grabResponse();
        $this->debugSection('Cat ID', $categories);
        $file = file_put_contents(codecept_data_dir('categories.json'), $categories);
        $CatId = json_decode($categories)[$id]->id;
        $this->debugSection('Cat ID', $CatId);
        return $CatId;
    }

    function getFlatCategoryTypes($id) //0..1
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $flat = $this->getCategories(0);
        $this->restModule->sendGET('/lists/category-types/'.$flat);
        $cType = $this->restModule->grabResponse();
        $this->debugSection('Flat Category Types', $cType);
        $file = file_put_contents(codecept_data_dir('flat_types.json'), $cType);
        $flatCatId = json_decode($cType)[$id]->id;
        $this->debugSection('flatCatId', $flatCatId);
        return $flatCatId;
    }

    function getHouseCategoryTypes($id) //0..2
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $house = $this->getCategories(1);
        $this->restModule->sendGET('/lists/category-types/'.$house);
        $cType = $this->restModule->grabResponse();
        $this->debugSection('House Category Types', $cType);
        $file = file_put_contents(codecept_data_dir('house_types.json'), $cType);
        $houseCatId = json_decode($cType)[$id]->id;
        $this->debugSection('houseCatId', $houseCatId);
        return $houseCatId;
    }

    function getParcelCategoryTypes($id) //0..4
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $parcel = $this->getCategories(2);
        $this->restModule->sendGET('/lists/category-types/'.$parcel);
        $cType = $this->restModule->grabResponse();
        $this->debugSection('Parcel Category Types', $cType);
        $file = file_put_contents(codecept_data_dir('parcel_types.json'), $cType);
        $parcelCatId = json_decode($cType)[$id]->id;
        $this->debugSection('parcelCatId', $parcelCatId);
        return $parcelCatId;
    }

function getCommercialCategoryTypes($id) //0..10
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $commerc = $this->getCategories(3);
        $this->restModule->sendGET('/lists/category-types/'.$commerc);
        $cType = $this->restModule->grabResponse();
        $this->debugSection('Commercial Category Types', $cType);
        $file = file_put_contents(codecept_data_dir('commercial_types.json'), $cType);
        $commercCatId = json_decode($cType)[$id]->id;
        $this->debugSection('commercCatId', $commercCatId);
        return $commercCatId;
    }

    function getFlatAdditionals($id) //0..15
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $flat = $this->getCategories(0);
        $this->restModule->sendGET('/lists/additionals/'.$flat);
        $flatAdditionals = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('flat_additionals.json'), $flatAdditionals);
        $flatAdd = json_decode($flatAdditionals)[$id]->id;
        $this->debugSection('flatAdd', $flatAdd);
        return $flatAdd;
    }

    function getHouseAdditionals($id) //0..15
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $house = $this->getCategories(1);
        $this->restModule->sendGET('/lists/additionals/' . $house);
        $houseAdditionals = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('house_additionals.json'), $houseAdditionals);
        $houseAdd = json_decode($houseAdditionals)[$id]->id;
        $this->debugSection('houseAdd', $houseAdd);
        return $houseAdd;
    }

    function getParcelAdditionals($id) //0..11
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $parcel = $this->getCategories(2);
        $this->restModule->sendGET('/lists/additionals/' . $parcel);
        $parcelAdditionals = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('parcel_additionals.json'), $parcelAdditionals);
        $parcelAdd = json_decode($parcelAdditionals)[$id]->id;
        $this->debugSection('parcelAdd', $parcelAdd);
        return $parcelAdd;

    }

    function getCommercialAdditionals($id) //0..7
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $commercial = $this->getCategories(3);
        $this->restModule->sendGET('/lists/additionals/' . $commercial);
        $commercialAdditionals = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('commercial_additionals.json'), $commercialAdditionals);
        $commercialAdd = json_decode($commercialAdditionals)[$id]->id;
        $this->debugSection('commercialAdd0', $commercialAdd);
        return $commercialAdd;
    }

    function getAppliances($id) //0..7
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/appliances');
        $appliances = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('appliances.json'), $appliances);
        $appliancesId = json_decode($appliances)[$id]->id;
        $this->debugSection('appliancesId', $appliancesId);
        return $appliancesId;
    }

    function getActualCurrency()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/actual-currency');
        $actCurrency = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('actual_currency.json'), $actCurrency);

    }

    function getAreaUnits($id) //0..2
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/area-units');
        $areaUnits = $this->restModule->grabResponse('$data.');
        $file = file_put_contents(codecept_data_dir('area_units.json'), $areaUnits);
        $areaUnitId = json_decode($areaUnits)[$id]->id;
        $this->debugSection('areaUnitId', $areaUnitId);
        return $areaUnitId;
    }

    function getBalconies($id) //0..3
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/balconies');
        $balconies = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('balconies.json'), $balconies);
        $balconyId = json_decode($balconies)[$id]->id;
        $this->debugSection('balconyId0', $balconyId);
        return $balconyId;
    }

    function getCommunications($id) //0..7
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/communications');
        $communications = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('communications.json'), $communications);
        $communicatId = json_decode($communications)[$id]->id;
        $this->debugSection('communicatId', $communicatId);
        return $communicatId;
    }

    function getCurrency($id) //0..1
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/currency');
        $currency = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('currency.json'), $currency);
        $currencyId = json_decode($currency)[$id]->id;
        $this->debugSection('currencyId', $currencyId);
        return $currencyId;
    }

    function getFurnitures($id) //0..7
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/furnitures');
        $furnitures = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('furnitures.json'), $furnitures);
        $furId = json_decode($furnitures)[$id]->id;
        $this->debugSection('furId', $furId);
        return $furId;
    }

    function getHeatings($id) //0..4
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/heatings');
        $heatings = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('heatings.json'), $heatings);
        $heatId = json_decode($heatings)[$id]->id;
        $this->debugSection('heatId', $heatId);
        return $heatId;
    }

    function getMarketType($id) //0..1
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/market-types');
        $mTypes = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('market_types.json'), $mTypes);
        $mTypeId = json_decode($mTypes)[$id]->id;
        $this->debugSection('mTypeId', $mTypeId);
        return $mTypeId;
    }

    function getNearObjects($id) //0..9
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/near-objects');
        $nearObj = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('near_objects.json'), $nearObj);
        $nObjId = json_decode($nearObj)[$id]->id;
        $this->debugSection('nObjId', $nObjId);
        return $nObjId;

    }

    function getOperationType($id) //0..1
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/operation-types');
        $opTypes = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('operation_types.json'), $opTypes);
        $opTypeId = json_decode($opTypes)[$id]->id;
        $this->debugSection('opTypeId', $opTypeId);
        return $opTypeId;
    }

    function getPeriod($id) //0..1
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/period');
        $periods = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('periods.json'), $periods);
        $periodId = json_decode($periods)[$id]->id;
        $this->debugSection('periodId', $periodId);
        return $periodId;
    }

    function getStatuses($id) //0..4
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/statuses');
        $statuses = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('statuses.json'), $statuses);
        $statusId = json_decode($statuses)[$id]->id;
        $this->debugSection('statusId', $statusId);
        return $statusId;
    }

    function getRepairs($id) //0..7
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/repairs');
        $repairs = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('repairs.json'), $repairs);
        $repairId = json_decode($repairs)[$id]->id;
        $this->debugSection('repairId', $repairId);
        return $repairId;
    }

    function getUnpublishReasons($id) //0..1
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/unpublish-reasons');
        $unpubReason = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('unpublish_reasons.json'), $unpubReason);
        $unpReasonId = json_decode($unpubReason)[$id]->id;
        $this->debugSection('unpReasonId', $unpReasonId);
        return $unpReasonId;
    }

    function getWallMaterials($id) //0..11
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/wall-materials');
        $wallMaterials = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('wall_materials.json'), $wallMaterials);
        $wMaterialId = json_decode($wallMaterials)[$id]->id;
        $this->debugSection('wMaterialId', $wMaterialId);
        return $wMaterialId;
    }

    function getWaterHeatings($id) //0..4
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/water-heatings');
        $waterHeatings = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('water_heatings.json'), $waterHeatings);
        $wHeatId = json_decode($waterHeatings)[$id]->id;
        $this->debugSection('wHeatId', $wHeatId);
        return $wHeatId;
    }

    function getWC($id) //0..2
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/wc');
        $wc = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('wc.json'), $wc);
        $wcId = json_decode($wc)[$id]->id;
        $this->debugSection('wcId', $wcId);
        return $wcId;
    }

    /*===================================================== API REALTY =============================================*/

    function realtyFlatAdd()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/add', ['category' => $this->getCategories(0),
            'categoryType' => $this->getFlatCategoryTypes(0),
            'region' => $this->getRegion(0),
            'city' => $this->getCity(0),
            'district' => $this->getDistrict(23),
            'street' => $this->getStreet(32),
            'houseNumber' => Flat::houseNumber,
            'flatNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Flat::latitude,
            'longitude' => Flat::longitude,
            'roomCount' => Flat::roomCount,
            'wallMaterial' => $this->getWallMaterials(0),
            'area' => Flat::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'livingArea' => Flat::livingArea,
            'kitchenArea' => Flat::kitchenArea,
            'floor' => Flat::floors,
            'floorNumber' => Flat::floorNumber,
            'buildYear' => Flat::buildYear,
            'wc' => $this->getWC(1),
            'balcony' => $this->getBalconies(1),
            'heating' => $this->getHeatings(0),
            'waterHeating' => $this->getWaterHeatings(1),
            'nearObjects' => [$this->getNearObjects(0), $this->getNearObjects(1), $this->getNearObjects(5)]
//            'schema' =>
        ]);

        $realtyFlat = $this->restModule->grabResponse();
        $realtyFlatId = json_decode($realtyFlat)->id;
        $file = file_put_contents(codecept_data_dir('realtyFlatId.json'), $realtyFlatId);
        $this->debugSection('realtyFlatId', $realtyFlatId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }

    function realtyHouseAdd()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/add', ['category' => $this->getCategories(1),
            'categoryType' => $this->getHouseCategoryTypes(0),
            'region' => $this->getRegion(0),
            'city' => $this->getCity(0),
            'district' => $this->getDistrict(15),
            'street' => $this->getStreet(99),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::latitude,
            'longitude' => House::longitude,
            'roomCount' => House::roomCount,
            'wallMaterial' => $this->getWallMaterials(0),
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'livingArea' => House::livingArea,
            'kitchenArea' => House::kitchenArea,
            'landArea' => $this->getAreaUnits(1),
            'floorNumber' => House::floorNumber,
            'buildYear' => House::buildYear,
            'wc' => $this->getWC(0),
            'heating' => $this->getHeatings(0),
            'waterHeating' => $this->getWaterHeatings(1),
            'communication' => [$this->getCommunications(0), $this->getCommunications(3), $this->getCommunications(5)],
            'nearObjects' => [$this->getNearObjects(0), $this->getNearObjects(1), $this->getNearObjects(5)]
//           'schema' =>
        ]);

        $realtyHouse = $this->restModule->grabResponse();
        $realtyHouseId = json_decode($realtyHouse)->id;
        $file = file_put_contents(codecept_data_dir('realtyHouseId.json'), $realtyHouseId);
        $this->debugSection('realtyHouseId', $realtyHouseId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }

    function realtyParcelAdd()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/add', ['category' => $this->getCategories(2),
            'categoryType' => $this->getParcelCategoryTypes(0),
            'region' => $this->getRegion(0),
            'city' => $this->getCity(0),
            'district' => $this->getDistrict(7),
            'street' => $this->getStreet(66),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::latitude,
            'longitude' => Parcel::longitude,
            'area' => Parcel::area,
            'areaUnit' => $this->getAreaUnits(0),
            'communication' => [$this->getCommunications(0), $this->getCommunications(6)],
            'nearObjects' => [$this->getNearObjects(0), $this->getNearObjects(3)]
//           'schema' =>
        ]);

        $realtyParcel = $this->restModule->grabResponse();
        $realtyParcelId = json_decode($realtyParcel)->id;
        $file = file_put_contents(codecept_data_dir('realtyParcelId.json'), $realtyParcelId);
        $this->debugSection('realtyParcelId', $realtyParcelId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }

    function realtyCommercialAdd()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//           'schema' =>
        $this->restModule->sendPOST('/realties/commercials/add', ['category' => $this->getCategories(3),
            'categoryType' => $this->getCommercialCategoryTypes(0),
            'region' => $this->getRegion(0),
            'city' => $this->getCity(0),
            'district' => $this->getDistrict(22),
            'street' => $this->getStreet(33),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::latitude,
            'longitude' => Commercial::longitude,
            'area' => Commercial::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'effectiveArea' => Commercial::effectiveArea,
            'wallMaterial' => $this->getWallMaterials(0),
            'roomCount' => Commercial::roomCount,
            'floor' => Commercial::floor,
            'floorNumber' => Commercial::floorNumber,
            'buildYear' => Commercial::buildYear,
            'wc' => $this->getWC(0),
            'heating' => $this->getHeatings(0),
            'waterHeating' => $this->getWaterHeatings(1),
            'communication' => [$this->getCommunications(0), $this->getCommunications(2), $this->getCommunications(4)],
        ]);

        $realtyCommercial = $this->restModule->grabResponse();
        $realtyCommercialId = json_decode($realtyCommercial)->id;
        $file = file_put_contents(codecept_data_dir('realtyCommercialId.json'), $realtyCommercialId);
        $this->debugSection('realtyCommercialId', $realtyCommercialId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }


}
