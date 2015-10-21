<?php
namespace Step\Vpn;
use \Data\Flat;
use \Page\AdvertsList;
use \Page\AddAdvert;
use \Page\AdvPage;
use \Data\Lists;
use \Facebook\WebDriver\WebDriverKeys;

class EditAdvert extends \VpnTester
{
    public function openEditFlatPage()
    {
        $I=$this;
        $advFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advFlatId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
    }

    public function editFlatAdvert()
    {
        $I=$this;
        $I->click(AdvertsList::$editAdvTab);

        $I->click(AddAdvert::$operationTypeRent);
        $I->fillField(AddAdvert::$advertDescription, Flat::editDescriptionFlatRent);
        $I->fillField(AddAdvert::$price, Flat::editPriceFlatRent);
        $I->click(AddAdvert::$currency);
        $I->fillField(AddAdvert::$typeCurrency, Flat::currencyUA);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$auction);
        $I->doubleClick(AddAdvert::$date);
        $I->pressKey(AddAdvert::$date, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$date, Flat::editDate);
        $I->click(AddAdvert::$month);
        $I->fillField(AddAdvert::$typeMonth, Flat::editMonth);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->doubleClick(AddAdvert::$year);
        $I->pressKey(AddAdvert::$year, WebDriverKeys::DELETE);
        $I->fillField(AddAdvert::$year, Flat::editYear);
        $I->click(AddAdvert::$market);
        $I->fillField(AddAdvert::$typeMarket, Flat::market1);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->click(AddAdvert::$repair);
        $I->fillField(AddAdvert::$typeRepair, Flat::repair2);
        $I->click(AddAdvert::$chooseFirstRow);
        $I->doubleClick(AddAdvert::$bedsCount);
        $I->fillField(AddAdvert::$bedsCount, Flat::editBeds);
    }

    public function fillInEditFlatAdvertCheckboxes()
    {
        $I = $this;
        $I->click(AddAdvert::$furniture0);
        $I->click(AddAdvert::$furniture1);
        $I->click(AddAdvert::$furniture2);
        $I->click(AddAdvert::$furniture3);
        $I->click(AddAdvert::$furniture4);
        $I->click(AddAdvert::$furniture5);
        $I->click(AddAdvert::$furniture6);
        $I->click(AddAdvert::$furniture7);

        $I->click(AddAdvert::$appliance0);
        $I->click(AddAdvert::$appliance1);
        $I->click(AddAdvert::$appliance2);
        $I->click(AddAdvert::$appliance3);
        $I->click(AddAdvert::$appliance4);
        $I->click(AddAdvert::$appliance5);
        $I->click(AddAdvert::$appliance6);
        $I->click(AddAdvert::$appliance7);

        $I->click(AddAdvert::$additionalFlat0);
        $I->click(AddAdvert::$additionalFlat1);
        $I->click(AddAdvert::$additionalFlat2);
        $I->click(AddAdvert::$additionalFlat3);
        $I->click(AddAdvert::$additionalFlat4);
        $I->click(AddAdvert::$additionalFlat5);
        $I->click(AddAdvert::$additionalFlat6);
        $I->click(AddAdvert::$additionalFlat7);
        $I->click(AddAdvert::$additionalFlat8);
        $I->click(AddAdvert::$additionalFlat9);
        $I->click(AddAdvert::$additionalFlat10);
        $I->click(AddAdvert::$additionalFlat11);
        $I->click(AddAdvert::$additionalFlat11);
        $I->click(AddAdvert::$additionalFlat12);
        $I->click(AddAdvert::$additionalFlat13);
        $I->click(AddAdvert::$additionalFlat14);
        $I->click(AddAdvert::$additionalFlat15);
    }

    public function openAdvertPage()
    {
        $I=$this;
        $I->
        $I->click(AdvertsList::$advInfoTab);
        $I->waitForElement(AdvertsList::$advInfoLink);
        $I->click(AdvertsList::$advInfoLink);
        $I->wait(3);
    }

    public function checkEditedFlatProperties() //webUS-6
    {
        $I = $this;
//        $I->amOnPage();
//        $I->click(AdvertsList::$advInfoTab);
//        $I->click(AdvertsList::adv)
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Flat::priceFlatSell, AdvPage::$advInfoPrice);
        $I->see(Flat::editAvailableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Flat::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Flat::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Lists::wallMaterial0, AdvPage::$advInfoMainProps);
        $I->see(Flat::floorNumber, AdvPage::$advInfoMainProps);
        $I->see(Flat::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Flat::editDescriptionFlatRent,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->see($this->agencyEmail, AdvPage::$advInfoContacts);
        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AdvPage::$advPropsTab);
        $I->see(Flat::category, AdvPage::$advPropsTable);
        $I->see(Flat::categoryType0, AdvPage::$advPropsTable);
        $I->see(Flat::region, AdvPage::$advPropsTable);
        $I->see(Flat::city, AdvPage::$advPropsTable);
        $I->see(Flat::editDistrict, AdvPage::$advPropsTable);
        $I->see(Flat::editStreet, AdvPage::$advPropsTable);
        $I->see(Flat::generalArea, AdvPage::$advPropsTable);
        $I->see(Flat::livingArea, AdvPage::$advPropsTable);
        $I->see(Flat::kitchenArea, AdvPage::$advPropsTable);
        $I->see(Flat::market1, AdvPage::$advPropsTable);
        $I->see(Flat::roomCount, AdvPage::$advPropsTable);
        $I->see(Flat::editBeds, AdvPage::$advPropsTable);
        $I->see(Flat::floorNumber, AdvPage::$advPropsTable);
        $I->see(Flat::floors, AdvPage::$advPropsTable);
        $I->see(Flat::buildYear, AdvPage::$advPropsTable);
        $I->see(Lists::wc1, AdvPage::$advPropsTable);
        $I->see(Lists::balconies1, AdvPage::$advPropsTable);
        $I->see(Lists::heating0, AdvPage::$advPropsTable);
        $I->see(Lists::waterHeat1, AdvPage::$advPropsTable);
        $I->see(Lists::repair2, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject0, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject1, AdvPage::$advPropsTable);
        $I->see(Lists::nearObject5, AdvPage::$advPropsTable);

        $I->see(Lists::furniture0, AdvPage::$advPropsTable);
        $I->see(Lists::furniture1, AdvPage::$advPropsTable);
        $I->see(Lists::furniture2, AdvPage::$advPropsTable);
        $I->see(Lists::furniture3, AdvPage::$advPropsTable);
        $I->see(Lists::furniture4, AdvPage::$advPropsTable);
        $I->see(Lists::furniture5, AdvPage::$advPropsTable);
        $I->see(Lists::furniture6, AdvPage::$advPropsTable);
        $I->see(Lists::furniture7, AdvPage::$advPropsTable);

        $I->see(Lists::appliance0, AdvPage::$advPropsTable);
        $I->see(Lists::appliance1, AdvPage::$advPropsTable);
        $I->see(Lists::appliance2, AdvPage::$advPropsTable);
        $I->see(Lists::appliance3, AdvPage::$advPropsTable);
        $I->see(Lists::appliance4, AdvPage::$advPropsTable);
        $I->see(Lists::appliance5, AdvPage::$advPropsTable);
        $I->see(Lists::appliance6, AdvPage::$advPropsTable);
        $I->see(Lists::appliance7, AdvPage::$advPropsTable);

        $I->see(Lists::additionalFlat0, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat1, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat2, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat3, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat4, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat5, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat6, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat7, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat8, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat9, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat10, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat11, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat12, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat13, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat14, AdvPage::$advPropsTable);
        $I->see(Lists::additionalFlat15, AdvPage::$advPropsTable);

        $I->click(AdvPage::$advSchemaTab);
        $I->seeElement(AdvPage::$advSchemaImg);

    }
}