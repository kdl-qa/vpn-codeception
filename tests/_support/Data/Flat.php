<?php

namespace Data;


class Flat
{
/*======================================================Add Flat==========================================*/
    const category = 'Квартиры и комнаты';
    const categoryType0 = 'Квартира';
    const categoryType1 = 'Комната';
    const region = 'Черкасская область';
    const city = 'Черкассы';
    const district = '700-летия';
    const street = 'Крещатик улица';
    const houseNumber = 200;
    const generalArea = 58;
    const latitude = 49.44314;
    const longitude = 32.06470;
    const generalAreaUnit = 'Кв. метры';
    const wallMaterial = 'Силикатный кирпич';
    const roomCount = 2;
    const livingArea = 43;
    const kitchenArea = 9;
    const floorNumber = 4;
    const floors = 10;
    const buildYear = 1982;
    const wc = 'Раздельный';
    const balcony = '1';
    const heating = 'Централизованное';
    const waterHeating = 'Бойлер';
    const descriptionFlatSell = 'Продается квартира в центре города. Квартира вложений не требует. Хорошая транспортная розвязка.';
    const priceFlatSell = '65121';
    const priceFlatSearch = '35000';
    const priceFlatRent = '500'; //5000 грн

    const currencyUA = 'грн.';
    const currencyUS = '$';
    const periodDay = 'За день';
    const periodMonth = 'За месяц';
    const commission = '3';
    const date = '8';
    const month = 'Ноября';
    const year = '2015';
    const availableFrom = '8.11.2015';
    const apiAvailableFrom = '2015-11-08';
    const market0 = 'Первичный';
    const market1 = 'Вторичный';
    const repair0 = 'Косметический';
    const repair1 = 'Евроремонт';
    const repair2 = 'Дизайнерский';
    const repair3 = 'После строителей';

    const beds = '3';
    const ownerName = 'Иван Иванов';
    const ownerContacts = 'wrong@mail.com; +380671234567';

/*===================================================Edit Flat==========================================*/

    const editDescriptionFlatRent = 'Аренда квартиры в центре города. Аренда квартиры без посредников. Квартира вложений не требует. Хорошая транспортная розвязка.';
    const editDescriptionFlatSale = 'Продажа квартиры на окраине города. Продажа квартир без посредников. Квартира ремонта и вложений не требует. Рядом хорошая транспортная розвязка.';

    const editCity = 'Смела';
    const editPriceFlatSell = '35121'; //$
    const editPriceFlatRent = '4000'; //грн

    const apiStreet = 'Василевского Маршала улица';
    const editDistrict = 'Ж/д вокзал';
    const editStreet = 'Будённого';
    const editHouseNumber = '175';
    const editCommission = '5.5';
    const editLatitude = '49.44314';
    const editLongitude = '32.06470';

    const editGeneralArea = '75';
    const editLivingArea = '60';
    const editKitchenArea = '10';
    const editFloorNumber = '5';
    const editFloors = '15';
    const editBuildYear = '1996';


    const editRoomCount = '4';
    const editWallMaterial = 'Кирпич';
    const editWaterHeating = 'Централизованный';

    const editDate = '1';
    const editMonth = 'Декабря';
    const editYear = '2015';
    const editAvailableFrom = '01.12.2015';
    const editBeds = '4';

    const editOwnerName = 'Марк Цукенберг';
    const editOwnerContacts = 'markzu@mail.com; +380671234567';


/*===================================================General Info==========================================*/
    const operationType0 = 'Аренда';
    const operationType1 = 'Продажа';

    const descriptionDealFinished = 'Квартира продана согласно эксклюзивному договору между владельцем и агентством недвижимости.';
    const descriptionOtherReason = 'Владелец передумал продавать квартиру из-за низкой рыночной стоимости.';

    const status0 = 'На премодерации';
    const status1 = 'Опубликовано';
    const status2 = 'Отклонено администрацией';
    const status3 = 'Заявка на снятие с публикации';
    const status4 = 'Снято с публикации';

    const videoURL = 'https://www.youtube.com/embed/BlD2Zr_USXw';
    const videoImage = 'https://i.ytimg.com/vi/BlD2Zr_USXw/hqdefault.jpg';


    static $currentFlatNumber;

    static function uniqueFlatNumber()
    {
//        if (self::$currentFlatNumber) {
//            return self::$currentFlatNumber;
//        }
        $constFileName = codecept_data_dir('flat_number.txt');
        $number = trim(file_get_contents($constFileName));
        $number++;
        self::$currentFlatNumber = $number;
        file_put_contents(codecept_data_dir('flat_number.txt'), $number);
        return $number;
    }



}