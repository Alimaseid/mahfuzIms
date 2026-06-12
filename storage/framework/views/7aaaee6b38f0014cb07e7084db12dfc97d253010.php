<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <?php if(auth()->user()->role == 1): ?>
        <style>
            .small-box {
                border-radius: 15px !important;
                transition: 0.3s;
            }

            .small-box:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            }

            .small-box .icon {
                font-size: 60px;
                top: 10px;
                right: 20px;
                opacity: 0.2;
            }
        </style>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Daily, Monthly and Yearly Sales</h3>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Daily Sales -->
                        <div class="col-lg-4 col-12">
                            <div class="small-box bg-success shadow rounded">
                                <div class="inner">
                                    <p>Daily Sales</p>
                                    <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                                        data-target="#dailySalesModal">
                                        View
                                    </button>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-day" style="color: white"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Sales -->
                        <div class="col-lg-4 col-12">
                            <div class="small-box bg-primary shadow rounded">
                                <div class="inner">
                                    <p>Monthly Sales</p>
                                    <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                                        data-target="#monthlySalesModal">
                                        View
                                    </button>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-alt" style="color: white"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Yearly Sales -->
                        <div class="col-lg-4 col-12">
                            <div class="small-box bg-warning shadow rounded">
                                <div class="inner">
                                    <p>Yearly Sales</p>
                                    <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                                        data-target="#yearlySalesModal">
                                        View
                                    </button>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar" style="color: white"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Graph -->
                    <div class="card mt-4">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Sales Graph (Without VAT)</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="dailySalesModal" tabindex="-1" role="dialog"
                aria-labelledby="dailySalesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="dailySalesModalLabel">Daily Sales Breakdown</h5>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>With VAT</th>
                                        <th>VAT Only</th>
                                        <th>Without VAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Cash Sales</td>
                                        <td><?php echo e(number_format($dailyCash, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($dailyCashVat, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($dailyCash - $dailyCashVat, 2)); ?> birr</td>
                                    </tr>
                                    <tr>
                                        <td>Credit Sales</td>
                                        <td><?php echo e(number_format($dailyCredit, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($dailyCreditVat, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($dailyCredit - $dailyCreditVat, 2)); ?> birr</td>
                                    </tr>
                                    <tr class="table-success font-weight-bold">
                                        <td>Total</td>
                                        <td><?php echo e(number_format($dailyCash + $dailyCredit, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($dailyCashVat + $dailyCreditVat, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($dailyWithoutVat, 2)); ?> birr</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="monthlySalesModal" tabindex="-1" role="dialog"
                aria-labelledby="monthlySalesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="monthlySalesModalLabel">Monthly Sales Breakdown</h5>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>With VAT</th>
                                        <th>VAT Only</th>
                                        <th>Without VAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Cash Sales</td>
                                        <td><?php echo e(number_format($monthlyCash, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($monthlyCashVat, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($monthlyCash - $monthlyCashVat, 2)); ?> birr</td>
                                    </tr>
                                    <tr>
                                        <td>Credit Sales</td>
                                        <td><?php echo e(number_format($monthlyCredit, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($monthlyCreditVat, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($monthlyCredit - $monthlyCreditVat, 2)); ?> birr</td>
                                    </tr>
                                    <tr class="table-primary font-weight-bold">
                                        <td>Total</td>
                                        <td><?php echo e(number_format($monthlyCash + $monthlyCredit, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($monthlyCashVat + $monthlyCreditVat, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($monthlyWithoutVat, 2)); ?> birr</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="yearlySalesModal" tabindex="-1" role="dialog"
                aria-labelledby="yearlySalesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title" id="yearlySalesModalLabel">Yearly Sales Breakdown</h5>
                            <button type="button" class="close text-dark"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>With VAT</th>
                                        <th>VAT Only</th>
                                        <th>Without VAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Cash Sales</td>
                                        <td><?php echo e(number_format($yearlyCash, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($yearlyCashVat, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($yearlyCash - $yearlyCashVat, 2)); ?> birr</td>
                                    </tr>
                                    <tr>
                                        <td>Credit Sales</td>
                                        <td><?php echo e(number_format($yearlyCredit, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($yearlyCreditVat, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($yearlyCredit - $yearlyCreditVat, 2)); ?> birr</td>
                                    </tr>
                                    <tr class="table-warning font-weight-bold">
                                        <td>Total</td>
                                        <td><?php echo e(number_format($yearlyCash + $yearlyCredit, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($yearlyCashVat + $yearlyCreditVat, 2)); ?> birr</td>
                                        <td><?php echo e(number_format($yearlyWithoutVat, 2)); ?> birr</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    <?php else: ?>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <!-- AREA CHART -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Monthly Sales and Purchase</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-primary" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">Users</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="areaChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- DONUT CHART -->
                        <div class="card card-success" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">Payment</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="donutChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- PIE CHART -->
                        <div class="card card-danger" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">Pie Chart</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="pieChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col (LEFT) -->
                    <div class="col-md-6">
                        <!-- LINE CHART -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Payments</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="lineChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- BAR CHART -->

                        <!-- /.card -->

                        <!-- STACKED BAR CHART -->
                        <div class="card card-success" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">Stacked Bar Chart</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="stackedBarChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col (RIGHT) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- jQuery -->
        <!-- Page specific script -->
        <script>
            $(function() {
                /* ChartJS
                 * -------
                 * Here we will create a few charts using ChartJS
                 */

                //--------------
                //- AREA CHART -
                //--------------

                // Get context with jQuery - using jQuery's .get() method.
                var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

                var areaChartData = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                            label: 'Purchase',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: [28, 48, 40, 19, 86, 27, 90]
                        },
                        {
                            label: 'Sales',
                            backgroundColor: 'rgba(210, 214, 222, 1)',
                            borderColor: 'rgba(210, 214, 222, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(210, 214, 222, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data: [65, 59, 80, 81, 56, 55, 40]
                        },
                    ]
                }

                var areaChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }]
                    }
                }

                // This will get the first returned node in the jQuery collection.
                new Chart(areaChartCanvas, {
                    type: 'line',
                    data: areaChartData,
                    options: areaChartOptions
                })

                //-------------
                //- LINE CHART -
                //--------------
                var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
                var lineChartOptions = $.extend(true, {}, areaChartOptions)
                var lineChartData = $.extend(true, {}, areaChartData)
                lineChartData.datasets[0].fill = false;
                lineChartData.datasets[1].fill = false;
                lineChartOptions.datasetFill = false

                var lineChart = new Chart(lineChartCanvas, {
                    type: 'line',
                    data: lineChartData,
                    options: lineChartOptions
                })

                //-------------
                //- DONUT CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
                var donutData = {
                    labels: [
                        'Chrome',
                        'IE',
                        'FireFox',
                        'Safari',
                        'Opera',
                        'Navigator',
                    ],
                    datasets: [{
                        data: [700, 500, 400, 600, 300, 100],
                        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                    }]
                }
                var donutOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                }
                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
                new Chart(donutChartCanvas, {
                    type: 'doughnut',
                    data: donutData,
                    options: donutOptions
                })

                //-------------
                //- PIE CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                var pieData = donutData;
                var pieOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                }
                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
                new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                })

                //-------------
                //- BAR CHART -
                //-------------
                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                var barChartData = $.extend(true, {}, areaChartData)
                var temp0 = areaChartData.datasets[0]
                var temp1 = areaChartData.datasets[1]
                barChartData.datasets[0] = temp1
                barChartData.datasets[1] = temp0

                var barChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false
                }

                new Chart(barChartCanvas, {
                    type: 'bar',
                    data: barChartData,
                    options: barChartOptions
                })

                //---------------------
                //- STACKED BAR CHART -
                //---------------------
                var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
                var stackedBarChartData = $.extend(true, {}, barChartData)

                var stackedBarChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }

                new Chart(stackedBarChartCanvas, {
                    type: 'bar',
                    data: stackedBarChartData,
                    options: stackedBarChartOptions
                })
            })
        </script>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');

        const weeklyLabels = <?php echo json_encode(array_keys($weeklySalesData), 15, 512) ?>;
        const weeklyData = <?php echo json_encode(array_values($weeklySalesData), 15, 512) ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Sales (Without VAT)',
                    data: weeklyData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString() + " birr";
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + " birr";
                            }
                        }
                    }
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ims_webims/amarImsfinal/resources/views/pages/index.blade.php ENDPATH**/ ?>