<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <span class="trans-header">Referrer Chart</span>

                <div id="myChart" style="width:100%; max-width:600px; height:500px;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    google.charts.load('current',{packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
// Set Data
        var jobs = {!! json_encode($ref_days) !!};
        const arr = [['Days', 'Referrer']]
        for(var i = 0; i < jobs.length; i++){
            arr.push([jobs[i].day, jobs[i].counter])
        }


        console.log([['Days', 'Referrer'], arr])
        var data = google.visualization.arrayToDataTable(
             arr
        );
// Set Options
        var options = {
            title: 'Last 14 days of Ref',
            hAxis: {title: 'Days'},
            vAxis: {title: 'Ref Counter'},
            legend: 'none'
        };
// Draw
        var chart = new google.visualization.LineChart(document.getElementById('myChart'));
        chart.draw(data, options);
    }
</script>
