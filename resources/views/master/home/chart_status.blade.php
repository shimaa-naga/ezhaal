<div class="chart-container"
    style="background-color: lightgoldenrodyellow;position: relative; height:300px; width:300px">
    <canvas id="myChart" class="col-md-6"></canvas>
</div>
@push('js')

    <script type="text/javascript">
        $(function() {
            const data = {
                labels: {!! json_encode($complaint_status->labels) !!},
                datasets: [{
                    label: 'Complaints Status',
                    data: {!! json_encode($complaint_status->data) !!},
                    backgroundColor: {!! json_encode($complaint_status->colors) !!}
                         ,
                    hoverOffset: 4
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
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
                            text: "{{ _i('Complaints Status') }}"
                        }
                    }
                },

            };

            var myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
        });

    </script>
@endpush
