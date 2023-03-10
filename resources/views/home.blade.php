@extends('layouts.app', ['menuItems' => $menuItems])

@section('title', 'Dashboard')

@section('content')
    <div class="">
        <div class="row">
            <a class="col-xl-3 col-md-6 mb-4" href="{{route("customers.index")}}" style="text-decoration: none;">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Earnings (Monthly)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{number_format($result->totalAmountMonth)}}
                                    / {{number_format($result->totalAmountMonthAll)}}
                                </div>
                                <div class="h5 mb-0 text-primary text-xs">{{number_format($result->countMonth) }}
                                    / {{number_format($result->countMonthAll) }}
                                    <span class="text-primary text-left text-xs">Transactions</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a class="col-xl-3 col-md-6 mb-4" href="{{route("customers.index")}}" style="text-decoration: none;">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Earnings (Summary)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{number_format($result->totalAmount)}} / {{number_format($result->totalAmountAll)}}
                                </div>
                                <div class="h5 mb-0 text-primary text-xs">{{number_format($result->count) }}
                                    / {{number_format($result->countAll) }}
                                    <span class="text-primary text-left text-xs">Transactions</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a class="col-xl-3 col-md-6 mb-4" href="{{route("customers.index")}}" style="text-decoration: none;">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Rewards (Monthly)
                                </div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($result->reward)}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a class="col-xl-3 col-md-6 mb-4" href="{{route("customers.index")}}" style="text-decoration: none;">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Customers
                                </div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($result->customers)}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                        <div class="dropdown no-arrow">
                            <span>2023</span>
                            {{--                            <select id="yearEarn" name="yearEarn">--}}
                            {{--                                @for($year=date('Y'); $year>=2020; $year--)--}}
                            {{--                                    <option value="{{$year}}">{{$year}}</option>--}}
                            {{--                                @endfor--}}
                            {{--                            </select>--}}
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Leaderboard</h6>
                        <div class="dropdown no-arrow">
                            <span>2023</span>
                            {{--                            <select id="yearLeaderboard" name="yearLeaderboard">--}}
                            {{--                                @for($year=date('Y'); $year>=2020; $year--)--}}
                            {{--                                    <option value="{{$year}}">{{$year}}</option>--}}
                            {{--                                @endfor--}}
                            {{--                            </select>--}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <div class="table-responsive ">
                                <table class="table table-borderless" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center">Position</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Earning</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($result->leaderboard as $key => $leaderboard)
                                        <tr style="{{$key == 0 ? 'background-color: #FAFAD2' : ''}}">
                                            @if($key == 0)
                                                <th scope="row" style="text-align: center">
                                                    <span class="fas fa-star" style="color: #FFD700">{{$key + 1}}</span>
                                                </th>
                                            @else
                                                <th scope="row" style="text-align: center">
                                                    <span>{{$key+1}}</span>
                                                </th>
                                            @endif
                                            <td>{{$leaderboard->name}}</td>
                                            <td>{{number_format($leaderboard->total_amount)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ url('/') }}/js/utils.js"></script>
    <script>

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        const labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        const depositResult = {{ Js::from($result->deposit) }};

        const withdrawalResult = {{ Js::from($result->withdrawal) }};

        const depositAllResult = {{ Js::from($result->depositAll) }};

        const withdrawalAllResult = {{ Js::from($result->withdrawalAll) }};

        const listDeposit = [];
        for (const label in labels) {
            let data = {x: labels[label]}
            if (label <= new Date().getMonth()) {
                for (const key in depositResult) {
                    if (parseInt(depositResult[key].month) === (parseInt(label) + 1)) {
                        data.y = depositResult[key].total_amount;
                        break
                    }
                }
                if (!data.y) {
                    data.y = 0;
                }
            }
            listDeposit.push(data);
        }

        const listWithdrawal = [];
        for (const label in labels) {
            let data = {x: labels[label]}
            if (label <= new Date().getMonth()) {
                for (const key in withdrawalResult) {
                    if (parseInt(withdrawalResult[key].month) === (parseInt(label) + 1)) {
                        data.y = Math.abs(withdrawalResult[key].total_amount);
                        break;
                    }
                }
                if (!data.y) {
                    data.y = 0;
                }
            }
            listWithdrawal.push(data);
        }

        const listDepositAll = [];
        for (const label in labels) {
            let data = {x: labels[label]}
            if (label <= new Date().getMonth()) {
                for (const key in depositAllResult) {
                    if (parseInt(depositAllResult[key].month) === (parseInt(label) + 1)) {
                        data.y = depositAllResult[key].total_amount;
                        break
                    }
                }
                if (!data.y) {
                    data.y = 0;
                }
            }
            listDepositAll.push(data);
        }

        const listWithdrawalAll = [];
        for (const label in labels) {
            let data = {x: labels[label]}
            if (label <= new Date().getMonth()) {
                for (const key in withdrawalAllResult) {
                    if (parseInt(withdrawalAllResult[key].month) === (parseInt(label) + 1)) {
                        data.y = Math.abs(withdrawalAllResult[key].total_amount);
                        break;
                    }
                }
                if (!data.y) {
                    data.y = 0;
                }
            }
            listWithdrawalAll.push(data);
        }

        const ctxArea = document.getElementById("myAreaChart");
        const myLineChart = new Chart(ctxArea, {
            type: 'line',
            data: {
                // labels: labels,
                datasets: [
                    {
                        label: "Deposit Team",
                        lineTension: 0.3,
                        backgroundColor: "rgb(6,72,239)",
                        borderColor: "rgb(6,72,239)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgb(6,72,239)",
                        pointBorderColor: "rgb(6,72,239)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgb(6,72,239)",
                        pointHoverBorderColor: "rgb(6,72,239)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: listDepositAll,
                    },
                    {
                        label: "Withdrawal Team",
                        lineTension: 0.3,
                        backgroundColor: "rgb(250,116,6)",
                        borderColor: "rgb(250,116,6)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgb(250,116,6)",
                        pointBorderColor: "rgb(250,116,6)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgb(250,116,6)",
                        pointHoverBorderColor: "rgb(250,116,6)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: listWithdrawalAll,
                    },
                    {
                        label: "Deposit",
                        lineTension: 0.3,
                        backgroundColor: "rgb(84,239,6)",
                        borderColor: "rgb(84,239,6)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgb(84,239,6)",
                        pointBorderColor: "rgb(84,239,6)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgb(84,239,6)",
                        pointHoverBorderColor: "rgb(84,239,6)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: listDeposit,
                    },
                    {
                        label: "Withdrawal",
                        lineTension: 0.3,
                        backgroundColor: "rgb(241,29,47)",
                        borderColor: "rgb(241,29,47,1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(241,29,47, 1)",
                        pointBorderColor: "rgba(241,29,47, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(241,29,47, 1)",
                        pointHoverBorderColor: "rgba(241,29,47, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: listWithdrawal,
                    }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                                return '$' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });

    </script>
@endsection
