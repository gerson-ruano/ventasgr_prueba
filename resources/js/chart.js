import Chart from 'chart.js/auto';

// Configuración común para todas las gráficas
const commonChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top',
        }
    }
};

// Colores predefinidos para uso consistente
const chartColors = {
    primary: 'rgb(45, 76, 110)',
    secondary: 'rgb(255, 99, 132)',
    success: 'rgb(75, 192, 192)',
    warning: 'rgb(255, 205, 86)',
    info: 'rgb(54, 162, 235)',
    gray: 'rgb(201, 203, 207)',
    blue: 'blue',
    green: 'green',
    red: 'red'
};

// Función para obtener datos del DOM de forma segura
const getSafeJsonData = (elementId, attribute = 'textContent') => {
    const element = document.getElementById(elementId);
    if (!element) return null;
    try {
        return JSON.parse(attribute === 'textContent' ?
            element.textContent :
            element.getAttribute(attribute));
    } catch (e) {
        console.error(`Error parsing data for ${elementId}:`, e);
        return null;
    }
};

// Función para calcular línea de tendencia
const calculateTrendline = (x, y) => {
    const n = x.length;
    const xySum = x.reduce((sum, xi, i) => sum + xi * y[i], 0);
    const xSum = x.reduce((sum, xi) => sum + xi, 0);
    const ySum = y.reduce((sum, yi) => sum + yi, 0);
    const xxSum = x.reduce((sum, xi) => sum + xi * xi, 0);

    const m = (n * xySum - xSum * ySum) / (n * xxSum - xSum * xSum);
    const b = (ySum - m * xSum) / n;

    return x.map(xi => m * xi + b);
};

// Función para generar colores aleatorios
const getRandomColor = () => {
    const letters = '0123456789ABCDEF';
    return '#' + Array(6).fill(0).map(() => letters[Math.floor(Math.random() * 16)]).join('');
};

// Función para crear una gráfica
const createChart = (canvasId, config) => {
    const ctx = document.getElementById(canvasId)?.getContext('2d');
    if (!ctx) return null;
    return new Chart(ctx, {
        ...config,
        options: { ...commonChartOptions, ...config.options }
    });
};

// Configuraciones de todas las gráficas
const chartConfigs = {
    // 1. Gráfica de últimos días y ventas
    ultimosDias: {
        requiredData: ['daysOfWeek', 'salesData'],
        create: (data) => ({
            type: 'bar',
            data: {
                labels: data.daysOfWeek,
                datasets: [
                    {
                        label: 'No. de Ventas',
                        data: data.salesData,
                        backgroundColor: chartColors.primary
                    },
                    {
                        label: 'Línea de Tendencia',
                        data: calculateTrendline(
                            Array.from({ length: data.daysOfWeek.length }, (_, i) => i),
                            data.salesData
                        ),
                        type: 'line',
                        borderColor: chartColors.secondary,
                        fill: false
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'ÚLTIMOS DIAS / VENTAS'
                    }
                }
            }
        })
    },

    // 2. Gráfica de stock y ventas
    stock: {
        requiredData: ['datosDeVentas', 'productosConMenosExistencias'],
        create: (data) => ({
            type: 'bar',
            data: {
                labels: data.productosConMenosExistencias.map(p => p.name),
                datasets: [
                    {
                        label: 'Ventas',
                        data: data.datosDeVentas.map(v => v.total_quantity),
                        backgroundColor: chartColors.info
                    },
                    {
                        label: 'Existencias',
                        data: data.productosConMenosExistencias.map(p => p.stock),
                        backgroundColor: chartColors.secondary
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'PRODUCTOS CON STOCK MINIMO'
                    }
                }
            }
        })
    },

    // 3. Gráfica de productos más vendidos
    productTop: {
        requiredData: ['productData'],
        create: (data) => ({
            type: 'pie',
            data: {
                labels: data.productData.map(item => item.name),
                datasets: [{
                    data: data.productData.map(item => item.total_quantity),
                    backgroundColor: [
                        chartColors.secondary,
                        chartColors.success,
                        chartColors.warning,
                        chartColors.gray,
                        chartColors.info
                    ]
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'PRODUCTOS MAS VENDIDOS'
                    }
                }
            }
        })
    },

    // 4. Gráfica de reporte estadístico
    report: {
        requiredData: ['totalMoney', 'totalStock', 'totalSales'],
        create: (data) => ({
            type: 'doughnut',
            data: {
                labels: ['CAJA TOTAL', 'PRODUCTOS EXISTENTES', 'VENTAS TOTALES'],
                datasets: [{
                    data: [
                        Array.isArray(data.totalMoney) ?
                            data.totalMoney.reduce((a, b) => Number(a) + Number(b), 0) :
                            Number(data.totalMoney),
                        data.totalStock,
                        data.totalSales
                    ],
                    backgroundColor: [chartColors.blue, chartColors.green, chartColors.red]
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'REPORTE ESTADISTICO GENERAL'
                    }
                }
            }
        })
    },

    // 5. Gráfica de top usuarios
    topUsers: {
        requiredData: ['userNames', 'salesCounts'],
        create: (data) => ({
            type: 'bar',
            data: {
                labels: data.userNames,
                datasets: [{
                    label: 'No. de Ventas',
                    data: data.salesCounts,
                    backgroundColor: chartColors.primary
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'VENTAS POR USUARIO'
                    }
                }
            }
        })
    },

    // 6. Gráfica de ingresos monetarios
    ingresos: {
        requiredData: ['totalMoney'],
        create: (data) => ({
            type: 'doughnut',
            data: {
                labels: ['ACTIVO', 'PENDIENTE DE PAGAR', 'ANULADOS'],
                datasets: [{
                    data: data.totalMoney,
                    backgroundColor: [chartColors.green, chartColors.blue, chartColors.gray]
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'REPORTE MONETARIOS ACTIVO/PASIVO'
                    }
                }
            }
        })
    },

    // 7. Gráfica de tendencia anual
    tendenciaAnual: {
        requiredData: ['salesMonths'],
        create: (data) => {
            const months = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];

            const datasets = Object.entries(data.salesMonths).map(([year, yearData]) => {
                const sales = Array(12).fill(0);
                yearData.forEach(data => {
                    sales[data.month - 1] = data.sales;
                });

                return {
                    label: `Ventas ${year}`,
                    data: sales,
                    fill: false,
                    borderColor: getRandomColor(),
                    tension: 0.1
                };
            });

            return {
                type: 'line',
                data: {
                    labels: months,
                    datasets
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'LINEA DE TENDENCIA AÑO / MES'
                        }
                    }
                }
            };
        }
    },

    // 8. Gráfica de estado de pago
    tipoPago: {
        requiredData: ['datosVentasPorTipoPago'],
        create: (data) => ({
            type: 'bar',
            data: {
                labels: data.datosVentasPorTipoPago.map(venta => venta.status),
                datasets: [{
                    label: 'Numero de Ventas',
                    data: data.datosVentasPorTipoPago.map(venta => venta.total_ventas),
                    backgroundColor: [
                        chartColors.success,
                        chartColors.secondary,
                        chartColors.gray,
                        chartColors.warning,
                        chartColors.gray,
                        chartColors.info
                    ]
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'ESTADOS DE PAGO'
                    }
                }
            }
        })
    }
};

// Función para verificar si los datos requeridos están disponibles
const hasRequiredData = (requiredData, data) => {
    return requiredData.every(key => {
        const value = data[key];
        return value !== null &&
            value !== undefined &&
            (!Array.isArray(value) || value.length > 0);
    });
};

// Función principal para inicializar todas las gráficas
const initializeCharts = () => {
    // Obtener todos los datos necesarios
    const chartData = {
        daysOfWeek: getSafeJsonData('daysOfWeek'),
        salesData: getSafeJsonData('salesData'),
        datosDeVentas: getSafeJsonData('datosDeVentas'),
        productosConMenosExistencias: getSafeJsonData('productosConMenosExistencias'),
        productData: getSafeJsonData('productData'),
        totalStock: getSafeJsonData('totalStock'),
        totalSales: getSafeJsonData('totalSales'),
        totalMoney: getSafeJsonData('totalMoney'),
        userNames: getSafeJsonData('top-user-data', 'data-user-names'),
        salesCounts: getSafeJsonData('top-user-data', 'data-sales-counts'),
        salesMonths: getSafeJsonData('salesMonths'),
        datosVentasPorTipoPago: getSafeJsonData('ventasTipoPago')
    };

    // Crear cada gráfica solo si los datos necesarios están disponibles
    Object.entries(chartConfigs).forEach(([key, { requiredData, create }]) => {
        const chartId = `chart${key.charAt(0).toUpperCase() + key.slice(1)}`;
        if (hasRequiredData(requiredData, chartData)) {
            createChart(chartId, create(chartData));
        }
    });
};

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initializeCharts);



