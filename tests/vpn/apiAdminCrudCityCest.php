<?php
use \VpnTester;


class apiAdminCrudCityCest
{
    protected function apiLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
    }

    /**
     * @before apiLogin
     */

    public function apiAdminCity (VpnTester $city, VpnTester $district, VpnTester $street, VpnTester $categoryType )
    {
        $city->apiAdminAddCity();
        $city->apiAdminEditCity();

        $district->apiAdminAddDistrict();
        $district->apiAdminEditDistrict();

        $street->apiAdminAddStreet();
        $street->apiAdminEditStreet();

        $district->apiAdminDeleteDistrict();
        $street->apiAdminDeleteStreet();
        $city->apiAdminDeleteCity();

        $categoryType->apiAdminAddCategoryType(0);
        $categoryType->apiAdminEditCategoryType();
        $categoryType->apiAdminChangePositionCategoryType();
        $categoryType->apiAdminDeleteCategoryType();
    }


}