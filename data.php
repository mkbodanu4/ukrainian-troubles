<?php

error_reporting(NULL);

function get_predictions($query = "")
{
    $params = array(
        "hl" => "uk",
        "client" => "firefox",
        "q" => $query,
        "jsonp" => ""
    );
    $base = "http://suggestqueries.google.com/complete/search";

    $handler = curl_init();
    curl_setopt($handler, CURLOPT_URL, $base . "?" . http_build_query($params));
    curl_setopt($handler, CURLOPT_HEADER, FALSE);
    curl_setopt($handler, CURLOPT_HTTPHEADER, array());
    curl_setopt($handler, CURLINFO_HEADER_OUT, FALSE);
    curl_setopt($handler, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($handler, CURLOPT_MAXREDIRS, 10);
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($handler, CURLOPT_TIMEOUT, 30);
    curl_setopt($handler, CURLOPT_USERAGENT, "PHP/" . phpversion());
    $result = curl_exec($handler);
    $content_type = curl_getinfo($handler, CURLINFO_CONTENT_TYPE);
    curl_close($handler);

    $encoding = preg_replace("/(.*?)charset\=(.*?)/i", "$2", $content_type);
    if ($encoding) {
        $result = mb_convert_encoding($result, 'utf-8', $encoding);
    }

    if ($result)
        return json_decode($result);

    return FALSE;

}

$cities = array(
    'ua-vi' => "Вінниці",
    'ua-dp' => "Дніпрі",
    'ua-dt' => "Донецьку",
    'ua-zt' => "Житомирі",
    'ua-zp' => "Запоріжжі",
    'ua-if' => "Івано-Франківську",
    'ua-kv' => "Києві",
    'ua-kc' => "місті Києві",
    'ua-kh' => "Кропивницькому",
    'ua-lh' => "Луганську",
    'ua-vo' => "Луцьку",
    'ua-lv' => "Львові",
    'ua-mk' => "Миколаєві",
    'ua-my' => "Одесі",
    'ua-pl' => "Полтаві",
    'ua-rv' => "Рівному",
    'ua-sc' => "Севастополi",
    'ua-kr' => "Криму",
    'ua-sm' => "Сумах",
    'ua-tp' => "Тернополі",
    'ua-zk' => "Ужгороді",
    'ua-kk' => "Харкові",
    'ua-ks' => "Херсоні",
    'ua-km' => "Хмельницькому",
    'ua-ck' => "Черкасах",
    'ua-cv' => "Чернівцях",
    'ua-ch' => "Чернігові"
);

$cases = array();

foreach ($cities as $key => $city) {
    $predictions = get_predictions("у " . $city);
    if ($predictions && isset($predictions[1]) && is_array($predictions[1]) && count($predictions[1]) >= 2) {
        $predictions = array_values($predictions[1]);
        $case = $predictions[rand(0, (count($predictions) - 1))];
        while (trim(mb_strtolower($case)) == mb_strtolower("у " . $city)) {
            $case = $predictions[rand(0, (count($predictions) - 1))];
        }
        $cases[$key] = preg_replace("/[ув]\ " . mb_strtolower($city) . "\ (.*?)/u", "$1", mb_strtolower($case));
    }
}

$i = 0;
$data = array();
foreach ($cases as $key => $case) {
    $data[] = array(
        "case" => $case,
        "value" => $i,
        "hc-key" => $key
    );
    $i++;
}

header('Content-type: text/javascript');
?>var cases = <?php echo json_encode($data); ?>;