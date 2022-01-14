<div class="chart-container"
    style="background-color: lightgoldenrodyellow;position: relative; height:300px; width:300px">
    <canvas id="myChart5" class="col-md-6"></canvas>
</div>
@push('js')
    <script type="text/javascript">
        $(function() {
            const data5 = {
                labels: {!! json_encode($project_status->labels) !!} ,
                datasets: [{
                    label: 'Project Status',
                    data: {!! json_encode($project_status->data) !!} ,
                    backgroundColor: {!! json_encode($project_status->colors) !!} ,
                    hoverOffset: 4
                }]
            };

            const config5 = {
                type: 'doughnut',
                data: data5,
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
                            text: "{{ _i('Projects Status') }}"
                        }
                    }
                },

            };

            var myChart5 = new Chart(
                document.getElementById('myChart5'),
                config5
            );

        });

    </script>
@endpush
