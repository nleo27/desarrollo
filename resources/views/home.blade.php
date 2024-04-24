@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title">Áreas Registradas</h5>
                <p class="card-text">No tienes datos registrados en las areas.</p>
                <a href="" class="btn btn-light">
                    <i class="fas fa-list"></i> Ver Áreas
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Áreas Registradas</h5>
                <p class="card-text">No hay areas registardas.</p>
                <a href="" class="btn btn-light">
                    <i class="fas fa-list"></i> Ver Áreas
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Áreas Registradas</h5>
                <p class="card-text">Tienes mucha informacion registrada</p>
                <a href="" class="btn btn-light">
                    <i class="fas fa-list"></i> Ver Áreas
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Áreas Registradas</h5>
                <p class="card-text">Tienes áreas registradas en tu base de datos.</p>
                <a href="" class="btn btn-light">
                    <i class="fas fa-list"></i> Ver Áreas
                </a>
            </div>
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