<?php

$_SERVER["DOCUMENT_ROOT"] = realpath(__DIR__ . "/../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define("CHK_EVENT", true);

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

CModule::IncludeModule("iblock");

$limit = 1910;
$iblockId = 1;

$dadata = new Dadata(DADATA_API_KEY);
$dadata->init();

$cache = [];

$found = 0;
$notFound = 0;
$invalid = 0;
$errors = 0;
$updated = 0;

$rs = CIBlockElement::GetList(
    ["ID" => "ASC"],
    [
        "IBLOCK_ID" => $iblockId,
        "!PROPERTY_INN" => false,
        "PROPERTY_OGRN" => false,
    ],
    false,
    ["nTopCount" => $limit],
    [
        "ID",
        "NAME",
        "PROPERTY_INN",
        "PROPERTY_OGRN",
    ]
);

echo "UPDATE MODE: заполнение ОГРН по ИНН\n";
echo "Будут обновлены записи с пустым ОГРН\n\n";

while ($item = $rs->Fetch()) {
    $id = (int)$item["ID"];
    $name = $item["NAME"];
    $inn = trim((string)$item["PROPERTY_INN_VALUE"]);

    echo "----------------------------------------\n";
    echo "ID: {$id}\n";
    echo "Название: {$name}\n";
    echo "ИНН: {$inn}\n";

    if (
        !preg_match('/^([0-9]{10}|[0-9]{12})$/', $inn)
        || preg_match('/^0+$/', $inn)
    ) {
        echo "Статус: SKIP_INVALID_INN\n";
        $invalid++;
        continue;
    }

    try {
        if (isset($cache[$inn])) {
            $ogrn = $cache[$inn];
            echo "Источник: CACHE\n";
        } else {
            $result = $dadata->findById("party", [
                "query" => $inn,
                "count" => 1,
            ]);

            $ogrn = $result["suggestions"][0]["data"]["ogrn"] ?? "";
            $cache[$inn] = $ogrn;

            echo "Источник: DADATA\n";
        }

        if ($ogrn !== "") {

            CIBlockElement::SetPropertyValuesEx(
                $id,
                $iblockId,
                ['OGRN' => $ogrn]
            );

            echo "Найден ОГРН: {$ogrn}\n";
            echo "Статус: SAVED\n";

            $found++;
            $updated++;
        }
        else {
            echo "ОГРН не найден\n";
            echo "Статус: NOT_FOUND\n";
            $notFound++;
        }

        usleep(250000);
    } catch (Throwable $e) {
        echo "Статус: ERROR\n";
        $errors++;
        echo "Ошибка: " . $e->getMessage() . "\n";
    }
}

$dadata->close();

echo "\n====================================\n";
echo "СТАТИСТИКА\n";
echo "====================================\n";
echo "Найдено ОГРН: {$found}\n";
echo "Не найдено: {$notFound}\n";
echo "Некорректный ИНН: {$invalid}\n";
echo "Ошибок: {$errors}\n";
echo "Обновлено записей: {$updated}\n";
echo "Кешированных ИНН: " . count($cache) . "\n";

echo "\nГотово. Выполнено обновление ОГРН.\n";
