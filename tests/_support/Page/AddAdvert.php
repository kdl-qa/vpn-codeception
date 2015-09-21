<?php
namespace Page;
use Data\Flat;

class AddAdvert
{
    public static $chooseFirstRow = "//a[@class='ui-select-choices-row-inner']";

    public static $category ='//dd[1]/div/div/span/span[2]'; //html/body/div[1]/div[3]/form/dl/dd[1]/div/div/span
    public static $flatCategory = "//div[contains(.,'" . Flat::category . "')]";
    public static $houseCategory ;
    public static $parcelCategory ;
    public static $commercialCategory ;

    public static $category_type = '//dd[2]/div/div/span/span[2]';
    public static $catTypeFlat = "//div[contains(.,'" .Flat::categoryType1. "')]";
    public static $catTypeRoom;

    public static $catTypeHouse;
    public static $catTypePartHouse;
    public static $catTypeSumCottage;

    public static $catTypeLandForBuild;

    public static $region = '//dd[3]/div/div/span/span[2]';
    public static $chooseRegion = "//div[contains(.,'".Flat::region."')]";

    public static $city = '//dd[4]/div/div/span/span[2]';
    public static $chooseCity = "//div[contains(.,'".Flat::city."')]";

    public static $district = '//dd[5]/div/div/span/span[2]';
    public static $typeDistrict = '//dd[5]/div/input[1]';
    public static $chooseDistrict = "//div[@id='ui-select-choices-row-4-0']/a/div";

    public static $street = '//dd[6]/div/div/span/span';
    public static $typeStreet = '//dd[6]/div/input[1]';
    public static $chooseStreet = "//div[@id='ui-select-choices-row-5-0']/a/div";


    public static $house_number = "//input[@id='houseNumber']";
    public static $flat_number = "//input[@id='flatNumber']";
    public static $step1_submit = "//button[@type='submit']";

    public static $yandexMap = ".//*[@id='map-canvas']/ymaps/ymaps/ymaps[1]";

    public static $step1PopUp = 'html/body/div[5]/div/div';
    public static $step1PopUpTitle = 'Новый объект недвижимости';
    public static $step1PopUpYes = 'html/body/div[5]/div/div/div[2]/div/button[2]';
    public static $step1PopUpCancel = 'html/body/div[5]/div/div/div[2]/div/button[1]';

    /*step 2 ==================================================================================*/

    public static $generalArea = "//input[@id='generalArea']";
    public static $generalAreaUnit = "html/body/div[1]/div[3]/form/dl/dd[1]/div/div/span";
    public static $generalAreaUnitType = Flat::generalAreaUnit;

    public static $wallMaterial = "//dd[2]/div/div/span";
    public static $typeWallMaterial = '//dd[2]/div/input'; //Силикатный

//        public static $chooseWallMaterial = "//a[@class='ui-select-choices-row-inner']";


    public static $roomСount = '//dd[3]/div/input';
    public static $typeRoomCount = 3;

    public static $livingArea = ".//*[@id='liveArea']";
    public static $kitchenArea = ".//*[@id='kichenArea']";
    public static $floors = ".//*[@id='storeys']";
    public static $floorNumber = ".//*[@id='floor']";
    public static $buildYear = ".//*[@id='buildYear']";

    public static $wc = '//dd[9]/div/div/span';
    public static $typeWC = '//dd[9]/div/input';
//        public static $chooseWC = "//a[@class='ui-select-choices-row-inner']";

    public static $balcony = '//dd[10]/div/div/span';
    public static $typeBalcony = '//dd[10]/div/input';
//        public static $chooseBalcony = "//a[@class='ui-select-choices-row-inner']";

    public static $heating = '//dd[11]/div/div/span';
    public static $typeHeating = '//dd[11]/div/input';
//        public static $chooseHeating = "//a[@class='ui-select-choices-row-inner']";

    public static $waterHeating = '//dd[12]/div/div/span';
    public static $typeWaterHeating = '//dd[12]/div/input';
//        public static $chooseWaterHeating = "//a[@class='ui-select-choices-row-inner']";

    public static $nearObjectsFirst = '//dd[13]/div/div[1]/div/span[1]';
    public static $nearObjectsLast = '//dd[13]/div/div[10]/div/span[1]';
    public static $step2_previous = 'html/body/div[1]/div[3]/form/dl/div[2]/button[1]';
    public static $step2_next = "//button[@type='submit']";

    public static $step2_2_changeAddress = 'html/body/div[1]/div[3]/div/button[1]';
    public static $step2_2_changeProperties = 'html/body/div[1]/div[3]/div/button[2]';
    public static $step2_2_createObject = 'html/body/div[1]/div[3]/div/button[3]';

    public static $objectTable = 'table.realty';

    /*step 3 ==================================================================================*/
    public static $operationTypeSell = '//dd[1]/label[2]';
    public static $operationTypeRent = '//dd[1]/label[1]';
    public static $advertDescription = "//textarea[@id='description']";
    public static $price = ".//*[@id='price']";
    public static $currency = '//dd/div[1]/div/span';
    public static $typeCurrency = '//dd/div[1]/input[1]';
//        public static $chooseCurrency = "//a[@class='ui-select-choices-row-inner']";
    public static $auction = '//dd/div[2]/div/span[1]';
    public static $period = '//dd/div/div/span';
    public static $typePeriod = '//dd/div/input[1]';
//        public static $choosePeriod = "//a[@class='ui-select-choices-row-inner']";
    public static $date = '//dd[3]/div/input[1]';
    public static $month = '//dd[3]/div/div/div/span';
    public static $typeMonth = '//dd[3]/div/div/input[1]';
//        public static $chooseDate = "//a[@class='ui-select-choices-row-inner']";
    public static $year = '//dd[3]/div/input[2]';
    public static $market = '//dd[4]/div/div/span';
    public static $typeMarket = '//dd[4]/div/input[1]';
//        public static $chooseMarket = "a[@class='ui-select-choices-row-inner']";
    public static $repair = '//dd[5]/div/div/span';
    public static $typeRepair = '//dd[5]/div/input[1]';
    public static $bedsCount = '//dd[6]/div/input';
    public static $furnitureFirst = '//dd[7]/div/div[1]/div/span[1]';
    public static $furnitureLast = '//dd[7]/div/div[8]/div/span[1]';
    public static $appliancesFirst = '//dd[8]/div/div[1]/div/span[1]';
    public static $appliancesLast = '//dd[8]/div/div[8]/div/span[1]';
    public static $additionalFirst = '//dd[9]/div/div[1]/div/span[1]';
    public static $additionalLast = '//dd[9]/div/div[16]/div/span[1]';
    public static $ownerName = "//input[@id='ownerName']";
    public static $ownerContacts = "//textarea[@id='ownerContacts']";
    public static $ownerLink = "//a[@class='dottedLink']";
    public static $createAdvertButton = "//button[@type='submit']";
    public static $step3_Good = 'html/body/div[5]/div/div/div[2]/div/button';

    public static $schemaFile = '#image';
    public static $galleryFile = '#image';



}
