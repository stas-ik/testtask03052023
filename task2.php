<?php
require_once './vendor/autoload.php';
$res_array = [];
$dates = [];
$money = [];
$key = 0;
if (($handle = fopen("https://api.blockchain.info/charts/market-price?format=csv&timespan=all", "r")) !== FALSE) {
    while (($data = fgetcsv($handle,null, ",")) !== FALSE) {
        $res_array[] = [
            'date' => $data[0] ?? '0000-00-00 00:00:00',
            'summ' => $data[1] ?? 0.0,
        ];
        $dates[$key] = $data[0] ?? '0000-00-00 00:00:00';
        $money[$key] = $data[1] ?? 0.0;
        $key++;
    }
    fclose($handle);
}

//TODO WRITE MIGRATIONS
//TODO VALIDATE AND SAVE TO DATABASE

$res_array = json_encode($res_array);
$dates = json_encode($dates);
$money = json_encode($money);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>test 2</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .btn_wrapper{
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="moneyChart_wrapper">
        <canvas id="moneyChart" width="600" height="400"></canvas>
    </div>
    <div class="btn_wrapper">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" data-filter="30d" class="btn btn-secondary">30 Days</button>
            <button type="button" data-filter="60d" class="btn btn-secondary">60 Days</button>
            <button type="button" data-filter="180d" class="btn btn-secondary">180 Days</button>
            <button type="button" data-filter="1y" class="btn btn-secondary">1 Year</button>
            <button type="button" data-filter="2y" class="btn btn-secondary">2 Year</button>
            <button type="button" data-filter="all" class="btn btn-secondary active">All Time</button>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    //TODO AJAX for FILTER and rebuild chart

    let moneyCanvas = document.getElementById("moneyChart");
    let data = JSON.stringify(<?php echo $money; ?>);
    data = JSON.parse(data);
    let labels = JSON.stringify(<?php echo $dates; ?>);
    labels = JSON.parse(labels);

    let moneyData = {
        labels: labels,
        datasets: [{
            label: "Money/Year",
            data: data,
            lineTension: 0,
            fill: false,
            borderColor: 'blue',
            backgroundColor: 'transparent',
            borderDash: [5, 1],
            pointBorderColor: 'blue',
            pointBackgroundColor: 'blue',
            pointRadius: 1,
            pointHoverRadius: 10,
            pointHitRadius: 30,
            pointBorderWidth: 2,
            pointStyle: 'rectRounded'
        }]
    };

    let chartOptions = {
        legend: {
            display: true,
            position: 'top',
            labels: {
                boxWidth: 80,
                fontColor: 'black'
            }
        }
    };

    let lineChart = new Chart(moneyCanvas, {
        type: 'line',
        data: moneyData,
        options: chartOptions
    });
</script>
</html>
