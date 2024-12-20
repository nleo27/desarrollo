@extends('adminlte::page')
<style>
    .badge-indicator {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 5px 10px;
    font-size: 14px;
}
</style>

@section('title', 'Dashboard')

@section('content_header')

    <div class="row">

        <div class="col-lg-3 col-6">
        
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>
                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
        
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-area"></i>
                </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $numeroCartas }}</h3>
                    <p>Cartas Recibidas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope-open-text"></i>
                    <!-- Indicador de carta nueva (muestra el número si hay cartas nuevas) -->
                    @if ($cartasNuevas > 0)
                        <span class="badge badge-danger badge-indicator">{{ str_pad($cartasNuevas, 2, '0', STR_PAD_LEFT) }}</span>
                    @endif
                </div>
                <a href="#" class="small-box-footer">Ver Cartas Recibidas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
        
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>
                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="fas fa-upload"></i>
                </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
    </div>

@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Gráfico de Áreas</h3>
    </div>
    <div class="card-body">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
</div>
@endsection



@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    });
</script>
@stop