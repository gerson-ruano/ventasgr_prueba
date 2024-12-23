<script>
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

    // Colores predefinidos para uso consistente
    const chartColors = {
        primary: 'rgb(45, 76, 110)',
        secondary: 'rgb(255, 99, 132)',
        success: 'rgb(75, 192, 192)',
        warning: 'rgb(255, 205, 86)',
        info: 'rgb(54, 162, 235)',
        gray: 'rgb(201, 203, 207)'
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

    // Objeto con configuraciones de gráficas individuales
    const chartConfigs = {
        ultimosDias: (data) => ({
            type: 'bar',
            data: {
                labels: data.daysOfWeek,
                datasets: [
                    {
                        label: 'Ventas del día',
                        data: data.salesData,
                        backgroundColor: chartColors.primary
                    },
                    {
                        label: 'Línea de Tendencia',
                        data: calculateTrendline(data.daysOfWeek, data.salesData),
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
        }),

        stock: (data) => ({
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
        }),

        // ... (configuraciones similares para las demás gráficas)
    };

    // Función principal para inicializar todas las gráficas
    const initializeCharts = () => {
        // Obtener todos los datos necesarios
        const chartData = {
            daysOfWeek: getSafeJsonData('daysOfWeek'),
            salesData: getSafeJsonData('salesData'),
            datosDeVentas: getSafeJsonData('datosDeVentas'),
            productosConMenosExistencias: getSafeJsonData('productosConMenosExistencias'),
            // ... (obtener resto de datos)
        };

        // Crear cada gráfica solo si los datos necesarios están disponibles
        if (chartData.daysOfWeek && chartData.salesData) {
            createChart('chartUltimosDias', chartConfigs.ultimosDias(chartData));
        }

        if (chartData.datosDeVentas && chartData.productosConMenosExistencias) {
            createChart('chartStock', chartConfigs.stock(chartData));
        }

        // ... (crear resto de gráficas)
    };

    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', initializeCharts);
</script>
