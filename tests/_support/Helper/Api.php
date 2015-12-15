<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

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
        $this->restModule->sendGET('/lists/category-types/' . $flat);
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
        $this->restModule->sendGET('/lists/category-types/' . $house);
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
        $this->restModule->sendGET('/lists/category-types/' . $parcel);
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
        $this->restModule->sendGET('/lists/category-types/' . $commerc);
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
        $this->restModule->sendGET('/lists/additionals/' . $flat);
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
        file_put_contents(codecept_data_dir('currency.json'), $currency);
        $currencyId = json_decode($currency)[$id]->id;
        $this->debugSection('currencyId', $currencyId);
        return $currencyId;
    }

    function getHouseNumbers($id)
    {
        $streetId = $this->getStreet(0);
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

    function getWallMaterials($id) //0..10
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

    function apiGetAgencyAnnouncementsList()
    {
        $token = User::getAgencyToken();
        $this->restModule->haveHttpHeader('token', $token);
        $this->restModule->sendGET('/profiles/announcements-lists/lists');
        $announcement_list = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agency_announcement_list.json'), $announcement_list);
    }

    function apiGetAgentAnnouncementsList()
    {
        $token = User::getAgentToken();
        $this->restModule->haveHttpHeader('token', $token);
        $this->restModule->sendGET('/profiles/announcements-lists/lists');
        $announcement_list = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agent_announcement_list.json'), $announcement_list);
    }

    function apiGetUserAnnouncementsList()
    {
        $token = User::getUserToken();
        $this->restModule->haveHttpHeader('token', $token);
        $this->restModule->sendGET('/profiles/announcements-lists/lists');
        $announcement_list = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('user_announcement_list.json'), $announcement_list);
    }

    function apiGetUser()
    {
        $token = User::getUserToken();
        $this->restModule->haveHttpHeader('token', $token);
        $this->restModule->sendGET('/users/' . User::getUserId(1));
        $user_info = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('get_user.json'), $user_info);
    }

    function apiGetAgent()
    {
        $token = User::getAgentToken();
        $this->restModule->haveHttpHeader('token', $token);
        $this->restModule->sendGET('/users/' . User::getUserId(2));
        $agent_info = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('get_agent.json'), $agent_info);
    }

    function apiGetAgency()
    {
        $token = User::getAgencyToken();
        $this->restModule->haveHttpHeader('token', $token);
        $this->restModule->sendGET('/users/' . User::getUserId(3));
        $agency_info = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('get_agency.json'), $agency_info);
    }
    function apiGetAgencies()
    {
        $agencyName = User::$agencyName;
        $region = $this->getRegion(21);
        $city = $this->getCity(6);
        //http://uhome.co/api/v1/users/agencies/search/1/24?city=5620c5e1d69b5aaa228b45b4&name=best&region=5620c5e1d69b5aaa228b459c
        $this->restModule->sendGET('/users/agencies/search/1/24?city='.$city.'&name='.$agencyName.'&region='.$region.'');
        $agencies_list = $this->restModule->grabResponse();
        file_put_contents(codecept_data_dir('agencies_list.json'), $agencies_list);
        $this->restModule->seeResponseCodeIS(200);
    }

    /*======================================================== API REALTY ==================================*/

    /*=================================== COMMON =================================*/

    function realtyFlatHistory()
    {
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyFlatID = file_get_contents(codecept_data_dir('realtyFlatId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyHouseID = file_get_contents(codecept_data_dir('realtyHouseId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyParcelID = file_get_contents(codecept_data_dir('realtyParcelId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyCommercialID = file_get_contents(codecept_data_dir('realtyCommercialId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $agency = file_get_contents(codecept_data_dir('agency_data.json'));
        $agencyID = json_decode($agency)->id;

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/realties/lists', [
            'category' => $this->getCategories(0),
            'categoryType' => $this->getFlatCategoryTypes(0),
            'status' => 1,
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'street' => $this->getStreet(32),
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/add', [
            'category' => $this->getCategories(0),
            'categoryType' => $this->getFlatCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
//            'district' => $this->getDistrict(23),
            'street' => $this->getStreet(0),
            'houseNumber' => Flat::houseNumber,
            'flatNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Flat::latitude,
            'longitude' => Flat::longitude,
            'roomCount' => Flat::roomCount,
            'wallMaterial' => $this->getWallMaterials(0),
            'area' => Flat::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
//            'livingArea' => Flat::livingArea,
//            'kitchenArea' => Flat::kitchenArea,
            'floor' => Flat::floors,
            'floorNumber' => Flat::floorNumber,
//            'buildYear' => Flat::buildYear,
            'wc' => $this->getWC(0),
            'balcony' => $this->getBalconies(0),
            'heating' => $this->getHeatings(0),
            'waterHeating' => $this->getWaterHeatings(0),
//            'nearObjects' => [$this->getNearObjects(0), $this->getNearObjects(1), $this->getNearObjects(5)],
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/add', [
            'category' => $this->getCategories(0),
            'categoryType' => $this->getFlatCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(7),
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
            'heating' => $this->getHeatings(1),
            'waterHeating' => $this->getWaterHeatings(1),
            'nearObjects' => [
                $this->getNearObjects(0),
                $this->getNearObjects(1),
                $this->getNearObjects(2),
                $this->getNearObjects(3),
                $this->getNearObjects(4),
                $this->getNearObjects(5),
                $this->getNearObjects(6),
                $this->getNearObjects(7),
                $this->getNearObjects(8),
                $this->getNearObjects(9)
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
//        $schema = file_get_contents(codecept_data_dir('schema_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/add', [
            'category' => $this->getCategories(0),
            'categoryType' => $this->getFlatCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(7),
            'street' => $this->getStreet(34),
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
            'floor' => Flat::floorNumber,
            'floorNumber' => Flat::floors,
            'buildYear' => Flat::buildYear,
            'wc' => $this->getWC(1),
            'balcony' => $this->getBalconies(1),
            'heating' => $this->getHeatings(1),
            'waterHeating' => $this->getWaterHeatings(1),
            'nearObjects' => [$this->getNearObjects(0)]
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $flatNumbs = file_get_contents(codecept_data_dir('flat_numbers.json'));
        $flatNumber = json_decode($flatNumbs)[0]->number;
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/check', [
            'category' => $this->getCategories(0),
            'categoryType' => $this->getFlatCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'street' => $this->getStreet(0),
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/validate', [
            'category' => $this->getCategories(0),
            'categoryType' => $this->getFlatCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
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
            'heating' => $this->getHeatings(1),
            'waterHeating' => $this->getWaterHeatings(1),
            'nearObjects' => [$this->getNearObjects(0), $this->getNearObjects(1)]

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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $realtyFlatID = file_get_contents(codecept_data_dir('realtyFlatId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/flats/edit/' . $realtyFlatID, [
            'status' => 1,
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(0),
            'street' => $this->getStreet(0),
            'houseNumber' => House::uniqueHouseNumber(),
            'flatNumber' => Flat::uniqueFlatNumber(),
            'latitude' => Flat::editLatitude,
            'longitude' => Flat::editLongitude,
            'roomCount' => Flat::editRoomCount,
            'wallMaterial' => $this->getWallMaterials(2),
            'area' => Flat::editGeneralArea,
            'areaUnit' => $this->getAreaUnits(0),
            'livingArea' => Flat::editLivingArea,
            'kitchenArea' => Flat::editKitchenArea,
            'floor' => Flat::editFloorNumber,
            'floorNumber' => Flat::editFloors,
            'buildYear' => Flat::editBuildYear,
            'wc' => $this->getWC(2),
            'balcony' => $this->getBalconies(2),
            'heating' => $this->getHeatings(2),
            'waterHeating' => $this->getWaterHeatings(2),
            'nearObjects' => [
                $this->getNearObjects(0),
                $this->getNearObjects(1),
                $this->getNearObjects(2),
                $this->getNearObjects(3),
                $this->getNearObjects(4),
                $this->getNearObjects(5),
                $this->getNearObjects(6),
                $this->getNearObjects(7),
                $this->getNearObjects(8),
                $this->getNearObjects(9)
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyFlatID = file_get_contents(codecept_data_dir('realtyFlatId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/add', [
            'category' => $this->getCategories(1),
            'categoryType' => $this->getHouseCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'street' => $this->getStreet(94),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::latitude,
            'longitude' => House::longitude,
            'roomCount' => House::roomCount,
//            'landArea' => House::landArea,
            'landAreaUnit' => $this->getAreaUnits(0),
            'floorNumber' => House::floors,
            'wallMaterial' => $this->getWallMaterials(10),
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'wc' => $this->getWC(0),
            'heating' => $this->getHeatings(0),
            'waterHeating' => $this->getWaterHeatings(0)
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/add', [
            'category' => $this->getCategories(1),
            'categoryType' => $this->getHouseCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(2),
            'street' => $this->getStreet(94),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::latitude,
            'longitude' => House::longitude,
            'roomCount' => House::roomCount,
            'wallMaterial' => $this->getWallMaterials(10),
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'livingArea' => House::livingArea,
            'kitchenArea' => House::kitchenArea,
            'landArea' => House::landArea,
            'landAreaUnit' => $this->getAreaUnits(1),
            'floorNumber' => House::floors,
            'buildYear' => House::buildYear,
            'wc' => $this->getWC(0),
            'heating' => $this->getHeatings(1),
            'waterHeating' => $this->getWaterHeatings(1),
            'communication' => [
                $this->getCommunications(0),
                $this->getCommunications(1),
                $this->getCommunications(2),
                $this->getCommunications(3),
                $this->getCommunications(4),
                $this->getCommunications(5),
                $this->getCommunications(6),
                $this->getCommunications(7)
            ],
            'nearObjects' => [
                $this->getNearObjects(0),
                $this->getNearObjects(1),
                $this->getNearObjects(2),
                $this->getNearObjects(3),
                $this->getNearObjects(4),
                $this->getNearObjects(5),
                $this->getNearObjects(6),
                $this->getNearObjects(7),
                $this->getNearObjects(8),
                $this->getNearObjects(9)
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/add', [
            'category' => $this->getCategories(1),
            'categoryType' => $this->getHouseCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(3),
            'street' => $this->getStreet(52),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::latitude,
            'longitude' => House::longitude,
            'roomCount' => House::roomCount,
            'wallMaterial' => $this->getWallMaterials(10),
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'livingArea' => House::livingArea,
            'kitchenArea' => House::kitchenArea,
            'landArea' => House::landArea,
            'landAreaUnit' => $this->getAreaUnits(1),
            'floorNumber' => House::floors,
            'buildYear' => House::buildYear,
            'wc' => $this->getWC(0),
            'heating' => $this->getHeatings(1),
            'waterHeating' => $this->getWaterHeatings(1),
            'communication' => [
                $this->getCommunications(0)],
            'nearObjects' => [
                $this->getNearObjects(0)]
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/check', [
            'category' => $this->getCategories(1),
            'categoryType' => $this->getHouseCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'street' => $this->getStreet(94),
            'houseNumber' => House::$currentHouseNumber
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType(['id' => 'string']);
    }

    function realtyHousesValidate()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/houses/validate', [
            'category' => $this->getCategories(1),
            'categoryType' => $this->getHouseCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(2),
            'street' => $this->getStreet(94),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::latitude,
            'longitude' => House::longitude,
            'roomCount' => House::roomCount,
            'wallMaterial' => $this->getWallMaterials(10),
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'livingArea' => House::livingArea,
            'kitchenArea' => House::kitchenArea,
            'landArea' => House::landArea,
            'landAreaUnit' => $this->getAreaUnits(1),
            'floorNumber' => House::floors,
            'buildYear' => House::buildYear,
            'wc' => $this->getWC(0),
            'heating' => $this->getHeatings(1),
            'waterHeating' => $this->getWaterHeatings(1),
            'communication' => [$this->getCommunications(0), $this->getCommunications(1)],
            'nearObjects' => [$this->getNearObjects(0), $this->getNearObjects(1), $this->getNearObjects(2)]
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $realtyHouseID = file_get_contents(codecept_data_dir('realtyHouseId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/houses/edit/' . $realtyHouseID, [
            'status' => 1,
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'street' => $this->getStreet(21),
            'houseNumber' => House::uniqueHouseNumber(),
            'latitude' => House::editLatitude,
            'longitude' => House::editLongitude,
            'area' => House::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'livingArea' => House::editLivingArea,
            'kitchenArea' => House::editKitchenArea,
            'landArea' => House::editLandArea,
            'landAreaUnit' => $this->getAreaUnits(1),
            'roomCount' => House::editRoomCount,
            'wallMaterial' => $this->getWallMaterials(1),
            'floorNumber' => House::editFloors,
            'buildYear' => House::editBuildYear,
            'wc' => $this->getWC(1),
            'heating' => $this->getHeatings(1),
            'waterHeating' => $this->getWaterHeatings(1),
            'communication' => [
                $this->getCommunications(0),
                $this->getCommunications(1),
                $this->getCommunications(2),
                $this->getCommunications(3),
                $this->getCommunications(4),
                $this->getCommunications(5),
                $this->getCommunications(6),
                $this->getCommunications(7)
            ],
            'nearObjects' => [
                $this->getNearObjects(0),
                $this->getNearObjects(1),
                $this->getNearObjects(2),
                $this->getNearObjects(3),
                $this->getNearObjects(4),
                $this->getNearObjects(5),
                $this->getNearObjects(6),
                $this->getNearObjects(7),
                $this->getNearObjects(8),
                $this->getNearObjects(9)
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyHouseID = file_get_contents(codecept_data_dir('realtyHouseId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/add', [
            'category' => $this->getCategories(2),
            'categoryType' => $this->getParcelCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
//            'district' => $this->getDistrict(7),
//            'street' => $this->getStreet(32),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::latitude,
            'longitude' => Parcel::longitude,
            'area' => Parcel::generalArea,
            'areaUnit' => $this->getAreaUnits(1),
//            'communication' => [$this->getCommunications(0), $this->getCommunications(6)],
//            'nearObjects' => [$this->getNearObjects(0), $this->getNearObjects(3)]
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/add', [
            'category' => $this->getCategories(2),
            'categoryType' => $this->getParcelCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(7),
            'street' => $this->getStreet(32),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::latitude,
            'longitude' => Parcel::longitude,
            'area' => Parcel::generalArea,
            'areaUnit' => $this->getAreaUnits(1),
            'communication' => [
                $this->getCommunications(0),
                $this->getCommunications(1),
                $this->getCommunications(2),
                $this->getCommunications(3),
                $this->getCommunications(4),
                $this->getCommunications(5),
                $this->getCommunications(6),
                $this->getCommunications(7)
            ],
            'nearObjects' => [
                $this->getNearObjects(0),
                $this->getNearObjects(1),
                $this->getNearObjects(2),
                $this->getNearObjects(3),
                $this->getNearObjects(4),
                $this->getNearObjects(5),
                $this->getNearObjects(6),
                $this->getNearObjects(7),
                $this->getNearObjects(8),
                $this->getNearObjects(9)
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
//        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/add', [
            'category' => $this->getCategories(2),
            'categoryType' => $this->getParcelCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(7),
            'street' => $this->getStreet(32),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::latitude,
            'longitude' => Parcel::longitude,
            'area' => Parcel::generalArea,
            'areaUnit' => $this->getAreaUnits(1),
            'communication' => [$this->getCommunications(0)],
            'nearObjects' => [$this->getNearObjects(0)],
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $cadastr = file_get_contents(codecept_data_dir('cadastral_number.txt'));
        $cadastrNumb = str_replace(':', '', $cadastr);
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/check', [
            'category' => $this->getCategories(2),
            'categoryType' => $this->getParcelCategoryTypes(0),
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/parcels/validate', [
            'category' => $this->getCategories(2),
            'categoryType' => $this->getParcelCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(7),
            'street' => $this->getStreet(32),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::latitude,
            'longitude' => Parcel::longitude,
            'area' => Parcel::generalArea,
            'areaUnit' => $this->getAreaUnits(1),
            'communication' => [$this->getCommunications(0), $this->getCommunications(1)],
            'nearObjects' => [$this->getNearObjects(0), $this->getNearObjects(1), $this->getNearObjects(2)]
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $realtyParcelID = file_get_contents(codecept_data_dir('realtyParcelId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/parcels/edit/' . $realtyParcelID, [
            'status' => 1,
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(7),
            'street' => $this->getStreet(25),
            'cadastralNumber' => Parcel::uniqueCadastralNumber(),
            'latitude' => Parcel::editLatitude,
            'longitude' => Parcel::editLongitude,
            'area' => Parcel::editGeneralArea,
            'areaUnit' => $this->getAreaUnits(2),
            'communication' => [
                $this->getCommunications(0),
                $this->getCommunications(1),
                $this->getCommunications(2),
                $this->getCommunications(3),
                $this->getCommunications(4),
                $this->getCommunications(5),
                $this->getCommunications(6),
                $this->getCommunications(7)
            ],
            'nearObjects' => [
                $this->getNearObjects(0),
                $this->getNearObjects(1),
                $this->getNearObjects(2),
                $this->getNearObjects(3),
                $this->getNearObjects(4),
                $this->getNearObjects(5),
                $this->getNearObjects(6),
                $this->getNearObjects(7),
                $this->getNearObjects(8),
                $this->getNearObjects(9)
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyParcelsID = file_get_contents(codecept_data_dir('realtyParcelId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
//        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/add', [
            'category' => $this->getCategories(3),
            'categoryType' => $this->getCommercialCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(7),
            'street' => $this->getStreet(97),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::latitude,
            'longitude' => Commercial::longitude,
            'area' => Commercial::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'effectiveArea' => Commercial::effectiveArea,
            'wallMaterial' => $this->getWallMaterials(0),
            'roomCount' => Commercial::roomCount,
            'floor' => Commercial::floors,
            'floorNumber' => Commercial::floorNumber,
            'wc' => $this->getWC(0),
            'heating' => $this->getHeatings(0),
            'waterHeating' => $this->getWaterHeatings(0),
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/add', [
            'category' => $this->getCategories(3),
            'categoryType' => $this->getCommercialCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(7),
            'street' => $this->getStreet(39),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::latitude,
            'longitude' => Commercial::longitude,
            'area' => Commercial::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'effectiveArea' => Commercial::effectiveArea,
            'wallMaterial' => $this->getWallMaterials(0),
            'roomCount' => Commercial::roomCount,
            'floor' => Commercial::floorNumber,
            'floorNumber' => Commercial::floors,
            'buildYear' => Commercial::buildYear,
            'wc' => $this->getWC(2),
            'heating' => $this->getHeatings(2),
            'waterHeating' => $this->getWaterHeatings(2),
            'communication' => [
                $this->getCommunications(0),
                $this->getCommunications(1),
                $this->getCommunications(2),
                $this->getCommunications(3),
                $this->getCommunications(4),
                $this->getCommunications(5),
                $this->getCommunications(6),
                $this->getCommunications(7)
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/add', [
            'category' => $this->getCategories(3),
            'categoryType' => $this->getCommercialCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(7),
            'street' => $this->getStreet(49),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::latitude,
            'longitude' => Commercial::longitude,
            'area' => Commercial::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'effectiveArea' => Commercial::effectiveArea,
            'wallMaterial' => $this->getWallMaterials(0),
            'roomCount' => Commercial::roomCount,
            'floor' => Commercial::floorNumber,
            'floorNumber' => Commercial::floors,
            'buildYear' => Commercial::buildYear,
            'wc' => $this->getWC(2),
            'heating' => $this->getHeatings(2),
            'waterHeating' => $this->getWaterHeatings(2),
            'communication' => [$this->getCommunications(0)],
//            'schema' => $schema
        ]);

        $realtyCommercial = $this->restModule->grabResponse();
        $realtyCommercialId = json_decode($realtyCommercial)->id;
        file_put_contents(codecept_data_dir('realtyCommercialId.json'), $realtyCommercialId);
        $this->debugSection('realtyCommercialId', $realtyCommercialId);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
    }

    /*==============================================SEARCH API=========================================================*/
    function apiFlatSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&userIds[0]='.$agencyID.'&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('total' => 18));
        $search = $this->restModule->grabResponse();
        $this->debugSection('realtyFlatId', $search);

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(22).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(5).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(8).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(35).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(1).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSell.'&priceTo='.Flat::priceFlatSell.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(1).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::editBuildYear.'&buildYearTo='.Flat::editBuildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::editBeds.'&bedsCountTo='.Flat::editBeds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(1).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(1).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(2).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::editGeneralArea.'&areaTo='.Flat::editGeneralArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::editLivingArea.'&livingAreaTo='.Flat::editLivingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::editKitchenArea.'&kitchenAreaTo='.Flat::editKitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::editRoomCount.'&roomCountTo='.Flat::editRoomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::editFloorNumber.'&floorTo='.Flat::editFloorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::editFloors.'&floorNumberFrom='.Flat::editFloors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(1).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(1).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(1).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(34).'&category='.$this->getCategories(0).'&categoryType='.$this->getFlatCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Flat::priceFlatSearch.'&priceTo='.Flat::priceFlatSearch.'&auction=true&marketType='.$this->getMarketType(0).'&buildYearFrom='.Flat::buildYear.'&buildYearTo='.Flat::buildYear.'&bedsCountFrom='.Flat::beds.'&bedsCountTo='.Flat::beds.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&balcony='.$this->getBalconies(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.Flat::generalArea.'&areaTo='.Flat::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.Flat::livingArea.'&livingAreaTo='.Flat::livingArea.'&kitchenAreaFrom='.Flat::kitchenArea.'&kitchenAreaTo='.Flat::kitchenArea.'&roomCountFrom='.Flat::roomCount.'&roomCountTo='.Flat::roomCount.'&floorFrom='.Flat::floorNumber.'&floorTo='.Flat::floorNumber.'&floorNumberTo='.Flat::floors.'&floorNumberFrom='.Flat::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getFlatAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(1));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

    }

    function apiHouseSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('total' => 15));
        $searchHouse = $this->restModule->grabResponse();
        $this->debugSection('Search', $searchHouse);


        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(22).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(5).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(4).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(53).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(1).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.House::editPriceHouseRent.'&priceTo='.House::editPriceHouseRent.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(0).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::editBuildYear.'&buildYearTo='.House::editBuildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(9).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(1).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::editGeneralArea.'&areaTo='.House::editGeneralArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&livingAreaFrom='.House::editLivingArea.'&livingAreaTo='.House::editLivingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::editKitchenArea.'&kitchenAreaTo='.House::editKitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::editRoomCount.'&roomCountTo='.House::editRoomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::editFloors.'&floorNumberFrom='.House::editFloors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(1).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(1).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(1).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(3).'&street='.$this->getStreet(52).'&category='.$this->getCategories(1).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.House::priceHouseSearch.'&priceTo='.House::priceHouseSearch.'&period='.$this->getPeriod(1).'&auction=true&userIds[0]='.$agencyID.'&buildYearFrom='.House::buildYear.'&buildYearTo='.House::buildYear.'&wallMaterial='.$this->getWallMaterials(10).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(0).'&heating='.$this->getHeatings(1).'&waterHeating='.$this->getWaterHeatings(1).'&areaFrom='.House::generalArea.'&areaTo='.House::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&livingAreaFrom='.House::livingArea.'&livingAreaTo='.House::livingArea.'&kitchenAreaFrom='.House::kitchenArea.'&kitchenAreaTo='.House::kitchenArea.'&roomCountFrom='.House::roomCount.'&roomCountTo='.House::roomCount.'&floorNumberTo='.House::floors.'&floorNumberFrom='.House::floors.'&furniture[0]='.$this->getFurnitures(0).'&appliances[0]='.$this->getAppliances(0).'&additionally[0]='.$this->getHouseAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(1));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

    }

    function apiParcelSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('total' => 11));
        $searchParcel = $this->restModule->grabResponse();
        $this->debugSection('Search', $searchParcel);

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(22).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(5).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(4).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(37).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(1).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Parcel::editPriceParcelSell.'&priceTo='.Parcel::editPriceParcelSell.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]=56681324d69b5a3e1c8b456c&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::editGeneralArea.'&areaTo='.Parcel::editGeneralArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(1).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(1).'&nearObjects[0]='.$this->getNearObjects(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(32).'&category='.$this->getCategories(2).'&categoryType='.$this->getParcelCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Parcel::priceParcelSearch.'&priceTo='.Parcel::priceParcelSearch.'&auction=true&userIds[0]='.$agencyID.'&areaFrom='.Parcel::generalArea.'&areaTo='.Parcel::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getParcelAdditionals(0).'&nearObjects[0]='.$this->getNearObjects(1));
        $this->restModule->seeResponseContainsJson(array('total' => 0));





    }

    function apiCommercialSearch()
    {
        $agencyID = json_decode(file_get_contents(codecept_data_dir() . 'agency_data.json'))->id;
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseContainsJson(array('total' => 13));
        $search = $this->restModule->grabResponse();
        $this->debugSection('Commercial', $search);

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(0).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(22).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(5).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(8).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(45).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(2).'&categoryType='.$this->getHouseCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(2).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(0).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSell.'&priceTo='.Commercial::priceCommercialSell.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(1).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]=56681324d69b5a3e1c8b456c&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::editBuildYear.'&buildYearTo='.Commercial::editBuildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(1).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(1).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(1).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(3).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(3).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::editGeneralArea.'&areaTo='.Commercial::editGeneralArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(1).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::editRoomCount.'&roomCountTo='.Commercial::editRoomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::editFloorNumber.'&floorTo='.Commercial::editFloorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::editFloor.'&floorNumberFrom='.Commercial::editFloor.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(1).'&additionally[0]='.$this->getCommercialAdditionals(0));
        $this->restModule->seeResponseContainsJson(array('total' => 0));

        $this->restModule->sendGET('/search/1/24/date?operationType='.$this->getOperationType(1).'&region='.$this->getRegion(21).'&city='.$this->getCity(6).'&district='.$this->getDistrict(7).'&street='.$this->getStreet(49).'&category='.$this->getCategories(3).'&categoryType='.$this->getCommercialCategoryTypes(0).'&currency='.$this->getCurrency(1).'&priceFrom='.Commercial::priceCommercialSearch.'&priceTo='.Commercial::priceCommercialSearch.'&auction=true&period='.$this->getPeriod(0).'&userIds[0]='.$agencyID.'&buildYearFrom='.Commercial::buildYear.'&buildYearTo='.Commercial::buildYear.'&wallMaterial='.$this->getWallMaterials(0).'&repair='.$this->getRepairs(0).'&wc='.$this->getWC(2).'&heating='.$this->getHeatings(2).'&waterHeating='.$this->getWaterHeatings(2).'&areaFrom='.Commercial::generalArea.'&areaTo='.Commercial::generalArea.'&areaUnit='.$this->getAreaUnits(0).'&roomCountFrom='.Commercial::roomCount.'&roomCountTo='.Commercial::roomCount.'&floorFrom='.Commercial::floorNumber.'&floorTo='.Commercial::floorNumber.'&floorNumberTo='.Commercial::floors.'&floorNumberFrom='.Commercial::floors.'&communication[0]='.$this->getCommunications(0).'&additionally[0]='.$this->getCommercialAdditionals(1));
        $this->restModule->seeResponseContainsJson(array('total' => 0));



    }
    /*===============================================ADVERT API===============================================================*/
    function realtyCommercialsCheck()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/check', [
            'category' => $this->getCategories(3),
            'categoryType' => $this->getCommercialCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'street' => $this->getStreet(97),
            'houseNumber' => Commercial::$currentCommercialNumber
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeHttpHeader('Content-Type', 'application/json');
        $this->restModule->seeResponseMatchesJsonType(['id' => 'string']);
    }

    function realtyCommercialsValidate()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/commercials/validate', [
            'category' => $this->getCategories(3),
            'categoryType' => $this->getCommercialCategoryTypes(0),
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(22),
            'street' => $this->getStreet(97),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::latitude,
            'longitude' => Commercial::longitude,
            'area' => Commercial::generalArea,
            'areaUnit' => $this->getAreaUnits(0),
            'effectiveArea' => Commercial::effectiveArea,
            'wallMaterial' => $this->getWallMaterials(0),
            'roomCount' => Commercial::roomCount,
            'floor' => Commercial::floors,
            'floorNumber' => Commercial::floorNumber,
            'buildYear' => Commercial::buildYear,
            'wc' => $this->getWC(2),
            'heating' => $this->getHeatings(2),
            'waterHeating' => $this->getWaterHeatings(2),
            'communication' => [$this->getCommunications(0), $this->getCommunications(1), $this->getCommunications(2)]
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $schema = file_get_contents(codecept_data_dir('schema_id.json'));
        $realtyCommercialID = file_get_contents(codecept_data_dir('realtyCommercialId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/realties/commercials/edit/' . $realtyCommercialID, [
            'status' => 1,
            'region' => $this->getRegion(21),
            'city' => $this->getCity(6),
            'district' => $this->getDistrict(2),
            'street' => $this->getStreet(94),
            'houseNumber' => Commercial::uniqueCommercialNumber(),
            'latitude' => Commercial::editLatitude,
            'longitude' => Commercial::editLongitude,
            'area' => Commercial::editGeneralArea,
            'areaUnit' => $this->getAreaUnits(0),
            'effectiveArea' => Commercial::editEffectiveArea,
            'wallMaterial' => $this->getWallMaterials(1),
            'roomCount' => Commercial::editRoomCount,
            'floor' => Commercial::editFloorNumber,
            'floorNumber' => Commercial::editFloor,
            'buildYear' => Commercial::editBuildYear,
            'wc' => $this->getWC(1),
            'heating' => $this->getHeatings(1),
            'waterHeating' => $this->getWaterHeatings(1),
            'communication' => [
                $this->getCommunications(0),
                $this->getCommunications(1),
                $this->getCommunications(2),
                $this->getCommunications(3),
                $this->getCommunications(4),
                $this->getCommunications(5),
                $this->getCommunications(6),
                $this->getCommunications(7)
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $realtyCommercialsID = file_get_contents(codecept_data_dir('realtyCommercialId.json'));

        $this->restModule->haveHttpHeader('token', $adminToken);
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
                'name' => 'Test Group',
                'client' => User::getUserId(1),
                'reset' => 'true'
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $groupInfo = $this->restModule->grabResponse();
        $groupId = json_decode($groupInfo)->id;
        file_put_contents(codecept_data_dir('groupId.json'), $groupId);

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
    }

    function apiAgencySendAnnouncementListToUser()
    {

        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/announcements-lists/' . User::getGroupId() . '/send', [
            'email' => User::$userApiEmail,
            'subject' => 'Test subject',
            'text' => 'Use this link to see announcement list'
        ]);
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAgencyAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/'.User::getGroupId());
        $this->restModule->seeResponseCodeIs(200);
    }

    function apiAgencyEditAnnouncementList()
    {
        $this->restModule->haveHttpHeader('token', User::getAgencyToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPUT('/profiles/announcements-lists/'.User::getGroupId().'/edit',[
            'name' => 'Edit Test Group',
            'client' => '56681347d69b5a5b0d8b4567',
            'reset' => 'true'
        ]);
        $this->restModule->seeResponseCodeIs(200);


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
            'reset' => 'true'
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $groupInfo = $this->restModule->grabResponse();
        $groupId = json_decode($groupInfo)->id;
        file_put_contents(codecept_data_dir('groupId.json'), $groupId);

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
    }

    function apiAgentSendAnnouncementListToUser()
    {

        $this->restModule->haveHttpHeader('token', User::getAgentToken());
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/profiles/announcements-lists/' . User::getGroupId() . '/send', [
            'email' => User::$userApiEmail,
            'subject' => 'Test subject',
            'text' => 'Use this link to see announcement list'
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
            'reset' => 'true'
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/flats/add/' . $realtyFlatId, [
            'operationType' => $this->getOperationType(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSell,
            'currency' => $this->getCurrency(0),
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketType(0),
            'repair' => $this->getRepairs(0),
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/flats/add/' . $realtyFlatId, [
            'operationType' => $this->getOperationType(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSell,
            'currency' => $this->getCurrency(0),
//            'period' => ,
            'commission' => Flat::commission,
            'auction' => true,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketType(0),
            'repair' => $this->getRepairs(0),
            'bedsCount' => Flat::beds,
            'furniture' => [
                $this->getFurnitures(0),
                $this->getFurnitures(1),
                $this->getFurnitures(2),
                $this->getFurnitures(3),
                $this->getFurnitures(4),
                $this->getFurnitures(5),
                $this->getFurnitures(6),
                $this->getFurnitures(7)
            ],
            'appliances' => [
                $this->getAppliances(0),
                $this->getAppliances(1),
                $this->getAppliances(2),
                $this->getAppliances(3),
                $this->getAppliances(4),
                $this->getAppliances(5),
                $this->getAppliances(6),
                $this->getAppliances(7)
            ],
            'additionally' => [
                $this->getFlatAdditionals(0),
                $this->getFlatAdditionals(1),
                $this->getFlatAdditionals(2),
                $this->getFlatAdditionals(3),
                $this->getFlatAdditionals(4),
                $this->getFlatAdditionals(5),
                $this->getFlatAdditionals(6),
                $this->getFlatAdditionals(7),
                $this->getFlatAdditionals(8),
                $this->getFlatAdditionals(9),
                $this->getFlatAdditionals(10),
                $this->getFlatAdditionals(11),
                $this->getFlatAdditionals(12),
                $this->getFlatAdditionals(13),
                $this->getFlatAdditionals(14),
                $this->getFlatAdditionals(15)
            ],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyFlatId = file_get_contents(codecept_data_dir('realtyFlatId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/flats/add/' . $realtyFlatId, [
            'operationType' => $this->getOperationType(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrency(0),
            'commission' => Flat::commission,
            'auction' => true,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketType(0),
            'repair' => $this->getRepairs(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnitures(0)],
            'appliances' => [$this->getAppliances(0)],
            'additionally' => [$this->getFlatAdditionals(0)],
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
        $this->restModule->sendGET('/get-announcements/' . $flatID);
        $this->restModule->seeResponseIsJson();
        $this->restModule->seeResponseCodeIs(200);

    }



    /*========================================= HOUSES =========================================*/

    function apiAdvertHouseAddPlain()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/houses/add/' . $realtyHouseId, [
            'operationType' => $this->getOperationType(1),
            'period' => $this->getPeriod(1),
            'price' => House::priceHouseRent,
            'currency' => $this->getCurrency(1),
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/houses/add/' . $realtyHouseId, [
            'operationType' => $this->getOperationType(1),
            'period' => $this->getPeriod(1),
            'price' => House::priceHouseRent,
            'currency' => $this->getCurrency(1),
            'commission' => House::commission,
            'availableFrom' => House::availableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairs(0),
            'furniture' => [
                $this->getFurnitures(0),
                $this->getFurnitures(1),
                $this->getFurnitures(2),
                $this->getFurnitures(3),
                $this->getFurnitures(4),
                $this->getFurnitures(5),
                $this->getFurnitures(6),
                $this->getFurnitures(7)
            ],
            'appliances' => [
                $this->getAppliances(0),
                $this->getAppliances(1),
                $this->getAppliances(2),
                $this->getAppliances(3),
                $this->getAppliances(4),
                $this->getAppliances(5),
                $this->getAppliances(6),
                $this->getAppliances(7)
            ],
            'additionally' => [
                $this->getHouseAdditionals(0),
                $this->getHouseAdditionals(1),
                $this->getHouseAdditionals(2),
                $this->getHouseAdditionals(3),
                $this->getHouseAdditionals(4),
                $this->getHouseAdditionals(5),
                $this->getHouseAdditionals(6),
                $this->getHouseAdditionals(7),
                $this->getHouseAdditionals(8),
                $this->getHouseAdditionals(9),
                $this->getHouseAdditionals(10),
                $this->getHouseAdditionals(11),
                $this->getHouseAdditionals(12),
                $this->getHouseAdditionals(13),
                $this->getHouseAdditionals(14),
                $this->getHouseAdditionals(15)
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyHouseId = file_get_contents(codecept_data_dir('realtyHouseId.json'));
//        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/houses/add/' . $realtyHouseId, [
            'operationType' => $this->getOperationType(1),
            'period' => $this->getPeriod(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrency(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairs(0),
            'furniture' => [$this->getFurnitures(0)],
            'appliances' => [$this->getAppliances(0)],
            'additionally' => [$this->getHouseAdditionals(0)]
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/parcels/add/' . $realtyParcelId, [
            'operationType' => $this->getOperationType(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrency(0),
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/parcels/add/' . $realtyParcelId, [
            'operationType' => $this->getOperationType(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrency(0),
//            'period' => ,
            'commission' => Parcel::commission,
            'auction' => true,
            'availableFrom' => Parcel::apiAvailableFrom,
            'additionally' => [
                $this->getParcelAdditionals(0),
                $this->getParcelAdditionals(1),
                $this->getParcelAdditionals(2),
                $this->getParcelAdditionals(3),
                $this->getParcelAdditionals(4),
                $this->getParcelAdditionals(5),
                $this->getParcelAdditionals(6),
                $this->getParcelAdditionals(7),
                $this->getParcelAdditionals(8),
                $this->getParcelAdditionals(9),
                $this->getParcelAdditionals(10),
                $this->getParcelAdditionals(11),
                $this->getParcelAdditionals(12),
                $this->getParcelAdditionals(13),
                $this->getParcelAdditionals(14),
                $this->getParcelAdditionals(15)
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyParcelId = file_get_contents(codecept_data_dir('realtyParcelId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/parcels/add/' . $realtyParcelId, [
            'operationType' => $this->getOperationType(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSell,
            'currency' => $this->getCurrency(0),
            'commission' => Parcel::commission,
            'auction' => true,
            'availableFrom' => Parcel::apiAvailableFrom,
            'additionally' => [$this->getParcelAdditionals(0)],
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/commercials/add/' . $realtyCommercialId, [
            'operationType' => $this->getOperationType(0),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSell,
            'currency' => $this->getCurrency(0),
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairs(0),
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/commercials/add/' . $realtyCommercialId, [
            'operationType' => $this->getOperationType(1),
            'description' => Commercial::descriptionCommercialRent,
            'price' => Commercial::priceCommercialRent,
            'currency' => $this->getCurrency(1),
            'period' => $this->getPeriod(1),
            'commission' => Commercial::commission,
            'auction' => true,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairs(0),
            'additionally' => [
                $this->getCommercialAdditionals(0),
                $this->getCommercialAdditionals(1),
                $this->getCommercialAdditionals(2),
                $this->getCommercialAdditionals(3),
                $this->getCommercialAdditionals(4),
                $this->getCommercialAdditionals(5),
                $this->getCommercialAdditionals(6),
                $this->getCommercialAdditionals(7),
                $this->getCommercialAdditionals(8),
                $this->getCommercialAdditionals(9),
                $this->getCommercialAdditionals(10),
                $this->getCommercialAdditionals(11),
                $this->getCommercialAdditionals(12),
                $this->getCommercialAdditionals(13),
                $this->getCommercialAdditionals(14),
                $this->getCommercialAdditionals(15)
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
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $realtyCommercialId = file_get_contents(codecept_data_dir('realtyCommercialId.json'));
        $images = file_get_contents(codecept_data_dir('images_id.json'));

        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/announcements/commercials/add/' . $realtyCommercialId, [
            'operationType' => $this->getOperationType(1),
            'description' => Commercial::descriptionCommercialRent,
            'price' => Commercial::priceCommercialSearch,
            'currency' => $this->getCurrency(1),
            'period' => $this->getPeriod(0),
            'commission' => Commercial::commission,
            'auction' => true,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairs(0),
            'additionally' => [$this->getCommercialAdditionals(0)],
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
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
        $adminToken = file_get_contents(codecept_data_dir('admin_token.json'));
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendDELETE('/admin/info-pages/' . Info::inf_editLatinName . '/delete');
        $this->restModule->seeResponseIsJson();
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
            'operationType' => $this->getOperationType(1),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSell,
            'currency' => $this->getCurrency(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketType(0),
            'repair' => $this->getRepairs(0),
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
            'operationType' => $this->getOperationType(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSell,
            'currency' => $this->getCurrency(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketType(0),
            'repair' => $this->getRepairs(0),
            'bedsCount' => Flat::beds,
            'furniture' => [
                $this->getFurnitures(0),
                $this->getFurnitures(1),
                $this->getFurnitures(2),
                $this->getFurnitures(3),
                $this->getFurnitures(4),
                $this->getFurnitures(5),
                $this->getFurnitures(6),
                $this->getFurnitures(7)
            ],
            'appliances' => [
                $this->getAppliances(0),
                $this->getAppliances(1),
                $this->getAppliances(2),
                $this->getAppliances(3),
                $this->getAppliances(4),
                $this->getAppliances(5),
                $this->getAppliances(6),
                $this->getAppliances(7)
            ],
            'additionally' => [
                $this->getFlatAdditionals(0),
                $this->getFlatAdditionals(1),
                $this->getFlatAdditionals(2),
                $this->getFlatAdditionals(3),
                $this->getFlatAdditionals(4),
                $this->getFlatAdditionals(5),
                $this->getFlatAdditionals(6),
                $this->getFlatAdditionals(7),
                $this->getFlatAdditionals(8),
                $this->getFlatAdditionals(9),
                $this->getFlatAdditionals(10),
                $this->getFlatAdditionals(11),
                $this->getFlatAdditionals(12),
                $this->getFlatAdditionals(13),
                $this->getFlatAdditionals(14),
                $this->getFlatAdditionals(15)
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
            'operationType' => $this->getOperationType(0),
            'description' => Flat::descriptionFlatSell,
            'price' => Flat::priceFlatSearch,
            'currency' => $this->getCurrency(0),
            'auction' => true,
            'commission' => Flat::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketType(0),
            'repair' => $this->getRepairs(0),
            'bedsCount' => Flat::beds,
            'furniture' => [$this->getFurnitures(0)],
            'appliances' => [$this->getAppliances(0)],
            'additionally' => [$this->getFlatAdditionals(0)],
            'ownerContacts' => Flat::ownerContacts,
            'ownerName' => Flat::ownerName,
        ]);
        $this->restModule->seeResponseCodeIs(200);
        $this->restModule->seeResponseIsJson();
        $advertFlat = $this->restModule->grabResponse();
        $advFlatId = json_decode($advertFlat)->id;
        file_put_contents(codecept_data_dir('advertParcelId.json'), $advFlatId);
        $this->debugSection('advertParcelId', $advFlatId);

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
            'operationType' => $this->getOperationType(0),
            'description' => House::descriptionHouseSell,
            'price' => House::priceHouseSell,
            'currency' => $this->getCurrency(0),
            'auction' => true,
            'commission' => House::commission,
            'availableFrom' => Flat::apiAvailableFrom,
            'marketType' => $this->getMarketType(0),
            'repair' => $this->getRepairs(0),
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
        $this->debugSection('advertParcelId', $advHouseId);
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
            'operationType' => $this->getOperationType(1),
            'period' => $this->getPeriod(1),
            'price' => House::priceHouseSearch,
            'currency' => $this->getCurrency(1),
            'commission' => House::commission,
            'availableFrom' => House::apiAvailableFrom,
            'ownerName' => House::ownerName,
            'ownerContacts' => House::ownerContacts,
            'description' => House::descriptionHouseSell,
            'auction' => true,
            'repair' => $this->getRepairs(0),
            'furniture' => [$this->getFurnitures(0)],
            'appliances' => [$this->getAppliances(0)],
            'additionally' => [$this->getHouseAdditionals(0)],
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
        'operationType' => $this->getOperationType(0),
        'description' => Parcel::descriptionParcelSell,
        'price' => Parcel::priceParcelSell,
        'currency' => $this->getCurrency(0),
        'auction' => true,
        'commission' => Parcel::commission,
        'availableFrom' => Parcel::apiAvailableFrom,
//            'additionally' => [$this->getParcelAdditionals(0), $this->getParcelAdditionals(15)],
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
            'operationType' => $this->getOperationType(0),
            'description' => Parcel::descriptionParcelSell,
            'price' => Parcel::priceParcelSearch,
            'currency' => $this->getCurrency(0),
            'auction' => true,
            'commission' => Parcel::commission,
            'availableFrom' => Parcel::apiAvailableFrom,
            'additionally' => [$this->getParcelAdditionals(0)],
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
            'operationType' => $this->getOperationType(0),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSell,
            'currency' => $this->getCurrency(0),
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
            'operationType' => $this->getOperationType(1),
            'description' => Commercial::descriptionCommercialSell,
            'price' => Commercial::priceCommercialSearch,
            'period' => $this->getPeriod(0),
            'currency' => $this->getCurrency(1),
            'auction' => true,
            'commission' => Commercial::commission,
            'availableFrom' => Commercial::apiAvailableFrom,
            'repair' => $this->getRepairs(0),
            'additionally' => [$this->getCommercialAdditionals(0)],
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

    function uploadSchema()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->sendPOST('/uploads/schema', [], ['file' => codecept_data_dir('/img/schema_1.jpg')]);
        $this->restModule->seeResponseCodeIs(201);
        $this->restModule->seeResponseIsJson();
        $objSchema = $this->restModule->grabResponse();
        $schema = json_decode($objSchema)->id;
        $file = file_put_contents(codecept_data_dir('schema_id.json'), $schema);
        $this->debugSection('schemaId', $schema);
    }

    function uploadAdvImages()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
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

//        $advsId1 = json_decode($img1)->id;
//        $advsId2 = json_decode($img2)->id;
//        $advsId3 = json_decode($img3)->id;

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
//        $advID = array('[{"id":"'.$advsId1.'"},{"id":"'.$advsId2.'"},{"id":"'.$advsId3.'"}]');
        $file = file_put_contents(codecept_data_dir('images_id.json'), json_encode($images, JSON_UNESCAPED_SLASHES));
        $this->debugSection('advertsID', $images);
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
        $agencyOfficeRegion0 = $this->getRegion(21);
        $agencyOfficeCity0 = $this->getCity(6);
        $agencyOfficeAddress0 = $this->getStreetNameById(4,1);

        $agencyOfficeRegion1 = $this->getRegion(21);
        $agencyOfficeCity1 = $this->getCity(6);
        $agencyOfficeAddress1 = $this->getStreetNameById(4,1);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->haveHttpHeader('token', $adminToken);
        $this->restModule->sendPOST('/admin/registration/agency', [
            'name' => User::$agencyName,
            'subdomain' => User::uniqueSubdomain(),
            'firstName' => User::$agencyfirstName,
            'lastName' => User::$agencylastName,
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

        $agencyOfficeRegion0 = $this->getRegion(21);
        $agencyOfficeCity0 = $this->getCity(6);
        $agencyOfficeAddress0 = $this->getStreetNameById(4,1);

        $agencyOfficeRegion1 = $this->getRegion(21);
        $agencyOfficeCity1 = $this->getCity(6);
        $agencyOfficeAddress1 = $this->getStreetNameById(4,1);

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/registration/agency', [
            'name' => User::$agencyName,
            'subdomain' => User::uniqueSubdomain(),
            'firstName' => User::$agencyfirstName,
            'lastName' => User::$agencylastName,
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
        $agencyOfficeRegion0 = $this->getRegion(21);
        $agencyOfficeCity0 = $this->getCity(3);
        $agencyOfficeAddress0 = $this->getStreetNameById(3,2);
        $agencyData = file_get_contents(codecept_data_dir('agency_data.json'));
        $userId = json_decode($agencyData)->id;
        $agencyOfficeRegion1 = $this->getRegion(21);
        $agencyOfficeCity1 = $this->getCity(3);
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
        $city = $this->getCity($cityId);
        $this->restModule->sendGET('/lists/streets/' . $city);
        $streets = $this->restModule->grabResponse();
        $streetName = json_decode($streets)[$name]->name;
        //$this->debugSection('Street ID', $streetName);
        file_put_contents(codecept_data_dir('streets_name.json'), $streets);
        return $streetName;
    }


}

class Images
{
    public $id;
    public $mainImage;
}



