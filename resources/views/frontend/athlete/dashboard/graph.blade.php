@extends('frontend.athlete.layouts.app')
@section('title', 'Dashboard')
@section('style')
<style>
    #aci-score{
        padding-right: 5px;
    }
    #myChart {
        width: 100%;
        height: 300px;
    }
    g[aria-labelledby="id-66-title"]{
        display:none !important;
    }
    .dashboard_r_top_l, .dashboard_r_top_r{
        display:none;
    }

    .dashboard_l{
        display:none;
    }


</style>
@endsection
@section('content')
<?php 
use App\Models\CoachInformation;
use App\Models\CoachLevel;


?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-12 col-xs-12">
               
                    <div class="">
                        <div class="dashboard_r_top" style="width:100%;">
                            @if(empty($score_dataset))
                            <img src="{{ asset('public/frontend/images/no-grap.png') }}" alt="graph_img" />
                            @else
                            <div id="myChart" width="100%" height="500"></div>
                            @endif
                        </div>
                    </div>
                    
                

            </div>
            
        </div>
    </div>


@endsection

@section('script')
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script>
    $(document).ready(function(){
        $('#calculate-aci-score').on('click', function(){
            $.ajax({
            type : "GET",
            url : "{{ url('athlete/aci-index-calculate') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    $('#aci-score').html(res.data.aci_index.toFixed(2));
                    $('#calculate-aci-score').html('Recalculate');
                }else{
                    swal(res.message, 'Warning', 'warning');
                }
            },
            error: function(err){
                console.log(err);
            }
            }).done( () => {
            });
        })
    })

    // calculate-aci-rank

    // $(document).ready(function(){
    //     $('#calculate-aci-rank').on('click', function(){
    //         $.ajax({
    //         type : "GET",
    //         url : "{{ url('athlete/aci-rank-calculate') }}",
    //         data : {},
    //         beforeSend: function(){
    //             //$("#overlay").fadeIn(300);
    //         },
    //         success: function(res){
    //             console.log(res);
    //             if(res.success){
    //                 $('#aci-rank').html(res.data.aci_index.toFixed(2));
    //                 $('#calculate-aci-rank').html('Recalculate');
    //             }else{
    //                 swal(res.message, 'Warning', 'warning');
    //             }
    //         },
    //         error: function(err){
    //             console.log(err);
    //         }
    //         }).done( () => {
    //         });
    //     })
    // })

    /**---Chart.js */
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("myChart", am4charts.XYChart);
        chart.paddingRight = 20;
        // Add data
        chart.data = {!! json_encode($score_dataset) !!};
        
        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "month";
        categoryAxis.renderer.minGridDistance = 50;
        categoryAxis.renderer.grid.template.location = 0.5;
        categoryAxis.startLocation = 0.5;
        categoryAxis.endLocation = 0.5;

        // Create value axis
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.baseValue = 0;

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.categoryX = "month";
        series.strokeWidth = 3;
        series.tensionX = 0.77;
        series.stroke = am4core.color("#4BFF00"); // red
        // bullet is added because we add tooltip to a bullet for it to change color
        var bullet = series.bullets.push(new am4charts.Bullet());
        bullet.tooltipText = "{valueY}";

        bullet.adapter.add("fill", function(fill, target){
            if(target.dataItem.valueY < 0){
                return am4core.color("#FF0000");
            }
            return fill;
        })
        var range = valueAxis.createSeriesRange(series);
        range.value = 0;
        range.endValue = -1000;
        range.contents.stroke = am4core.color("#FF0000");
        range.contents.fill = range.contents.stroke;

        // Add scrollbar
        var scrollbarX = new am4charts.XYChartScrollbar();
        scrollbarX.series.push(series);
        chart.scrollbarX = scrollbarX;

        chart.cursor = new am4charts.XYCursor();

    }); // end am4core.ready()

    

    $('.post-recommendation').on('click', function(){
        let id = $(this).data('id');        
        swal({
            //title: "Are you sure?",
            title: "Are you sure that you want to post this recommendations on your profile",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willPost) => {
            if (willPost) {
                $.ajax({
                    
                    url: "{{ url('athlete/post-recommendation') }}"+"/"+id,
                    
                    type:'get',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {                     
                        swal(data.message, 'success')
                        .then( () => {
                            location.reload();
                        });
                    }
                });
            }else{
                return false;
            }
        });
    });

    $('.dontpost-recommendation').on('click', function(){
        let id = $(this).data('id');        
        swal({
            //title: "Are you sure?",
            title: "Are you sure that you don't want to post this recommendations on your profile",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willPost) => {
            if (willPost) {
                $.ajax({
                    
                    url: "{{ url('athlete/dontpost-recommendation') }}"+"/"+id,
                    
                    type:'get',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {                       
                        swal(data.message, 'success')
                        .then( () => {
                            location.reload();
                        });
                    }
                });
            }else{
                return false;
            }
        });
    });

    

     $('.contactcaochbtn').click(function(){
         $('#recommend-id').val($(this).data('id'));
        
    });

    $('#contactForm').submit(function() {
      if ($.trim($("#replymsg").val()) === "") {
        $('#err_msg').show();
        return false;
    }else{
        $('#err_msg').hide();
    }
});
</script>
@endsection