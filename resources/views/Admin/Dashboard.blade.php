@extends('Layout.AdminMain')

@push('title')
    <title>Dashboard</title>
@endpush

@section('header')
    @include('Component.Header')
@endsection 

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1 class="mb-1">Dashboard</h1>
        <div class="page-nav">
        </div>
    </div>
    <section class="section dashboard mt-2">

        <div class="row">

            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title fw-normal mt-3">Accounts</h5>
                        <div id="accounts-chart"></div>
                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title fw-normal mt-3">Post vs Application</h5>
                        <div id="ap-chart"></div>
                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title fw-normal mt-3">Job Post Per Category</h5>
                        <div id="jppc-chart"></div>
                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title fw-normal mt-3">Verified Accounts</h5>
                        <div id="va-chart"></div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('script')
    <!-- datatable js -->
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.3/apexcharts.min.js" integrity="sha512-sa449wQ9TM6SvZV7TK7Zx/SjVR6bc7lR8tRz1Ar4/R6X2jOLaFln/9C+6Ak2OkAKZ/xBAKJ94dQMeYa0JT1RLg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function bar_chart(data, categories, id){
            var options = {
                series: [{
                    data: data
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                    }
                },
                tooltip: {
                    enabled: false
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        rotate: 0
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector(id), options);
            chart.render();
        }

        function pie_chart(data, categories, id){
            var options = {
                series: data,
                chart: {
                    height: 350,
                    type: 'pie',
                    toolbar: {
                        show: true
                    },
                },
                labels: categories,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            var chart = new ApexCharts(document.querySelector(id), options);
            chart.render();
        }

        bar_chart([{{ $emp }}, {{ $app }}],['Employer', 'Applicant'], '#accounts-chart');
        bar_chart([{{ $jp }}, {{ $ja }}], ['Job Post', 'Job Application'], '#ap-chart');
        bar_chart([@foreach($jpc as $c) {{ $c->total }}, @endforeach], [@foreach($jpc as $c) "{{ $c->jc_category }}", @endforeach], '#jppc-chart');
        pie_chart([{{ $va }}, {{ ($app + $emp)-$va }}], ['Verified', 'Not Verified'], '#va-chart');
    </script>
@endpush