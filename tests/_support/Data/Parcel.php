<?php


namespace Data;


class Parcel
{
    const category = 'Земельные участки';
    const categoryType0 = 'Участок под жилую застройку';
    const categoryType1 = 'Земля коммерческого назначения';
    const categoryType2 = 'Земля сельскохозяйственного назначения';
    const categoryType3 = 'Земля рекреационного назначения';
    const categoryType4 = 'Земля природно-заповедного назначения';

    const region = 'Черкасская область';
    const city = 'Черкассы';
//    const district = 'Молокозавод';
    const street = 'Ватутина улица';
//    const houseNumber = '129';
//    const generalArea = '65';
    const latitude = '49.41473';
    const longitude = '32.08260';
//    const generalAreaUnit = 'Кв. метры';
//    const wallMaterial = 'Дерево и кирпич';
//    const roomCount = '4';
//    const livingArea = '50';
//    const kitchenArea = '9';
    const area = '6';
    const areaUnit = 'Сотки';
//    const wc = 'Раздельный';
//    const heating = 'Централизованное';
//    const waterHeating = 'Бойлер';
    const descriptionParcelSell = 'Продается Земельный участок в тихом районе города. Все документы на землю в соответствуют законодательству страны. Рядом хорошая транспортная розвязка.';
    const priceParcelSell = '10050';
    const currencyUA = 'грн.';
    const currencyUS = '$';
    const periodDay = 'За день';
    const periodMonth = 'За месяц';
    const date = '20';
    const month = 'Октября';
    const year = '2015';
    const market = 'Вторичный';
    const ownerName = 'Ioan Ioan';
    const ownerContacts = 'ioan@freeletter.me; +380671234567';


    static $currentCadastralNumber;

    static function uniqueCadastralNumber()
    {
        if (self::$currentCadastralNumber) {
            return self::$currentCadastralNumber;
        }
        $constFileName = codecept_data_dir('cadastral_number.txt');
        $number = trim(file_get_contents($constFileName));
        $number++;
        self::$currentCadastralNumber = $number;
        file_put_contents(codecept_data_dir('cadastral_number.txt'), $number);
        return $number;
    }


}