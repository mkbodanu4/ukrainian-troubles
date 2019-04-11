<!DOCTYPE html>
<html>
<head>
    <title>Карта нещасть України</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        #container {
            height: 100%;
            min-width: 310px;
            max-width: 100%;
            margin: 0 auto;
        }

        .loading {
            margin-top: 10em;
            text-align: center;
            color: gray;
        }

        .highcharts-title {
            font-family: 'Courier New', monospace;
            fill: #434348 !important;
            font-weight: bold !important;
            font-size: 3em !important;
        }

        .highcharts-subtitle {
            font-family: 'Courier New', monospace;
            font-style: italic;
            fill: #141428 !important;
        }

    </style>
</head>
<body>

<div id="container"></div>

<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/ua/ua-all.js"></script>
<script src="data.php"></script>
<script>
    Highcharts.mapChart('container', {
        chart: {
            map: 'countries/ua/ua-all'
        },

        title: {
            text: 'Карта нещасть України',
            y: 30
        },

        subtitle: {
            text: 'Що пропонує гугл, якщо ввести "у -назві-міста-"',
            y: 60
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },

        legend: {
            enabled: false
        },

        tooltip: {
            headerFormat: '',
            pointFormat: '{point.case}'
        },

        series: [{
            data: cases,
            name: "Нещастя",
            color: "#FFFFEC",
            dataLabels: {
                enabled: true,
                format: '{point.case}',
                crop: true,
                allowOverlap: true,
                style: {
                    textOverflow: 'justify'
                }
            }
        }]
    });

</script>
</body>
</html>