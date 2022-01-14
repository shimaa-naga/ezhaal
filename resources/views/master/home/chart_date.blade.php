<div class="chart-container" style="position: relative; height:300px;">
    <canvas id="myChart_date"></canvas>
</div>

@push('js')


    <script type="text/javascript">
        $(function() {
            const data3 = {
                labels: {!! json_encode($complaint_dates->labels) !!},
                datasets: [{
                    label: 'Complaints Dates',
                    data: {!! json_encode($complaint_dates->data) !!},
                    backgroundColor: {!! json_encode($complaint_dates->colors) !!},
                    hoverOffset: 4
                }]
            };

            const config3 = {
                type: 'bar',
                data: data3,
                //   responsive: true,
                //  maintainAspectRatio: false,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: "{{ _i('Complaints Dates') }}"
                        }
                    }
                },



            };

            var myChart3 = new Chart(
                document.getElementById('myChart_date'),
                config3
            );
        });

    </script>
@endpush
