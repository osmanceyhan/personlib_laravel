@extends('admin.layouts.master')
@section('title') @lang('translation.Dashboard') @endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('admin.common-components.breadcrumb')
@slot('pagetitle') Tanımlar @endslot
@slot('title') Tanımlar @endslot
@endcomponent


<div class="row-container">
    <div class="row">
        @foreach($definations as $result)
            <div class="col-md-6 col-xl-3" sortable-card>
                <div class="card card_gradient card_stats" style="height:calc(100% - 1.25rem);">
                    <div class="card-body">
                        <div>
                            <div class="card_header">
                                <p class="text-muted mb-0">{{$result['title']}}</p>
                                <div class="card_stats_dropdown">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 hover:opacity-80">
                                        <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                        <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                        <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                    </svg>
                                </div>
                            </div>
                            <div class="card_value d-flex justify-content-between align-items-center">
                                <h4 class="mb-1 mt-1 "><span data-plugin="counterup">{{$result["count"]}}</span></h4>
                                <a href="{{$result['route']}}" class="btn btn-sm bg-white text-black">İncele</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
        @endforeach
    </div>

</div>

<!-- end row -->

@endsection
@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script>
    $(function() {
        $("[sortable-row-container]").sortable({
            handle: "[sortable-row]",
            items: "[sortable-row]",
            placeholder: "row-placeholder",
            forcePlaceholderSize: true,
            tolerance: "pointer",
            helper: "clone",
            cursor: "move",
            start: function(event, ui) {
                $(this).addClass('dragging');
            },
            stop: function(event, ui) {
                $(this).removeClass('dragging');
            }
        });

        $("[sortable-row]").sortable({
            items: "[sortable-card]",
            connectWith: "[sortable-row]",
            placeholder: "card-placeholder",
            forcePlaceholderSize: true,
            tolerance: "pointer",
            helper: "clone",
            cursor: "move",
            start: function(event, ui) {
                $(this).addClass('dragging');
            },
            stop: function(event, ui) {
                $(this).removeClass('dragging');
            }
        }).disableSelection();

        $("[sortable-row], [sortable-card]").on("sortchange", function(event, ui) {
            ui.item.hide().fadeIn(); // Sürüklenen öğe için bir animasyon ekle
        });
    });
</script>

<script type="text/javascript">

    function dashboardCreatorToggle(){
        $(".dashboardCreator").toggleClass("hidden");
        if(!$(".dashboardCreator").hasClass("hidden")){
            $(".select2").select2();
        }
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    function getChartColorsArray(chartId) {
        if (document.getElementById(chartId) !== null) {
            var colors = document.getElementById(chartId).getAttribute("data-colors");

            if (colors) {
                colors = JSON.parse(colors);
                return colors.map(function (value) {
                    var newValue = value.replace(" ", "");

                    if (newValue.indexOf(",") === -1) {
                        var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                        if (color) return color;else return newValue;
                        ;
                    } else {
                        var val = value.split(',');

                        if (val.length == 2) {
                            var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                            rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                            return rgbaColor;
                        } else {
                            return newValue;
                        }
                    }
                });
            }
        }
    } //


    // CSRF token'ını al
    var csrfToken = '{{ csrf_token() }}';
    // Mock API Endpoint URL
    var apiUrl = '{{route(getRouteWeb('statsApi'))}}';
    var LinechartsalesColors = getChartColorsArray("sales-analytics-chart");

    var apiData = '';
    // AJAX isteği yapalım
    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // CSRF token'ını headers'a ekleyin
        },
        // ... diğer istek ayarları ...
    })
        .then(response => response.json())
        .then(data => {
            // Verileri işleyelim ve chart'a entegre edelim
            processAndRenderChart(data);
            apiData = data;
        })
        .catch(error => console.error('API Hatası:', error));

    function processAndRenderChart(data) {
        // Chart konfigürasyonunu oluştur
        var options = {
            chart: {
                height: 343,
                type: 'line',
                stacked: false,
                toolbar: {
                    show: false
                }
            },
            stroke: {
                width: [0, 2, 4],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '30%'
                }
            },
            colors: LinechartsalesColors,
            series: data.reservation_locations.series,
            fill: {
                opacity: [0.85, 0.25, 1],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: data.reservation_locations.labels,
            markers: {
                size: 0
            },
            xaxis: {
                type: 'datetime'
            },
            yaxis: {
                title: {
                    text: 'Points'
                }
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function formatter(y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " points";
                        }

                        return y;
                    }
                }
            },
            grid: {
                borderColor: '#f1f1f1'
            }
        };

        // Chart'ı render et
        var chart = new ApexCharts(document.querySelector("#sales-analytics-chart"), options);
        chart.render();
    }
</script>



@endsection
