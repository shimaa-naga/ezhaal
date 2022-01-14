<div class="chart-container"  style="background-color:beige;position: relative; height:300px; width:300px">
    <canvas id="myChart_types" class="col-md-6"></canvas>
</div>

@push('js')


    <script type="text/javascript">
        $(function(){
            const data2 = {
            labels: {!! json_encode($complaint_types->labels) !!},
            datasets: [{
                label: 'Complaints Types',
                data: {!! json_encode($complaint_types->data) !!},
                backgroundColor: {!! json_encode($complaint_types->colors) !!},
                hoverOffset: 4
            }]
        };

        const config2 = {
            type: 'pie',
            data: data2,
            responsive: true,
            maintainAspectRatio: false,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: "{{_i('Complaints Types')}}"
                    }
                }
            },



        };

        var myChart2 = new Chart(
            document.getElementById('myChart_types'),
            config2
        );
        })



    </script>
@endpush
