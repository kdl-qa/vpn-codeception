<?php


class testCest
{
//    public function _before(VpnTester $I)
//    {
//        $I->apiAdminLogin();
//        $I->apiAgencyLogin();
//    }


    public function addRealties(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
        $I->realtyFlatAddPlain();
        $I->realtyHouseAddPlain();
        $I->realtyParcelAddPlain();
        $I->realtyCommercialAddPlain();
        $I->realtiesStatistics();
        $I->realtiesLists();

    }

    public function images(VpnTester $I)

    {
        $I->uploadSchema();
        $I->uploadCertificates();
    }

    public function checkAddedRealties(VpnTester $I)
    {
        $I->realtyFlatCheck();
        $I->realtyHousesCheck();
        $I->realtyParcelsCheck();
        $I->realtyCommercialsCheck();
    }

    public function validateRealties(VpnTester $I)
    {
        $I->realtyFlatsValidate();
        $I->realtyHousesValidate();
        $I->realtyCommercialsValidate();
        $I->realtyParcelsValidate();
    }

    public function editRealtyFlats(VpnTester $I)
    {
        $I->uploadSchema();
        $I->realtyFlatsEdit();
    }

    public function editRealtyHouses(VpnTester $I)
    {
        $I->uploadSchema();
        $I->realtyHousesEdit();
    }

    public function editRealtyParcels(VpnTester $I)
    {
        $I->uploadSchema();
        $I->realtyParcelsEdit();
    }

    public function editRealtyCommercials(VpnTester $I)
    {
        $I->uploadSchema();
        $I->realtyCommercialsEdit();
    }

    public function realtiesHistory(VpnTester $I)
    {
        $I->realtyFlatHistory();
        $I->realtyHouseHistory();
        $I->realtyParcelHistory();
        $I->realtyCommercialHistory();
    }

    public function deleteRealties(VpnTester $I)
    {
        $I->realtyFlatsDelete();
        $I->realtyHousesDelete();
        $I->realtyParcelsDelete();
        $I->realtyCommercialsDelete();
    }

}
