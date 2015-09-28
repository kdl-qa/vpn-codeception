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
    const district = 'Центр';
    const street = 'Шевченка улица';
    const houseNumber = '208';
    const generalArea = '250';
    const latitude = '49.44968';
    const longitude = '32.04494';
    const generalAreaUnit = 'Кв. метры';
    const wallMaterial = 'Дерево и кирпич';
    const effectiveArea = '200';
    const roomCount = '3';
    const floor = '3';
    const floorNumber = '5';
    const buildYear = '1993';
    const wc = 'Раздельный';
    const heating = 'Централизованное';
    const waterHeating = 'Бойлер';
    const descriptionCommercialSell = 'Продается коммерческая недвижимость в тихом районе города. Недвижимость ремонта и вложений не требует. Рядом хорошая транспортная розвязка.';
    const priceСommercialSell = '125400';
    const currencyUA = 'грн.';
    const currencyUS = '$';
    const periodDay = 'За день';
    const periodMonth = 'За месяц';
    const date = '20';
    const month = 'Октября';
    const year = '2015';
    const market = 'Вторичный';
    const repair = 'Косметический';
    const ownerName = 'Русо Туристо';
    const ownerContacts = 'tourist@mail.com; +380679638527';


    static $currentCommercialNumber;

    static function uniqueCommercialNumber()
    {
        if (self::$currentCommercialNumber) {
            return self::$currentCommercialNumber;
        }
        $constFileName = codecept_data_dir('commercial_number.txt');
        $number = trim(file_get_contents($constFileName));
        $number++;
        self::$currentCommercialNumber = $number;
        file_put_contents(codecept_data_dir('commercial_number.txt'), $number);
        return $number;
    }

}