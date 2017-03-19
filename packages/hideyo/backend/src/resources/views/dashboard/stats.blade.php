@extends('admin._layouts.default')

@section('main')



<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li><a href="/admin">Dashboard <span class="sr-only">(current)</span></a></li>
            <li  class="active"><a href="/admin/dashboard/stats"><i class="entypo-folder"></i>Stats</a></li>


        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <ol class="breadcrumb">
            <li><a href=""><i class="entypo-folder"></i>Stats</a></li>
        </ol>
        {!! Notification::showAll() !!}

        <div class="row">
            <div class="col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-heading">Revenue growth month</div>
                    <div class="panel-body stats-revenue-container">


                        <select  data-url="/admin/dashboard/stats/revenue-by-year" class="form-control stats-revenue">


                            @foreach($years as $year)
                            @if($year->year == $selectedYears->year)
                            <option value="{!! $year->year !!}" selected="selected">{!! $year->year !!}</option>
                            @else
                            <option value="{!! $year->year !!}">{!! $year->year !!}</option>
                            @endif
                            @endforeach
                        </select>

                        @if($revenueChart)
                        <div id="perf_div"></div>
                        @columnchart('Finances', 'perf_div')
                        @else
                        <p>geen resultaat</p>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-heading">Revenue a year</div>
                    <div class="panel-body">


                        @if($years)
                        <div id="perf_div4"></div>
                        @columnchart('Years', 'perf_div4')
                        @else
                        <p>geen resultaat</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-heading">Total orders</div>
                    <div class="panel-body stats-totals-container">


                        <select  data-url="/admin/dashboard/stats/totals-by-year" class="form-control stats-totals">


                            @foreach($years as $year)
                            @if($year->year == $selectedYears->year)
                            <option value="{!! $year->year !!}" selected="selected">{!! $year->year !!}</option>
                            @else
                            <option value="{!! $year->year !!}">{!! $year->year !!}</option>
                            @endif
                            @endforeach
                        </select>

                        @if($revenueChartTotal)
                        <div id="perf_div3"></div>
                        @columnchart('totalOrders', 'perf_div3')
                        @else
                        <p>geen resultaat</p>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-heading">Browser information</div>
                    <div class="panel-body stats-browser-container">


                        <select  data-url="/admin/dashboard/stats/browser-by-year" class="form-control stats-browser">


                            @foreach($years as $year)
                            @if($year->year == $selectedYears->year)
                            <option value="{!! $year->year !!}" selected="selected">{!! $year->year !!}</option>
                            @else
                            <option value="{!! $year->year !!}">{!! $year->year !!}</option>
                            @endif
                            @endforeach
                        </select>

                        @if($revenueChartMobile)
                        <div id="perf_div2"></div>
                        @columnchart('BrowserDetect', 'perf_div2')
                        @else
                        <p>geen resultaat</p>
                        @endif
                    </div>
                </div>
            </div>



            <div class="col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-heading">Payment way information</div>
                    <div class="panel-body stats-payment-method-container">


                        <select  data-url="/admin/dashboard/stats/payment-method-by-year" class="form-control stats-payment-method">


                            @foreach($years as $year)
                            @if($year->year == $selectedYears->year)
                            <option value="{!! $year->year !!}" selected="selected">{!! $year->year !!}</option>
                            @else
                            <option value="{!! $year->year !!}">{!! $year->year !!}</option>
                            @endif
                            @endforeach
                        </select>

                        @if($revenueChartPaymentMethod)
                        <div id="perf_div5"></div>
                        @columnchart('PaymentMethodDetect', 'perf_div5')
                        @else
                        <p>geen resultaat</p>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-heading">Average order amount</div>
                    <div class="panel-body stats-average-container">


                        <select  data-url="/admin/dashboard/stats/order-average-by-year" class="form-control stats-average-order">


                            @foreach($years as $year)
                            @if($year->year == $selectedYears->year)
                            <option value="{!! $year->year !!}" selected="selected">{!! $year->year !!}</option>
                            @else
                            <option value="{!! $year->year !!}">{!! $year->year !!}</option>
                            @endif
                            @endforeach
                        </select>

                        @if($revenueAverageChart)
                        <div id="perf_div6"></div>
                        @columnchart('FinancesAverage', 'perf_div6')
                        @else
                        <p>geen resultaat</p>
                        @endif
                    </div>
                </div>
            </div>




        </div>

    </div>




</div>








</div>
@stop