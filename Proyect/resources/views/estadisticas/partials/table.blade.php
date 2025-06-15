
<!-- Gráfico Donaciones -->
<div class="col-md-6 mb-4">
    <div class="card shadow-sm h-100">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">Tipo de Donaciones</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="text-center p-2 bg-light rounded">
                    <div class="text-primary font-weight-bold">Solidarios</div>
                    <div class="h4">{{ number_format($solidarios) }}</div>
                </div>
                <div class="text-center p-2 bg-light rounded">
                    <div class="text-success font-weight-bold">Voluntarios</div>
                    <div class="h4">{{ number_format($voluntarios) }}</div>
                </div>
            </div>
            <canvas id="donacionTipo" style="max-height: 250px;"></canvas>
        </div>
    </div>
</div>

<!-- Gráfico Agendados -->
<div class="col-md-6 mb-4">
    <div class="card shadow-sm h-100">
        <div class="card-header bg-info text-white text-center">
            <h5 class="mb-0">Agendados</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="text-center p-2 bg-light rounded">
                    <div class="text-info font-weight-bold">Donaciones</div>
                    <div class="h4">{{ number_format($donacionesAgendadas) }}</div>
                </div>
                <div class="text-center p-2 bg-light rounded">
                    <div class="text-warning font-weight-bold">Diferimientos</div>
                    <div class="h4">{{ number_format($diferimientosAgendados) }}</div>
                </div>
                <div class="text-center p-2 bg-light rounded">
                    <div class="text-danger font-weight-bold">No Asistió</div>
                    <div class="h4">{{ number_format($noAsistio) }}</div>
                </div>
            </div>
            <canvas id="agendados" style="max-height: 250px;"></canvas>
        </div>
    </div>
</div>

<!-- Gráfico Diferimientos -->
<div class="col-md-6 offset-md-3 mb-4">
    <div class="card shadow-sm h-100">
        <div class="card-header bg-warning text-dark text-center">
            <h5 class="mb-0">Tipo de Diferimientos</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="text-center p-2 bg-light rounded">
                    <div class="text-secondary font-weight-bold">Temporales</div>
                    <div class="h4">{{ number_format($temporales) }}</div>
                </div>
                <div class="text-center p-2 bg-light rounded">
                    <div class="text-orange font-weight-bold">Permanentes</div>
                    <div class="h4">{{ number_format($permanentes) }}</div>
                </div>
            </div>
            <canvas id="diferimientos" style="max-height: 250px;"></canvas>
        </div>
    </div>
</div>

<style>
    .text-orange {
        color: #fd7e14;
    }
    .h4 {
        font-size: 1.5rem;
        font-weight: 600;
    }
    .bg-light {
        background-color: #f8f9fa!important;
    }
    .rounded {
        border-radius: 0.375rem!important;
    }
</style>


<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico Donaciones
        new Chart(document.getElementById('donacionTipo'), {
            type: 'doughnut',
            data: {
                labels: ['Solidarios', 'Voluntarios'],
                datasets: [{
                    data: [{{ $solidarios }}, {{ $voluntarios }}],
                    backgroundColor: ['#4e73df', '#1cc88a'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.label}: ${context.raw}`
                        }
                    }
                }
            }
        });

        // Gráfico Agendados
        new Chart(document.getElementById('agendados'), {
            type: 'bar',
            data: {
                labels: ['Donaciones', 'Diferimientos', 'No Asistió'],
                datasets: [{
                    label: 'Cantidad',
                    data: [{{ $donacionesAgendadas }}, {{ $diferimientosAgendados }},
                        {{ $noAsistio }}
                    ],
                    backgroundColor: ['#36b9cc', '#f6c23e', '#e74a3b']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Gráfico Diferimientos
        new Chart(document.getElementById('diferimientos'), {
            type: 'pie',
            data: {
                labels: ['Temporales', 'Permanentes'],
                datasets: [{
                    data: [{{ $temporales }}, {{ $permanentes }}],
                    backgroundColor: ['#858796', '#fd7e14']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.label}: ${context.raw}`
                        }
                    }
                }
            }
        });
    });

    function actualizarGraficos(datos) {
        // Destruir gráficos anteriores si existen
        if (graficoDonaciones) graficoDonaciones.destroy();
        if (graficoAgendados) graficoAgendados.destroy();
        if (graficoDiferimientos) graficoDiferimientos.destroy();

        // Redibujar Donaciones - Doughnut
        graficoDonaciones = new Chart(document.getElementById('donacionTipo'), {
            type: 'doughnut',
            data: {
                labels: ['Solidarios', 'Voluntarios'],
                datasets: [{
                    data: [datos.solidarios, datos.voluntarios],
                    backgroundColor: ['#4e73df', '#1cc88a']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.label}: ${context.raw}`
                        }
                    }
                }
            }
        });

        // Redibujar Agendados - Bar
        graficoAgendados = new Chart(document.getElementById('agendados'), {
            type: 'bar',
            data: {
                labels: ['Donaciones', 'Diferimientos', 'No Asistió'],
                datasets: [{
                    label: 'Cantidad',
                    data: [datos.donacionesAgendadas, datos.diferimientosAgendados, datos.noAsistio],
                    backgroundColor: ['#36b9cc', '#f6c23e', '#e74a3b']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Redibujar Diferimientos - Pie
        graficoDiferimientos = new Chart(document.getElementById('diferimientos'), {
            type: 'pie',
            data: {
                labels: ['Temporales', 'Permanentes'],
                datasets: [{
                    data: [datos.temporales, datos.permanentes],
                    backgroundColor: ['#858796', '#fd7e14']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.label}: ${context.raw}`
                        }
                    }
                }
            }
        });
    }
</script>
