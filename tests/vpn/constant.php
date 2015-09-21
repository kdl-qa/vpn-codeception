<?php

    $mail = 'kdl';
    $userFName = 'Dima';
    $userLName = 'Kravchenko';
    $userEmail = $mail.'@freeletter.me';
    $userPhone0 = '+380671234567';
    $userPass = 'qwaszx12';
    $userConfPass = $userPass;
  //  $userToken;

    $agencyName = 'uhome';
    $agencyEmail = 'support@uhome.ck.ua';
    $agencyChiefFName = 'Андрей';
    $agencyChiefLName = 'Сорокин';
    $agencyPass = 'L7KZXX';
    //$agencyToken;
    $attachFile = '#image';


    class RegistrationUser {
        public static $url = '/registration-private-person';
        public static $fname = "//input[@id='fname']";
        public static $lname = "//input[@id='lname']";
        public static $email = "//input[@id='email']";
        public static $phone0 = "//input[@id='phone0']";
        public static $pass = "//input[@id='pass']";
        public static $confirmPass = "//input[@id='confirm']";
        public static $image = '#image';
        public static $submit = "//button[@type='submit']";
        public static $terms = "//a[@href='/info/terms-of-use']";
    }

    class Login {
        public static $email = "//input[@id='email']";
        public static $pass = "//input[@id='password']";
        public static $submit = "//button[@type='submit']";
        public static $restorePass = 'html/body/div[1]/div[3]/form/dl/div/a';
        public static $sigUpLink = 'html/body/div[1]/div[3]/p/a[1]';
    }

    class FlatObject {
        const category = 'Квартиры и комнаты';
        const categoryType1 = 'Квартира';
        const categoryType2 = 'Комната';
        const region = 'Черкасская область';
        const city = 'Черкассы';
        const district = '700-летия';
        const street = 'Крещатик улица';
        const houseNumber = '200';
        const flatNumber = '40';
        const generalArea = '55';
        const generalAreaUnit = 'Кв. метры';
        const wallMaterial = 'Силикатный кирпич';
        const roomCount = '3';
        const livingArea = '42';
        const kitchenArea = '9';
        const floorNumber = '3';
        const floors = '10';
        const buildYear = '1982';
        const wc = 'Раздельный';
        const balcony = '1';
        const heating = 'Централизованное';
        const waterHeating = 'Бойлер';

        const descriptionFlatSell = 'Продается квартира в центре города. Квартира вложений не требует. Хорошая транспортная розвязка.';
        const priceFlatSell = '45121';
        const currencyUA = 'грн.';
        const currencyUS = '$';
        const periodDay = 'За день';
        const periodMonth = 'За месяц';
        const date = '20';
        const month = 'Октября';
        const year = '2015';
        const market = 'Вторичный';
        const repair = 'Дизайнерский';
        const beds = '3';
        const ownerName = 'Иван Иванов';
        const ownerContacts = 'wrong@mail.com; +380671234567';

    }

    class AddAdvert{

        public static $chooseFirstRow = "//a[@class='ui-select-choices-row-inner']";

        public static $category ='//dd[1]/div/div/span/span[2]'; //html/body/div[1]/div[3]/form/dl/dd[1]/div/div/span
        public static $flatCategory = "//div[contains(.,'" . FlatObject::category . "')]";
        public static $houseCategory ;
        public static $parcelCategory ;
        public static $commercialCategory ;

        public static $category_type = '//dd[2]/div/div/span/span[2]';
        public static $catTypeFlat = "//div[contains(.,'" .FlatObject::categoryType1. "')]";
        public static $catTypeRoom;

        public static $catTypeHouse;
        public static $catTypePartHouse;
        public static $catTypeSumCottage;

        public static $catTypeLandForBuild;

        public static $region = '//dd[3]/div/div/span/span[2]';
        public static $chooseRegion = "//div[contains(.,'".FlatObject::region."')]";

        public static $city = '//dd[4]/div/div/span/span[2]';
        public static $chooseCity = "//div[contains(.,'".FlatObject::city."')]";

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
        public static $generalAreaUnitType = FlatObject::generalAreaUnit;

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

        public static $step2_2_changeAdress = 'html/body/div[1]/div[3]/div/button[1]';
        public static $step2_2_changeProperties = 'html/body/div[1]/div[3]/div/button[2]';
        public static $step2_2_createObject = 'html/body/div[1]/div[3]/div/button[3]';

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











    }




?>