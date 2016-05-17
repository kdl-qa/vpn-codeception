<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Data\Garage;
use Data\Lists;
use Data\User;
use Data\Flat;
use Data\House;
use Data\Parcel;
use Data\Commercial;
use Data\Info;


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

        codecept_debug('Here is response: ' . $this->restModule->response);
    }

    protected function apiLogin()
    {

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login', ['email' => User::$agencyEmail, 'password' => User::$agencyPass]);
        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $this->debugSection('New Token', $token);
        $this->restModule->haveHttpHeader('token', $token);
    }

    function apiUserLogin()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login', [
            'email' => User::$userApiEmail,
            'password' => User::$userPass
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $user_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('user_data.json'), $user_data);
        file_put_contents(codecept_data_dir('user_token.json'), $token);
    }

    function apiAgencyLogin()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login', ['email' => User::$agencyEmail, 'password' => User::$agencyPass]);
        $usrData = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agency_data.json'), $usrData);
//        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $token = json_decode($usrData)->token;
        $this->debugSection('New Token', $token);
//        $this->restModule->haveHttpHeader('token', $token);
        $agencyToken = file_put_contents(codecept_data_dir('agency_token.json'), $token);
    }

    function apiAgencyLogin1()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login', ['email' => User::$agencyEmail3, 'password' => User::$agencyPass3]);
        $usrData = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agency_data.json'), $usrData);
//        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $token = json_decode($usrData)->token;
        $this->debugSection('New Token', $token);
//        $this->restModule->haveHttpHeader('token', $token);
        $agencyToken = file_put_contents(codecept_data_dir('agency_token.json'), $token);
    }

    function apiAgencyLoginTmp()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login',
            ['email' => User::getApiAgencyEmail(), 'password' => User::$agencyRegPass]);
        $usrData = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agency_data.json'), $usrData);
        $token = json_decode($usrData)->token;
        $this->debugSection('New Token', $token);
        file_put_contents(codecept_data_dir('agency_token.json'), $token);
    }



    function apiAgentLogin()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login', ['email' => User::getApiAgentEmail(), 'password' => User::$agentPass]);
        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $agent_data = $this->restModule->grabResponse();
        $this->debugSection('New Token', $token);
        file_put_contents(codecept_data_dir('agent_token.json'), $token);
        file_put_contents(codecept_data_dir('agent_data.json'), $agent_data);
    }

    function apiAgentLogin1()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/login', ['email' => User::$agentEmail, 'password' => User::$agentPass]);
        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $agent_data = $this->restModule->grabResponse();
        $this->debugSection('New Token', $token);
        file_put_contents(codecept_data_dir('agent_token.json'), $token);
        file_put_contents(codecept_data_dir('agent_data.json'), $agent_data);
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

    function apiAdminLogin()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/admin/login', ['email' => User::$adminEmail, 'password' => User::$adminPass]);
        $token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        $this->debugSection('New Token', $token);
        file_put_contents(codecept_data_dir('admin_token.json'), $token);
    }

    function apiAdminLogout()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->sendPOST('/logout');
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
    }


    /*================================================ API LISTS ==================================================*/

    function getAllLists()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/countries');
        $country = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('countries.json'), $country);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/regions');
        $regions = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('regions.json'), $regions);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/cities/' . $this->getRegion(21));
        $cities = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('cities.json'), $cities);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');

        $this->restModule->sendGET('/lists/districts/' . $this->getCity(6));
        $districts = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('districts.json'), $districts);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/streets/' . $this->getCity(6));
        $streets = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('streets.json'), $streets);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $flat = $this->getCategory(0);
        $this->restModule->sendGET('/lists/category-types/' . $flat);
        $cType = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('flat_types.json'), $cType);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $house = $this->getCategory(1);
        $this->restModule->sendGET('/lists/category-types/' . $house);
        $cType = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('house_types.json'), $cType);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $parcel = $this->getCategory(2);
        $this->restModule->sendGET('/lists/category-types/' . $parcel);
        $cType = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('parcel_types.json'), $cType);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $commerc = $this->getCategory(3);
        $this->restModule->sendGET('/lists/category-types/' . $commerc);
        $cType = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('commercial_types.json'), $cType);

        $this->restModule->haveHttpHeader ('Content-Type', 'application/json');
        $garage = $this->getCategory(4);
        $this->restModule->sendGET('/lists/category-types/' . $garage);
        $cType = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('garage_types.json'), $cType);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $flat = $this->getCategory(0);
        $this->restModule->sendGET('/lists/additionals/' . $flat);
        $flatAdditionals = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('flat_additionals.json'), $flatAdditionals);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $house = $this->getCategory(1);
        $this->restModule->sendGET('/lists/additionals/' . $house);
        $houseAdditionals = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('house_additionals.json'), $houseAdditionals);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $parcel = $this->getCategory(2);
        $this->restModule->sendGET('/lists/additionals/' . $parcel);
        $parcelAdditionals = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('parcel_additionals.json'), $parcelAdditionals);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $commercial = $this->getCategory(3);
        $this->restModule->sendGET('/lists/additionals/' . $commercial);
        $commercialAdditionals = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('commercial_additionals.json'), $commercialAdditionals);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $garage = $this->getCategory(4);
        $this->restModule->sendGET('/lists/additionals/' . $garage);
        $garageAdditionals = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('garage_additionals.json'), $garageAdditionals);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/appliances');
        $appliances = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('appliances.json'), $appliances);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/actual-currency');
        $actCurrency = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('actual_currency.json'), $actCurrency);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/area-units');
        $areaUnits = $this->restModule->grabResponse('$data.');
        $file = file_put_contents(codecept_data_dir('area_units.json'), $areaUnits);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/balconies');
        $balconies = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('balconies.json'), $balconies);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/communications');
        $communications = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('communications.json'), $communications);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/currency');
        $currency = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('currency.json'), $currency);

        $streetId = $this->getStreetId(0);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/house-numbers/' . $streetId);
        $house_numbers = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('house_numbers.json'), $house_numbers);

        $houseNumID = $this->getHouseNumbers(0);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/flat-numbers/' . $houseNumID);
        $flat_numbers = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('flat_numbers.json'), $flat_numbers);

        $garageNumID = $this->getHouseNumbers(0);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/garage-numbers/' . $garageNumID);
        $garage_numbers = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('garage_numbers.json'), $garage_numbers);

        $garageNumID = $this->getHouseNumbers(0);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/garage-numbers/' . $garageNumID);
        $garage_numbers = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('garage_numbers.json'), $garage_numbers);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/furnitures');
        $furnitures = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('furnitures.json'), $furnitures);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/heatings');
        $heatings = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('heatings.json'), $heatings);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/market-types');
        $mTypes = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('market_types.json'), $mTypes);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/near-objects');
        $nearObj = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('near_objects.json'), $nearObj);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/operation-types');
        $opTypes = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('operation_types.json'), $opTypes);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/period');
        $periods = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('periods.json'), $periods);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/statuses');
        $statuses = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('statuses.json'), $statuses);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/repairs');
        $repairs = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('repairs.json'), $repairs);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/unpublish-reasons');
        $unpubReason = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('unpublish_reasons.json'), $unpubReason);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/wall-materials');
        $wallMaterials = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('wall_materials.json'), $wallMaterials);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/water-heatings');
        $waterHeatings = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('water_heatings.json'), $waterHeatings);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/wc');
        $wc = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('wc.json'), $wc);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/inspection-pit');
        $inspection_list = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('inspectionPit_list.json'), $inspection_list);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/parking-place');
        $parking_list = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('parkingPlace_list.json'), $parking_list);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/transport-type');
        $transport_list = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('transport_list.json'), $transport_list);



    }
    function getCountry()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/countries');
        $country = $this->restModule->grabResponse();
        $countryId = json_decode($country)[0]->id;
        $this->debugSection('Country ID', $countryId);
        file_put_contents(codecept_data_dir('countries.json'), $country);
        return $countryId;


    }

    function getRegion($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/regions');
        $regions = $this->restModule->grabResponse();
        $regId = json_decode($regions)[$id]->id;
        $this->debugSection('Reg ID', $regId);
        file_put_contents(codecept_data_dir('regions.json'), $regions);
        return $regId;
    }
    function getRegionName($id)
    {
        $region = file_get_contents(codecept_data_dir('regions.json'));
        $regionName = json_decode($region)[$id]->name;
        $this->debugSection('Region', $regionName);
        return $regionName;
    }

    function getRegionId($id)
    {
        $region = file_get_contents(codecept_data_dir('regions.json'));
        $regionId = json_decode($region)[$id]->id;
        $this->debugSection('Region', $regionId);
        return $regionId;
    }

    function getCity($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $reg = $this->getRegion(21);
        $this->restModule->sendGET('/lists/cities/' . $reg);
        $cities = $this->restModule->grabResponse();
        $cityId = json_decode($cities)[$id]->id;
        $this->debugSection('City ID', $cityId);
        file_put_contents(codecept_data_dir('cities.json'), $cities);
        return $cityId;
    }
    function getCityName($id)
    {
        $city = file_get_contents(codecept_data_dir('cities.json'));
        $cityName = json_decode($city)[$id]->name;
        $this->debugSection('City Name', $cityName);
        return $cityName;
    }
    function getCityId($id)
    {
        $city = file_get_contents(codecept_data_dir('cities.json'));
        $cityId = json_decode($city)[$id]->id;
        $this->debugSection('City Id', $cityId);
        return $cityId;
    }
    function getCityLatinName($id)
    {
        $city = file_get_contents(codecept_data_dir('cities.json'));
        $cityName = json_decode($city)[$id]->latinName;
        $this->debugSection('City latin Name', $cityName);
        return $cityName;
    }


    function getDistrict($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $city = $this->getCity(6);
        $this->restModule->sendGET('/lists/districts/' . $city);
        $districts = $this->restModule->grabResponse();
        $districtId = json_decode($districts)[$id]->id;
        $this->debugSection('District ID', $districtId);
        $file = file_put_contents(codecept_data_dir('districts.json'), $districts);
        return $districtId;
    }
    function getDistrictName($id)
    {
        $district = file_get_contents(codecept_data_dir('districts.json'));
        $districtName = json_decode($district)[$id]->name;
        $this->debugSection('Districts Name', $districtName);
        return $districtName;
    }
    function getDistrictId($id)
    {
        $district = file_get_contents(codecept_data_dir('districts.json'));
        $districtId = json_decode($district)[$id]->id;
        $this->debugSection('Districts id', $districtId);
        return $districtId;
    }

    function getStreet($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $city = $this->getCity(6);
        $this->restModule->sendGET('/lists/streets/' . $city);
        $streets = $this->restModule->grabResponse();
        $streetId = json_decode($streets)[$id]->id;
        $this->debugSection('Street ID', $streetId);
        $file = file_put_contents(codecept_data_dir('streets.json'), $streets);
        return $streetId;
    }
    function getStreetName($id)
    {
        $street = file_get_contents(codecept_data_dir('streets.json'));
        $streetName = json_decode($street)[$id]->name;
        $this->debugSection('Street Name', $streetName);
        return $streetName;
    }
    function getStreetId($id)
    {
        $street = file_get_contents(codecept_data_dir('streets.json'));
        $streetId = json_decode($street)[$id]->id;
        $this->debugSection('Street Id', $streetId);
        return $streetId;
    }

    function getCategory($id) //0..3
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
    function getCategoryName($id)
    {
        $caregory = file_get_contents(codecept_data_dir('categories.json'));
        $caregoryName = json_decode($caregory)[$id]->name;
        $this->debugSection('Category Name', $caregoryName);
        return $caregoryName;
    }
    function getCategoryId($id)
    {
        $caregory = file_get_contents(codecept_data_dir('categories.json'));
        $caregoryId = json_decode($caregory)[$id]->id;
        $this->debugSection('Category ID', $caregoryId);
        return $caregoryId;
    }
    function getCategoryTypeName($id)
    {
        $caregory = file_get_contents(codecept_data_dir('categories.json'));
        $caregoryName = json_decode($caregory)[$id]->type;
        $this->debugSection('Category  Type Name', $caregoryName);
        return $caregoryName;
    }

    function getFlatCategoryTypes($id) //0..1
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $flat = $this->getCategory(0);
        $this->restModule->sendGET('/lists/category-types/' . $flat);
        $cType = $this->restModule->grabResponse();
        $this->debugSection('Flat Category Types', $cType);
        $file = file_put_contents(codecept_data_dir('flat_types.json'), $cType);
        $flatCatId = json_decode($cType)[$id]->id;
        $this->debugSection('flatCatId', $flatCatId);
        return $flatCatId;
    }
    function getFlatCategoryTypeName($id) //0..1
    {
        $caregoryType = file_get_contents(codecept_data_dir('flat_types.json'));
        $caregoryTypeName = json_decode($caregoryType)[$id]->name;
        $this->debugSection('Flat Category Type Name', $caregoryTypeName);
        return $caregoryTypeName;
    }
    function getFlatCategoryTypeId($id) //0..1
    {
        $caregoryType = file_get_contents(codecept_data_dir('flat_types.json'));
        $caregoryTypeId = json_decode($caregoryType)[$id]->id;
        $this->debugSection('Flat Category Type Id', $caregoryTypeId);
        return $caregoryTypeId;
    }

//    function getHouseCategoryTypeId($id) //0..2
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $house = $this->getCategory(1);
//        $this->restModule->sendGET('/lists/category-types/' . $house);
//        $cType = $this->restModule->grabResponse();
//        $this->debugSection('House Category Types', $cType);
//        $file = file_put_contents(codecept_data_dir('house_types.json'), $cType);
//        $houseCatId = json_decode($cType)[$id]->id;
//        $this->debugSection('houseCatId', $houseCatId);
//        return $houseCatId;
//    }
    function getHouseCategoryTypeName($id) //0..2
    {
        $caregoryType = file_get_contents(codecept_data_dir('house_types.json'));
        $caregoryTypeName = json_decode($caregoryType)[$id]->name;
        $this->debugSection('House Category Type Name', $caregoryTypeName);
        return $caregoryTypeName;
    }
    function getHouseCategoryTypeId($id) //0..2
    {
        $caregoryType = file_get_contents(codecept_data_dir('house_types.json'));
        $caregoryTypeId = json_decode($caregoryType)[$id]->id;
        $this->debugSection('House Category Type Name', $caregoryTypeId);
        return $caregoryTypeId;
    }

//    function getParcelCategoryTypeId($id) //0..4
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $parcel = $this->getCategoryId(2);
//        $this->restModule->sendGET('/lists/category-types/' . $parcel);
//        $cType = $this->restModule->grabResponse();
//        $this->debugSection('Parcel Category Types', $cType);
//        $file = file_put_contents(codecept_data_dir('parcel_types.json'), $cType);
//        $parcelCatId = json_decode($cType)[$id]->id;
//        $this->debugSection('parcelCatId', $parcelCatId);
//        return $parcelCatId;
//    }
    function getParcelCategoryTypeName($id) //0..4
    {
        $caregoryType = file_get_contents(codecept_data_dir('parcel_types.json'));
        $caregoryTypeName = json_decode($caregoryType)[$id]->name;
        $this->debugSection('Parcel Category Type Name', $caregoryTypeName);
        return $caregoryTypeName;
    }
    function getParcelCategoryTypeId($id) //0..4
    {
        $caregoryType = file_get_contents(codecept_data_dir('parcel_types.json'));
        $caregoryTypeId = json_decode($caregoryType)[$id]->id;
        $this->debugSection('Parcel Category Type Id', $caregoryTypeId);
        return $caregoryTypeId;
    }

//    function getCommercialCategoryTypeId($id) //0..10
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $commerc = $this->getCategoryId(3);
//        $this->restModule->sendGET('/lists/category-types/' . $commerc);
//        $cType = $this->restModule->grabResponse();
//        $this->debugSection('Commercial Category Types', $cType);
//        $file = file_put_contents(codecept_data_dir('commercial_types.json'), $cType);
//        $commercCatId = json_decode($cType)[$id]->id;
//        $this->debugSection('commercCatId', $commercCatId);
//        return $commercCatId;
//    }
    function getCommercialCategoryTypeName($id) //0..10
    {
        $caregoryType = file_get_contents(codecept_data_dir('commercial_types.json'));
        $caregoryTypeName = json_decode($caregoryType)[$id]->name;
        $this->debugSection('Commercial Category Type Name', $caregoryTypeName);
        return $caregoryTypeName;
    }
    function getCommercialCategoryTypeId($id) //0..10
    {
        $caregoryType = file_get_contents(codecept_data_dir('commercial_types.json'));
        $caregoryTypeId = json_decode($caregoryType)[$id]->id;
        $this->debugSection('Commercial Category Type ID', $caregoryTypeId);
        return $caregoryTypeId;
    }
//    function getGaragesCategoryTypeId($id) //0..3
//    {
//        $this->restModule->haveHttpHeader ('Content-Type', 'application/json');
//        $garage = $this->getCategoryId(4);
//        $this->restModule->sendGET('/lists/category-types/' . $garage);
//        $cType = $this->restModule->grabResponse();
//        $this->debugSection('Garage Category Types', $cType);
//        file_put_contents(codecept_data_dir('garage_types.json'), $cType);
//        $garageCatId = json_decode($cType)[$id]->id;
//        $this->debugSection('garageCatId', $garageCatId);
//        return $garageCatId;
//    }
    function getGaragesCategoryTypeName($id) //0..3
    {
        $caregoryType = file_get_contents(codecept_data_dir('garage_types.json'));
        $caregoryTypeName = json_decode($caregoryType)[$id]->name;
        $this->debugSection('Garages Category Type Name', $caregoryTypeName);
        return $caregoryTypeName;
    }
    function getGaragesCategoryTypeId($id) //0..3
    {
        $caregoryType = file_get_contents(codecept_data_dir('garage_types.json'));
        $caregoryTypeId = json_decode($caregoryType)[$id]->id;
        $this->debugSection('Garages Category Type ID', $caregoryTypeId);
        return $caregoryTypeId;
    }

//    function getFlatAdditionalsId($id) //0..15
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $flat = $this->getCategoryId(0);
//        $this->restModule->sendGET('/lists/additionals/' . $flat);
//        $flatAdditionals = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('flat_additionals.json'), $flatAdditionals);
//        $flatAdd = json_decode($flatAdditionals)[$id]->id;
//        $this->debugSection('flatAdd', $flatAdd);
//        return $flatAdd;
//    }
    function getFlatAdditionalsName($id) //0..15
    {
        $additional = file_get_contents(codecept_data_dir('flat_additionals.json'));
        $additionalName = json_decode($additional)[$id]->name;
        $this->debugSection('Flat Additionals Name', $additionalName);
        return $additionalName;
    }
    function getFlatAdditionalsId($id) //0..15
    {
        $additional = file_get_contents(codecept_data_dir('flat_additionals.json'));
        $additionalId = json_decode($additional)[$id]->id;
        $this->debugSection('Flat Additionals ID', $additionalId);
        return $additionalId;
    }

//    function getHouseAdditionalsId($id) //0..15
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $house = $this->getCategoryId(1);
//        $this->restModule->sendGET('/lists/additionals/' . $house);
//        $houseAdditionals = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('house_additionals.json'), $houseAdditionals);
//        $houseAdd = json_decode($houseAdditionals)[$id]->id;
//        $this->debugSection('houseAdd', $houseAdd);
//        return $houseAdd;
//    }
    function getHouseAdditionalsName($id) //0..15
    {
        $additional = file_get_contents(codecept_data_dir('house_additionals.json'));
        $additionalName = json_decode($additional)[$id]->name;
        $this->debugSection('House Additionals Name', $additionalName);
        return $additionalName;
    }
    function getHouseAdditionalsId($id) //0..15
    {
        $additional = file_get_contents(codecept_data_dir('house_additionals.json'));
        $additionalId = json_decode($additional)[$id]->id;
        $this->debugSection('House Additionals ID', $additionalId);
        return $additionalId;
    }

//    function getParcelAdditionalsID($id) //0..11
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $parcel = $this->getCategoryId(2);
//        $this->restModule->sendGET('/lists/additionals/' . $parcel);
//        $parcelAdditionals = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('parcel_additionals.json'), $parcelAdditionals);
//        $parcelAdd = json_decode($parcelAdditionals)[$id]->id;
//        $this->debugSection('parcelAdd', $parcelAdd);
//        return $parcelAdd;
//    }
    function getParcelAdditionalsName($id) //0..11
    {
        $additional = file_get_contents(codecept_data_dir('parcel_additionals.json'));
        $additionalName = json_decode($additional)[$id]->name;
        $this->debugSection('Parcel Additionals Name', $additionalName);
        return $additionalName;
    }
    function getParcelAdditionalsID($id) //0..11
    {
        $additional = file_get_contents(codecept_data_dir('parcel_additionals.json'));
        $additionalId = json_decode($additional)[$id]->id;
        $this->debugSection('Parcel Additionals ID', $additionalId);
        return $additionalId;
    }

//    function getCommercialAdditionalsId($id) //0..7
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $commercial = $this->getCategoryId(3);
//        $this->restModule->sendGET('/lists/additionals/' . $commercial);
//        $commercialAdditionals = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('commercial_additionals.json'), $commercialAdditionals);
//        $commercialAdd = json_decode($commercialAdditionals)[$id]->id;
//        $this->debugSection('commercialAdd0', $commercialAdd);
//        return $commercialAdd;
//    }
    function getCommercialAdditionalsName($id) //0..7
    {
        $additional = file_get_contents(codecept_data_dir('commercial_additionals.json'));
        $additionalName = json_decode($additional)[$id]->name;
        $this->debugSection('Commercial Additionals Name', $additionalName);
        return $additionalName;
    }
    function getCommercialAdditionalsId($id) //0..7
    {
        $additional = file_get_contents(codecept_data_dir('commercial_additionals.json'));
        $additionalId = json_decode($additional)[$id]->id;
        $this->debugSection('Commercial Additionals ID', $additionalId);
        return $additionalId;
    }

//    function getGarageAdditionalsId($id) //0..7
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $garage = $this->getCategoryId(4);
//        $this->restModule->sendGET('/lists/additionals/' . $garage);
//        $garageAdditionals = $this->restModule->grabResponse();
//        file_put_contents(codecept_data_dir('garage_additionals.json'), $garageAdditionals);
//        $garageAdd = json_decode($garageAdditionals)[$id]->id;
//        $this->debugSection('Garage Add0', $garageAdd);
//        return $garageAdd;
//    }
    function getGarageAdditionalsName($id) //0..7
    {
        $additional = file_get_contents(codecept_data_dir('garage_additionals.json'));
        $additionalName = json_decode($additional)[$id]->name;
        $this->debugSection('Garage Additionals Name', $additionalName);
        return $additionalName;
    }
    function getGarageAdditionalsId($id) //0..7
    {
        $additional = file_get_contents(codecept_data_dir('garage_additionals.json'));
        $additionalId = json_decode($additional)[$id]->id;
        $this->debugSection('Garage Additionals ID', $additionalId);
        return $additionalId;
    }

//    function getAppliancesId($id) //0..7
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/appliances');
//        $appliances = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('appliances.json'), $appliances);
//        $appliancesId = json_decode($appliances)[$id]->id;
//        $this->debugSection('appliancesId', $appliancesId);
//        return $appliancesId;
//    }
    function getAppliancesName($id) //0..7
    {
        $appliances = file_get_contents(codecept_data_dir('appliances.json'));
        $appliancesName = json_decode($appliances)[$id]->name;
        $this->debugSection('Appliances Name', $appliancesName);
        return $appliancesName;
    }
    function getAppliancesId($id) //0..7
    {
        $appliances = file_get_contents(codecept_data_dir('appliances.json'));
        $appliancesId = json_decode($appliances)[$id]->id;
        $this->debugSection('Appliances Id', $appliancesId);
        return $appliancesId;
    }

    function getActualCurrency()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/actual-currency');
        $actCurrency = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('actual_currency.json'), $actCurrency);
    }
    function getActualCurrencyName($id)
    {
        $actualCurrency = file_get_contents(codecept_data_dir('actual_currency.json'));
        $actualCurrencyName = json_decode($actualCurrency)[$id]->currency;
        $this->debugSection('Actual Currency Name', $actualCurrencyName);
        return $actualCurrencyName;
    }

//    function getAreaUnitsId($id) //0..2
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/area-units');
//        $areaUnits = $this->restModule->grabResponse('$data.');
//        $file = file_put_contents(codecept_data_dir('area_units.json'), $areaUnits);
//        $areaUnitId = json_decode($areaUnits)[$id]->id;
//        $this->debugSection('areaUnitId', $areaUnitId);
//        return $areaUnitId;
//    }
    function getAreaUnitsName($id)
    {
        $areaUnits = file_get_contents(codecept_data_dir('area_units.json'));
        $areaUnitsName = json_decode($areaUnits)[$id]->name;
        $this->debugSection('Area Unit Name', $areaUnitsName);
        return $areaUnitsName;
    }
    function getAreaUnitsId($id)
    {
        $areaUnits = file_get_contents(codecept_data_dir('area_units.json'));
        $areaUnitsId = json_decode($areaUnits)[$id]->id;
        $this->debugSection('Area Unit ID', $areaUnitsId);
        return $areaUnitsId;
    }

//    function getBalconiesId($id) //0..3
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/balconies');
//        $balconies = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('balconies.json'), $balconies);
//        $balconyId = json_decode($balconies)[$id]->id;
//        $this->debugSection('balconyId0', $balconyId);
//        return $balconyId;
//    }
    function getBalconiesName($id)
    {
        $balconies = file_get_contents(codecept_data_dir('balconies.json'));
        $balconiesName = json_decode($balconies)[$id]->name;
        $this->debugSection('Balcony', $balconiesName);
        return $balconiesName;
    }
    function getBalconiesId($id)
    {
        $balconies = file_get_contents(codecept_data_dir('balconies.json'));
        $balconiesId = json_decode($balconies)[$id]->id;
        $this->debugSection('Balcony', $balconiesId);
        return $balconiesId;
    }

//    function getCommunicationsId($id) //0..7
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/communications');
//        $communications = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('communications.json'), $communications);
//        $communicatId = json_decode($communications)[$id]->id;
//        $this->debugSection('communicatId', $communicatId);
//        return $communicatId;
//    }
    function getCommunicationsName($id)
    {
        $communications = file_get_contents(codecept_data_dir('communications.json'));
        $communicationsName = json_decode($communications)[$id]->name;
        $this->debugSection('Communications Name', $communicationsName);
        return $communicationsName;
    }
    function getCommunicationsId($id)
    {
        $communications = file_get_contents(codecept_data_dir('communications.json'));
        $communicationsId = json_decode($communications)[$id]->id;
        $this->debugSection('Communications ID', $communicationsId);
        return $communicationsId;
    }

//    function getCurrencyId($id) //0..1
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/currency');
//        $currency = $this->restModule->grabResponse();
//        file_put_contents(codecept_data_dir('currency.json'), $currency);
//        $currencyId = json_decode($currency)[$id]->id;
//        $this->debugSection('currencyId', $currencyId);
//        return $currencyId;
//    }
    function getCurrencyName($id)
    {
        $currency = file_get_contents(codecept_data_dir('currency.json'));
        $currencyName = json_decode($currency)[$id]->name;
        $this->debugSection('Communications Name', $currencyName);
        return $currencyName;
    }
    function getCurrencyId($id)
    {
        $currency = file_get_contents(codecept_data_dir('currency.json'));
        $currencyId = json_decode($currency)[$id]->id;
        $this->debugSection('Communications Id', $currencyId);
        return $currencyId;
    }

    function getHouseNumbers($id)
    {
        $streetId = $this->getStreetId(0);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/house-numbers/' . $streetId);
        $house_numbers = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('house_numbers.json'), $house_numbers);
        $houseNumbersID = json_decode($house_numbers)[$id]->id;
        $this->debugSection('house_number ID', $houseNumbersID);
        return $houseNumbersID;
    }

    function getFlatNumbers($id)
    {
        $houseNumID = $this->getHouseNumbers(0);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/flat-numbers/' . $houseNumID);
        $flat_numbers = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('flat_numbers.json'), $flat_numbers);
        $flatNumbersID = json_decode($flat_numbers)[$id]->id;
        $this->debugSection('flat_number ID', $flatNumbersID);
        return $flatNumbersID;
    }
    function getGarageNumbers($id)
    {
        $garageNumID = $this->getHouseNumbers(0);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/garage-numbers/' . $garageNumID);
        $garage_numbers = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('garage_numbers.json'), $garage_numbers);
        $garageNumbersID = json_decode($garage_numbers)[$id]->id;
        $this->debugSection('garage_number ID', $garageNumbersID);
        return $garageNumbersID;
    }

//    function getFurnituresId($id) //0..7
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/furnitures');
//        $furnitures = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('furnitures.json'), $furnitures);
//        $furId = json_decode($furnitures)[$id]->id;
//        $this->debugSection('furId', $furId);
//        return $furId;
//    }
    function getFurnituresName($id)
    {
        $furnitures = file_get_contents(codecept_data_dir('furnitures.json'));
        $furnituresName = json_decode($furnitures)[$id]->name;
        $this->debugSection('Furnitures Name', $furnituresName);
        return $furnituresName;
    }
    function getFurnituresId($id)
    {
        $furnitures = file_get_contents(codecept_data_dir('furnitures.json'));
        $furnituresId = json_decode($furnitures)[$id]->id;
        $this->debugSection('Furnitures ID', $furnituresId);
        return $furnituresId;
    }

//    function getHeatingsId($id) //0..4
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/heatings');
//        $heatings = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('heatings.json'), $heatings);
//        $heatId = json_decode($heatings)[$id]->id;
//        $this->debugSection('heatId', $heatId);
//        return $heatId;
//    }
    function getHeatingsName($id)
    {
        $heatings = file_get_contents(codecept_data_dir('heatings.json'));
        $heatingsName = json_decode($heatings)[$id]->name;
        $this->debugSection('Heatings Name', $heatingsName);
        return $heatingsName;
    }
    function getHeatingsId($id)
    {
        $heatings = file_get_contents(codecept_data_dir('heatings.json'));
        $heatingsId = json_decode($heatings)[$id]->id;
        $this->debugSection('Heatings Id', $heatingsId);
        return $heatingsId;
    }

//    function getMarketTypeId($id) //0..1
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/market-types');
//        $mTypes = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('market_types.json'), $mTypes);
//        $mTypeId = json_decode($mTypes)[$id]->id;
//        $this->debugSection('mTypeId', $mTypeId);
//        return $mTypeId;
//    }
    function getMarketTypeName($id) //0..1
    {
        $market = file_get_contents(codecept_data_dir('market_types.json'));
        $marketName = json_decode($market)[$id]->name;
        $this->debugSection('Market Name', $marketName);
        return $marketName;
    }
    function getMarketTypeId($id) //0..1
    {
        $market = file_get_contents(codecept_data_dir('market_types.json'));
        $marketId = json_decode($market)[$id]->id;
        $this->debugSection('Market Id', $marketId);
        return $marketId;
    }

//    function getNearObjectsId($id) //0..9
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/near-objects');
//        $nearObj = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('near_objects.json'), $nearObj);
//        $nObjId = json_decode($nearObj)[$id]->id;
//        $this->debugSection('nObjId', $nObjId);
//        return $nObjId;
//
//    }
    function getNearObjectsName($id)
    {
        $nearObj = file_get_contents(codecept_data_dir('near_objects.json'));
        $nearObjName = json_decode($nearObj)[$id]->name;
        $this->debugSection('NearObjects Name', $nearObjName);
        return $nearObjName;
    }
    function getNearObjectsId($id)
    {
        $nearObj = file_get_contents(codecept_data_dir('near_objects.json'));
        $nearObjId = json_decode($nearObj)[$id]->id;
        $this->debugSection('NearObjects ID', $nearObjId);
        return $nearObjId;
    }

//    function getOperationTypeId($id) //0..1
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/operation-types');
//        $opTypes = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('operation_types.json'), $opTypes);
//        $opTypeId = json_decode($opTypes)[$id]->id;
//        $this->debugSection('opTypeId', $opTypeId);
//        return $opTypeId;
//    }
    function getOperationTypeName($id)
    {
        $opTypes = file_get_contents(codecept_data_dir('operation_types.json'));
        $opTypesName = json_decode($opTypes)[$id]->name;
        $this->debugSection('OperationType Name', $opTypesName);
        return $opTypesName;
    }
    function getOperationTypeId($id)
    {
        $opTypes = file_get_contents(codecept_data_dir('operation_types.json'));
        $opTypesId = json_decode($opTypes)[$id]->id;
        $this->debugSection('OperationType Id', $opTypesId);
        return $opTypesId;
    }

//    function getPeriodId($id) //0..1
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/period');
//        $periods = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('periods.json'), $periods);
//        $periodId = json_decode($periods)[$id]->id;
//        $this->debugSection('periodId', $periodId);
//        return $periodId;
//    }
    function getPeriodName($id)
    {
        $periods = file_get_contents(codecept_data_dir('periods.json'));
        $periodsName = json_decode($periods)[$id]->name;
        $this->debugSection('Period', $periodsName);
        return $periodsName;
    }
    function getPeriodId($id)
    {
        $periods = file_get_contents(codecept_data_dir('periods.json'));
        $periodsId = json_decode($periods)[$id]->id;
        $this->debugSection('Period', $periodsId);
        return $periodsId;
    }

//    function getStatusesId($id) //0..4
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/statuses');
//        $statuses = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('statuses.json'), $statuses);
//        $statusId = json_decode($statuses)[$id]->id;
//        $this->debugSection('statusId', $statusId);
//        return $statusId;
//    }
    function getStatusesName($id)
    {
        $statuses = file_get_contents(codecept_data_dir('statuses.json'));
        $statusesName = json_decode($statuses)[$id]->name;
        $this->debugSection('Status', $statusesName);
        return $statusesName;
    }
    function getStatusesId($id)
    {
        $statuses = file_get_contents(codecept_data_dir('statuses.json'));
        $statusesId = json_decode($statuses)[$id]->id;
        $this->debugSection('Status', $statusesId);
        return $statusesId;
    }

//    function getRepairsId($id) //0..7
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/repairs');
//        $repairs = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('repairs.json'), $repairs);
//        $repairId = json_decode($repairs)[$id]->id;
//        $this->debugSection('repairId', $repairId);
//        return $repairId;
//    }
    function getRepairsName($id)
    {
        $repairs = file_get_contents(codecept_data_dir('repairs.json'));
        $repairsName = json_decode($repairs)[$id]->name;
        $this->debugSection('Repairs Name', $repairsName);
        return $repairsName;
    }
    function getRepairsId($id)
    {
        $repairs = file_get_contents(codecept_data_dir('repairs.json'));
        $repairsId = json_decode($repairs)[$id]->id;
        $this->debugSection('Repairs Id', $repairsId);
        return $repairsId;
    }

//    function getUnpublishReasonsId($id) //0..1
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/unpublish-reasons');
//        $unpubReason = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('unpublish_reasons.json'), $unpubReason);
//        $unpReasonId = json_decode($unpubReason)[$id]->id;
//        $this->debugSection('unpReasonId', $unpReasonId);
//        return $unpReasonId;
//    }
    function getUnpublishReasonsName($id)
    {
        $unpubReason = file_get_contents(codecept_data_dir('unpublish_reasons.json'));
        $unpubReasonName = json_decode($unpubReason)[$id]->name;
        $this->debugSection('Unpublish reason', $unpubReasonName);
        return $unpubReasonName;
    }
    function getUnpublishReasonsId($id)
    {
        $unpubReason = file_get_contents(codecept_data_dir('unpublish_reasons.json'));
        $unpubReasonId = json_decode($unpubReason)[$id]->id;
        $this->debugSection('Unpublish reason', $unpubReasonId);
        return $unpubReasonId;
    }

//    function getWallMaterialsId($id) //0..10
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/wall-materials');
//        $wallMaterials = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('wall_materials.json'), $wallMaterials);
//        $wMaterialId = json_decode($wallMaterials)[$id]->id;
//        $this->debugSection('wMaterialId', $wMaterialId);
//        return $wMaterialId;
//    }
    function getWallMaterialsName($id)
    {
        $wallMaterials = file_get_contents(codecept_data_dir('wall_materials.json'));
        $wallMaterialsName = json_decode($wallMaterials)[$id]->name;
        $this->debugSection('Wall material', $wallMaterialsName);
        return $wallMaterialsName;
    }
    function getWallMaterialsId($id)
    {
        $wallMaterials = file_get_contents(codecept_data_dir('wall_materials.json'));
        $wallMaterialsId = json_decode($wallMaterials)[$id]->id;
        $this->debugSection('Wall material', $wallMaterialsId);
        return $wallMaterialsId;
    }

//    function getWaterHeatingsId($id) //0..4
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/water-heatings');
//        $waterHeatings = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('water_heatings.json'), $waterHeatings);
//        $wHeatId = json_decode($waterHeatings)[$id]->id;
//        $this->debugSection('wHeatId', $wHeatId);
//        return $wHeatId;
//    }
    function getWaterHeatingsName($id)
    {
        $waterHeatings = file_get_contents(codecept_data_dir('water_heatings.json'));
        $waterHeatingsName = json_decode($waterHeatings)[$id]->name;
        $this->debugSection('Water Heating', $waterHeatingsName);
        return $waterHeatingsName;
    }
    function getWaterHeatingsId($id)
    {
        $waterHeatings = file_get_contents(codecept_data_dir('water_heatings.json'));
        $waterHeatingsId = json_decode($waterHeatings)[$id]->id;
        $this->debugSection('Water Heating', $waterHeatingsId);
        return $waterHeatingsId;
    }

//    function getWcId($id) //0..2
//    {
//        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
//        $this->restModule->sendGET('/lists/wc');
//        $wc = $this->restModule->grabResponse();
//        $file = file_put_contents(codecept_data_dir('wc.json'), $wc);
//        $wcId = json_decode($wc)[$id]->id;
//        $this->debugSection('wcId', $wcId);
//        return $wcId;
//    }
    function getWcName($id)
    {
        $wc = file_get_contents(codecept_data_dir('wc.json'));
        $wcName = json_decode($wc)[$id]->name;
        $this->debugSection('WC', $wcName);
        return $wcName;
    }
    function getWcId($id)
    {
        $wc = file_get_contents(codecept_data_dir('wc.json'));
        $wcId = json_decode($wc)[$id]->id;
        $this->debugSection('WC', $wcId);
        return $wcId;
    }
//    function  getInspectionPitId($id)
//    {
//        $this->restModule->sendGET('/lists/inspection-pit');
//        $inspection_list = $this->restModule->grabResponse();
//        file_put_contents(codecept_data_dir('inspectionPit_list.json'), $inspection_list);
//        $this->restModule->seeResponseCodeIS(200);
//        $inspectionId = json_decode($inspection_list)[$id]->id;
//        $this->debugSection('inspectionId', $inspectionId);
//        return $inspectionId;
//    }
    function getInspectionPitName($id)
    {
        $inspection = file_get_contents(codecept_data_dir('inspectionPit_list.json'));
        $inspectionName = json_decode($inspection)[$id]->name;
        $this->debugSection('Inspection Pit', $inspectionName);
        return $inspectionName;
    }
    function getInspectionPitId($id)
    {
        $inspection = file_get_contents(codecept_data_dir('inspectionPit_list.json'));
        $inspectionId = json_decode($inspection)[$id]->id;
        $this->debugSection('Inspection Pit', $inspectionId);
        return $inspectionId;
    }
//    function  getParkingPlaceId($id)
//    {
//        $this->restModule->sendGET('/lists/parking-place');
//        $parking_list = $this->restModule->grabResponse();
//        file_put_contents(codecept_data_dir('parkingPlace_list.json'), $parking_list);
//        $this->restModule->seeResponseCodeIS(200);
//        $parkingId = json_decode($parking_list)[$id]->id;
//        $this->debugSection('parkingId', $parkingId);
//        return $parkingId;
//    }
    function getParkingPlaceName($id)
    {
        $parking = file_get_contents(codecept_data_dir('parkingPlace_list.json'));
        $parkingName = json_decode($parking)[$id]->name;
        $this->debugSection('Parking Place', $parkingName);
        return $parkingName;
    }
    function getParkingPlaceId($id)
    {
        $parking = file_get_contents(codecept_data_dir('parkingPlace_list.json'));
        $parkingName = json_decode($parking)[$id]->id;
        $this->debugSection('Parking Place', $parkingName);
        return $parkingName;
    }
//    function  getTransportTypeId($id)
//    {
//        $this->restModule->sendGET('/lists/transport-type');
//        $transport_list = $this->restModule->grabResponse();
//        file_put_contents(codecept_data_dir('transport_list.json'), $transport_list);
//        $this->restModule->seeResponseCodeIS(200);
//        $transportId = json_decode($transport_list)[$id]->id;
//        $this->debugSection('transportId', $transportId);
//        return $transportId;
//    }
    function getTransportTypeName($id)
    {
        $transport = file_get_contents(codecept_data_dir('transport_list.json'));
        $transportName = json_decode($transport)[$id]->name;
        $this->debugSection('Transport Type', $transportName);
        return $transportName;
    }
    function getTransportTypeId($id)
    {
        $transport = file_get_contents(codecept_data_dir('transport_list.json'));
        $transportName = json_decode($transport)[$id]->id;
        $this->debugSection('Transport Type', $transportName);
        return $transportName;
    }

    function apiGetAgencyAnnouncementsList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->sendGET('/profiles/announcements-lists/lists');
        $announcement_list = $this->restModule->grabResponse();
        $this->restModule->seeResponseContainsJson(array('interestingCount' => '0'));
        $this->restModule->seeResponseContainsJson(array('uninterestingCount' => '0'));
        file_put_contents(codecept_data_dir('agency_announcement_list.json'), $announcement_list);
        $this->restModule->seeResponseContainsJson(array('id' => User::getGroupId()));
    }

    function apiGetAgentAnnouncementsList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->sendGET('/profiles/announcements-lists/lists');
        $announcement_list = $this->restModule->grabResponse();
        $this->restModule->seeResponseContainsJson(array('interestingCount' => '2'));
        $this->restModule->seeResponseContainsJson(array('uninterestingCount' => '2'));
        file_put_contents(codecept_data_dir('agent_announcement_list.json'), $announcement_list);
        $this->restModule->seeResponseContainsJson(array('id' => User::getGroupId()));
    }

    function apiGetUserAnnouncementsList()
    {
        $this->restModule->haveHttpHeader('token', User::getUserToken());
        $this->restModule->sendGET('/profiles/announcements-lists/lists');
        $announcement_list = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('user_announcement_list.json'), $announcement_list);
        $this->restModule->seeResponseContainsJson(array('id' => User::getGroupId()));
    }

    function apiGetUser()
    {
        $this->restModule->haveHttpHeader('token', User::getUserToken());
        $this->restModule->sendGET('/users/' . User::getUserId(1));
        $user_info = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('get_user.json'), $user_info);
    }

    function apiGetAgent()
    {
        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->sendGET('/users/' . User::getUserId(2));
        $agent_info = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('get_agent.json'), $agent_info);
    }

    function apiGetAgency()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->sendGET('/users/' . User::getUserId(3));
        $agency_info = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('get_agency.json'), $agency_info);
    }
    function apiGetAgencies()
    {
        $agencyName = User::$agencyName;
        $region = $this->getRegionId(21);
        $city = $this->getCityId(6);
        $this->restModule->sendGET('/users/agencies/search/1/24?city='.$city.'&name='.$agencyName.'&region='.$region.'');
        $agencies_list = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agencies_list.json'), $agencies_list);
        $this->restModule->seeResponseCodeIS(200);
    }
   


    /*=================================== API REALTY ==================================*/

    /*=================================== COMMON =================================*/

    function realtyFlatHistory()
    {
        $realtyFlatID = file_get_contents(codecept_data_dir('realtyFlatId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/realties/history/' . $realtyFlatID);
//        $realtyFlatDelete = $this->restModule->grabResponse();
//        $this->debugSection('realtyFlatDelete', $realtyFlatDelete);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => [
                [
                    'id' => 'string',
                    'createdAt' => 'string',
                    'user' => [
                        'firstName' => 'string',
                        'lastName' => 'string',
                        'email' => 'string',
                        'phones' => 'array',
                        'userType' => 'string'
                    ],
                    'status' => 'integer',
                    'realtyStatus' => 'integer'
                ]
            ]
        ]);
    }

    function realtyHouseHistory()
    {
        $realtyHouseID = file_get_contents(codecept_data_dir('realtyHouseId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/realties/history/' . $realtyHouseID);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    function realtyParcelHistory()
    {
        $realtyParcelID = file_get_contents(codecept_data_dir('realtyParcelId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/realties/history/' . $realtyParcelID);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    function realtyCommercialHistory()
    {
        $realtyCommercialID = file_get_contents(codecept_data_dir('realtyCommercialId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/realties/history/' . $realtyCommercialID);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    function realtiesStatistics()
    {

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/realties/statistics');
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'active' => 'integer',
            'notActive' => 'integer'
        ]);

    }

    function realtiesLists()
    {
        $agency = file_get_contents(codecept_data_dir('agency_data.json'));
        $agencyID = json_decode($agency)->id;

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/realties/lists', [
            'category' => $this->getCategoryId(0),
            'categoryType' => $this->getFlatCategoryTypeId(0),
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(32),
            'author' => $agencyID
        ]);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    /*========================================= FLATS =========================================*/
    function realtyFlatAddPlain()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/add', [
            'category' => $this->getCategoryId(0),
            'categoryType' => $this->getFlatCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
//            'district' => $this->getDistrictId(23),
            'street' => $this->getStreetId(0),
            'houseNumber' => Flat::houseNumber,
            'flatNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Flat::latitude,
            'longitude' => Flat::longitude,
            'roomCount' => Flat::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'area' => Flat::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
//            'livingArea' => Flat::livingArea,
//            'kitchenArea' => Flat::kitchenArea,
            'floor' => Flat::floors,
            'floorNumber' => Flat::floorNumber,
//            'buildYear' => Flat::buildYear,
            'wc' => $this->getWcId(0),
            'balcony' => $this->getBalconiesId(0),
            'heating' => $this->getHeatingsId(0),
            'waterHeating' => $this->getWaterHeatingsId(0),
//            'nearObjects' => [$this->getNearObjectsId(0), $this->getNearObjectsId(1), $this->getNearObjectsId(5)],
//            'schema' => $schema
        ]);

        $realtyFlat = $this->restModule->grabResponse();
        $realtyFlatId = json_decode($realtyFlat)->id;
        file_put_contents(codecept_data_dir('realtyFlatId.json'), $realtyFlatId);
        $this->debugSection('realtyFlatId', $realtyFlatId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }

    function realtyFlatAddComplex()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/add', [
            'category' => $this->getCategoryId(0),
            'categoryType' => $this->getFlatCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(32),
            'houseNumber' => Flat::houseNumber,
            'flatNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Flat::latitude,
            'longitude' => Flat::longitude,
            'roomCount' => Flat::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'area' => Flat::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => Flat::livingArea,
            'kitchenArea' => Flat::kitchenArea,
            'floor' => Flat::floors,
            'floorNumber' => Flat::floorNumber,
            'buildYear' => Flat::buildYear,
            'wc' => $this->getWcId(1),
            'balcony' => $this->getBalconiesId(1),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],
            'schema' => $schema
        ]);

        $realtyFlat = $this->restModule->grabResponse();
        $realtyFlatId = json_decode($realtyFlat)->id;
        file_put_contents(codecept_data_dir('realtyFlatId.json'), $realtyFlatId);
        $this->debugSection('realtyFlatId', $realtyFlatId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }
    function realtyFlatAddForSearch()
    {
//        $schema = file_get_contents(codecept_data_dir('schema_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/add', [
            'category' => $this->getCategoryId(0),
            'categoryType' => $this->getFlatCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(34),
            'houseNumber' => Flat::houseNumber,
            'flatNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Flat::searchLatitude,
            'longitude' => Flat::searchLongitude,
            'roomCount' => Flat::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'area' => Flat::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => Flat::livingArea,
            'kitchenArea' => Flat::kitchenArea,
            'floor' => Flat::floorNumber,
            'floorNumber' => Flat::floors,
            'buildYear' => Flat::buildYear,
            'wc' => $this->getWcId(1),
            'balcony' => $this->getBalconiesId(1),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'nearObjects' => [$this->getNearObjectsId(0)]
//            'schema' => $schema
        ]);

        $realtyFlat = $this->restModule->grabResponse();
        $realtyFlatId = json_decode($realtyFlat)->id;
        file_put_contents(codecept_data_dir('realtyFlatId.json'), $realtyFlatId);
        $this->debugSection('realtyFlatId', $realtyFlatId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }

    function realtyFlatCheck()
    {
        $flatNumbs = file_get_contents(codecept_data_dir('flat_numbers.json'));
        $flatNumber = json_decode($flatNumbs)[0]->number;
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/check', [
            'category' => $this->getCategoryId(0),
            'categoryType' => $this->getFlatCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(0),
            'houseNumber' => Flat::houseNumber,
            'flatNumber' => Flat::$currentFlatNumber
//            'flatNumber' => $flatNumber

        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType(['id' => 'string']);

    }

    function realtyFlatsValidate()
    {

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/validate', [
            'category' => $this->getCategoryId(0),
            'categoryType' => $this->getFlatCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(23),
            'street' => $this->getStreetId(32),
            'houseNumber' => Flat::houseNumber,
            'flatNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Flat::latitude,
            'longitude' => Flat::longitude,
            'roomCount' => Flat::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'area' => Flat::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => Flat::livingArea,
            'kitchenArea' => Flat::kitchenArea,
            'floor' => Flat::floors,
            'floorNumber' => Flat::floorNumber,
            'buildYear' => Flat::buildYear,
            'wc' => $this->getWcId(1),
            'balcony' => $this->getBalconiesId(1),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'nearObjects' => [$this->getNearObjectsId(0), $this->getNearObjectsId(1)]

        ]);

        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'category' => 'string',
            'categoryType' => 'string',
            'region' => 'string',
            'city' => 'string',
            'district' => 'string',
            'street' => 'string',
            'houseNumber' => 'integer',
            'flatNumber' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
            'roomCount' => 'integer',
            'wallMaterial' => 'string',
            'area' => 'integer',
            'areaUnit' => 'string',
            'livingArea' => 'integer',
            'kitchenArea' => 'integer',
            'floor' => 'integer',
            'floorNumber' => 'integer',
            'buildYear' => 'integer',
            'wc' => 'string',
            'balcony' => 'string',
            'heating' => 'string',
            'waterHeating' => 'string',
            'nearObjects' => 'array'
        ]);
    }

    function realtyFlatsEdit() //previously you should execute function realtyFlatAdd(Plain or Complex)
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $realtyFlatID = file_get_contents(codecept_data_dir('realtyFlatId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/flats/edit/' . $realtyFlatID, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(0),
            'street' => $this->getStreetId(0),
            'houseNumber' => House::uniqueHouseNumber(),
            'flatNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Flat::editLatitude,
            'longitude' => Flat::editLongitude,
            'roomCount' => Flat::editRoomCount,
            'wallMaterial' => $this->getWallMaterialsId(2),
            'area' => Flat::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => Flat::editLivingArea,
            'kitchenArea' => Flat::editKitchenArea,
            'floor' => Flat::editFloorNumber,
            'floorNumber' => Flat::editFloors,
            'buildYear' => Flat::editBuildYear,
            'wc' => $this->getWcId(2),
            'balcony' => $this->getBalconiesId(2),
            'heating' => $this->getHeatingsId(2),
            'waterHeating' => $this->getWaterHeatingsId(2),
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],
            'schema' => $schema
        ]);

        $realtyFlat = $this->restModule->grabResponse();
        $realtyFlatId = json_decode($realtyFlat)->id;
        if ($realtyFlatID === $realtyFlatId) {
            file_put_contents(codecept_data_dir('realtyFlatId.json'), $realtyFlatId);
        }
        $this->debugSection('realtyFlatId', $realtyFlatId);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
    }

    function realtyFlatsDelete()
    {
        $realtyFlatID = file_get_contents(codecept_data_dir('realtyFlatId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/realties/' . $realtyFlatID . '/delete');
        $realtyFlatDelete = $this->restModule->grabResponse();
        $this->debugSection('realtyFlatDelete', $realtyFlatDelete);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
    }

    /*========================================= HOUSES =========================================*/

    function realtyHouseAddPlain()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/add', [
            'category' => $this->getCategoryId(1),
            'categoryType' => $this->getHouseCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(94),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::latitude,
            'longitude' => House::longitude,
            'roomCount' => House::roomCount,
//            'landArea' => House::landArea,
            'landAreaUnit' => $this->getAreaUnitsId(0),
            'floorNumber' => House::floors,
            'wallMaterial' => $this->getWallMaterialsId(10),
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'wc' => $this->getWcId(0),
            'heating' => $this->getHeatingsId(0),
            'waterHeating' => $this->getWaterHeatingsId(0)
        ]);

        $realtyHouse = $this->restModule->grabResponse();
        $realtyHouseId = json_decode($realtyHouse)->id;
        file_put_contents(codecept_data_dir('realtyHouseId.json'), $realtyHouseId);
        $this->debugSection('realtyHouseId', $realtyHouseId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }

    function realtyHouseAddComplex()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/add', [
            'category' => $this->getCategoryId(1),
            'categoryType' => $this->getHouseCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(2),
            'street' => $this->getStreetId(94),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::latitude,
            'longitude' => House::longitude,
            'roomCount' => House::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(10),
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => House::livingArea,
            'kitchenArea' => House::kitchenArea,
            'landArea' => House::landArea,
            'landAreaUnit' => $this->getAreaUnitsId(1),
            'floorNumber' => House::floors,
            'buildYear' => House::buildYear,
            'wc' => $this->getWcId(0),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'communication' => [
                $this->getCommunicationsId(0),
                $this->getCommunicationsId(1),
                $this->getCommunicationsId(2),
                $this->getCommunicationsId(3),
                $this->getCommunicationsId(4),
                $this->getCommunicationsId(5),
                $this->getCommunicationsId(6),
                $this->getCommunicationsId(7)
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],
            'schema' => $schema
        ]);

        $realtyHouse = $this->restModule->grabResponse();
        $realtyHouseId = json_decode($realtyHouse)->id;
        file_put_contents(codecept_data_dir('realtyHouseId.json'), $realtyHouseId);
        $this->debugSection('realtyHouseId', $realtyHouseId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }
    function realtyHouseAddSearch()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/add', [
            'category' => $this->getCategoryId(1),
            'categoryType' => $this->getHouseCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(3),
            'street' => $this->getStreetId(52),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::searchLatitude,
            'longitude' => House::searchLongitude,
            'roomCount' => House::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(10),
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => House::livingArea,
            'kitchenArea' => House::kitchenArea,
            'landArea' => House::landArea,
            'landAreaUnit' => $this->getAreaUnitsId(1),
            'floorNumber' => House::floors,
            'buildYear' => House::buildYear,
            'wc' => $this->getWcId(0),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'communication' => [
                $this->getCommunicationsId(0)],
            'nearObjects' => [
                $this->getNearObjectsId(0)]
//            'schema' => $schema
        ]);

        $realtyHouse = $this->restModule->grabResponse();
        $realtyHouseId = json_decode($realtyHouse)->id;
        file_put_contents(codecept_data_dir('realtyHouseId.json'), $realtyHouseId);
        $this->debugSection('realtyHouseId', $realtyHouseId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }


    function realtyHousesCheck()
    {

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/check', [
            'category' => $this->getCategoryId(1),
            'categoryType' => $this->getHouseCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(94),
            'houseNumber' => House::$currentHouseNumber
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType(['id' => 'string']);
    }

    function realtyHousesValidate()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/validate', [
            'category' => $this->getCategoryId(1),
            'categoryType' => $this->getHouseCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(2),
            'street' => $this->getStreetId(94),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::latitude,
            'longitude' => House::longitude,
            'roomCount' => House::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(10),
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => House::livingArea,
            'kitchenArea' => House::kitchenArea,
            'landArea' => House::landArea,
            'landAreaUnit' => $this->getAreaUnitsId(1),
            'floorNumber' => House::floors,
            'buildYear' => House::buildYear,
            'wc' => $this->getWcId(0),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'communication' => [$this->getCommunicationsId(0), $this->getCommunicationsId(1)],
            'nearObjects' => [$this->getNearObjectsId(0), $this->getNearObjectsId(1), $this->getNearObjectsId(2)]
        ]);

        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'category' => 'string',
            'categoryType' => 'string',
            'region' => 'string',
            'city' => 'string',
            'district' => 'string',
            'street' => 'string',
            'houseNumber' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
            'roomCount' => 'integer',
            'wallMaterial' => 'string',
            'area' => 'integer',
            'areaUnit' => 'string',
            'livingArea' => 'integer',
            'kitchenArea' => 'integer',
            'landArea' => 'integer',
            'landAreaUnit' => 'string',
            'floorNumber' => 'integer',
            'buildYear' => 'integer',
            'wc' => 'string',
            'heating' => 'string',
            'waterHeating' => 'string',
            'communication' => 'array',
            'nearObjects' => 'array'
        ]);
    }

    function realtyHousesEdit()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $realtyHouseID = file_get_contents(codecept_data_dir('realtyHouseId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/houses/edit/' . $realtyHouseID, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(21),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::editLatitude,
            'longitude' => House::editLongitude,
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => House::editLivingArea,
            'kitchenArea' => House::editKitchenArea,
            'landArea' => House::editLandArea,
            'landAreaUnit' => $this->getAreaUnitsId(1),
            'roomCount' => House::editRoomCount,
            'wallMaterial' => $this->getWallMaterialsId(1),
            'floorNumber' => House::editFloors,
            'buildYear' => House::editBuildYear,
            'wc' => $this->getWcId(1),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'communication' => [
                $this->getCommunicationsId(0),
                $this->getCommunicationsId(1),
                $this->getCommunicationsId(2),
                $this->getCommunicationsId(3),
                $this->getCommunicationsId(4),
                $this->getCommunicationsId(5),
                $this->getCommunicationsId(6),
                $this->getCommunicationsId(7)
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],
            'schema' => $schema
        ]);

        $realtyHouse = $this->restModule->grabResponse();
        $realtyEditHouseId = json_decode($realtyHouse)->id;
        if ($realtyHouseID === $realtyEditHouseId) {
            file_put_contents(codecept_data_dir('realtyHouseId.json'), $realtyEditHouseId);
        }

        $this->debugSection('realtyEditHouseId', $realtyEditHouseId);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
    }

    function realtyHousesDelete()
    {
        $realtyHouseID = file_get_contents(codecept_data_dir('realtyHouseId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/realties/' . $realtyHouseID . '/delete');
        $realtyHouseDelete = $this->restModule->grabResponse();
        $this->debugSection('realtyHouseDelete', $realtyHouseDelete);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
    }

    /*========================================= PARCELS =========================================*/

    function realtyParcelAddPlain()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/add', [
            'category' => $this->getCategoryId(2),
            'categoryType' => $this->getParcelCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
//            'district' => $this->getDistrictId(7),
//            'street' => $this->getStreetId(32),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::latitude,
            'longitude' => Parcel::longitude,
            'area' => Parcel::generalArea,
            'areaUnit' => $this->getAreaUnitsId(1),
//            'communication' => [$this->getCommunicationsId(0), $this->getCommunicationsId(6)],
//            'nearObjects' => [$this->getNearObjectsId(0), $this->getNearObjectsId(3)]
        ]);

        $realtyParcel = $this->restModule->grabResponse();
        $realtyParcelId = json_decode($realtyParcel)->id;
        file_put_contents(codecept_data_dir('realtyParcelId.json'), $realtyParcelId);
        $this->debugSection('realtyParcelId', $realtyParcelId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }

    function realtyParcelAddComplex()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/add', [
            'category' => $this->getCategoryId(2),
            'categoryType' => $this->getParcelCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(32),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::latitude,
            'longitude' => Parcel::longitude,
            'area' => Parcel::generalArea,
            'areaUnit' => $this->getAreaUnitsId(1),
            'communication' => [
                $this->getCommunicationsId(0),
                $this->getCommunicationsId(1),
                $this->getCommunicationsId(2),
                $this->getCommunicationsId(3),
                $this->getCommunicationsId(4),
                $this->getCommunicationsId(5),
                $this->getCommunicationsId(6),
                $this->getCommunicationsId(7)
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],
            'schema' => $schema
        ]);

        $realtyParcel = $this->restModule->grabResponse();
        $realtyParcelId = json_decode($realtyParcel)->id;
        file_put_contents(codecept_data_dir('realtyParcelId.json'), $realtyParcelId);
        $this->debugSection('realtyParcelId', $realtyParcelId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }

    function realtyParcelAddSearch()
    {
//        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/add', [
            'category' => $this->getCategoryId(2),
            'categoryType' => $this->getParcelCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(32),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::searchLatitude,
            'longitude' => Parcel::searchLongitude,
            'area' => Parcel::generalArea,
            'areaUnit' => $this->getAreaUnitsId(1),
            'communication' => [$this->getCommunicationsId(0)],
            'nearObjects' => [$this->getNearObjectsId(0)],
//            'schema' => $schema
        ]);

        $realtyParcel = $this->restModule->grabResponse();
        $realtyParcelId = json_decode($realtyParcel)->id;
        file_put_contents(codecept_data_dir('realtyParcelId.json'), $realtyParcelId);
        $this->debugSection('realtyParcelId', $realtyParcelId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }

    function realtyParcelsCheck()
    {
        $cadastr = file_get_contents(codecept_data_dir('cadastral_number.txt'));
        $cadastrNumb = str_replace(':', '', $cadastr);
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/check', [
            'category' => $this->getCategoryId(2),
            'categoryType' => $this->getParcelCategoryTypeId(0),
//            'cadastralNumber' => Parcel::$currentCadastralNumber
            'cadastralNumber' => $cadastrNumb


        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType(['id' => 'string']);
    }

    function realtyParcelsValidate()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/validate', [
            'category' => $this->getCategoryId(2),
            'categoryType' => $this->getParcelCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(32),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::latitude,
            'longitude' => Parcel::longitude,
            'area' => Parcel::generalArea,
            'areaUnit' => $this->getAreaUnitsId(1),
            'communication' => [$this->getCommunicationsId(0), $this->getCommunicationsId(1)],
            'nearObjects' => [$this->getNearObjectsId(0), $this->getNearObjectsId(1), $this->getNearObjectsId(2)]
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'category' => 'string',
            'categoryType' => 'string',
            'region' => 'string',
            'city' => 'string',
            'district' => 'string',
            'street' => 'string',
            'cadastralNumber' => 'string',
            'latitude' => 'float',
            'longitude' => 'float',
            'area' => 'integer',
            'areaUnit' => 'string',
            'communication' => 'array',
            'nearObjects' => 'array'
        ]);
    }

    function realtyParcelsEdit()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $realtyParcelID = file_get_contents(codecept_data_dir('realtyParcelId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/parcels/edit/' . $realtyParcelID, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(25),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::editLatitude,
            'longitude' => Parcel::editLongitude,
            'area' => Parcel::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(2),
            'communication' => [
                $this->getCommunicationsId(0),
                $this->getCommunicationsId(1),
                $this->getCommunicationsId(2),
                $this->getCommunicationsId(3),
                $this->getCommunicationsId(4),
                $this->getCommunicationsId(5),
                $this->getCommunicationsId(6),
                $this->getCommunicationsId(7)
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],
            'schema' => $schema
        ]);

        $realtyParcel = $this->restModule->grabResponse();
        $realtyParcelEditId = json_decode($realtyParcel)->id;
        if ($realtyParcelEditId === $realtyParcelID) {
            file_put_contents(codecept_data_dir('realtyParcelId.json'), $realtyParcelEditId);
        }
        $this->debugSection('realtyParcelId', $realtyParcelEditId);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
    }

    function realtyParcelsDelete()
    {
        $realtyParcelsID = file_get_contents(codecept_data_dir('realtyParcelId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/realties/' . $realtyParcelsID . '/delete');
        $realtyParcelDelete = $this->restModule->grabResponse();
        $this->debugSection('realtyParcelDelete', $realtyParcelDelete);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
    }

    /*========================================= COMMERCIALS =========================================*/

    function realtyCommercialAddPlain()
    {
//        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/add', [
            'category' => $this->getCategoryId(3),
            'categoryType' => $this->getCommercialCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(97),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::latitude,
            'longitude' => Commercial::longitude,
            'area' => Commercial::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'effectiveArea' => Commercial::effectiveArea,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'roomCount' => Commercial::roomCount,
            'floor' => Commercial::floors,
            'floorNumber' => Commercial::floorNumber,
            'wc' => $this->getWcId(0),
            'heating' => $this->getHeatingsId(0),
            'waterHeating' => $this->getWaterHeatingsId(0),
        ]);

        $realtyCommercial = $this->restModule->grabResponse();
        $realtyCommercialId = json_decode($realtyCommercial)->id;
        file_put_contents(codecept_data_dir('realtyCommercialId.json'), $realtyCommercialId);
        $this->debugSection('realtyCommercialId', $realtyCommercialId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }

    function realtyCommercialAddComplex()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/add', [
            'category' => $this->getCategoryId(3),
            'categoryType' => $this->getCommercialCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(39),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::latitude,
            'longitude' => Commercial::longitude,
            'area' => Commercial::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'effectiveArea' => Commercial::effectiveArea,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'roomCount' => Commercial::roomCount,
            'floor' => Commercial::floorNumber,
            'floorNumber' => Commercial::floors,
            'buildYear' => Commercial::buildYear,
            'wc' => $this->getWcId(2),
            'heating' => $this->getHeatingsId(2),
            'waterHeating' => $this->getWaterHeatingsId(2),
            'communication' => [
                $this->getCommunicationsId(0),
                $this->getCommunicationsId(1),
                $this->getCommunicationsId(2),
                $this->getCommunicationsId(3),
                $this->getCommunicationsId(4),
                $this->getCommunicationsId(5),
                $this->getCommunicationsId(6),
                $this->getCommunicationsId(7)
            ],
            'schema' => $schema
        ]);

        $realtyCommercial = $this->restModule->grabResponse();
        $realtyCommercialId = json_decode($realtyCommercial)->id;
        file_put_contents(codecept_data_dir('realtyCommercialId.json'), $realtyCommercialId);
        $this->debugSection('realtyCommercialId', $realtyCommercialId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }

    function realtyCommercialAddSearch()
    {
//        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/add', [
            'category' => $this->getCategoryId(3),
            'categoryType' => $this->getCommercialCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(49),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::searchLatitude,
            'longitude' => Commercial::searchLongitude,
            'area' => Commercial::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'effectiveArea' => Commercial::effectiveArea,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'roomCount' => Commercial::roomCount,
            'floor' => Commercial::floorNumber,
            'floorNumber' => Commercial::floors,
            'buildYear' => Commercial::buildYear,
            'wc' => $this->getWcId(2),
            'heating' => $this->getHeatingsId(2),
            'waterHeating' => $this->getWaterHeatingsId(2),
            'communication' => [$this->getCommunicationsId(0)],
//            'schema' => $schema
        ]);

        $realtyCommercial = $this->restModule->grabResponse();
        $realtyCommercialId = json_decode($realtyCommercial)->id;
        file_put_contents(codecept_data_dir('realtyCommercialId.json'), $realtyCommercialId);
        $this->debugSection('realtyCommercialId', $realtyCommercialId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }
    /*============================================GARAGES======================================*/

    function realtyGarageAddPlain()
    {

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/garages/add', [
            'category' => $this->getCategoryId(4),
            'categoryType' => $this->getGaragesCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(201),
            'houseNumber' => Garage::houseNumber,
            'garageNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Garage::latitude,
            'longitude' => Garage::longitude,
            'roomCount' => Garage::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'area' => Garage::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'floor' => Garage::floor,
            'floorNumber' => Garage::floorNumber,
            'heating' => $this->getHeatingsId(0),

//            'inspectionPit'=>Garage::inspectionPit0,

//            'nearObjects' => [$this->getNearObjectsId(0), $this->getNearObjectsId(1), $this->getNearObjectsId(5)],
//            'schema' => $schema
        ]);

        $realtyGarage = $this->restModule->grabResponse();
        $realtyGarageId = json_decode($realtyGarage)->id;
        file_put_contents(codecept_data_dir('realtyGarageId.json'), $realtyGarageId);
        $this->debugSection('realtyGarageId', $realtyGarageId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }

    function realtyGarageAddComplex()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/garages/add', [
            'category' => $this->getCategoryId(4),
            'categoryType' => $this->getGaragesCategoryTypeId(1),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(16),
            'street' => $this->getStreetId(201),
            'houseNumber' => Garage::houseNumber,
            'garageNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Garage::latitude,
            'longitude' => Garage::longitude,
            'roomCount' => Garage::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'area' => Garage::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'floor' => Garage::floor,
            'floorNumber' => Garage::floorNumber,
            'inspectionPit'=> $this->getInspectionPitId(0),
            'parkingPlace' => $this->getParkingPlaceId(0),
            'transportType' =>$this->getTransportTypeId(0),
            'buildYear' => Garage::buildYear,
            'heating' => $this->getHeatingsId(1),
            'communication' => [
                $this->getCommunicationsId(0),
                $this->getCommunicationsId(1),
                $this->getCommunicationsId(2),
                $this->getCommunicationsId(3),
                $this->getCommunicationsId(4),
                $this->getCommunicationsId(5),
                $this->getCommunicationsId(6),
                $this->getCommunicationsId(7)
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],
            'schema' => $schema
        ]);

        $realtyGarage = $this->restModule->grabResponse();
        $realtyGarageId = json_decode($realtyGarage)->id;
        file_put_contents(codecept_data_dir('realtyGarageId.json'), $realtyGarageId);
        $this->debugSection('realtyGarageId', $realtyGarageId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }
    function realtyGarageAddForSearch()
    {
//        $schema = file_get_contents(codecept_data_dir('schema_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/garages/add', [
            'category' => $this->getCategoryId(4),
            'categoryType' => $this->getGaragesCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(16),
            'street' => $this->getStreetId(201),
            'houseNumber' => Garage::houseNumber,
            'garageNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Garage::latitude,
            'longitude' => Garage::longitude,
            'roomCount' => Garage::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'area' => Garage::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'floor' => Garage::floor,
            'floorNumber' => Garage::floorNumber,
            'buildYear' => Garage::buildYear,
            'inspectionPit'=> $this->getInspectionPitId(0),
            'parkingPlace' => $this->getParkingPlaceId(0),
            'transportType' =>$this->getTransportTypeId(0),
            'heating' => $this->getHeatingsId(0),
            'communication' => [$this->getCommunicationsId(0)],
            'nearObjects' => [$this->getNearObjectsId(0)]
//            'schema' => $schema
        ]);

        $realtyGarage = $this->restModule->grabResponse();
        $realtyGarageId = json_decode($realtyGarage)->id;
        file_put_contents(codecept_data_dir('realtyGarageId.json'), $realtyGarageId);
        $this->debugSection('realtyGarageId', $realtyGarageId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();

    }

    function realtyGarageCheck()
    {
        $flatNumbs = file_get_contents(codecept_data_dir('flat_numbers.json'));
        $flatNumber = json_decode($flatNumbs)[0]->number;
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/garages/check', [
            'category' => $this->getCategoryId(4),
            'categoryType' => $this->getGaragesCategoryTypeId(1),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(201),
            'houseNumber' => Garage::houseNumber,
//            'garageNumber' => Flat::$currentFlatNumber
            'garageNumber' => $flatNumber

        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType(['id' => 'string']);

    }

    function realtyGarageValidate()
    {

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/garages/validate', [
            'category' => $this->getCategoryId(4),
            'categoryType' => $this->getGaragesCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(16),
            'street' => $this->getStreetId(201),
            'houseNumber' => Garage::houseNumber,
            'garageNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Garage::latitude,
            'longitude' => Garage::longitude,
            'roomCount' => Garage::roomCount,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'area' => Garage::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'floor' => Garage::floor,
            'floorNumber' => Garage::floorNumber,
            'buildYear' => Garage::buildYear,
            'heating' => $this->getHeatingsId(1),
            'inspectionPit'=> $this->getInspectionPitId(0),
            'parkingPlace' => $this->getParkingPlaceId(0),
            'transportType' =>$this->getTransportTypeId(0),
            'communication' => [
                $this->getCommunicationsId(0),
                $this->getCommunicationsId(1),

            ],
            'nearObjects' => [$this->getNearObjectsId(0), $this->getNearObjectsId(1)]

        ]);

        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'category' => 'string',
            'categoryType' => 'string',
            'region' => 'string',
            'city' => 'string',
            'district' => 'string',
            'street' => 'string',
            'houseNumber' => 'integer',
            'garageNumber' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
            'roomCount' => 'integer',
            'wallMaterial' => 'string',
            'area' => 'integer',
            'areaUnit' => 'string',
            'floor' => 'integer',
            'floorNumber' => 'integer',
            'buildYear' => 'integer',
            'inspectionPit'=> 'string',
            'parkingPlace' => 'string',
            'transportType' =>'string',
            'heating' => 'string',
            'nearObjects' => 'array',
            'communication' => 'array',
        ]);
    }

    function realtyGarageEdit() //previously you should execute function realtyFlatAdd(Plain or Complex)
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $realtyGarageID = file_get_contents(codecept_data_dir('realtyGarageId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/garages/edit/' . $realtyGarageID, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(0),
            'street' => $this->getStreetId(0),
            'houseNumber' => House::uniqueHouseNumber(),
            'garageNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Garage::editLatitude,
            'longitude' => Garage::editLongitude,
            'roomCount' => Garage::editRoomCount,
            'wallMaterial' => $this->getWallMaterialsId(2),
            'area' => Garage::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'floor' => Garage::editFloor,
            'floorNumber' => Garage::editFloorNumber,
            'buildYear' => Garage::editBuildYear,
            'heating' => $this->getHeatingsId(2),
            'inspectionPit'=> $this->getInspectionPitId(1),
            'parkingPlace' => $this->getParkingPlaceId(1),
            'transportType' =>$this->getTransportTypeId(1),
            'communication' => [
                $this->getCommunicationsId(0),
                $this->getCommunicationsId(1),
                $this->getCommunicationsId(2),
                $this->getCommunicationsId(3),
                $this->getCommunicationsId(4),
                $this->getCommunicationsId(5),
                $this->getCommunicationsId(6),
                $this->getCommunicationsId(7)
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],
            'schema' => $schema
        ]);


        $realtyGarage = $this->restModule->grabResponse();
        $realtyGarageId = json_decode($realtyGarage)->id;
        if ($realtyGarageID === $realtyGarageId) {
            file_put_contents(codecept_data_dir('realtyGarageId.json'), $realtyGarageId);
        }
        $this->debugSection('realtyGarageId', $realtyGarageId);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
    }

    function realtyGarageDelete()
    {
        $realtyGarageID = file_get_contents(codecept_data_dir('realtyGarageId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/realties/' . $realtyGarageID . '/delete');
        $realtyGarageDelete = $this->restModule->grabResponse();
        $this->debugSection('realtyGarageDelete', $realtyGarageDelete);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
    }

    /*==============================================SEARCH API=========================================================*/
    function apiFlatSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&userIds[0]='.$agencyID.'&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('id' => User::getFlatId()));
        $search = $this->restModule->grabResponse();
        $this->debugSection('realtyFlatId', $search);

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(22).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(5).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(8).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(35).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(1).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSell.'&priceTo='.Flat::priceFlatSell.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(1).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::editBuildYear.'&buildYearTo='.Flat::editBuildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::editBeds.'&bedsCountTo='.Flat::editBeds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(1).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(1).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(2).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::editGeneralArea.'&areaTo='.Flat::editGeneralArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::editLivingArea.'&livingAreaTo='.Flat::editLivingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::editKitchenArea.'&kitchenAreaTo='.Flat::editKitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::editRoomCount.'&roomCountTo='.Flat::editRoomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::editFloorNumber.'&floorTo='.Flat::editFloorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::editFloors.'&floorNumberFrom='.Flat::editFloors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(1).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(1).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(1).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(34).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketTypeId(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&balcony='.$this->getBalconiesId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getFlatAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(1));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getFlatId()));

    }

    function apiHouseSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('id' => User::getHouseId()));
        $searchHouse = $this->restModule->grabResponse();
        $this->debugSection('Search', $searchHouse);


        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(22).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(5).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(4).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(53).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(1).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.House::editPriceHouseRent.'&priceTo='.House::editPriceHouseRent.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(0).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::editBuildYear.'&buildYearTo='.House::editBuildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(9).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(1).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::editGeneralArea.'&areaTo='.House::editGeneralArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&livingAreaFrom='.House::editLivingArea.'&livingAreaTo='.House::editLivingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::editKitchenArea.'&kitchenAreaTo='.House::editKitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::editRoomCount.'&roomCountTo='.House::editRoomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::editFloors.'&floorNumberFrom='.House::editFloors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(1).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(1).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(1).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(3).'&street='.$this->getStreetId(52).'&category='.$this->getCategoryId(1).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriodId(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterialsId(10).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(0).'&heating='.$this->getHeatingsId(1).'&waterHeating='.$this->getWaterHeatingsId(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnituresId(0).'&appliances[0]='.$this->getAppliancesId(0).'&additionally[0]='.$this->getHouseAdditionalsId(0).'&nearObjects[0]='.$this->getNearObjectsId(1));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getHouseId()));

    }

    function apiParcelSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('id' => User::getParcelId()));
        $searchParcel = $this->restModule->grabResponse();
        $this->debugSection('Search', $searchParcel);

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(22).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(5).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(4).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(37).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(1).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Parcel::editPriceParcelSell.'&priceTo='.Parcel::editPriceParcelSell.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]=56681324d69b5a3e1c8b456c&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::editGeneralArea.'&areaTo='.Parcel::editGeneralArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(1).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(1).'&nearObjects[0]='.$this->getNearObjectsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(32).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getParcelCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getParcelAdditionalsID(0).'&nearObjects[0]='.$this->getNearObjectsId(1));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getParcelId()));





    }

    function apiCommercialSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('id' => User::getCommercialId()));
        $search = $this->restModule->grabResponse();
        $this->debugSection('Commercial', $search);

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(22).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(5).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(8).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(45).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(2).'&categoryType='.$this->getHouseCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(2).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSell.'&priceTo='.Commercial::priceCommercialSell.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(1).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]=56681324d69b5a3e1c8b456c&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::editBuildYear.'&buildYearTo='.Commercial::editBuildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(1).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(1).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(1).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(3).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(3).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::editGeneralArea.'&areaTo='.Commercial::editGeneralArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::editRoomCount.'&roomCountTo='.Commercial::editRoomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::editFloorNumber.'&floorTo='.Commercial::editFloorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::editFloor.'&floorNumberFrom='.Commercial::editFloor.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(1).'&additionally[0]='.$this->getCommercialAdditionalsId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(7).'&street='.$this->getStreetId(49).'&category='.$this->getCategoryId(3).'&categoryType='.$this->getCommercialCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriodId(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&repair='.$this->getRepairsId(0).'&wc='.$this->getWcId(2).'&heating='.$this->getHeatingsId(2).'&waterHeating='.$this->getWaterHeatingsId(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunicationsId(0).'&additionally[0]='.$this->getCommercialAdditionalsId(1));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getCommercialId()));



    }

    function apiGarageSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('id' => User::getGarageId()));
        $search = $this->restModule->grabResponse();
        $this->debugSection('realtyGarageId', $search);

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(1).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(22).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(5).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(17).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(202).'&category='.$this->getCategoryId(0).'&categoryType='.$this->getFlatCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(1).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(1).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSell.'&priceTo='.Garage::priceGarageSell.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::editBuildYear.'&buildYearTo='.Garage::editBuildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(1).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(1).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::editGeneralArea.'&areaTo='.Garage::editGeneralArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(1).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::editRoomCount.'&roomCountTo='.Garage::editRoomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::editFloor.'&floorTo='.Garage::editFloor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::editFloorNumber.'&floorNumberFrom='.Garage::editFloorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(1).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(1).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(1).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(1).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(1).'&transportType='.$this->getTransportTypeId(0));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationTypeId(0).'&region='.$this->getRegionId(21).'&city='.$this->getCityId(6).'&district='.$this->getDistrictId(16).'&street='.$this->getStreetId(201).'&category='.$this->getCategoryId(4).'&categoryType='.$this->getGaragesCategoryTypeId(0).'&currency='.$this->getCurrencyId(0).'&priceFrom='.Garage::priceGarageSearch.'&priceTo='.Garage::priceGarageSearch.'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.Garage::buildYear.'&buildYearTo='.Garage::buildYear.'&wallMaterial='.$this->getWallMaterialsId(0).'&heating='.$this->getHeatingsId(0).'&areaFrom='.Garage::generalArea.'&areaTo='.Garage::generalArea.'&areaUnit='.$this->getAreaUnitsId(0).'&roomCountFrom='.Garage::roomCount.'&roomCountTo='.Garage::roomCount.'&floorFrom='.Garage::floor.'&floorTo='.Garage::floor.'&floorNumberTo='.Garage::floorNumber.'&floorNumberFrom='.Garage::floorNumber.'&additionally[0]='.$this->getGarageAdditionalsId(0).'&communication[0]='.$this->getCommunicationsId(0).'&nearObjects[0]='.$this->getNearObjectsId(0).'&inspectionPit='.$this->getInspectionPitId(0).'&parkingPlace='.$this->getParkingPlaceId(0).'&transportType='.$this->getTransportTypeId(1));
        $this->restModule->dontSeeResponseContainsJson(array('id' => User::getGarageId()));

    }

    //--------------------------------------Save search-----------------------//
    function apiAgencySaveFlatSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/searches/create', [
           'name' => 'TestFlat',
            'searchCriteria' => [
                'operationType'=> $this->getOperationTypeId(0),
                'region' => $this->getRegionId(21),
                'city' => $this->getCityId(6),
                'district' => $this->getDistrictId(7),
                'street' => $this->getStreetId(34),
                'coordinatesLatitude' => [Flat::latitude, Flat::searchLatitude, House::latitude],
                'coordinatesLongitude' => [Flat::longitude, Flat::searchLongitude, House::longitude],
                'category' => $this->getCategoryId(0),
                'categoryType' => $this->getFlatCategoryTypeId(0),
                'currency' => $this->getCurrencyId(0),
                'priceFrom' => Flat::priceFlatSell,
                'priceTo' => Flat::priceFlatSearch,
                'auction' => true,
                'userIds'=> [$agencyID],
                'marketType'=> $this->getMarketTypeId(0),
                'buildYearFrom' => Flat::buildYear,
                'buildYearTo' => Flat::buildYear,
                'bedsCountFrom' => Flat::beds,
                'bedsCountTo' => Flat::beds,
                'wallMaterial' => $this->getWallMaterialsId(0),
                'repair' => $this->getRepairsId(0),
                'wc' => $this->getWcId(1),
                'balcony' => $this->getBalconiesId(1),
                'heating' => $this->getHeatingsId(1),
                'waterHeating' => $this->getWaterHeatingsId(1),
                'areaFrom' => Flat::generalArea,
                'areaTo' => Flat::generalArea,
                'areaUnit' => $this->getAreaUnitsId(0),
                'livingAreaFrom' => Flat::livingArea,
                'livingAreaTo' => Flat::livingArea,
                'kitchenAreaFrom' => Flat::kitchenArea,
                'kitchenAreaTo' => Flat::kitchenArea,
                'roomCountFrom' => Flat::roomCount,
                'roomCountTo' => Flat::roomCount,
                'floorFrom' => Flat::floorNumber,
                'floorTo' => Flat::floorNumber,
                'floorNumberTo' => Flat::floors,
                'floorNumberFrom' => Flat::floors,
                'furniture' => [$this->getFurnituresId(0)],
                'appliances' => [$this->getAppliancesId(0)],
                'additionally' => [$this->getFlatAdditionalsId(0)],
                'nearObjects' => [$this->getNearObjectsId(0)],
            ]
        ]);
        $saveSearchFlat = $this->restModule->grabResponse();
        $saveSearchFlatId = json_decode($saveSearchFlat)->id;
        file_put_contents(codecept_data_dir('saveSearchFlatId.json'), $saveSearchFlatId);
        $this->debugSection('saveSearchFlatId', $saveSearchFlatId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }
    function apiAgencySaveFlatSearchPlain()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/searches/create', [
            'name' => 'TestFlatPlain',
            'searchCriteria' => [
                'operationType'=> $this->getOperationTypeId(0),
                'region' => $this->getRegionId(21),
                'category' => $this->getCategoryId(0),
                'categoryType' => $this->getFlatCategoryTypeId(0),
            ]
        ]);
        $saveSearchFlat = $this->restModule->grabResponse();
        $saveSearchFlatId = json_decode($saveSearchFlat)->id;
        file_put_contents(codecept_data_dir('saveSearchFlatId.json'), $saveSearchFlatId);
        $this->debugSection('saveSearchFlatId', $saveSearchFlatId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }
    function apiAgencySaveHouseSearch()
    {
            $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
            $this->restModule->haveHttpHeader('token', User::getAgencyToken());
            $this->restModule->haveHttpHeader('Content-Type', 'application/json');
            $this->restModule->sendPOST('/profiles/searches/create', [
                'name' => 'TestHouse',
                'searchCriteria' => [
                    'operationType' => $this->getOperationTypeId(1),
                    'region' => $this->getRegionId(21),
                    'city' => $this->getCityId(6),
                    'district' => $this->getDistrictId(3),
                    'street' => $this->getStreetId(52),
                    'category' => $this->getCategoryId(1),
                    'categoryType' => $this->getHouseCategoryTypeId(0),
                    'currency' => $this->getCurrencyId(1),
                    'priceFrom' => House::priceHouseSearch,
                    'priceTo' => House::priceHouseSearch,
                    'period' => $this->getPeriodId(1),
                    'auction' =>true,
                    'userIds' => [$agencyID],
                    'buildYearFrom' => House::buildYear,
                    'buildYearTo' => House::buildYear,
                    'wallMaterial' => $this->getWallMaterialsId(10),
                    'repair' => $this->getRepairsId(0),
                    'wc' => $this->getWcId(0),
                    'heating' => $this->getHeatingsId(1),
                    'waterHeating' => $this->getWaterHeatingsId(1),
                    'areaFrom' => House::generalArea,
                    'areaTo' => House::generalArea,
                    'areaUnit' => $this->getAreaUnitsId(0),
                    'livingAreaFrom' => House::livingArea,
                    'livingAreaTo' => House::livingArea,
                    'kitchenAreaFrom' => House::kitchenArea,
                    'kitchenAreaTo' => House::kitchenArea,
                    'roomCountFrom' => House::roomCount,
                    'roomCountTo' => House::roomCount,
                    'floorNumberTo' => House::floors,
                    'floorNumberFrom' => House::floors,
                    'furniture' => [$this->getFurnituresId(0)],
                    'appliances' => [$this->getAppliancesId(0)],
                    'additionally' => [$this->getHouseAdditionalsId(0)],
                    'nearObjects' => [$this->getNearObjectsId(0)]

                ]
                ]);
            $saveSearchFlat = $this->restModule->grabResponse();
            $saveSearchFlatId = json_decode($saveSearchFlat)->id;
            file_put_contents(codecept_data_dir('saveSearchFlatId.json'), $saveSearchFlatId);
            $this->debugSection('saveSearchFlatId', $saveSearchFlatId);
            $this->restModule->seeResponseCodeIs(201);
            $this->restModule->seeResponseIsJson();
    }
    function apiAgencySaveParcelSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/searches/create', [
            'name' => 'TestParcel',
            'searchCriteria' => [
                'operationType' => $this->getOperationTypeId(0),
                'region' => $this->getRegionId(21),
                'city' => $this->getCityId(6),
                'district' => $this->getDistrictId(7),
                'street' => $this->getStreetId(32),
                'category' => $this->getCategoryId(2),
                'categoryType' => $this->getParcelCategoryTypeId(0),
                'currency' => $this->getCurrencyId(0),
                'priceFrom' => Parcel::priceParcelSearch,
                'priceTo' => Parcel::priceParcelSearch,
                'auction' => true,
                'userIds' => [$agencyID],
                'areaFrom' => Parcel::generalArea,
                'areaTo' => Parcel::generalArea,
                'areaUnit' => $this->getAreaUnitsId(1),
                'communication' => [$this->getCommunicationsId(0)],
                'additionally' => [$this->getParcelAdditionalsID(0)],
                'nearObjects' => [$this->getNearObjectsId(0)],
                ]
        ]);
        $saveSearchFlat = $this->restModule->grabResponse();
        $saveSearchFlatId = json_decode($saveSearchFlat)->id;
        file_put_contents(codecept_data_dir('saveSearchFlatId.json'), $saveSearchFlatId);
        $this->debugSection('saveSearchFlatId', $saveSearchFlatId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }
    function apiAgencySaveCommercialSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/searches/create', [
            'name' => 'TestCommercial',
            'searchCriteria' => [
                'operationType' => $this->getOperationTypeId(1),
                'region' => $this->getRegionId(21),
                'city' => $this->getCityId(6),
                'district' => $this->getDistrictId(7),
                'street' => $this->getStreetId(49),
                'category' => $this->getCategoryId(3),
                'categoryType' => $this->getCommercialCategoryTypeId(0),
                'currency' => $this->getCurrencyId(1),
                'priceFrom' => Commercial::priceCommercialSearch,
                'priceTo' => Commercial::priceCommercialSearch,
                'auction' => true,
                'period' => $this->getPeriodId(0),
                'userIds' => [$agencyID],
                'buildYearFrom' => Commercial::buildYear,
                'buildYearTo' => Commercial::buildYear,
                'wallMaterial' => $this->getWallMaterialsId(0),
                'repair' => $this->getRepairsId(0),
                'wc' => $this->getWcId(2),
                'heating' => $this->getHeatingsId(2),
                'waterHeating' => $this->getWaterHeatingsId(2),
                'areaFrom' => Commercial::generalArea,
                'areaTo' => Commercial::generalArea,
                'areaUnit' => $this->getAreaUnitsId(0),
                'roomCountFrom' => Commercial::roomCount,
                'roomCountTo' => Commercial::roomCount,
                'floorFrom' => Commercial::floorNumber,
                'floorTo' => Commercial::floorNumber,
                'floorNumberTo' => Commercial::floors,
                'floorNumberFrom' => Commercial::floors,
                'communication' => [$this->getCommunicationsId(0)],
                'additionally' => [$this->getCommercialAdditionalsId(0)],
            ]
        ]);
        $saveSearchFlat = $this->restModule->grabResponse();
        $saveSearchFlatId = json_decode($saveSearchFlat)->id;
        file_put_contents(codecept_data_dir('saveSearchFlatId.json'), $saveSearchFlatId);
        $this->debugSection('saveSearchFlatId', $saveSearchFlatId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }
    function apiAgencyViewSaveSearch()
    {
        $searchId = file_get_contents(codecept_data_dir('saveSearchFlatId.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/profiles/searches/'.$searchId);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();

    }
    function apiAgencyEditSaveSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $searchId = file_get_contents(codecept_data_dir('saveSearchFlatId.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/profiles/searches/'.$searchId.'/edit', [
            'name' => 'EditTestFlat',
            'searchCriteria' => [
                'operationType'=> $this->getOperationTypeId(0),
                'region' => $this->getRegionId(21),
                'city' => $this->getCityId(6),
                'district' => $this->getDistrictId(7),
                'street' => $this->getStreetId(34),
                'category' => $this->getCategoryId(0),
                'categoryType' => $this->getFlatCategoryTypeId(0),
                'currency' => $this->getCurrencyId(0),
                'priceFrom' => Flat::priceFlatSearch,
                'priceTo' => Flat::priceFlatSearch,
                'auction' => true,
                'userIds'=> [$agencyID],
                'marketType'=> $this->getMarketTypeId(0),
                'buildYearFrom' => Flat::buildYear,
                'buildYearTo' => Flat::buildYear,
                'bedsCountFrom' => Flat::beds,
                'bedsCountTo' => Flat::beds,
                'wallMaterial' => $this->getWallMaterialsId(0),
                'repair' => $this->getRepairsId(0),
                'wc' => $this->getWcId(1),
                'balcony' => $this->getBalconiesId(1),
                'heating' => $this->getHeatingsId(1),
                'waterHeating' => $this->getWaterHeatingsId(1),
                'areaFrom' => Flat::generalArea,
                'areaTo' => Flat::generalArea,
                'areaUnit' => $this->getAreaUnitsId(0),
                'livingAreaFrom' => Flat::livingArea,
                'livingAreaTo' => Flat::livingArea,
                'kitchenAreaFrom' => Flat::kitchenArea,
                'kitchenAreaTo' => Flat::kitchenArea,
                'roomCountFrom' => Flat::roomCount,
                'roomCountTo' => Flat::roomCount,
                'floorFrom' => Flat::floorNumber,
                'floorTo' => Flat::floorNumber,
                'floorNumberTo' => Flat::floors,
                'floorNumberFrom' => Flat::floors,
                'furniture' => [$this->getFurnituresId(0)],
                'appliances' => [$this->getAppliancesId(0)],
                'additionally' => [$this->getFlatAdditionalsId(0)],
                'nearObjects' => [$this->getNearObjectsId(0)],
                ]
        ]);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();

    }
    function apiAgencyViewSaveSearchList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/profiles/searches/');
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
    }
    function apiAgencyDeleteSaveSearch()
    {
        $searchId = file_get_contents(codecept_data_dir('saveSearchFlatId.json'));
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/profiles/searches/'.$searchId.'/delete');
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
    }
    function apiGetFlatAdvert1()
    {

        $flatID = file_get_contents(codecept_data_dir() . 'advertFlatId.json');
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->sendGET('/get-announcements/567c1bb0d69b5a383e8b4567');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }
    function apiUserVisitAdvert()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/visit', [
            'adverts' => ['566e8fdfd69b5a68128b4567']
        ]);

        $this->restModule->seeResponseCodeIs(200);
    }
    /*===============================================ADVERT API===============================================================*/
    function realtyCommercialsCheck()
    {

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/check', [
            'category' => $this->getCategoryId(3),
            'categoryType' => $this->getCommercialCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(97),
            'houseNumber' => Commercial::$currentCommercialNumber
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType(['id' => 'string']);
    }

    function realtyCommercialsValidate()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/validate', [
            'category' => $this->getCategoryId(3),
            'categoryType' => $this->getCommercialCategoryTypeId(0),
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(22),
            'street' => $this->getStreetId(97),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::latitude,
            'longitude' => Commercial::longitude,
            'area' => Commercial::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'effectiveArea' => Commercial::effectiveArea,
            'wallMaterial' => $this->getWallMaterialsId(0),
            'roomCount' => Commercial::roomCount,
            'floor' => Commercial::floors,
            'floorNumber' => Commercial::floorNumber,
            'buildYear' => Commercial::buildYear,
            'wc' => $this->getWcId(2),
            'heating' => $this->getHeatingsId(2),
            'waterHeating' => $this->getWaterHeatingsId(2),
            'communication' => [$this->getCommunicationsId(0), $this->getCommunicationsId(1), $this->getCommunicationsId(2)]
        ]);

        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType([
            'category' => 'string',
            'categoryType' => 'string',
            'region' => 'string',
            'city' => 'string',
            'district' => 'string',
            'street' => 'string',
            'houseNumber' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
            'roomCount' => 'integer',
            'wallMaterial' => 'string',
            'area' => 'integer',
            'areaUnit' => 'string',
            'effectiveArea' => 'integer',
            'floorNumber' => 'integer',
            'floor' => 'integer',
            'buildYear' => 'integer',
            'wc' => 'string',
            'heating' => 'string',
            'waterHeating' => 'string',
            'communication' => 'array'
        ]);
    }

    function realtyCommercialsEdit()
    {
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $realtyCommercialID = file_get_contents(codecept_data_dir('realtyCommercialId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/commercials/edit/' . $realtyCommercialID, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(2),
            'street' => $this->getStreetId(94),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::editLatitude,
            'longitude' => Commercial::editLongitude,
            'area' => Commercial::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'effectiveArea' => Commercial::editEffectiveArea,
            'wallMaterial' => $this->getWallMaterialsId(1),
            'roomCount' => Commercial::editRoomCount,
            'floor' => Commercial::editFloorNumber,
            'floorNumber' => Commercial::editFloor,
            'buildYear' => Commercial::editBuildYear,
            'wc' => $this->getWcId(1),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'communication' => [
                $this->getCommunicationsId(0),
                $this->getCommunicationsId(1),
                $this->getCommunicationsId(2),
                $this->getCommunicationsId(3),
                $this->getCommunicationsId(4),
                $this->getCommunicationsId(5),
                $this->getCommunicationsId(6),
                $this->getCommunicationsId(7)
            ],
            'schema' => $schema
        ]);

        $realtyCommercial = $this->restModule->grabResponse();
        $realtyCommercialEditId = json_decode($realtyCommercial)->id;
        if ($realtyCommercialEditId === $realtyCommercialID) {
            file_put_contents(codecept_data_dir('realtyCommercialId.json'), $realtyCommercialEditId);
        }

        $this->debugSection('realtyCommercialEditId', $realtyCommercialEditId);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
    }

    function realtyCommercialsDelete()
    {
        $realtyCommercialsID = file_get_contents(codecept_data_dir('realtyCommercialId.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/realties/' . $realtyCommercialsID . '/delete');
        $realtyCommercialDelete = $this->restModule->grabResponse();
        $this->debugSection('realtyCommercialDelete', $realtyCommercialDelete);
        $this->restModule->seeResponseCodeIS(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
    }


    /*=============================================== ADVERT API =============================================*/

    /*========================================= COMMON =========================================*/
    function apiGetLastSaleAdverts()
    {
//        $cityID = json_decode(file_get_contents(codecept_data_dir() . 'cities.json'))[4]->id;
        $cityID = '5620c5e3d69b5aaa228b479c';
        $operationTypeSale = json_decode(file_get_contents(codecept_data_dir() . 'operation_types.json'))[0]->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/get-announcements/last/' . $operationTypeSale . '/1/24/' . $cityID);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    function apiGetLastRentAdverts()
    {
//        $cityID = json_decode(file_get_contents(codecept_data_dir() . 'cities.json'))[4]->id;
        $cityID = '5620c5e3d69b5aaa228b479c';
        $operationTypeRent = json_decode(file_get_contents(codecept_data_dir() . 'operation_types.json'))[1]->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/get-announcements/last/' . $operationTypeRent . '/1/24/' . $cityID);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    function apiGetAgencyAdverts()
    {
        //todo: you also can do adverts sort by text of description (add to the end of url - ?text=test)


        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/profiles/announcements/1/24');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    function apiGetAgencyAdvert()
    {
        //todo: you can change to House, Parcel or Commercial. Also you could change role to Agent.

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/profiles/announcements/' . User::getFlatId());
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'id' => 'string',
            'user' => 'array',
            'status' => 'integer',
            'realty' => 'array'
        ]);
    }

    function apiAgencyAddAnnouncementsList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/announcements-lists/create', [
                'name' => User::$groupName,
                'client' => User::getUserId(1),
                'reset' => true
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $groupInfo = $this->restModule->grabResponse();
        $groupId = json_decode($groupInfo)->id;
        file_put_contents(codecept_data_dir('groupId.json'), $groupId);
        $this->restModule->seeResponseContainsJson(array('id' => User::getGroupId()));

    }



    function apiAgencyAddAdvertToAnnouncementsList()
    {
       $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/announcements-lists/'.User::getGroupId().'/add', [
                'advert' => [
                    User::getFlatId(),
                    User::getHouseId(),
                    User::getParcelId(),
                    User::getCommercialId()
                ]
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson( array('id' => User::getGroupId()));
        $this->restModule->seeResponseContainsJson( array('adverts' => ['id' => User::getFlatId()]));
        $this->restModule->seeResponseContainsJson( array('adverts' => ['id' => User::getHouseId()]));
        $this->restModule->seeResponseContainsJson( array('adverts' => ['id' => User::getParcelId()]));
        $this->restModule->seeResponseContainsJson( array('adverts' => ['id' => User::getCommercialId()]));

    }

    function apiAgencySendAnnouncementListToUser()
    {

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/announcements-lists/' . User::getGroupId() . '/send', [
            'email' => User::$userApiEmail,
            'subject' => User::$subjectTitle,
            'text' => User::$textGroup
        ]);
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAgencyAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/'.User::getGroupId());
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson( array('id' => User::getGroupId()));
        $this->restModule->seeResponseContainsJson( array('email' => User::$agencyEmail3));
        $this->restModule->seeResponseContainsJson( array('firstName' => User::$agencyName3));


    }

    function apiAgencyEditAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/profiles/announcements-lists/'.User::getGroupId().'/edit',[
            'name' => User::$editGroupName,
            'client' => '56681347d69b5a5b0d8b4567',
            'reset' => true
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('name' => User::$editGroupName));


    }

    function apiAgencyDeleteAdvertAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDelete('/profiles/announcements-lists/'.User::getGroupId().'/'.User::getFlatId().'/delete');
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAgencyDeleteAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDelete('/profiles/announcements-lists/'.User::getGroupId().'/delete');
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiUserAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getUserToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/'.User::getGroupId());
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson( array('id' => User::getGroupId()));
        $this->restModule->seeResponseContainsJson( array('user' => [
            'email' => User::$agencyEmail3,
            'firstName' => User::$agencyName3
        ]));
        $this->restModule->seeResponseCodeIs(200);

    }
    function apiUserAnnouncementList1()
    {
        $this->restModule->haveHttpHeader('token', User::getUserToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/'.User::getGroupId());
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson( array('id' => User::getGroupId()));
        $this->restModule->seeResponseContainsJson( array('user' => [
            'email' => User::$agentEmail,
            'firstName' => 'Dom'
        ]));

    }


    function apiUserIsInterestingAdvert()
    {
        $this->restModule->haveHttpHeader('token', User::getUserToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/lists/'.User::getGroupId().'/'.User::getFlatId().'/true');
        $this->restModule->sendPUT('/lists/'.User::getGroupId().'/'.User::getHouseId().'/false');
        $this->restModule->sendPUT('/lists/'.User::getGroupId().'/'.User::getParcelId().'/true');
        $this->restModule->sendPUT('/lists/'.User::getGroupId().'/'.User::getCommercialId().'/false');
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAgentAddAnnouncementsList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/announcements-lists/create', [
            'name' => 'Test Agent Group',
            'client' => User::getUserId(1),
            'reset' => true
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $groupInfo = $this->restModule->grabResponse();
        $groupId = json_decode($groupInfo)->id;
        file_put_contents(codecept_data_dir('groupId.json'), $groupId);
        $this->restModule->seeResponseContainsJson( array('id' => User::getGroupId()));
        $this->restModule->seeResponseContainsJson( array('user' => ['email' => User::$agentEmail]));


    }
    function apiAgentAddAdvertToAnnouncementsList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/announcements-lists/'.User::getGroupId().'/add', [
            'advert' => [
                User::getFlatId(),
                User::getHouseId(),
                User::getParcelId(),
                User::getCommercialId()
            ]
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson( array('id' => User::getGroupId()));
        $this->restModule->seeResponseContainsJson( array('adverts' => ['id' => User::getFlatId()]));
        $this->restModule->seeResponseContainsJson( array('adverts' => ['id' => User::getHouseId()]));
        $this->restModule->seeResponseContainsJson( array('adverts' => ['id' => User::getParcelId()]));
        $this->restModule->seeResponseContainsJson( array('adverts' => ['id' => User::getCommercialId()]));

    }

    function apiAgentSendAnnouncementListToUser()
    {

        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/announcements-lists/' . User::getGroupId() . '/send', [
            'email' => User::$userApiEmail,
            'subject' => User::$subjectTitle,
            'text' => User::$textGroup
        ]);
        $this->restModule->seeResponseCodeIs(200);

    }

    function apiAgentAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/'.User::getGroupId());
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAgentEditAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/profiles/announcements-lists/'.User::getGroupId().'/edit',[
            'name' => 'Edit Test Agent Group',
            'client' => '56698809d69b5ac8288b4567',
            'reset' => false
        ]);
        $this->restModule->seeResponseCodeIs(200);


    }

    function apiAgentDeleteAdvertAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDelete('/profiles/announcements-lists/'.User::getGroupId().'/'.User::getFlatId().'/delete');
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAgentDeleteAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDelete('/profiles/announcements-lists/'.User::getGroupId().'/delete');
        $this->restModule->seeResponseCodeIs(200);
    }


    /*========================================= FLATS =========================================*/
    function apiAdvertFlatAddPlain()
    {
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/flats/add/' . $realtyFlatId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSell,
            'currency' => $this->getCurrencyId(0),
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertFlat = $this->restModule->grabResponse();
        $advFlatId = json_decode($advertFlat)->id;
        file_put_contents(codecept_data_dir('advertFlatId.json'), $advFlatId);
        $this->debugSection('advertFlatId', $advFlatId);
    }

    function apiAdvertFlatAddComplex()
    {
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/flats/add/' . $realtyFlatId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSell,
            'currency' => $this->getCurrencyId(0),
//            'period' => ,
            'commission' => Flat::commission,
            'auction' => true,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [
                $this->getFurnituresId(0),
                $this->getFurnituresId(1),
                $this->getFurnituresId(2),
                $this->getFurnituresId(3),
                $this->getFurnituresId(4),
                $this->getFurnituresId(5),
                $this->getFurnituresId(6),
                $this->getFurnituresId(7)
            ],
            'appliances' => [
                $this->getAppliancesId(0),
                $this->getAppliancesId(1),
                $this->getAppliancesId(2),
                $this->getAppliancesId(3),
                $this->getAppliancesId(4),
                $this->getAppliancesId(5),
                $this->getAppliancesId(6),
                $this->getAppliancesId(7)
            ],
            'additionally' => [
                $this->getFlatAdditionalsId(0),
                $this->getFlatAdditionalsId(1),
                $this->getFlatAdditionalsId(2),
                $this->getFlatAdditionalsId(3),
                $this->getFlatAdditionalsId(4),
                $this->getFlatAdditionalsId(5),
                $this->getFlatAdditionalsId(6),
                $this->getFlatAdditionalsId(7),
                $this->getFlatAdditionalsId(8),
                $this->getFlatAdditionalsId(9),
                $this->getFlatAdditionalsId(10),
                $this->getFlatAdditionalsId(11),
                $this->getFlatAdditionalsId(12),
                $this->getFlatAdditionalsId(13),
                $this->getFlatAdditionalsId(14),
                $this->getFlatAdditionalsId(15)
            ],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
            'images' => json_decode($images, true),
            'videos' => [['imageSrc' => Flat::videoImage, 'url' => Flat::videoURL]],

        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertFlat = $this->restModule->grabResponse();
        $advFlatId = json_decode($advertFlat)->id;
        file_put_contents(codecept_data_dir('advertFlatId.json'), $advFlatId);
        $this->debugSection('advertFlatId', $advFlatId);
    }
    function apiAdvertFlatAddForSearch()
    {
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
//        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/flats/add/' . $realtyFlatId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'commission' => Flat::commission,
            'auction' => true,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
            'videos' => [['imageSrc' => Flat::videoImage, 'url' => Flat::videoURL]],
//            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertFlat = $this->restModule->grabResponse();
        $advFlatId = json_decode($advertFlat)->id;
        file_put_contents(codecept_data_dir('advertFlatId.json'), $advFlatId);
        $this->debugSection('advertFlatId', $advFlatId);
    }

    function apiGetFlatAdvert()
    {
        //todo: your advert should be available on web site (status 1)
        $flatID = file_get_contents(codecept_data_dir() . 'advertFlatId.json');
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->sendGET('/get-announcements/' . $flatID);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }



    /*========================================= HOUSES =========================================*/

    function apiAdvertHouseAddPlain()
    {
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/houses/add/' . $realtyHouseId, [
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseRent,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertHouse = $this->restModule->grabResponse();
        $advHouseId = json_decode($advertHouse)->id;
        file_put_contents(codecept_data_dir('advertHouseId.json'), $advHouseId);
        $this->debugSection('advertHouseId', $advHouseId);
    }

    function apiAdvertHouseAddComplex()
    {
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/houses/add/' . $realtyHouseId, [
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseRent,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [
                $this->getFurnituresId(0),
                $this->getFurnituresId(1),
                $this->getFurnituresId(2),
                $this->getFurnituresId(3),
                $this->getFurnituresId(4),
                $this->getFurnituresId(5),
                $this->getFurnituresId(6),
                $this->getFurnituresId(7)
            ],
            'appliances' => [
                $this->getAppliancesId(0),
                $this->getAppliancesId(1),
                $this->getAppliancesId(2),
                $this->getAppliancesId(3),
                $this->getAppliancesId(4),
                $this->getAppliancesId(5),
                $this->getAppliancesId(6),
                $this->getAppliancesId(7)
            ],
            'additionally' => [
                $this->getHouseAdditionalsId(0),
                $this->getHouseAdditionalsId(1),
                $this->getHouseAdditionalsId(2),
                $this->getHouseAdditionalsId(3),
                $this->getHouseAdditionalsId(4),
                $this->getHouseAdditionalsId(5),
                $this->getHouseAdditionalsId(6),
                $this->getHouseAdditionalsId(7),
                $this->getHouseAdditionalsId(8),
                $this->getHouseAdditionalsId(9),
                $this->getHouseAdditionalsId(10),
                $this->getHouseAdditionalsId(11),
                $this->getHouseAdditionalsId(12),
                $this->getHouseAdditionalsId(13),
                $this->getHouseAdditionalsId(14),
                $this->getHouseAdditionalsId(15)
            ],
            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertHouse = $this->restModule->grabResponse();
        $advHouseId = json_decode($advertHouse)->id;
        file_put_contents(codecept_data_dir('advertHouseId.json'), $advHouseId);
        $this->debugSection('advertHouseId', $advHouseId);
    }

    function apiAdvertHouseAddSearch()
    {
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/houses/add/' . $realtyHouseId, [
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
//            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertHouse = $this->restModule->grabResponse();
        $advHouseId = json_decode($advertHouse)->id;
        file_put_contents(codecept_data_dir('advertHouseId.json'), $advHouseId);
        $this->debugSection('advertHouseId', $advHouseId);
    }

    function apiGetHouseAdvert()
    {
        $houseID = file_get_contents(codecept_data_dir() . 'advertHouseId.json');
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/get-announcements/' . $houseID);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }

    /*========================================= PARCELS =========================================*/

    function apiAdvertParcelAddPlain()
    {
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/parcels/add/' . $realtyParcelId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertParcel = $this->restModule->grabResponse();
        $advParcelId = json_decode($advertParcel)->id;
        file_put_contents(codecept_data_dir('advertParcelId.json'), $advParcelId);
        $this->debugSection('advertParcelId', $advParcelId);
    }

    function apiAdvertParcelAddComplex()
    {
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/parcels/add/' . $realtyParcelId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'commission' => Parcel::commission,
            'auction' => true,
            'availableFrom' => Parcel::apiAvailableFrom,
            'additionally' => [
                $this->getParcelAdditionalsID(0),
                $this->getParcelAdditionalsID(1),
                $this->getParcelAdditionalsID(2),
                $this->getParcelAdditionalsID(3),
                $this->getParcelAdditionalsID(4),
                $this->getParcelAdditionalsID(5),
                $this->getParcelAdditionalsID(6),
                $this->getParcelAdditionalsID(7),
                $this->getParcelAdditionalsID(8),
                $this->getParcelAdditionalsID(9),
                $this->getParcelAdditionalsID(10),
                $this->getParcelAdditionalsID(11)
            ],
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertParcel = $this->restModule->grabResponse();
        $advParcelId = json_decode($advertParcel)->id;
        file_put_contents(codecept_data_dir('advertParcelId.json'), $advParcelId);
        $this->debugSection('advertParcelId', $advParcelId);
    }

    function apiAdvertParcelAddSearch()
    {
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/parcels/add/' . $realtyParcelId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSearch,
            'currency' => $this->getCurrencyId(0),
            'commission' => Parcel::commission,
            'auction' => true,
            'availableFrom' => Parcel::apiAvailableFrom,
            'additionally' => [$this->getParcelAdditionalsID(0)],
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
//            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertParcel = $this->restModule->grabResponse();
        $advParcelId = json_decode($advertParcel)->id;
        file_put_contents(codecept_data_dir('advertParcelId.json'), $advParcelId);
        $this->debugSection('advertParcelId', $advParcelId);
    }

    function apiGetParcelAdvert()
    {
        $parcelID = file_get_contents(codecept_data_dir() . 'advertParcelId.json');
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/get-announcements/' . $parcelID);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }

    /*========================================= COMMERCIALS =========================================*/

    function apiAdvertCommercialAddPlain()
    {
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/commercials/add/' . $realtyCommercialId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSell,
            'currency' => $this->getCurrencyId(0),
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertCommercial = $this->restModule->grabResponse();
        $advCommercialId = json_decode($advertCommercial)->id;
        file_put_contents(codecept_data_dir('advertCommercialId.json'), $advCommercialId);
        $this->debugSection('advertCommercialId', $advCommercialId);
    }

    function apiAdvertCommercialAddComplex()
    {
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/commercials/add/' . $realtyCommercialId, [
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialRent,
            'price' => Commercial::priceCommercialRent,
            'currency' => $this->getCurrencyId(1),
            'period' => $this->getPeriodId(1),
            'commission' => Commercial::commission,
            'auction' => true,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [
                $this->getCommercialAdditionalsId(0),
                $this->getCommercialAdditionalsId(1),
                $this->getCommercialAdditionalsId(2),
                $this->getCommercialAdditionalsId(3),
                $this->getCommercialAdditionalsId(4),
                $this->getCommercialAdditionalsId(5),
                $this->getCommercialAdditionalsId(6),
                $this->getCommercialAdditionalsId(7)
            ],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertCommercial = $this->restModule->grabResponse();
        $advCommercialId = json_decode($advertCommercial)->id;
        $file = file_put_contents(codecept_data_dir('advertCommercialId.json'), $advCommercialId);
        $this->debugSection('advertCommercialId', $advCommercialId);
    }

    function apiAdvertCommercialAddSearch()
    {
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/commercials/add/' . $realtyCommercialId, [
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialRent,
            'price' => Commercial::priceCommercialSearch,
            'currency' => $this->getCurrencyId(1),
            'period' => $this->getPeriodId(0),
            'commission' => Commercial::commission,
            'auction' => true,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
//            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertCommercial = $this->restModule->grabResponse();
        $advCommercialId = json_decode($advertCommercial)->id;
        $file = file_put_contents(codecept_data_dir('advertCommercialId.json'), $advCommercialId);
        $this->debugSection('advertCommercialId', $advCommercialId);
    }

    function apiGetCommercialAdvert()
    {
        $commercialID = file_get_contents(codecept_data_dir() . 'advertCommercialId.json');
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/get-announcements/' . $commercialID);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }

    /*============================================GARAGES===============================*/

    function apiAdvertGarageAddPlain()
    {
        $realtyGarageId = file_get_contents(codecept_data_dir('realtyGarageId.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/garages/add/' . $realtyGarageId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Garage::descriptionGarageSell,
            'price' => Garage::priceGarageSell,
            'currency' => $this->getCurrencyId(0),
            'commission' => Garage::commission,
            'availableFrom' => Garage::apiAvailableFrom,
//            'repair' => $this->getRepairsId(0),
            'ownerContacts' => Garage::ownerContacts,
            'ownerName' => Garage::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertGarage = $this->restModule->grabResponse();
        $advGarageId = json_decode($advertGarage)->id;
        file_put_contents(codecept_data_dir('advertGarageId.json'), $advGarageId);
        $this->debugSection('advertGarageId', $advGarageId);
    }

    function apiAdvertGarageAddComplex()
    {
        $realtyGarageId = file_get_contents(codecept_data_dir('realtyGarageId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/garages/add/' . $realtyGarageId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Garage::descriptionGarageSell,
            'price' => Garage::priceGarageSell,
            'currency' => $this->getCurrencyId(0),
//            'period' => ,
            'commission' => Garage::commission,
            'auction' => true,
            'availableFrom' => Garage::apiAvailableFrom,
            'additionally' => [
                $this->getGarageAdditionalsId(0),
                $this->getGarageAdditionalsId(1),
                $this->getGarageAdditionalsId(2),
                $this->getGarageAdditionalsId(3),
                $this->getGarageAdditionalsId(4),
                $this->getGarageAdditionalsId(5),
            ],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
            'images' => json_decode($images, true),
            'videos' => [['imageSrc' => Flat::videoImage, 'url' => Flat::videoURL]],

        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertGarage = $this->restModule->grabResponse();
        $advGarageId = json_decode($advertGarage)->id;
        file_put_contents(codecept_data_dir('advertGarageId.json'), $advGarageId);
        $this->debugSection('advertGarageId', $advGarageId);
    }
    function apiAdvertGarageAddForSearch()
    {
        $realtyGarageId = file_get_contents(codecept_data_dir('realtyGarageId.json'));
//        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/garages/add/' . $realtyGarageId, [
            'operationType' => $this->getOperationTypeId(0),
            'description' => Garage::descriptionGarageSell,
            'price' => Garage::priceGarageSearch,
            'currency' => $this->getCurrencyId(0),
            'commission' => Garage::commission,
            'auction' => true,
            'availableFrom' => Garage::apiAvailableFrom,
            'additionally' => [$this->getGarageAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
            'videos' => [['imageSrc' => Flat::videoImage, 'url' => Flat::videoURL]],
//            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $advertGarage = $this->restModule->grabResponse();
        $advGarageId = json_decode($advertGarage)->id;
        file_put_contents(codecept_data_dir('advertGarageId.json'), $advGarageId);
        $this->debugSection('advertGarageId', $advGarageId);
    }






    /*=======================================================ADMIN API=============================================*/

    /*===================================================Common=======================================*/

    function apiAdminInfoPages()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/admin/info-pages/1/25');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'page' => 'integer',
            'count' => 'integer'
        ]);
    }

    function apiAdminAddInfoPage()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/admin/info-pages/create', [
            'name' => Info::inf_name,
            'latinName' => Info::inf_latinName,
            'content' => Info::inf_content,
            'title' => Info::inf_title,
            'metaDescription' => Info::inf_metaDescription,
            'metaKeywords' => Info::inf_metaKeywords,
            'isIndex' => true,
            'isFollow' => true
        ]);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseMatchesJsonType([
            'name' => 'string',
            'latinName' => 'string',
            'content' => 'string',
            'title' => 'string',
            'metaDescription' => 'string',
            'metaKeywords' => 'string',
            'metaRobots' => "string"
        ]);
    }

    function apiAdminEditInfoPage()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/admin/info-pages/' . Info::inf_latinName . '/edit', [
            'name' => Info::inf_editName,
            'latinName' => Info::inf_editLatinName,
            'content' => Info::inf_editContent,
            'title' => Info::inf_editTitle,
            'metaDescription' => Info::inf_editMetaDescription,
            'metaKeywords' => Info::inf_editMetaKeywords,
            'isIndex' => false,
            'isFollow' => false
        ]);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'name' => 'string',
            'latinName' => 'string',
            'content' => 'string',
            'title' => 'string',
            'metaDescription' => 'string',
            'metaKeywords' => 'string',
            'metaRobots' => "string"
        ]);
    }

    function apiAdminDeleteInfoPage()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/admin/info-pages/' . Info::inf_editLatinName . '/delete');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAdminAddCity()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPOST('/admin/lists/cities/add', [
            'regionId' => $this->getRegionId(23),
            'name' => Lists::cityName,
            'cityLocative' => Lists::cityLocativeName
        ]);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $city = $this->restModule->grabResponse();
        $cityId = json_decode($city)->id;
        file_put_contents(codecept_data_dir('cityId.json'), $cityId);
        $this->debugSection('City Id', $city);
    }

     function apiAdminEditCity()
     {
         $this->restModule->haveHttpHeader('token', User::getAdminToken());
         $this->restModule->sendPUT('/admin/lists/cities/'.User::getCityId().'/edit', [
             'name' => Lists::editCityName,
             'cityLocative' => Lists::editCityLocativeName
         ]);
         $this->restModule->seeResponseIsJson();
         $this->restModule->seeResponseCodeIs(200);
         $city = $this->restModule->grabResponse();
         $cityId = json_decode($city)->id;
         file_put_contents(codecept_data_dir('cityId.json'), $cityId);
         $this->debugSection('City Id', $city);
     }

    function apiAdminDeleteCity()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendDELETE('/admin/lists/cities/'.User::getCityId().'/delete');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAdminAddDistrict()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPOST('/admin/lists/districts/add', [
            'cityId' => User::getCityId(),
            'name' => Lists::districtName
        ]);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $district = $this->restModule->grabResponse();
        $districtId = json_decode($district)->id;
        file_put_contents(codecept_data_dir('districtId.json'), $districtId);
        $this->debugSection('District Id', $district);
    }

    function apiAdminEditDistrict()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/admin/lists/districts/'.User::getDistrictId().'/edit',[
            'name' => Lists::editDistrictName
        ]);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAdminDeleteDistrict()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendDELETE('/admin/lists/districts/'.User::getDistrictId().'/delete');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAdminAddStreet()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPOST('/admin/lists/streets/add', [
            'cityId' => User::getCityId(),
            'name' => Lists::streetName
        ]);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $street = $this->restModule->grabResponse();
        $streetId = json_decode($street)->id;
        file_put_contents(codecept_data_dir('streetId.json'), $streetId);
        $this->debugSection('Street Id', $street);
    }

    function apiAdminEditStreet()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/admin/lists/streets/'.User::getStreetId().'/edit',[
            'name' => Lists::editStreetName
        ]);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAdminDeleteStreet()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendDELETE('/admin/lists/streets/'.User::getStreetId().'/delete');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAdminAddCategoryType($id) //0..3(0)
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPOST('/admin/lists/category-types/add', [
            'categoryId' => $this->getCategoryId($id),
            'name' => Lists::categoryTypeName
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $categoryType = $this->restModule->grabResponse();
        $categoryTypeId = json_decode($categoryType)->id;
        file_put_contents(codecept_data_dir('categoryTypeId.json'), $categoryTypeId);
        $this->debugSection('Category Id', $categoryType);
    }

    function apiAdminEditCategoryType()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/admin/lists/category-types/'.User::getCategoryTypeId().'/edit', [
            'name' => Lists::editCategoryTypeName
        ]);
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAdminChangePositionCategoryType()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/admin/lists/category-types/'.User::getCategoryTypeId().'/0/edit', [
            'name' => Lists::editCategoryTypeName
        ]);
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAdminDeleteCategoryType()
    {
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendDELETE('/admin/lists/category-types/'.User::getCategoryTypeId().'/delete');
        $this->restModule->seeResponseCodeIs(200);
    }





    /*=================================================== REALTIES =======================================*/

    function apiAdminGetFlatRealties()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/profiles/realties/' . $realtyFlatId);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'id' => 'string',
            'category' => 'array',
            'categoryType' => 'array',
            'address' => 'array',
            'user' => 'array'
        ]);
    }

    function apiAdminGetHouseRealties()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/profiles/realties/' . $realtyHouseId);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'id' => 'string',
            'category' => 'array',
            'categoryType' => 'array',
            'address' => 'array',
            'user' => 'array'
        ]);
    }

    function apiAdminGetParcelRealties()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/profiles/realties/' . $realtyParcelId);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'id' => 'string',
            'category' => 'array',
            'categoryType' => 'array',
            'address' => 'array',
            'user' => 'array'
        ]);
    }

    function apiAdminGetCommercialRealties()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/profiles/realties/' . $realtyCommercialId);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'id' => 'string',
            'category' => 'array',
            'categoryType' => 'array',
            'address' => 'array',
            'user' => 'array'
        ]);
    }

    /*=================================================== ADVERTS =======================================*/

    function apiAdminAdvertsList()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/announcements/lists/1/25');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    function apiAdminAdvertsStatistics()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/announcements/statistics');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'preModeration' => 'integer',
            'published' => 'integer',
            'declined' => 'integer',
            'forUnpublished' => 'integer',
            'unpublished' => 'integer'
        ]);
    }

    /*=================================================== Edit Advert =======================================*/

    function apiAdminEditFlatAdvertPlain()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
        $advertFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
//            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }

    function apiAdminEditFlatAdvertComplex()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
        $advertFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [
                $this->getFurnituresId(0),
                $this->getFurnituresId(1),
                $this->getFurnituresId(2),
                $this->getFurnituresId(3),
                $this->getFurnituresId(4),
                $this->getFurnituresId(5),
                $this->getFurnituresId(6),
                $this->getFurnituresId(7)
            ],
            'appliances' => [
                $this->getAppliancesId(0),
                $this->getAppliancesId(1),
                $this->getAppliancesId(2),
                $this->getAppliancesId(3),
                $this->getAppliancesId(4),
                $this->getAppliancesId(5),
                $this->getAppliancesId(6),
                $this->getAppliancesId(7)
            ],
            'additionally' => [
                $this->getFlatAdditionalsId(0),
                $this->getFlatAdditionalsId(1),
                $this->getFlatAdditionalsId(2),
                $this->getFlatAdditionalsId(3),
                $this->getFlatAdditionalsId(4),
                $this->getFlatAdditionalsId(5),
                $this->getFlatAdditionalsId(6),
                $this->getFlatAdditionalsId(7),
                $this->getFlatAdditionalsId(8),
                $this->getFlatAdditionalsId(9),
                $this->getFlatAdditionalsId(10),
                $this->getFlatAdditionalsId(11),
                $this->getFlatAdditionalsId(12),
                $this->getFlatAdditionalsId(13),
                $this->getFlatAdditionalsId(14),
                $this->getFlatAdditionalsId(15)
            ],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();

    }

    function apiAdminEditFlatAdvertSearch()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
        $advertFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));


        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertFlat = $this->restModule->grabResponse();
        $advFlatId = json_decode($advertFlat)->id;
        file_put_contents(codecept_data_dir('advertFlatId.json'), $advFlatId);
        $this->debugSection('advertFlatId', $advFlatId);

    }


    function apiAdminEditFlatAdvertChangeStatus(\VpnTester $I)
    {
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
        $advertFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $houseNumber = file_get_contents(codecept_data_dir('house_number.txt'));
        $flatNumber  = file_get_contents(codecept_data_dir('flat_number.txt'));



        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/flats/edit/' . $realtyFlatId, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(0),
            'street' => $this->getStreetId(0),
            'houseNumber' => $houseNumber,
            'flatNumber' => $flatNumber,
            'latitude' => Flat::editLatitude,
            'longitude' => Flat::editLongitude,
            'roomCount' => Flat::editRoomCount,
            'wallMaterial' => $this->getWallMaterialsId(2),
            'area' => Flat::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => Flat::editLivingArea,
            'kitchenArea' => Flat::editKitchenArea,
            'floor' => Flat::editFloorNumber,
            'floorNumber' => Flat::editFloors,
            'buildYear' => Flat::editBuildYear,
            'wc' => $this->getWcId(2),
            'balcony' => $this->getBalconiesId(2),
            'heating' => $this->getHeatingsId(2),
            'waterHeating' => $this->getWaterHeatingsId(2),
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],

        ]);
        $this->restModule->seeResponseCodeIs(200);

        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/flats/edit/' . $realtyFlatId, [
            'status' => 0,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(0),
            'street' => $this->getStreetId(0),
            'houseNumber' => $houseNumber,
            'flatNumber' => $flatNumber,
            'latitude' => Flat::editLatitude,
            'longitude' => Flat::editLongitude,
            'roomCount' => Flat::editRoomCount,
            'wallMaterial' => $this->getWallMaterialsId(2),
            'area' => Flat::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => Flat::editLivingArea,
            'kitchenArea' => Flat::editKitchenArea,
            'floor' => Flat::editFloorNumber,
            'floorNumber' => Flat::editFloors,
            'buildYear' => Flat::editBuildYear,
            'wc' => $this->getWcId(2),
            'balcony' => $this->getBalconiesId(2),
            'heating' => $this->getHeatingsId(2),
            'waterHeating' => $this->getWaterHeatingsId(2),
            'nearObjects' => [
                $this->getNearObjectsId(0),
                $this->getNearObjectsId(1),
                $this->getNearObjectsId(2),
                $this->getNearObjectsId(3),
                $this->getNearObjectsId(4),
                $this->getNearObjectsId(5),
                $this->getNearObjectsId(6),
                $this->getNearObjectsId(7),
                $this->getNearObjectsId(8),
                $this->getNearObjectsId(9)
            ],

        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 2,
            'rejectionReason' => User::$rejectReason,
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertFlatId, [
            'type' => 'flats',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyFlatId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getFlatAdditionalsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseIsJson();
        $advertFlat = $this->restModule->grabResponse();
        $advFlatId = json_decode($advertFlat)->id;
        file_put_contents(codecept_data_dir('advertFlatId.json'), $advFlatId);
        $this->debugSection('advertFlatId', $advFlatId);


    }


    function apiAdminEditHouseAdvertPlain()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $advertHouseId = file_get_contents(codecept_data_dir('advertHouseId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => House::descriptionHouseSell,
            'price' => House::priceHouseSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => House::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketTypeId(0),
            'repair' => $this->getRepairsId(0),
            'bedsCount' => Flat::beds,
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
//            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertHouse = $this->restModule->grabResponse();
        $advHouseId = json_decode($advertHouse)->id;
        file_put_contents(codecept_data_dir('advertHouseId.json'), $advHouseId);
        $this->debugSection('advertHouseId', $advHouseId);
    }

    function apiAdminEditHouseAdvertComplex()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $advertHouseId = file_get_contents(codecept_data_dir('advertHouseId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseRent,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [
                $this->getFurnituresId(0),
                $this->getFurnituresId(1),
                $this->getFurnituresId(2),
                $this->getFurnituresId(3),
                $this->getFurnituresId(4),
                $this->getFurnituresId(5),
                $this->getFurnituresId(6),
                $this->getFurnituresId(7)
            ],
            'appliances' => [
                $this->getAppliancesId(0),
                $this->getAppliancesId(1),
                $this->getAppliancesId(2),
                $this->getAppliancesId(3),
                $this->getAppliancesId(4),
                $this->getAppliancesId(5),
                $this->getAppliancesId(6),
                $this->getAppliancesId(7)
            ],
            'additionally' => [
                $this->getHouseAdditionalsId(0),
                $this->getHouseAdditionalsId(1),
                $this->getHouseAdditionalsId(2),
                $this->getHouseAdditionalsId(3),
                $this->getHouseAdditionalsId(4),
                $this->getHouseAdditionalsId(5),
                $this->getHouseAdditionalsId(6),
                $this->getHouseAdditionalsId(7),
                $this->getHouseAdditionalsId(8),
                $this->getHouseAdditionalsId(9),
                $this->getHouseAdditionalsId(10),
                $this->getHouseAdditionalsId(11),
                $this->getHouseAdditionalsId(12),
                $this->getHouseAdditionalsId(13),
                $this->getHouseAdditionalsId(14),
                $this->getHouseAdditionalsId(15)
            ],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName,
            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertHouse = $this->restModule->grabResponse();
        $advHouseId = json_decode($advertHouse)->id;
        file_put_contents(codecept_data_dir('advertHouseId.json'), $advHouseId);
        $this->debugSection('advertHouseId', $advHouseId);
    }

    function apiAdminEditHouseAdvertSearch()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $advertHouseId = file_get_contents(codecept_data_dir('advertHouseId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName
//            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertHouse = $this->restModule->grabResponse();
        $advHouseId = json_decode($advertHouse)->id;
        file_put_contents(codecept_data_dir('advertHouseId.json'), $advHouseId);
        $this->debugSection('advertHouseId', $advHouseId);
    }

    function apiAdminEditHouseAdvertChangeStatus(\VpnTester $I)
    {
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $advertHouseId = file_get_contents(codecept_data_dir('advertHouseId.json'));
        $houseNumber = file_get_contents(codecept_data_dir('house_number.txt'));


        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/houses/edit/' . $realtyHouseId, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(21),
            'houseNumber' => $houseNumber,
            'latitude' => House::editLatitude,
            'longitude' => House::editLongitude,
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => House::editLivingArea,
            'kitchenArea' => House::editKitchenArea,
            'landArea' => House::editLandArea,
            'landAreaUnit' => $this->getAreaUnitsId(1),
            'roomCount' => House::editRoomCount,
            'wallMaterial' => $this->getWallMaterialsId(1),
            'floorNumber' => House::editFloors,
            'buildYear' => House::editBuildYear,
            'wc' => $this->getWcId(1),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'communication' => [
                $this->getCommunicationsId(0),
                            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
                             ],

        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/houses/edit/' . $realtyHouseId, [
            'status' => 0,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'street' => $this->getStreetId(21),
            'houseNumber' => $houseNumber,
            'latitude' => House::editLatitude,
            'longitude' => House::editLongitude,
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'livingArea' => House::editLivingArea,
            'kitchenArea' => House::editKitchenArea,
            'landArea' => House::editLandArea,
            'landAreaUnit' => $this->getAreaUnitsId(1),
            'roomCount' => House::editRoomCount,
            'wallMaterial' => $this->getWallMaterialsId(1),
            'floorNumber' => House::editFloors,
            'buildYear' => House::editBuildYear,
            'wc' => $this->getWcId(1),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'communication' => [
                $this->getCommunicationsId(0),
                            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),

            ],

        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 2,
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'rejectionReason' => User::$rejectReason,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);


        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertHouseId, [
            'type' => 'houses',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyHouseId,
            'operationType' => $this->getOperationTypeId(1),
            'period' => $this->getPeriodId(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrencyId(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairsId(0),
            'furniture' => [$this->getFurnituresId(0)],
            'appliances' => [$this->getAppliancesId(0)],
            'additionally' => [$this->getHouseAdditionalsId(0)],
            'ownerContacts' => House::ownerContacts,
            'ownerName' => House::ownerName
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertHouse = $this->restModule->grabResponse();
        $advHouseId = json_decode($advertHouse)->id;
        file_put_contents(codecept_data_dir('advertHouseId.json'), $advHouseId);
        $this->debugSection('advertHouseId', $advHouseId);


    }

    function apiAdminEditParcelAdvertPlain()
{
    $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
    $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
    $userId = json_decode($agencyData)->id;
    $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
    $advertParcelId = file_get_contents(codecept_data_dir('advertParcelId.json'));
    $images = file_get_contents(codecept_data_dir('images_id.json'));

    $this->restModule->haveHttpHeader('token', $adminToken);
    $this->restModule->haveHttpHeader('Content-Type', 'application/json');
    $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
        'type' => 'parcels',
        'status' => 1,
        'userId' => $userId,
        'realtyId' => $realtyParcelId,
        'operationType' => $this->getOperationTypeId(0),
        'description' => Parcel::descriptionParcelSell,
        'price' => Parcel::priceParcelSell,
        'currency' => $this->getCurrencyId(0),
        'auction' => true,
        'commission' => Parcel::commission,
        'availableFrom' => Parcel::apiAvailableFrom,
//            'additionally' => [$this->getParcelAdditionalsID(0), $this->getParcelAdditionalsID(15)],
        'ownerContacts' => Parcel::ownerContacts,
        'ownerName' => Parcel::ownerName,
//            'images' => json_decode($images, true)
    ]);
    $this->restModule->seeResponseCodeIs(200);
    $this->restModule->seeResponseIsJson();
    $advertParcel = $this->restModule->grabResponse();
    $advParcelId = json_decode($advertParcel)->id;
    file_put_contents(codecept_data_dir('advertParcelId.json'), $advParcelId);
    $this->debugSection('advertParcelId', $advParcelId);
}

    function apiAdminEditParcelAdvertComplex()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $advertParcelId = file_get_contents(codecept_data_dir('advertParcelId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'additionally' => [
                $this->getParcelAdditionalsID(0),
                $this->getParcelAdditionalsID(1),
                $this->getParcelAdditionalsID(2),
                $this->getParcelAdditionalsID(3),
                $this->getParcelAdditionalsID(4),
                $this->getParcelAdditionalsID(5),
                $this->getParcelAdditionalsID(6),
                $this->getParcelAdditionalsID(7),
                $this->getParcelAdditionalsID(8),
                $this->getParcelAdditionalsID(9),
                $this->getParcelAdditionalsID(10),
                $this->getParcelAdditionalsID(11),
            ],
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertParcel = $this->restModule->grabResponse();
        $advParcelId = json_decode($advertParcel)->id;
        file_put_contents(codecept_data_dir('advertParcelId.json'), $advParcelId);
        $this->debugSection('advertParcelId', $advParcelId);
    }

    function apiAdminEditParcelAdvertSearch()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $advertParcelId = file_get_contents(codecept_data_dir('advertParcelId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'additionally' => [$this->getParcelAdditionalsID(0)],
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
//            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertParcel = $this->restModule->grabResponse();
        $advParcelId = json_decode($advertParcel)->id;
        file_put_contents(codecept_data_dir('advertParcelId.json'), $advParcelId);
        $this->debugSection('advertParcelId', $advParcelId);
    }
    function apiAdminEditParcelAdvertChangeStatus(\VpnTester $I)
    {
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $advertParcelId = file_get_contents(codecept_data_dir('advertParcelId.json'));
        $cadastralNumber = file_get_contents(codecept_data_dir('cadastral_number1.txt'));


        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/parcels/edit/' . $realtyParcelId, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(25),
            'cadastralNumber' => $cadastralNumber,
            'latitude' => Parcel::editLatitude,
            'longitude' => Parcel::editLongitude,
            'area' => Parcel::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(2),
            'communication' => [
                $this->getCommunicationsId(0),
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
            ],
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/parcels/edit/' . $realtyParcelId, [
            'status' => 0,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(7),
            'street' => $this->getStreetId(25),
            'cadastralNumber' => $cadastralNumber,
            'latitude' => Parcel::editLatitude,
            'longitude' => Parcel::editLongitude,
            'area' => Parcel::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(2),
            'communication' => [
                $this->getCommunicationsId(0),
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
            ],
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 2,
            'rejectionReason' => User::$rejectReason,
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertParcelId, [
            'type' => 'parcels',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyParcelId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'ownerContacts' => Parcel::ownerContacts,
            'ownerName' => Parcel::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertParcel = $this->restModule->grabResponse();
        $advertParcelId = json_decode($advertParcel)->id;
        file_put_contents(codecept_data_dir('advertParcelId.json'), $advertParcelId);
        $this->debugSection('advertParcelId', $advertParcelId);


    }


    function apiAdminEditCommercialAdvertPlain()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $advertCommercialId = file_get_contents(codecept_data_dir('advertCommercialId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSell,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertCommercial = $this->restModule->grabResponse();
        $advCommercialId = json_decode($advertCommercial)->id;
        file_put_contents(codecept_data_dir('advertCommercialId.json'), $advCommercialId);
        $this->debugSection('advertCommercialId', $advCommercialId);
    }

    function apiAdminEditCommercialAdvertComplex()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $advertCommercialId = file_get_contents(codecept_data_dir('advertCommercialId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialRent,
            'price' => Commercial::priceCommercialRent,
            'currency' => $this->getCurrencyId(1),
            'period' => $this->getPeriodId(1),
            'commission' => Commercial::commission,
            'auction' => true,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [
                $this->getCommercialAdditionalsId(0),
                $this->getCommercialAdditionalsId(1),
                $this->getCommercialAdditionalsId(2),
                $this->getCommercialAdditionalsId(3),
                $this->getCommercialAdditionalsId(4),
                $this->getCommercialAdditionalsId(5),
                $this->getCommercialAdditionalsId(6),
                $this->getCommercialAdditionalsId(7)
            ],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
            'images' => json_decode($images, true)
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertCommercial = $this->restModule->grabResponse();
        $advCommercialId = json_decode($advertCommercial)->id;
        $file = file_put_contents(codecept_data_dir('advertCommercialId.json'), $advCommercialId);
        $this->debugSection('advertCommercialId', $advCommercialId);
    }

    function apiAdminEditCommercialAdvertSearch()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $advertCommercialId = file_get_contents(codecept_data_dir('advertCommercialId.json'));
//        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertCommercial = $this->restModule->grabResponse();
        $advCommercialId = json_decode($advertCommercial)->id;
        file_put_contents(codecept_data_dir('advertCommercialId.json'), $advCommercialId);
        $this->debugSection('advertCommercialId', $advCommercialId);
    }

    function apiAdminEditCommercialAdvertChangeStatus(\VpnTester $I)
    {
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $advertCommercialId = file_get_contents(codecept_data_dir('advertCommercialId.json'));
        $houseNumber = file_get_contents(codecept_data_dir('commercial_number.txt'));


        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/commercials/edit/' . $realtyCommercialId, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(2),
            'street' => $this->getStreetId(94),
            'houseNumber' => $houseNumber,
            'latitude' => Commercial::editLatitude,
            'longitude' => Commercial::editLongitude,
            'area' => Commercial::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'effectiveArea' => Commercial::editEffectiveArea,
            'wallMaterial' => $this->getWallMaterialsId(1),
            'roomCount' => Commercial::editRoomCount,
            'floor' => Commercial::editFloorNumber,
            'floorNumber' => Commercial::editFloor,
            'buildYear' => Commercial::editBuildYear,
            'wc' => $this->getWcId(1),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'communication' => [
                $this->getCommunicationsId(0),
            ],

        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/commercials/edit/' . $realtyCommercialId, [
            'status' => 0,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(2),
            'street' => $this->getStreetId(94),
            'houseNumber' => $houseNumber,
            'latitude' => Commercial::editLatitude,
            'longitude' => Commercial::editLongitude,
            'area' => Commercial::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'effectiveArea' => Commercial::editEffectiveArea,
            'wallMaterial' => $this->getWallMaterialsId(1),
            'roomCount' => Commercial::editRoomCount,
            'floor' => Commercial::editFloorNumber,
            'floorNumber' => Commercial::editFloor,
            'buildYear' => Commercial::editBuildYear,
            'wc' => $this->getWcId(1),
            'heating' => $this->getHeatingsId(1),
            'waterHeating' => $this->getWaterHeatingsId(1),
            'communication' => [
                $this->getCommunicationsId(0),
            ],

        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 2,
            'rejectionReason' => User::$rejectReason,
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertCommercialId, [
            'type' => 'commercial-property',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyCommercialId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertCommercial = $this->restModule->grabResponse();
        $advCommercialId = json_decode($advertCommercial)->id;
        file_put_contents(codecept_data_dir('advertCommercialId.json'), $advCommercialId);
        $this->debugSection('advertCommercialId', $advCommercialId);


    }

    function apiAdminEditGarageAdvertComplex()
    {
//        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyGarageId = file_get_contents(codecept_data_dir('realtyGarageId.json'));
        $advertGarageId = file_get_contents(codecept_data_dir('advertGarageId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Garage::editDescriptionGarageSell,
            'price' => Garage::priceGarageRent,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Garage::editCommission,
            'availableFrom' => Garage::apiAvailableFrom,
            'additionally' => [
                $this->getGarageAdditionalsId(0),
                $this->getGarageAdditionalsId(1),
                $this->getGarageAdditionalsId(2),
                $this->getGarageAdditionalsId(3),
                $this->getGarageAdditionalsId(4),
                $this->getGarageAdditionalsId(5),],
            'ownerContacts' => Flat::editOwnerContacts,
            'images' => json_decode($images, true),
            'ownerName' => Flat::editOwnerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);

        $this->restModule->seeResponseIsJson();
        $advertGarage = $this->restModule->grabResponse();
        $advGarageId = json_decode($advertGarage)->id;
        file_put_contents(codecept_data_dir('advertGarageId.json'), $advGarageId);
        $this->debugSection('advertGarageId', $advGarageId);
    }
    function apiAdminEditGarageAdvertPlain()
    {
//        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyGarageId = file_get_contents(codecept_data_dir('realtyGarageId.json'));
        $advertGarageId = file_get_contents(codecept_data_dir('advertGarageId.json'));
//        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Garage::editDescriptionGarageSell,
            'price' => Garage::priceGarageRent,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Garage::editCommission,
            'availableFrom' => Garage::apiAvailableFrom,
            'ownerContacts' => Flat::editOwnerContacts,
            'ownerName' => Flat::editOwnerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertGarage = $this->restModule->grabResponse();
        $advGarageId = json_decode($advertGarage)->id;
        file_put_contents(codecept_data_dir('advertGarageId.json'), $advGarageId);
        $this->debugSection('advertGarageId', $advGarageId);
    }
    function apiAdminEditGarageAdvertSearch()
    {
//        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyGarageId = file_get_contents(codecept_data_dir('realtyGarageId.json'));
        $advertGarageId = file_get_contents(codecept_data_dir('advertGarageId.json'));
//        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(0),
            'description' => Garage::descriptionGarageSell,
            'price' => Garage::priceGarageSearch,
            'currency' => $this->getCurrencyId(0),
            'auction' => true,
            'commission' => Garage::commission,
            'availableFrom' => Garage::apiAvailableFrom,
            'additionally' => [$this->getGarageAdditionalsId(0)],
            'communication' => [$this->getCommunicationsId(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertGarage = $this->restModule->grabResponse();
        $advGarageId = json_decode($advertGarage)->id;
        file_put_contents(codecept_data_dir('advertGarageId.json'), $advGarageId);
        $this->debugSection('advertGarageId', $advGarageId);
    }

    function apiAdminEditGarageAdvertChangeStatus(\VpnTester $I)
    {
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $realtyGarageId = file_get_contents(codecept_data_dir('realtyGarageId.json'));
        $advertGarageId = file_get_contents(codecept_data_dir('advertGarageId.json'));
        $houseNumber = file_get_contents(codecept_data_dir('house_number.txt'));
        $flatNumber  = file_get_contents(codecept_data_dir('flat_number.txt'));

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/garages/edit/' . $realtyGarageId, [
            'status' => 1,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(0),
            'street' => $this->getStreetId(0),
            'houseNumber' => $houseNumber,
            'garageNumber' => $flatNumber,
            'latitude' => Garage::editLatitude,
            'longitude' => Garage::editLongitude,
            'roomCount' => Garage::editRoomCount,
            'wallMaterial' => $this->getWallMaterialsId(2),
            'area' => Garage::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'floor' => Garage::editFloor,
            'floorNumber' => Garage::editFloorNumber,
            'buildYear' => Garage::editBuildYear,
            'heating' => $this->getHeatingsId(2),
            'inspectionPit'=> $this->getInspectionPitId(1),
            'parkingPlace' => $this->getParkingPlaceId(1),
            'transportType' =>$this->getTransportTypeId(1),
            'communication' => [
                $this->getCommunicationsId(0),
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
            ],
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');

        $this->restModule->sendPUT('/realties/garages/edit/' . $realtyGarageId, [
            'status' => 0,
            'region' => $this->getRegionId(21),
            'city' => $this->getCityId(6),
            'district' => $this->getDistrictId(0),
            'street' => $this->getStreetId(0),
            'houseNumber' => $houseNumber,
            'garageNumber' => $flatNumber,
            'latitude' => Garage::editLatitude,
            'longitude' => Garage::editLongitude,
            'roomCount' => Garage::editRoomCount,
            'wallMaterial' => $this->getWallMaterialsId(2),
            'area' => Garage::editGeneralArea,
            'areaUnit' => $this->getAreaUnitsId(0),
            'floor' => Garage::editFloor,
            'floorNumber' => Garage::editFloorNumber,
            'buildYear' => Garage::editBuildYear,
            'heating' => $this->getHeatingsId(2),
            'inspectionPit'=> $this->getInspectionPitId(1),
            'parkingPlace' => $this->getParkingPlaceId(1),
            'transportType' =>$this->getTransportTypeId(1),
            'communication' => [
                $this->getCommunicationsId(0),
            ],
            'nearObjects' => [
                $this->getNearObjectsId(0),
            ],
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 2,
            'rejectionReason' => User::$rejectReason,
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(0),
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatSell,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishPrice' => Flat::priceFlatRent,
            'unpublishReason' => $this->getUnpublishReasonsId(1),
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 3,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 4,
            'unpublishCurrency' => $this->getCurrencyId(0),
            'unpublishDescription'=> User::$unpublishDesc,
            'unpublishReason' => $this->getUnpublishReasonsId(2),
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $I->wait(1);

        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/announcements/edit/' . $advertGarageId, [
            'type' => 'garages',
            'status' => 1,
            'userId' => $userId,
            'realtyId' => $realtyGarageId,
            'operationType' => $this->getOperationTypeId(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriodId(0),
            'currency' => $this->getCurrencyId(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairsId(0),
            'additionally' => [$this->getCommercialAdditionalsId(0)],
            'ownerContacts' => Commercial::ownerContacts,
            'ownerName' => Commercial::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertGarage = $this->restModule->grabResponse();
        $advGarageId = json_decode($advertGarage)->id;
        file_put_contents(codecept_data_dir('advertGarageId.json'), $advGarageId);
        $this->debugSection('advertGarageId', $advGarageId);


    }

    /*================================================ Delete Advert ====================================*/

    function apiDeleteFlatAdvert()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $advertFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/announcements/' . $advertFlatId . '/delete');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }

    function apiDeleteHouseAdvert()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $advertHouseId = file_get_contents(codecept_data_dir('advertHouseId.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/announcements/' . $advertHouseId . '/delete');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }

    function apiDeleteParcelAdvert()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $advertParcelId = file_get_contents(codecept_data_dir('advertParcelId.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/announcements/' . $advertParcelId . '/delete');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }

    function apiDeleteCommercialAdvert()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $advertCommercialId = file_get_contents(codecept_data_dir('advertCommercialId.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/announcements/' . $advertCommercialId . '/delete');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }
    function apiDeleteGarageAdvert()
    {
//        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $advertGarageId = file_get_contents(codecept_data_dir('advertGarageId.json'));
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/announcements/' . $advertGarageId . '/delete');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }

    /*==================================================== Log API ==============================================*/

    function apiAdminLogs()
    {
        //todo: additional parameters - dateFrom, dateTo, endpoint.
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/logs');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    /*==================================================== Info API ==============================================*/

    function apiGetProjectInfo()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/get-project-info');

        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'address' => 'string',
            'schedule' => 'string',
            'phones' => 'string',
            'emails' => 'string',
            'copyright' => 'string',
            'logo' => 'array',
            'homepageH1' => 'string',
            'homepageContent' => 'string',
            'homepageTitle' => 'string',
            'homepageDescription' => 'string',
            'homepageKeywords' => 'string',
            'homepageRobots' => 'string',
        ]);
    }

    function apiEditProjectInfo()
    {
        //todo: before launch - upload to server the logotype image

        $logoID = file_get_contents(codecept_data_dir() . 'logo_id.json');
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/project-info/edit', [
            'logo' => $logoID,
            'address' => Info::prj_editAddress,
            'schedule' => Info::prj_editSchedule,
            'phones' => Info::prj_editPhones,
            'emails' => Info::prj_editEmails,
            'copyright' => Info::prj_editCopyright,
            'vk' => Info::prj_editVk,
            'facebook' => Info::prj_editFacebook,
            'google' => Info::prj_editGoogle,
            'ok' => Info::prj_editOk,
            'twitter' => Info::prj_editTwitter,
            'homepageH1' => Info::prj_editHomepageH1,
            'homepageContent' => Info::prj_editHomepageContent,
            'homepageTitle' => Info::prj_editHomepageTitle,
            'homepageDescription' => Info::prj_editHomepageDescription,
            'homepageKeywords' => Info::prj_editHomepageKeywords,
            'isIndex' => false,
            'isFollow' => false
        ]);

        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'address' => 'string',
            'schedule' => 'string',
            'phones' => 'string',
            'emails' => 'string',
            'copyright' => 'string',
            'logo' => 'array',
            'homepageH1' => 'string',
            'homepageContent' => 'string',
            'homepageTitle' => 'string',
            'homepageDescription' => 'string',
            'homepageKeywords' => 'string',
            'homepageRobots' => 'string',
        ]);
    }

    function apiGetInfoPage()
    {
        //todo: to change the aim info-page look the {latinName} page at the list info-pages

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/info/pages/contacts');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'name' => 'string',
            'latinName' => 'string',
            'content' => 'string',
            'title' => 'string',
            'metaDescription' => 'string',
            'metaRobots' => 'string'
        ]);
    }

    /*==================================================== Image API ==============================================*/

    //TODO: Fixed issue when we couldn't upload images with login (both func. in same Cest file)

    function uploadUserAvatar()
    {
        $this->restModule->sendPOST('/uploads/user-avatar/user_avatar', [], ['file' => codecept_data_dir('/img/pit.jpg')]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $usAvatar = $this->restModule->grabResponse();
        $avatar = json_decode($usAvatar)->id;
        file_put_contents(codecept_data_dir('avatar_id.json'), $avatar);
        $this->debugSection('avatarId', $avatar);
    }

    function uploadLogo()
    {
        $this->restModule->sendPOST('/uploads/user-avatar/logo', [], ['file' => codecept_data_dir('/img/logo.png')]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $log = $this->restModule->grabResponse();
        $logo = json_decode($log)->id;
        file_put_contents(codecept_data_dir('logo_id.json'), $logo);
        $this->debugSection('logoId', $logo);
    }


    function uploadEditUserAvatar()
    {
        $this->restModule->sendPOST('/uploads/user-avatar/user_avatar', [], ['file' => codecept_data_dir('/img/avatar_edit.jpg')]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $usAvatar = $this->restModule->grabResponse();
        $avatar = json_decode($usAvatar)->id;
        file_put_contents(codecept_data_dir('edit_avatar_id.json'), $avatar);
        $this->debugSection('avatarId', $avatar);
    }

    function uploadEditLogo()
    {
        $this->restModule->sendPOST('/uploads/user-avatar/logo', [], ['file' => codecept_data_dir('/img/agency_logo.png')]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $log = $this->restModule->grabResponse();
        $logo = json_decode($log)->id;
        file_put_contents(codecept_data_dir('edit_logo_id.json'), $logo);
        $this->debugSection('logoId', $logo);
    }

    function uploadCertificates()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->sendPOST('/uploads/certificates', [],
            ['file' => codecept_data_dir('/img/certificate_1.jpg')]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $imgCertificate = $this->restModule->grabResponse();
        $certificate = json_decode($imgCertificate)->id;
        file_put_contents(codecept_data_dir('certificate_id.json'), $certificate);
        $this->debugSection('certificateId', $certificate);
    }

    function uploadSchema($cat)
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        switch ($cat){
            case 0:
                $this->restModule->sendPOST('/uploads/schema', [], ['file' => codecept_data_dir('/img/schema_1.jpg')]);
                break;
            case 1:
                $this->restModule->sendPOST('/uploads/schema', [], ['file' => codecept_data_dir('/img/schema_2.jpg')]);
                break;
            case 2:
                $this->restModule->sendPOST('/uploads/schema', [], ['file' => codecept_data_dir('/img/schema_3.jpg')]);
                break;
            case 3:
                $this->restModule->sendPOST('/uploads/schema', [], ['file' => codecept_data_dir('/img/schema_4.jpg')]);
                break;

        }
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $objSchema = $this->restModule->grabResponse();
        $schema = json_decode($objSchema)->id;
        $file = file_put_contents(codecept_data_dir('schema_id.json'), $schema);
        $this->debugSection('schemaId', $schema);
    }

    function uploadAdvImages($cat)
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        switch($cat){
            case 0:
                $image1 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/flat_1.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img1 = $this->restModule->grabResponse($image1);
                $image2 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/flat_2.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img2 = $this->restModule->grabResponse($image2);

                $image3 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/flat_3.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img3 = $this->restModule->grabResponse($image3);
                $images = [];

                $image1 = new Images();
                $image1->id = json_decode($img1)->id;
                $image2 = new Images();
                $image2->id = json_decode($img2)->id;
                $image3 = new Images();
                $image3->id = json_decode($img3)->id;

                $images[] = $image1;
                $images[] = $image2;
                $images[] = $image3;
                $file = file_put_contents(codecept_data_dir('images_id.json'), json_encode($images, JSON_UNESCAPED_SLASHES));
                $this->debugSection('advertsID', $images);
                break;
            case 1:
                $image1 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/house_1.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img1 = $this->restModule->grabResponse($image1);
                $image2 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/house_2.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img2 = $this->restModule->grabResponse($image2);


                $images = [];

                $image1 = new Images();
                $image1->id = json_decode($img1)->id;
                $image2 = new Images();
                $image2->id = json_decode($img2)->id;


                $images[] = $image1;
                $images[] = $image2;

//        $advID = array('[{"id":"'.$advsId1.'"},{"id":"'.$advsId2.'"},{"id":"'.$advsId3.'"}]');
                $file = file_put_contents(codecept_data_dir('images_id.json'), json_encode($images, JSON_UNESCAPED_SLASHES));
                $this->debugSection('advertsID', $images);
                break;
            case 2:
                $image1 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/parcel_1.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img1 = $this->restModule->grabResponse($image1);
                $image2 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/parcel_2.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img2 = $this->restModule->grabResponse($image2);

                $image3 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/parcel_3.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img3 = $this->restModule->grabResponse($image3);
                $images = [];

                $image1 = new Images();
                $image1->id = json_decode($img1)->id;
                $image2 = new Images();
                $image2->id = json_decode($img2)->id;
                $image3 = new Images();
                $image3->id = json_decode($img3)->id;

                $images[] = $image1;
                $images[] = $image2;
                $images[] = $image3;
                $file = file_put_contents(codecept_data_dir('images_id.json'), json_encode($images, JSON_UNESCAPED_SLASHES));
                $this->debugSection('advertsID', $images);
                break;
            case 3:
                $image1 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/commerc_1.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img1 = $this->restModule->grabResponse($image1);
                $image2 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/commerc_2.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img2 = $this->restModule->grabResponse($image2);

                $image3 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/commerc_3.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img3 = $this->restModule->grabResponse($image3);
                $images = [];

                $image1 = new Images();
                $image1->id = json_decode($img1)->id;
                $image2 = new Images();
                $image2->id = json_decode($img2)->id;
                $image3 = new Images();
                $image3->id = json_decode($img3)->id;

                $images[] = $image1;
                $images[] = $image2;
                $images[] = $image3;
                $file = file_put_contents(codecept_data_dir('images_id.json'), json_encode($images, JSON_UNESCAPED_SLASHES));
                $this->debugSection('advertsID', $images);
                break;
            case 4:
                $image1 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/garage_1.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img1 = $this->restModule->grabResponse($image1);
                $image2 = $this->restModule->sendPOST('/uploads/announcement-image', [],
                    ['file' => codecept_data_dir('/img/garage_2.jpg')]);
                $this->restModule->seeResponseCodeIs(201);
                $this->restModule->seeResponseIsJson();
                $img2 = $this->restModule->grabResponse($image2);


                $images = [];

                $image1 = new Images();
                $image1->id = json_decode($img1)->id;
                $image2 = new Images();
                $image2->id = json_decode($img2)->id;


                $images[] = $image1;
                $images[] = $image2;

//        $advID = array('[{"id":"'.$advsId1.'"},{"id":"'.$advsId2.'"},{"id":"'.$advsId3.'"}]');
                $file = file_put_contents(codecept_data_dir('images_id.json'), json_encode($images, JSON_UNESCAPED_SLASHES));
                $this->debugSection('advertsID', $images);
                break;
        }
//

//        $advsId1 = json_decode($img1)->id;
//        $advsId2 = json_decode($img2)->id;
//        $advsId3 = json_decode($img3)->id;


    }

    /*==========================================================ADMIN API==============================================================*/
    function deleteAdvertImage()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $advImage0 = json_decode(file_get_contents(codecept_data_dir() . 'images_id.json'))[0]->id;
//        $advImage1 = json_decode(file_get_contents(codecept_data_dir().'images_id.json'))[1]->id;
//        $advImage2 = json_decode(file_get_contents(codecept_data_dir().'images_id.json'))[2]->id;
        $advertFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/announcements/' . $advertFlatId . '/images/' . $advImage0 . '/delete');

    }
    function apiAdminRegistrationAgency()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agencyOfficeRegion0 = $this->getRegionId(21);
        $agencyOfficeCity0 = $this->getCityId(6);
        $agencyOfficeAddress0 = $this->getStreetNameById(4,1);

        $agencyOfficeRegion1 = $this->getRegionId(21);
        $agencyOfficeCity1 = $this->getCityId(6);
        $agencyOfficeAddress1 = $this->getStreetNameById(4,1);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->sendPOST('/admin/registration/agency', [
            'name' => User::$agencyName,
            'subdomain' => User::uniqueSubdomain(),
            'firstName' => User::$agencyFirstName,
            'lastName' => User::$agencyLastName,
            'email' => User::uniqueApiAgencyEmail(),
            'plainPassword' => User::$agencyRegPass,
            'description' => User::$agencyDescription,
            'logo' => User::getAgencyLogo(),
            'userAvatar' => User::getAgencyAvatar(),
            'offices' => [
                array(
                    'officeName' => User::$agencyOfficeName0,
                    'region' => $agencyOfficeRegion0,
                    'city' => $agencyOfficeCity0,
                    'address' => $agencyOfficeAddress0,
                    'officeNumbers' => User::$agencyOfficeNumbers0,
                    'phones' => [
                        array('phone' => User::$agencyOfficePhoneNumber0_0),
                        array('phone' => User::$agencyOfficePhoneNumber0_1)
                    ]
                ),
                array(
                    'officeName' => User::$agencyOfficeName1,
                    'region' => $agencyOfficeRegion1,
                    'city' => $agencyOfficeCity1,
                    'address' => $agencyOfficeAddress1,
                    'officeNumbers' => User::$agencyOfficeNumbers1
                )
            ],
            'socialAccounts' => [array('facebook' => User::$agencySocialFb, 'vk' => User::$agencySocialVk)],
            'schedule' => [
                array('dayOfWeek' => '1-5', 'startTime' => '09:00', 'endTime' => '18:00'),
                array('dayOfWeek' => '6', 'startTime' => '10:00', 'endTime' => '13:00')
            ]
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $agency_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agency_data.json'), $agency_data);
    }





    /*======================================================= User API =============================================*/

    function apiAgenciesInfo()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('http://' . User::$subdomain . User::$domain . '/api/v1/agencies/info');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'id' => 'string',
            'name' => 'string',
            'description' => 'string',
            'email' => 'string',
            'userType' => 'string',
            'subdomain' => 'string'
        ]);

    }

    function apiAgenciesServices()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('http://' . User::$subdomain . User::$domain . '/api/v1/agencies/services');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'service' => 'array',
            'certificate' => 'array'
        ]);
    }

    function apiAgenciesEmployees()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('http://' . User::$subdomain . User::$domain . '/api/v1/agencies/employees');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'manager' => 'array',
            'employees' => 'array'
        ]);
    }

    function apiAgenciesAdverts()
    {
        //todo: you can do custom search by text of the advert
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('http://' . User::$subdomain . User::$domain . '/api/v1/agencies/get-announcements/1/24');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }

    function apiAdminUsersList()
    {
        //todo: additional parameters - role(e.g. ROLE_AGENT), status, text. (sample request - ?status=true&role=ROLE_AGENT&text=test)
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/users/1/25');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'page' => 'integer',
            'data' => 'array'
        ]);
    }


    function apiAdminUsersStatistic()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/users/statistics');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'active' => [
                'total' => 'integer',
                'agency' => 'integer',
                'agent' => 'integer',
                'privatePerson' => 'integer',
            ],
            'notActive' => [
                'total' => 'integer',
                'agency' => 'integer',
                'agent' => 'integer',
                'privatePerson' => 'integer',
            ]
        ]);
    }

    function apiUserById()
    {
        //todo: this check for simple agency. If have a lot time add cases for pr.person and agent or simplify
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/users/' . $agencyID);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'id' => 'string',
            'name' => 'string',
            'subdomain' => 'string',
            'firstName' => 'string',
            'lastName' => 'string',
            'email' => 'string'
        ]);
    }

//*=========================================================== USER API=====================================================*/

    public function apiGetUsers()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendGET('/users/1/24');
        $users = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('users.json'), $users);
    }

    function apiAgencyAgents()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/profiles/agencies/agents/1/25');
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'total' => 'integer',
            'count' => 'integer',
            'data' => 'array',
            'page' => 'integer'
        ]);
    }

    function apiAgencyEditServices()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $certificate1 = file_get_contents(codecept_data_dir() . 'certificate_id.json');
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/agencies/services/edit', [
            'services' => [
                [
                    'title' => User::$serviceTitle1,
                    'description' => User::$serviceDescription1
                ],
                [
                    'title' => User::$serviceTitle2,
                    'description' => User::$serviceDescription2
                ]
            ],
            'certificates' => [
                [
                    'title' => User::$certificateTitle1,
                    'image' => $certificate1

                ]
            ]
        ]);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseMatchesJsonType([
            'id' => 'string',
            'name' => 'string',
            'subdomain' => 'string',
            'firstName' => 'string',
            'lastName' => 'string',
            'email' => 'string',
            'certificates' => 'array',
            'services' => 'array'
        ]);
    }

    function apiUserRegistration()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/registration/private-person', [
            'firstName' => User::$userFirstName,
            'email' => User::uniqueApiUserEmail()
        ]);
        $user_info = $this->restModule->grabResponse();
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        file_put_contents(codecept_data_dir('user_data.json'), $user_info);
    }
    function apiEditUser()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $userToken = file_get_contents(codecept_data_dir('user_token.json'));
        $this->restModule->haveHttpHeader('token', $userToken);
        $this->restModule->sendPUT('/profiles/private-persons/edit', [
            'firstName' => User::$userFirstNameEdit,
            'lastName' => User::$userLastNameEdit,
            'email' => User::$userEmailEdit,
            'userAvatar' => User::getAgencyLogo(),
            'phones' => [
                        array('phone' => User::$userPhoneNumber1),
                        array('phone' => User::$userPhoneNumber2)

            ],
        ]);
        $user_info = $this->restModule->grabResponse();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        file_put_contents(codecept_data_dir('edit_user_data.json'), $user_info);
        $userToken = file_get_contents(codecept_data_dir('user_token.json'));
        $this->restModule->haveHttpHeader('token', $userToken);
        $this->restModule->sendPUT('/profiles/private-persons/edit', [
            'firstName' => User::$userFirstName,
            'lastName' => User::$userLastName,
            'email' => User::$userApiEmail,
            'userAvatar' => User::getAgencyLogo(),
            'phones' => [
                array('phone' => User::$userPhoneNumber2),
                array('phone' => User::$userPhoneNumber1)

            ],
        ]);
        $this->restModule->seeResponseCodeIs(200);
    }

    function changeUserPassword()
    {
        $userToken = file_get_contents(codecept_data_dir('user_token.json'));
        $this->restModule->haveHttpHeader('token', $userToken);
        $this->restModule->sendPUT('/profiles/change-password', [
            'oldPassword' => User::$agentPass,
            'newPassword' => 654321
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->haveHttpHeader('token', $userToken);
        $this->restModule->sendPUT('/profiles/change-password', [
            'oldPassword' => 654321,
            'newPassword' => User::$agentPass
        ]);
        $this->restModule->seeResponseCodeIs(200);

    }



    function apiCheckUserPasswordLink()
    {
        $md5Key = md5(User::getUserEmail());
        $this->restModule->sendGET('http://api.temp-mail.ru/request/mail/id/' . $md5Key . '/format/php');
        $raw_html = $this->restModule->grabResponse();
        $mail = User::grabPassFromMail($raw_html);
        file_put_contents(codecept_data_dir('user_password_response.php'), $mail);
    }


    function apiUserDelete()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendDELETE('/users/' . User::getUserId(1) . '/delete');
        /*$admin_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('user_delete.json'),$admin_data);*/
    }

    function apiAgentDelete()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendDELETE('/users/' . User::getUserId(2) . '/delete');
        /*$agent_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agent_data.json'), $agent_data);*/
    }

    function apiAgencyDelete()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendDELETE('/users/' . User::getUserId(3) . '/delete');
        /*$agency_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agency_data.json'), $agency_data);*/
    }

    function apiActivateUser()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/users/' . User::getUserId(1) . '/change-status', [
            'status' => 1
        ]);
        $user_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('user_data.json'), $user_data);
    }

    function apiDeActivateUser()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/users/' . User::getUserId(1) . '/change-status', [
            'status' => 0,
            'disableReason' => 'disabled'
        ]);
        $user_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('user_data.json'), $user_data);
    }

    function apiActivateAgent()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/users/' . User::getUserId(2) . '/change-status', [
            'status' => 1
        ]);
        $agent_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agent_data.json'), $agent_data);
    }

    function apiDeActivateAgent()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/users/' . User::getUserId(2) . '/change-status', [
            'status' => 0,
            'disableReason' => 'disabled'
        ]);
        $agent_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agent_data.json'), $agent_data);
    }

    function apiActivateAgency()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/users/' . User::getUserId(3) . '/change-status', [
            'status' => 1
        ]);
        $agency_data = $this->restModule->grabResponse();
        $agency_token = $this->restModule->grabDataFromResponseByJsonPath('$.token');
        file_put_contents(codecept_data_dir('agency_data.json'), $agency_data);
        file_put_contents(codecept_data_dir('agency_token.json'), $agency_token);
    }

    function apiDeActivateAgency()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAdminToken());
        $this->restModule->sendPUT('/users/' . User::getUserId(3) . '/change-status', [
            'status' => 0,
            'disableReason' => 'disabled'
        ]);
        $agency_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agency_data.json'), $agency_data);
    }

    function apiAgentRegistration()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->sendPOST('/registration/agent', [
            'firstName' => User::$agentFirstName,
            'lastName' => User::$agentLastName,
            'email' => User::uniqueApiAgentEmail(),
            'plainPassword' => User::$agentPass,
//            'userAvatar' => User::getAgencyAvatar(),
            'phones' => [
                array('phone' => User::$agentPhone0),
                array('phone' => User::$agentPhone1)
            ],
        ]);
        $agent_info = $this->restModule->grabResponse();
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        file_put_contents(codecept_data_dir('agent_data.json'), $agent_info);
    }
    function apiEditAgent()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->sendPUT('/profiles/agents/edit', [
            'firstName' => User::$editAgentFirstName,
            'lastName' => User::$editAgentLastName,
            'email' => User::uniqueApiAgentEmail(),
            'userAvatar' => User::getAgencyAvatar(),
            'phones' => [
                array('phone' => User::$editAgentPhone0),
                array('phone' => User::$editAgentPhone1)
            ],
        ]);
        $agent_info = $this->restModule->grabResponse();
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        file_put_contents(codecept_data_dir('edit_agent_data.json'), $agent_info);
    }
    function changeAgentPassword()
    {
        $agentToken = file_get_contents(codecept_data_dir('agent_token.json'));
        $this->restModule->haveHttpHeader('token', $agentToken);
        $this->restModule->sendPUT('/profiles/change-password', [
            'oldPassword' => User::$agentPass,
            'newPassword' => 654321
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->haveHttpHeader('token', $agentToken);
        $this->restModule->sendPUT('/profiles/change-password', [
            'oldPassword' => 654321,
            'newPassword' => User::$agentPass
        ]);
        $this->restModule->seeResponseCodeIs(200);

    }



    function apiAgencyRegistration()
    {

        $agencyOfficeRegion0 = $this->getRegionId(21);
        $agencyOfficeCity0 = $this->getCityId(6);
        $agencyOfficeAddress0 = $this->getStreetNameById(4,1);

        $agencyOfficeRegion1 = $this->getRegionId(21);
        $agencyOfficeCity1 = $this->getCityId(6);
        $agencyOfficeAddress1 = $this->getStreetNameById(4,1);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/registration/agency', [
            'name' => User::$agencyName,
            'subdomain' => User::uniqueSubdomain(),
            'firstName' => User::$agencyFirstName,
            'lastName' => User::$agencyLastName,
            'email' => User::uniqueApiAgencyEmail(),
            'plainPassword' => User::$agencyRegPass,
            'description' => User::$agencyDescription,
//            'logo' => User::getAgencyLogo(),
//            'userAvatar' => User::getAgencyAvatar(),
            'offices' => [
                array(
                    'officeName' => User::$agencyOfficeName0,
                    'region' => $agencyOfficeRegion0,
                    'city' => $agencyOfficeCity0,
                    'address' => $agencyOfficeAddress0,
                    'officeNumbers' => User::$agencyOfficeNumbers0,
                    'phones' => [
                        array('phone' => User::$agencyOfficePhoneNumber0_0),
                        array('phone' => User::$agencyOfficePhoneNumber0_1)
                    ]
                ),
                array(
                    'officeName' => User::$agencyOfficeName1,
                    'region' => $agencyOfficeRegion1,
                    'city' => $agencyOfficeCity1,
                    'address' => $agencyOfficeAddress1,
                    'officeNumbers' => User::$agencyOfficeNumbers1
                )
            ],
            'socialAccounts' => [array('facebook' => User::$agencySocialFb, 'vk' => User::$agencySocialVk)],
            'schedule' => [
                array('dayOfWeek' => '1-5', 'startTime' => '09:00', 'endTime' => '18:00'),
                array('dayOfWeek' => '6', 'startTime' => '10:00', 'endTime' => '13:00')
            ]
        ]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $agency_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agency_data.json'), $agency_data);
    }

    function checkAgencyDomain()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->sendGET('/registration/agency/check-subdomain/'.User::uniqueSubdomain().'');
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
    }

    function apiEditAgency()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $agencyOfficeRegion0 = $this->getRegionId(21);
        $agencyOfficeCity0 = $this->getCityId(3);
        $agencyOfficeAddress0 = $this->getStreetNameById(3,2);
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $agencyOfficeRegion1 = $this->getRegionId(21);
        $agencyOfficeCity1 = $this->getCityId(3);
        $agencyOfficeAddress1 = $this->getStreetNameById(3,2);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->sendPUT('/profiles/agencies/edit', [
            'name' => User::$editAgencyName,
            'subdomain' => User::uniqueSubdomain(),
            'firstName' => User::$editAgencyfirstName,
            'lastName' => User::$editAgencylastName,
            'email' => User::uniqueApiAgencyEmail(),
            'description' => User::$editAgencyDescription,
            'logo' => User::getEditAgencyLogo(),
            'userAvatar' => User::getEditAgencyAvatar(),
            'id' => $userId,
            'offices' => [
                array(
                    'officeName' => User::$editAgencyOfficeName0,
                    'region' => $agencyOfficeRegion0,
                    'city' => $agencyOfficeCity0,
                    'address' => $agencyOfficeAddress0,
                    'officeNumbers' => User::$editAgencyOfficeNumbers0,
                    'phones' => [
                        array('phone' => User::$editAgencyOfficePhoneNumber0_0),
                        array('phone' => User::$editAgencyOfficePhoneNumber0_1)
                    ]
                ),
                array(
                    'officeName' => User::$editAgencyOfficeName1,
                    'region' => $agencyOfficeRegion1,
                    'city' => $agencyOfficeCity1,
                    'address' => $agencyOfficeAddress1,
                    'officeNumbers' => User::$editAgencyOfficeNumbers1
                )
            ],
            'socialAccounts' => [array('facebook' => User::$editAgencySocialFb, 'vk' => User::$editAgencySocialVk)],
            'schedule' => [
                array('dayOfWeek' => '6', 'startTime' => '09:00', 'endTime' => '18:00'),
                array('dayOfWeek' => '1-5', 'startTime' => '10:00', 'endTime' => '13:00')
            ]
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $agency_data = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('edit_agency_data.json'), $agency_data);
    }

    function changeAgencyPassword()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->sendPUT('/profiles/change-password', [
            'oldPassword' => User::$agencyPass3,
            'newPassword' => 654321
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->sendPUT('/profiles/change-password', [
            'oldPassword' => 654321,
            'newPassword' => User::$agencyPass3
        ]);
        $this->restModule->seeResponseCodeIs(200);

    }



    function getStreetNameById($cityId, $name)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $city = $this->getCityId($cityId);
        $this->restModule->sendGET('/lists/streets/' . $city);
        $streets = $this->restModule->grabResponse();
        $streetName = json_decode($streets)[$name]->name;
        $this->debugSection('Street ID', $streetName);
        file_put_contents(codecept_data_dir('streets_name.json'), $streets);
        return $streetName;
    }

    function getDistrictNameById($cityId, $name)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $city = $this->getCityId($cityId);
        $this->restModule->sendGET('/lists/districts/' . $city);
        $streets = $this->restModule->grabResponse();
        $streetName = json_decode($streets)[$name]->name;
        $this->debugSection('District ID', $streetName);
//        file_put_contents(codecept_data_dir('streets_name.json'), $streets);
        return $streetName;
    }


}

class Images
{
    public $id;
    public $mainImage;
}



