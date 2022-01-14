<div class="chart-container" style="position: relative; height:300px;">
    <canvas id="myChart_date2"></canvas>
</div>

@push('js')


    <script type="text/javascript">
        $(function() {
            const data4 = {
                labels: {!! json_encode($project_dates->labels) !!},
                datasets: [{
                    label: 'Projects Dates',
                    data: {!! json_encode($project_dates->data) !!},
                    backgroundColor: {!! json_encode($project_dates->colors) !!},
                    hoverOffset: 4
                }]
            };

            const config4 = {
                type: 'bar',
                data: data4,
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
                            text: "{{ _i('Projects Dates') }}"
                        }
                    }
                },



            };

            var myChart4 = new Chart(
                document.getElementById('myChart_date2'),
                config4
            );
        });

    </script>
@endpush
