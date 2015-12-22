<?php

namespace Data;


class Commercial
{
    const category = 'Коммерческая недвижимость';
    const categoryType0 = 'Офисное помещение';
    const categoryType1 = 'Офисные здания';
    const categoryType2 = 'Торговые площади';
    const categoryType3 = 'Складские помещения';
    const categoryType4 = 'Производственные помещения';
    const categoryType5 = 'Кафе, бар, ресторан';
    const categoryType6 = 'Объект сферы услуг';
    const categoryType7 = 'Отель, гостиница';
    const categoryType8 = 'База отдыха, пансионат';
    const categoryType9 = 'Помещения свободного назначения';
    const categoryType10 = 'Готовый бизнес';

    const region = 'Черкасская область';
    const city = 'Черкассы';
    const district = 'Днепровский';
    const street = 'Шевченко бульвар';
//    const houseNumber = '208';
    const generalArea = '250';
    const latitude = '49.44188';
    const longitude = '32.06402';
    const effectiveArea = '200';
    const roomCount = '5';
    const roomCountDefault = '5';

    const floors = '2';
    const floorNumber = '1';
    const buildYear = '2000';
    const wc = 'Раздельный';
    const heating = 'Централизованное';
    const waterHeating = 'Бойлер';
    const descriptionCommercialSell = 'Продается коммерческая недвижимость в тихом районе города. Недвижимость ремонта и вложений не требует. Рядом хорошая транспортная розвязка.';
    const descriptionCommercialRent = 'Сдается в аренду коммерческая недвижимость в центре города. Недвижимость ремонта и вложений не требует. Рядом хорошая транспортная розвязка.';

    const priceCommercialSell = '125400';
    const priceCommercialRent = '25400';
    const priceCommercialSearch = '7000';


    const periodDay = 'За день';
    const periodMonth = 'За месяц';
    const commission = '4';
    const currencyUA = 'грн.';
    const currencyUS = '$';
    const date = '5';
    const month = 'Января';
    const year = '2016';
    const availableFrom = '05.01.2016';
    const apiAvailableFrom = '2016-01-05';
    const market = 'Вторичный';
    const repair = 'Косметический';
    const ownerName = 'Русо Туристо';
    const ownerContacts = 'tourist@mail.com; +380679638527';

/*==========================================Edit Commercial=========================================*/

    const editDescriptionCommercialSell = 'Edit. Продается коммерческая недвижимость в тихом районе города. Недвижимость ремонта и вложений не требует.';
    const editDescriptionCommercialRent = 'Edit. Сдается в аренду коммерческая недвижимость в центре города. Рядом хорошая транспортная розвязка.';
    const editCommission = '3.5';
    const editPriceCommercialSell = '151000';
    const editPriceCommercialRent = '29999';

    const apiDistrict = 'Ж/д вокзал';
    const apiStreet = 'Вербовецкого улица';
    const apiStreetRent = 'Володарского улица';

    const editDistrict = 'Водоканал-Невского';
    const editStreet = 'Вернигоры улица';

    const editLatitude = '49.41815';
    const editLongitude = '32.09172';
    const editGeneralArea = '225';
    const editRoomCount = '4';
    const editEffectiveArea = '190';

    const editFloor = '3';
    const editFloorNumber = '2';
    const editBuildYear = '1999';


    const editDate = '15';
    const editMonth = 'Февраля';
    const editYear = '2016';
    const editAvailableFrom = '15.02.2016';


/*==========================================Common=========================================*/

    static $currentCommercialNumber;

    static function uniqueCommercialNumber()
    {
//        if (self::$currentCommercialNumber) {
//            return self::$currentCommercialNumber;
//        }
        $constFileName = codecept_data_dir('commercial_number.txt');
        $number = trim(file_get_contents($constFileName));
        $number++;
        self::$currentCommercialNumber = $number;
        file_put_contents(codecept_data_dir('commercial_number.txt'), $number);
        return $number;
    }

}