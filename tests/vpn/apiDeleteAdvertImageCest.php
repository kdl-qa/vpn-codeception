<?php
use \VpnTester;

class apiDeleteAdvertImageCest
{
    protected function loginAgency(VpnTester $I)
    {
        $I->apiAgencyLogin();
    }

    protected function addRealties(VpnTester $I)
    {
        $I->realtyFlatAddPlain();
    }

    protected function uploadAdvertImages(VpnTester $I)
    {
        $I->uploadAdvImages();
    }


    protected function addAdvert(VpnTester $I)
    {
        $I->apiAdvertFlatAddComplex();
    }

    protected function apiDeleteAdvert(VpnTester $I)
    {
        $I->apiDeleteFlatAdvert();
    }

    /**
     *@before uploadAdvertImages
     *@before loginAgency
     *@before addRealties
     *@before addAdvert
     *@after apiDeleteAdvert
     */
    public function deleteAdvertImage(VpnTester $I)
    {
        $I->deleteAdvertImage();
    }

}
