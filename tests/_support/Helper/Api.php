<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Data\User;

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

    function getRegion()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/regions');
        $regions = $this->restModule->grabResponse();
        $regId = json_decode($regions)[0]->id;
//        $regId= $this->restModule->grabDataFromResponseByJsonPath('$.[0].id');
        $this->debugSection('Reg ID', $regId);
        $file = file_put_contents(codecept_data_dir('regions.json'), $regions);
        return $regId;
    }

    function getCity()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $reg = $this->getRegion();
        $this->restModule->sendGET('/lists/cities/'.$reg);
        $cities = $this->restModule->grabResponse();
        $cityId = json_decode($cities)[0]->id;
        $this->debugSection('City ID', $cityId);
        $file = file_put_contents(codecept_data_dir('cities.json'), $cities);
        return $cityId;
    }

    function getDistrict()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $city = $this->getCity();
        $this->restModule->sendGET('/lists/districts/'.$city);
        $districts = $this->restModule->grabResponse();
        $districtId = json_decode($districts)[0]->id;
        $this->debugSection('District ID', $districtId);
        $file = file_put_contents(codecept_data_dir('districts.json'), $districts);
        return $districtId;
    }

    function getStreet()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $city = $this->getCity();
        $this->restModule->sendGET('/lists/streets/'.$city);
        $streets = $this->restModule->grabResponse();
        $streetId = json_decode($streets)[0]->id;
        $this->debugSection('Street ID', $streetId);
        $file = file_put_contents(codecept_data_dir('streets.json'), $streets);
        return $streetId;
    }

    function getCategories($id)
    {

        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/categories');
        $categories = $this->restModule->grabResponse();
        $this->debugSection('Cat ID', $categories);
        $file = file_put_contents(codecept_data_dir('categories.json'), $categories);
        switch ($id) {
            case 0:
                $flatCatId = json_decode($categories)[0]->id;
                $this->debugSection('Cat ID', $flatCatId);
                return $flatCatId;
                break;
            case 1:
                $houseCatId = json_decode($categories)[1]->id;
                $this->debugSection('Cat ID', $houseCatId);
                return $houseCatId;
                break;
            case 2:
                $parcelCatId = json_decode($categories)[2]->id;
                $this->debugSection('Cat ID', $parcelCatId);
                return $parcelCatId;
                break;
            case 3:
                $commercialCatId = json_decode($categories)[3]->id;
                $this->debugSection('Cat ID', $commercialCatId);
                return $commercialCatId;
                break;
        }
    }

    function getFlatCategoryTypes($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $flat = $this->getCategories(0);
        $this->restModule->sendGET('/lists/category-types/'.$flat);
        $cType = $this->restModule->grabResponse();
        $this->debugSection('Flat Category Types', $cType);
        $file = file_put_contents(codecept_data_dir('flat_types.json'), $cType);
        switch ($id) {
            case 0:
                $flatCatId0 = json_decode($cType)[0]->id;
                $this->debugSection('flatCatId0', $flatCatId0);
                return $flatCatId0;
                break;
            case 1:
                $flatCatId1 = json_decode($cType)[1]->id;
                $this->debugSection('flatCatId1', $flatCatId1);
                return $flatCatId1;
                break;
        }
    }

    function getHouseCategoryTypes($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $house = $this->getCategories(1);
        $this->restModule->sendGET('/lists/category-types/'.$house);
        $cType = $this->restModule->grabResponse();
        $this->debugSection('House Category Types', $cType);
        $file = file_put_contents(codecept_data_dir('house_types.json'), $cType);
        switch ($id) {
            case 0:
                $houseCatId0 = json_decode($cType)[0]->id;
                $this->debugSection('houseCatId0', $houseCatId0);
                return $houseCatId0;
                break;
            case 1:
                $houseCatId1 = json_decode($cType)[1]->id;
                $this->debugSection('houseCatId1', $houseCatId1);
                return $houseCatId1;
                break;
            case 2:
                $houseCatId2 = json_decode($cType)[2]->id;
                $this->debugSection('houseCatId2', $houseCatId2);
                return $houseCatId2;
                break;
        }
    }

    function getParcelCategoryTypes($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $parcel = $this->getCategories(2);
        $this->restModule->sendGET('/lists/category-types/'.$parcel);
        $cType = $this->restModule->grabResponse();
        $this->debugSection('Parcel Category Types', $cType);
        $file = file_put_contents(codecept_data_dir('parcel_types.json'), $cType);
        switch ($id) {
            case 0:
                $parcelCatId0 = json_decode($cType)[0]->id;
                $this->debugSection('parcelCatId0', $parcelCatId0);
                return $parcelCatId0;
                break;
            case 1:
                $parcelCatId1 = json_decode($cType)[1]->id;
                $this->debugSection('parcelCatId1', $parcelCatId1);
                return $parcelCatId1;
                break;
            case 2:
                $parcelCatId2 = json_decode($cType)[2]->id;
                $this->debugSection('parcelCatId2', $parcelCatId2);
                return $parcelCatId2;
                break;
            case 3:
                $parcelCatId3 = json_decode($cType)[3]->id;
                $this->debugSection('parcelCatId3', $parcelCatId3);
                return $parcelCatId3;
                break;
            case 4:
                $parcelCatId4 = json_decode($cType)[4]->id;
                $this->debugSection('parcelCatId4', $parcelCatId4);
                return $parcelCatId4;
                break;
        }
    }

function getCommercialCategoryTypes($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $commerc = $this->getCategories(3);
        $this->restModule->sendGET('/lists/category-types/'.$commerc);
        $cType = $this->restModule->grabResponse();
        $this->debugSection('Commercial Category Types', $cType);
        $file = file_put_contents(codecept_data_dir('commercial_types.json'), $cType);
        switch ($id) {
            case 0:
                $commercCatId0 = json_decode($cType)[0]->id;
                $this->debugSection('commercCatId0', $commercCatId0);
                return $commercCatId0;
                break;
            case 1:
                $commercCatId1 = json_decode($cType)[1]->id;
                $this->debugSection('commercCatId1', $commercCatId1);
                return $commercCatId1;
                break;
            case 2:
                $commercCatId2 = json_decode($cType)[2]->id;
                $this->debugSection('commercCatId2', $commercCatId2);
                return $commercCatId2;
                break;
            case 3:
                $commercCatId3 = json_decode($cType)[3]->id;
                $this->debugSection('commercCatId3', $commercCatId3);
                return $commercCatId3;
                break;
            case 4:
                $commercCatId4 = json_decode($cType)[4]->id;
                $this->debugSection('commercCatId4', $commercCatId4);
                return $commercCatId4;
                break;
            case 5:
                $commercCatId5 = json_decode($cType)[5]->id;
                $this->debugSection('commercCatId5', $commercCatId5);
                return $commercCatId5;
                break;
            case 6:
                $commercCatId6 = json_decode($cType)[6]->id;
                $this->debugSection('commercCatId6', $commercCatId6);
                return $commercCatId6;
                break;
            case 7:
                $commercCatId7 = json_decode($cType)[7]->id;
                $this->debugSection('commercCatId7', $commercCatId7);
                return $commercCatId7;
                break;
            case 8:
                $commercCatId8 = json_decode($cType)[8]->id;
                $this->debugSection('commercCatId8', $commercCatId8);
                return $commercCatId8;
                break;
            case 9:
                $commercCatId9 = json_decode($cType)[9]->id;
                $this->debugSection('commercCatId9', $commercCatId9);
                return $commercCatId9;
                break;
            case 10:
                $commercCatId10 = json_decode($cType)[10]->id;
                $this->debugSection('commercCatId10', $commercCatId10);
                return $commercCatId10;
                break;


        }
    }

    function getFlatAdditionals($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $flat = $this->getCategories(0);
        $this->restModule->sendGET('/lists/additionals/'.$flat);
        $flatAdditionals = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('flat_additionals.json'), $flatAdditionals);
        switch ($id)
        {
            case 0:
                $flatAdd0 = json_decode($flatAdditionals)[0]->id;
                $this->debugSection('flatAdd0', $flatAdd0);
                return $flatAdd0;
                break;
            case 1:
                $flatAdd1 = json_decode($flatAdditionals)[1]->id;
                $this->debugSection('flatAdd1', $flatAdd1);
                return $flatAdd1;
                break;
            case 2:
                $flatAdd2 = json_decode($flatAdditionals)[2]->id;
                $this->debugSection('flatAdd2', $flatAdd2);
                return $flatAdd2;
                break;
            case 3:
                $flatAdd3 = json_decode($flatAdditionals)[3]->id;
                $this->debugSection('flatAdd3', $flatAdd3);
                return $flatAdd3;
                break;
            case 4:
                $flatAdd4 = json_decode($flatAdditionals)[4]->id;
                $this->debugSection('flatAdd4', $flatAdd4);
                return $flatAdd4;
                break;
            case 5:
                $flatAdd5 = json_decode($flatAdditionals)[5]->id;
                $this->debugSection('flatAdd5', $flatAdd5);
                return $flatAdd5;
                break;
            case 6:
                $flatAdd6 = json_decode($flatAdditionals)[6]->id;
                $this->debugSection('flatAdd6', $flatAdd6);
                return $flatAdd6;
                break;
            case 7:
                $flatAdd7 = json_decode($flatAdditionals)[7]->id;
                $this->debugSection('flatAdd7', $flatAdd7);
                return $flatAdd7;
                break;
            case 8:
                $flatAdd8 = json_decode($flatAdditionals)[8]->id;
                $this->debugSection('flatAdd8', $flatAdd8);
                return $flatAdd8;
                break;
            case 9:
                $flatAdd9 = json_decode($flatAdditionals)[9]->id;
                $this->debugSection('flatAdd9', $flatAdd9);
                return $flatAdd9;
                break;
            case 10:
                $flatAdd10 = json_decode($flatAdditionals)[10]->id;
                $this->debugSection('flatAdd10', $flatAdd10);
                return $flatAdd10;
                break;
            case 11:
                $flatAdd11 = json_decode($flatAdditionals)[11]->id;
                $this->debugSection('flatAdd11', $flatAdd11);
                return $flatAdd11;
                break;
            case 12:
                $flatAdd12 = json_decode($flatAdditionals)[12]->id;
                $this->debugSection('flatAdd12', $flatAdd12);
                return $flatAdd12;
                break;
            case 13:
                $flatAdd13 = json_decode($flatAdditionals)[13]->id;
                $this->debugSection('flatAdd13', $flatAdd13);
                return $flatAdd13;
                break;
            case 14:
                $flatAdd14 = json_decode($flatAdditionals)[14]->id;
                $this->debugSection('flatAdd14', $flatAdd14);
                return $flatAdd14;
                break;
            case 15:
                $flatAdd15 = json_decode($flatAdditionals)[15]->id;
                $this->debugSection('flatAdd15', $flatAdd15);
                return $flatAdd15;
                break;

        }
    }

    function getHouseAdditionals($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $house = $this->getCategories(1);
        $this->restModule->sendGET('/lists/additionals/' . $house);
        $houseAdditionals = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('house_additionals.json'), $houseAdditionals);
        switch ($id)
        {
            case 0:
                $houseAdd0 = json_decode($houseAdditionals)[0]->id;
                $this->debugSection('houseAdd0', $houseAdd0);
                return $houseAdd0;
                break;
            case 1:
                $houseAdd1 = json_decode($houseAdditionals)[1]->id;
                $this->debugSection('houseAdd1', $houseAdd1);
                return $houseAdd1;
                break;
            case 2:
                $houseAdd2 = json_decode($houseAdditionals)[2]->id;
                $this->debugSection('houseAdd2', $houseAdd2);
                return $houseAdd2;
                break;
            case 3:
                $houseAdd3 = json_decode($houseAdditionals)[3]->id;
                $this->debugSection('houseAdd3', $houseAdd3);
                return $houseAdd3;
                break;
            case 4:
                $houseAdd4 = json_decode($houseAdditionals)[4]->id;
                $this->debugSection('houseAdd4', $houseAdd4);
                return $houseAdd4;
                break;
            case 5:
                $houseAdd5 = json_decode($houseAdditionals)[5]->id;
                $this->debugSection('houseAdd5', $houseAdd5);
                return $houseAdd5;
                break;
            case 6:
                $houseAdd6 = json_decode($houseAdditionals)[6]->id;
                $this->debugSection('houseAdd6', $houseAdd6);
                return $houseAdd6;
                break;
            case 7:
                $houseAdd7 = json_decode($houseAdditionals)[7]->id;
                $this->debugSection('houseAdd7', $houseAdd7);
                return $houseAdd7;
                break;
            case 8:
                $houseAdd8 = json_decode($houseAdditionals)[8]->id;
                $this->debugSection('houseAdd8', $houseAdd8);
                return $houseAdd8;
                break;
            case 9:
                $houseAdd9 = json_decode($houseAdditionals)[9]->id;
                $this->debugSection('houseAdd9', $houseAdd9);
                return $houseAdd9;
                break;
            case 10:
                $houseAdd10 = json_decode($houseAdditionals)[10]->id;
                $this->debugSection('houseAdd10', $houseAdd10);
                return $houseAdd10;
                break;
            case 11:
                $houseAdd11 = json_decode($houseAdditionals)[11]->id;
                $this->debugSection('houseAdd11', $houseAdd11);
                return $houseAdd11;
                break;
            case 12:
                $houseAdd12 = json_decode($houseAdditionals)[12]->id;
                $this->debugSection('houseAdd12', $houseAdd12);
                return $houseAdd12;
                break;
            case 13:
                $houseAdd13 = json_decode($houseAdditionals)[13]->id;
                $this->debugSection('houseAdd13', $houseAdd13);
                return $houseAdd13;
                break;
            case 14:
                $houseAdd14 = json_decode($houseAdditionals)[14]->id;
                $this->debugSection('houseAdd14', $houseAdd14);
                return $houseAdd14;
                break;
            case 15:
                $houseAdd15 = json_decode($houseAdditionals)[15]->id;
                $this->debugSection('houseAdd15', $houseAdd15);
                return $houseAdd15;
                break;

        }
    }

    function getParcelAdditionals($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $parcel = $this->getCategories(2);
        $this->restModule->sendGET('/lists/additionals/' . $parcel);
        $parcelAdditionals = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('parcel_additionals.json'), $parcelAdditionals);
        switch ($id)
        {
            case 0:
                $parcelAdd0 = json_decode($parcelAdditionals)[0]->id;
                $this->debugSection('parcelAdd0', $parcelAdd0);
                return $parcelAdd0;
                break;
            case 1:
                $parcelAdd1 = json_decode($parcelAdditionals)[1]->id;
                $this->debugSection('parcelAdd1', $parcelAdd1);
                return $parcelAdd1;
                break;
            case 2:
                $parcelAdd2 = json_decode($parcelAdditionals)[2]->id;
                $this->debugSection('parcelAdd2', $parcelAdd2);
                return $parcelAdd2;
                break;
            case 3:
                $parcelAdd3 = json_decode($parcelAdditionals)[3]->id;
                $this->debugSection('parcelAdd3', $parcelAdd3);
                return $parcelAdd3;
                break;
            case 4:
                $parcelAdd4 = json_decode($parcelAdditionals)[4]->id;
                $this->debugSection('parcelAdd4', $parcelAdd4);
                return $parcelAdd4;
                break;
            case 5:
                $parcelAdd5 = json_decode($parcelAdditionals)[5]->id;
                $this->debugSection('parcelAdd5', $parcelAdd5);
                return $parcelAdd5;
                break;
            case 6:
                $parcelAdd6 = json_decode($parcelAdditionals)[6]->id;
                $this->debugSection('parcelAdd6', $parcelAdd6);
                return $parcelAdd6;
                break;
            case 7:
                $parcelAdd7 = json_decode($parcelAdditionals)[7]->id;
                $this->debugSection('parcelAdd7', $parcelAdd7);
                return $parcelAdd7;
                break;
            case 8:
                $parcelAdd8 = json_decode($parcelAdditionals)[8]->id;
                $this->debugSection('parcelAdd8', $parcelAdd8);
                return $parcelAdd8;
                break;
            case 9:
                $parcelAdd9 = json_decode($parcelAdditionals)[9]->id;
                $this->debugSection('parcelAdd9', $parcelAdd9);
                return $parcelAdd9;
                break;
            case 10:
                $parcelAdd10 = json_decode($parcelAdditionals)[10]->id;
                $this->debugSection('parcelAdd10', $parcelAdd10);
                return $parcelAdd10;
                break;
            case 11:
                $parcelAdd11 = json_decode($parcelAdditionals)[11]->id;
                $this->debugSection('parcelAdd11', $parcelAdd11);
                return $parcelAdd11;
                break;
        }
    }

    function getCommercialAdditionals($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $commercial = $this->getCategories(3);
        $this->restModule->sendGET('/lists/additionals/' . $commercial);
        $commercialAdditionals = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('commercial_additionals.json'), $commercialAdditionals);
        switch ($id)
        {
            case 0:
                $commercialAdd0 = json_decode($commercialAdditionals)[0]->id;
                $this->debugSection('commercialAdd0', $commercialAdd0);
                return $commercialAdd0;
                break;
            case 1:
                $commercialAdd1 = json_decode($commercialAdditionals)[1]->id;
                $this->debugSection('commercialAdd1', $commercialAdd1);
                return $commercialAdd1;
                break;
            case 2:
                $commercialAdd2 = json_decode($commercialAdditionals)[2]->id;
                $this->debugSection('commercialAdd2', $commercialAdd2);
                return $commercialAdd2;
                break;
            case 3:
                $commercialAdd3 = json_decode($commercialAdditionals)[3]->id;
                $this->debugSection('commercialAdd3', $commercialAdd3);
                return $commercialAdd3;
                break;
            case 4:
                $commercialAdd4 = json_decode($commercialAdditionals)[4]->id;
                $this->debugSection('commercialAdd4', $commercialAdd4);
                return $commercialAdd4;
                break;
            case 5:
                $commercialAdd5 = json_decode($commercialAdditionals)[5]->id;
                $this->debugSection('commercialAdd5', $commercialAdd5);
                return $commercialAdd5;
                break;
            case 6:
                $commercialAdd6 = json_decode($commercialAdditionals)[6]->id;
                $this->debugSection('commercialAdd6', $commercialAdd6);
                return $commercialAdd6;
                break;
            case 7:
                $commercialAdd7 = json_decode($commercialAdditionals)[7]->id;
                $this->debugSection('commercialAdd7', $commercialAdd7);
                return $commercialAdd7;
                break;

        }
    }

    function getAppliances($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/appliances');
        $appliances = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('appliances.json'), $appliances);
        switch ($id)
        {
            case 0:
                $appliancesId0 = json_decode($appliances)[0]->id;
                $this->debugSection('appliancesId0', $appliancesId0);
                return $appliancesId0;
                break;
            case 1:
                $appliancesId1 = json_decode($appliances)[1]->id;
                $this->debugSection('appliancesId1', $appliancesId1);
                return $appliancesId1;
                break;
            case 2:
                $appliancesId2 = json_decode($appliances)[2]->id;
                $this->debugSection('appliancesId2', $appliancesId2);
                return $appliancesId2;
                break;
            case 3:
                $appliancesId3 = json_decode($appliances)[3]->id;
                $this->debugSection('appliancesId3', $appliancesId3);
                return $appliancesId3;
                break;
            case 4:
                $appliancesId4 = json_decode($appliances)[4]->id;
                $this->debugSection('appliancesId4', $appliancesId4);
                return $appliancesId4;
                break;
            case 5:
                $appliancesId5 = json_decode($appliances)[5]->id;
                $this->debugSection('appliancesId5', $appliancesId5);
                return $appliancesId5;
                break;
            case 6:
                $appliancesId6 = json_decode($appliances)[6]->id;
                $this->debugSection('appliancesId6', $appliancesId6);
                return $appliancesId6;
                break;
            case 7:
                $appliancesId7 = json_decode($appliances)[7]->id;
                $this->debugSection('appliancesId7', $appliancesId7);
                return $appliancesId7;
                break;

        }
    }

    function getActualCurrency()
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/actual-currency');
        $actCurrency = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('actual_currency.json'), $actCurrency);

    }

    function getAreaUnits($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/area-units');
        $areaUnits = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('area_units.json'), $areaUnits);
        switch ($id)
        {
            case 0:
                $areaUnitId0 = json_decode($areaUnits)[0]->id;
                $this->debugSection('areaUnitId0', $areaUnitId0);
                return $areaUnitId0;
                break;
            case 1:
                $areaUnitId1 = json_decode($areaUnits)[1]->id;
                $this->debugSection('areaUnitId1', $areaUnitId1);
                return $areaUnitId1;
                break;
            case 2:
                $areaUnitId2 = json_decode($areaUnits)[2]->id;
                $this->debugSection('areaUnitId2', $areaUnitId2);
                return $areaUnitId2;
                break;

        }
    }

    function getBalconies($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/balconies');
        $balconies = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('balconies.json'), $balconies);
        switch ($id)
        {
            case 0:
                $balconyId0 = json_decode($balconies)[0]->id;
                $this->debugSection('balconyId0', $balconyId0);
                return $balconyId0;
                break;
            case 1:
                $balconyId1 = json_decode($balconies)[1]->id;
                $this->debugSection('balconyId1', $balconyId1);
                return $balconyId1;
                break;
            case 2:
                $balconyId2 = json_decode($balconies)[2]->id;
                $this->debugSection('balconyId2', $balconyId2);
                return $balconyId2;
                break;
            case 3:
                $balconyId3 = json_decode($balconies)[3]->id;
                $this->debugSection('balconyId2', $balconyId3);
                return $balconyId3;
                break;

        }
    }

    function getCommunications($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/communications');
        $communications = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('communications.json'), $communications);
        switch ($id)
        {
            case 0:
                $communicatId0 = json_decode($communications)[0]->id;
                $this->debugSection('communicatId0', $communicatId0);
                return $communicatId0;
                break;
            case 1:
                $communicatId1 = json_decode($communications)[1]->id;
                $this->debugSection('communicatId1', $communicatId1);
                return $communicatId1;
                break;
            case 2:
                $communicatId2 = json_decode($communications)[2]->id;
                $this->debugSection('communicatId2', $communicatId2);
                return $communicatId2;
                break;
            case 3:
                $communicatId3 = json_decode($communications)[3]->id;
                $this->debugSection('communicatId3', $communicatId3);
                return $communicatId3;
                break;
            case 4:
                $communicatId4 = json_decode($communications)[4]->id;
                $this->debugSection('communicatId4', $communicatId4);
                return $communicatId4;
                break;
            case 5:
                $communicatId5 = json_decode($communications)[5]->id;
                $this->debugSection('communicatId5', $communicatId5);
                return $communicatId5;
                break;
            case 6:
                $communicatId6 = json_decode($communications)[6]->id;
                $this->debugSection('communicatId6', $communicatId6);
                return $communicatId6;
                break;
            case 7:
                $communicatId7 = json_decode($communications)[7]->id;
                $this->debugSection('communicatId7', $communicatId7);
                return $communicatId7;
                break;
        }
    }

    function getCurrency($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/currency');
        $currency = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('currency.json'), $currency);
        switch ($id) {
            case 0:
                $currencyId0 = json_decode($currency)[0]->id;
                $this->debugSection('currencyId0', $currencyId0);
                return $currencyId0;
                break;
            case 1:
                $currencyId1 = json_decode($currency)[1]->id;
                $this->debugSection('currencyId1', $currencyId1);
                return $currencyId1;
                break;
        }
    }

    function getFurnitures($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/furnitures');
        $furnitures = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('furnitures.json'), $furnitures);
        switch ($id) {
            case 0:
                $furId0 = json_decode($furnitures)[0]->id;
                $this->debugSection('furId0', $furId0);
                return $furId0;
                break;
            case 1:
                $furId1 = json_decode($furnitures)[1]->id;
                $this->debugSection('furId1', $furId1);
                return $furId1;
                break;
            case 2:
                $furId2 = json_decode($furnitures)[2]->id;
                $this->debugSection('furId2', $furId2);
                return $furId2;
                break;
            case 3:
                $furId3 = json_decode($furnitures)[3]->id;
                $this->debugSection('furId3', $furId3);
                return $furId3;
                break;
            case 4:
                $furId4 = json_decode($furnitures)[4]->id;
                $this->debugSection('furId4', $furId4);
                return $furId4;
                break;
            case 5:
                $furId5 = json_decode($furnitures)[5]->id;
                $this->debugSection('furId5', $furId5);
                return $furId5;
                break;
            case 6:
                $furId6 = json_decode($furnitures)[6]->id;
                $this->debugSection('furId6', $furId6);
                return $furId6;
                break;
            case 7:
                $furId7 = json_decode($furnitures)[7]->id;
                $this->debugSection('furId7', $furId7);
                return $furId7;
                break;
        }
    }

    function getHeatings($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/heatings');
        $heatings = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('heatings.json'), $heatings);
        switch ($id) {
            case 0:
                $heatId0 = json_decode($heatings)[0]->id;
                $this->debugSection('heatId0', $heatId0);
                return $heatId0;
                break;
            case 1:
                $heatId1 = json_decode($heatings)[1]->id;
                $this->debugSection('heatId1', $heatId1);
                return $heatId1;
                break;
            case 2:
                $heatId2 = json_decode($heatings)[2]->id;
                $this->debugSection('heatId2', $heatId2);
                return $heatId2;
                break;
            case 3:
                $heatId3 = json_decode($heatings)[3]->id;
                $this->debugSection('heatId3', $heatId3);
                return $heatId3;
                break;
            case 4:
                $heatId4 = json_decode($heatings)[4]->id;
                $this->debugSection('heatId4', $heatId4);
                return $heatId4;
                break;
        }
    }

    function getMarketType($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/market-types');
        $mTypes = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('market_types.json'), $mTypes);
        switch ($id) {
            case 0:
                $mTypeId0 = json_decode($mTypes)[0]->id;
                $this->debugSection('mTypeId0', $mTypeId0);
                return $mTypeId0;
                break;
            case 1:
                $mTypeId1 = json_decode($mTypes)[1]->id;
                $this->debugSection('mTypeId1', $mTypeId1);
                return $mTypeId1;
                break;
        }
    }

    function getNearObjects($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/near-objects');
        $nearObj = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('near_objects.json'), $nearObj);
        switch ($id) {
            case 0:
                $nObjId0 = json_decode($nearObj)[0]->id;
                $this->debugSection('nObjId0', $nObjId0);
                return $nObjId0;
                break;
            case 1:
                $nObjId1 = json_decode($nearObj)[1]->id;
                $this->debugSection('nObjId1', $nObjId1);
                return $nObjId1;
                break;
            case 2:
                $nObjId2 = json_decode($nearObj)[2]->id;
                $this->debugSection('nObjId2', $nObjId2);
                return $nObjId2;
                break;
            case 3:
                $nObjId3 = json_decode($nearObj)[3]->id;
                $this->debugSection('nObjId3', $nObjId3);
                return $nObjId3;
                break;
            case 4:
                $nObjId4 = json_decode($nearObj)[4]->id;
                $this->debugSection('nObjId4', $nObjId4);
                return $nObjId4;
                break;
            case 5:
                $nObjId5 = json_decode($nearObj)[5]->id;
                $this->debugSection('nObjId5', $nObjId5);
                return $nObjId5;
                break;
            case 6:
                $nObjId6 = json_decode($nearObj)[6]->id;
                $this->debugSection('nObjId6', $nObjId6);
                return $nObjId6;
                break;
            case 7:
                $nObjId7 = json_decode($nearObj)[7]->id;
                $this->debugSection('nObjId7', $nObjId7);
                return $nObjId7;
                break;
            case 8:
                $nObjId8 = json_decode($nearObj)[8]->id;
                $this->debugSection('nObjId8', $nObjId8);
                return $nObjId8;
                break;
            case 9:
                $nObjId9 = json_decode($nearObj)[9]->id;
                $this->debugSection('nObjId9', $nObjId9);
                return $nObjId9;
                break;

        }
    }

    function getOperationType($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/operation-types');
        $opTypes = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('operation_types.json'), $opTypes);
        switch ($id) {
            case 0:
                $opTypeId0 = json_decode($opTypes)[0]->id;
                $this->debugSection('opTypeId0', $opTypeId0);
                return $opTypeId0;
                break;
            case 1:
                $opTypeId1 = json_decode($opTypes)[1]->id;
                $this->debugSection('opTypeId1', $opTypeId1);
                return $opTypeId1;
                break;
        }
    }

    function getPeriod($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/period');
        $periods = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('periods.json'), $periods);
        switch ($id) {
            case 0:
                $periodId0 = json_decode($periods)[0]->id;
                $this->debugSection('periodId0', $periodId0);
                return $periodId0;
                break;
            case 1:
                $periodId1 = json_decode($periods)[1]->id;
                $this->debugSection('periodId1', $periodId1);
                return $periodId1;
                break;
        }
    }

    function getRepairs($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/repairs');
        $repairs = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('repairs.json'), $repairs);
        switch ($id) {
            case 0:
                $repairId0 = json_decode($repairs)[0]->id;
                $this->debugSection('repairId0', $repairId0);
                return $repairId0;
                break;
            case 1:
                $repairId1 = json_decode($repairs)[1]->id;
                $this->debugSection('repairId1', $repairId1);
                return $repairId1;
                break;
            case 2:
                $repairId2 = json_decode($repairs)[2]->id;
                $this->debugSection('repairId2', $repairId2);
                return $repairId2;
                break;
            case 3:
                $repairId3 = json_decode($repairs)[3]->id;
                $this->debugSection('repairId3', $repairId3);
                return $repairId3;
                break;
            case 4:
                $repairId4 = json_decode($repairs)[4]->id;
                $this->debugSection('repairId4', $repairId4);
                return $repairId4;
                break;
            case 5:
                $repairId5 = json_decode($repairs)[5]->id;
                $this->debugSection('repairId5', $repairId5);
                return $repairId5;
                break;
            case 6:
                $repairId6 = json_decode($repairs)[6]->id;
                $this->debugSection('repairId6', $repairId6);
                return $repairId6;
                break;
            case 7:
                $repairId7 = json_decode($repairs)[7]->id;
                $this->debugSection('repairId7', $repairId7);
                return $repairId7;
                break;
        }
    }

    function getStatuses($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/statuses');
        $statuses = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('statuses.json'), $statuses);
        switch ($id) {
            case 0:
                $statusId0 = json_decode($statuses)[0]->id;
                $this->debugSection('statusId0', $statusId0);
                return $statusId0;
                break;
            case 1:
                $statusId1 = json_decode($statuses)[1]->id;
                $this->debugSection('statusId1', $statusId1);
                return $statusId1;
                break;
            case 2:
                $statusId2 = json_decode($statuses)[2]->id;
                $this->debugSection('statusId2', $statusId2);
                return $statusId2;
                break;
            case 3:
                $statusId3 = json_decode($statuses)[3]->id;
                $this->debugSection('statusId3', $statusId3);
                return $statusId3;
                break;
            case 4:
                $statusId4 = json_decode($statuses)[4]->id;
                $this->debugSection('statusId4', $statusId4);
                return $statusId4;
                break;

        }
    }

    function getUnpublishReasons($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/unpublish-reasons');
        $unpubReason = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('unpublish_reasons.json'), $unpubReason);
        switch ($id) {
            case 0:
                $unpReasonId0 = json_decode($unpubReason)[0]->id;
                $this->debugSection('unpReasonId0', $unpReasonId0);
                return $unpReasonId0;
                break;
            case 1:
                $unpReasonId1 = json_decode($unpubReason)[1]->id;
                $this->debugSection('unpReasonId1', $unpReasonId1);
                return $unpReasonId1;
                break;
        }
    }

    function getWallMaterials($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/wall-materials');
        $wallMaterials = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('wall_materials.json'), $wallMaterials);
        switch ($id) {
            case 0:
                $wMaterialId0 = json_decode($wallMaterials)[0]->id;
                $this->debugSection('wMaterialId0', $wMaterialId0);
                return $wMaterialId0;
                break;
            case 1:
                $wMaterialId1 = json_decode($wallMaterials)[1]->id;
                $this->debugSection('wMaterialId1', $wMaterialId1);
                return $wMaterialId1;
                break;
            case 2:
                $wMaterialId2 = json_decode($wallMaterials)[2]->id;
                $this->debugSection('wMaterialId2', $wMaterialId2);
                return $wMaterialId2;
                break;
            case 3:
                $wMaterialId3 = json_decode($wallMaterials)[3]->id;
                $this->debugSection('wMaterialId3', $wMaterialId3);
                return $wMaterialId3;
                break;
            case 4:
                $wMaterialId4 = json_decode($wallMaterials)[4]->id;
                $this->debugSection('wMaterialId4', $wMaterialId4);
                return $wMaterialId4;
                break;
            case 5:
                $wMaterialId5 = json_decode($wallMaterials)[5]->id;
                $this->debugSection('wMaterialId5', $wMaterialId5);
                return $wMaterialId5;
                break;
            case 6:
                $wMaterialId6 = json_decode($wallMaterials)[6]->id;
                $this->debugSection('wMaterialId6', $wMaterialId6);
                return $wMaterialId6;
                break;
            case 7:
                $wMaterialId7 = json_decode($wallMaterials)[7]->id;
                $this->debugSection('wMaterialId7', $wMaterialId7);
                return $wMaterialId7;
                break;
            case 8:
                $wMaterialId8 = json_decode($wallMaterials)[8]->id;
                $this->debugSection('wMaterialId8', $wMaterialId8);
                return $wMaterialId8;
                break;
            case 9:
                $wMaterialId9 = json_decode($wallMaterials)[9]->id;
                $this->debugSection('wMaterialId9', $wMaterialId9);
                return $wMaterialId9;
                break;
            case 10:
                $wMaterialId10 = json_decode($wallMaterials)[10]->id;
                $this->debugSection('wMaterialId10', $wMaterialId10);
                return $wMaterialId10;
                break;
        }
    }

    function getWaterHeatings($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/water-heatings');
        $waterHeatings = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('water_heatings.json'), $waterHeatings);
        switch ($id) {
            case 0:
                $wHeatId0 = json_decode($waterHeatings)[0]->id;
                $this->debugSection('wHeatId0', $wHeatId0);
                return $wHeatId0;
                break;
            case 1:
                $wHeatId1 = json_decode($waterHeatings)[1]->id;
                $this->debugSection('wHeatId1', $wHeatId1);
                return $wHeatId1;
                break;
            case 2:
                $wHeatId2 = json_decode($waterHeatings)[2]->id;
                $this->debugSection('wHeatId2', $wHeatId2);
                return $wHeatId2;
                break;
            case 3:
                $wHeatId3 = json_decode($waterHeatings)[3]->id;
                $this->debugSection('wHeatId3', $wHeatId3);
                return $wHeatId3;
                break;
            case 4:
                $wHeatId4 = json_decode($waterHeatings)[4]->id;
                $this->debugSection('wHeatId4', $wHeatId4);
                return $wHeatId4;
                break;
        }
    }

    function getWC($id)
    {
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendGET('/lists/wc');
        $wc = $this->restModule->grabResponse();
        $file = file_put_contents(codecept_data_dir('wc.json'), $wc);
        switch ($id) {
            case 0:
                $wcId0 = json_decode($wc)[0]->id;
                $this->debugSection('wcId0', $wcId0);
                return $wcId0;
                break;
            case 1:
                $wcId1 = json_decode($wc)[1]->id;
                $this->debugSection('wcId1', $wcId1);
                return $wcId1;
                break;
            case 2:
                $wcId2 = json_decode($wc)[2]->id;
                $this->debugSection('wcId2', $wcId2);
                return $wcId2;
                break;

        }
    }

    /*===================================================== API REALTY =============================================*/

    function realtyFlatAdd()
    {
        $agencyToken = file_get_contents(codecept_data_dir('agency_token.json'));
        $this->restModule->haveHttpHeader('token', $agencyToken);
        $this->restModule->haveHttpHeader('Content-Type', 'application/json');
        $this->restModule->sendPOST('/realties/flats/add', ['category' => '']);
        $wc = $this->restModule->grabResponse();


    }


}
