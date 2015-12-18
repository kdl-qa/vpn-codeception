<?php



class apiTesterCest
{


    public function apiAdminCity (VpnTester $U)
    {
        $U->apiAdminLogin();
        $U->apiAdminAddCity();
        $U->apiAdminEditCity();

        $U->apiAdminAddDistrict();
        $U->apiAdminEditDistrict();

        $U->apiAdminAddStreet();
        $U->apiAdminEditStreet();

        $U->apiAdminDeleteDistrict();
        $U->apiAdminDeleteStreet();
        $U->apiAdminDeleteCity();

        $U->apiAdminAddCategoryType(0);
        $U->apiAdminEditCategoryType();
        $U->apiAdminChangePositionCategoryType();
        $U->apiAdminDeleteCategoryType();
    }


}