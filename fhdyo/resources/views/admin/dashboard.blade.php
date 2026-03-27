@extends('layouts.app')

@section('title', 'Admin Panel - Boshqaruv paneli')

@section('content')
<div class="p-4 lg:p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6 lg:mb-8">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            Boshqaruv paneli
        </h1>
        <p class="text-gray-600 mt-2 text-sm lg:text-base">Nikohga sorovnoma tizim statistikasi va tahlili</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-4 lg:p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs lg:text-sm font-medium">Jami juftliklar</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-2">{{ $totalCouples }}</p>
                    <p class="text-blue-100 text-xs mt-1">Tizimdagi barcha juftliklar</p>
                </div>
                <div class="bg-white/20 rounded-full p-2 lg:p-3">
                    <i class="fas fa-heart text-white text-lg lg:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-4 lg:p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs lg:text-sm font-medium">Jami testlar</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-2">{{ $totalTests }}</p>
                    <p class="text-green-100 text-xs mt-1">Barcha testlar soni</p>
                </div>
                <div class="bg-white/20 rounded-full p-2 lg:p-3">
                    <i class="fas fa-clipboard-list text-white text-lg lg:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-4 lg:p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-xs lg:text-sm font-medium">Tugallangan testlar</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-2">{{ $completedTests }}</p>
                    <p class="text-purple-100 text-xs mt-1">Tugallangan testlar soni</p>
                </div>
                <div class="bg-white/20 rounded-full p-2 lg:p-3">
                    <i class="fas fa-check-circle text-white text-lg lg:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <div class="bg-white rounded-xl shadow-lg p-4 lg:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                <h3 class="text-base lg:text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                    Kunlik
                </h3>
                <div class="flex items-center space-x-2">
                    <input type="date" id="dailyDateFilter" 
                           value="{{ now()->format('Y-m-d') }}"
                           class="text-xs border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-1.5">
                    <button onclick="downloadChart('daily')" class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-lg hover:bg-blue-100 hidden sm:block">
                        <i class="fas fa-download mr-1"></i> Yuklab olish
                    </button>
                </div>
            </div>
            <div class="relative h-48 lg:h-64">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-4 lg:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                <h3 class="text-base lg:text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-calendar-alt mr-2 text-purple-600"></i>
                    Oylik
                </h3>
                <div class="flex items-center space-x-2">
                    <input type="month" id="monthlyDateFilter" 
                           value="{{ now()->format('Y-m') }}"
                           class="text-xs border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 p-1.5">
                    <button onclick="downloadChart('monthly')" class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded-lg hover:bg-purple-100 hidden sm:block">
                        <i class="fas fa-download mr-1"></i> Yuklab olish
                    </button>
                </div>
            </div>
            <div class="relative h-48 lg:h-64">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Additional Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <!-- Section Performance -->
        <div class="bg-white rounded-xl shadow-lg p-4 lg:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                <h3 class="text-base lg:text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-bar mr-2 text-green-600"></i>
                    Bo'limlar bo'yicha natijalar
                </h3>
                <input type="month" id="sectionDateFilter" 
                       value="{{ now()->format('Y-m') }}"
                       class="text-xs border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 p-1.5">
            </div>
            <div class="space-y-3" id="sectionStatsContainer">
                @foreach($sectionStats as $stat)
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs lg:text-sm font-medium text-gray-700 truncate">{{ $stat['title'] }}</span>
                                <span class="text-xs lg:text-sm font-bold text-gray-900">{{ $stat['avg_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full transition-all duration-300"
                                     style="width: {{ $stat['avg_score'] }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Compatibility Distribution -->
        <div class="bg-white rounded-xl shadow-lg p-4 lg:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                <h3 class="text-base lg:text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-pie-chart mr-2 text-orange-600"></i>
                    Moslik darajasi taqsimoti
                </h3>
                <input type="month" id="compatibilityDateFilter" 
                       value="{{ now()->format('Y-m') }}"
                       class="text-xs border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 p-1.5">
            </div>
            <div class="space-y-3" id="compatibilityStatsContainer">
                @php
                    $totalCompatibility = array_sum($compatibilityStats);
                    $compatibilityData = [
                        ['label' => 'Juda yuqori', 'value' => $compatibilityStats['juda_yuqori'], 'color' => 'green'],
                        ['label' => 'Yuqori', 'value' => $compatibilityStats['yuqori'], 'color' => 'blue'],
                        ['label' => 'O\'rtacha', 'value' => $compatibilityStats['o\'rtacha'], 'color' => 'yellow'],
                        ['label' => 'Past', 'value' => $compatibilityStats['past'], 'color' => 'red']
                    ];
                @endphp
                @foreach($compatibilityData as $item)
                    @if($item['value'] > 0)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 rounded-full bg-{{ $item['color'] }}-500"></div>
                                <span class="text-xs lg:text-sm font-medium text-gray-700">{{ $item['label'] }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="text-xs lg:text-sm font-bold text-gray-900">{{ $item['value'] }}</div>
                                <div class="text-xs text-gray-500">({{ $totalCompatibility > 0 ? round(($item['value'] / $totalCompatibility) * 100, 1) : 0 }}%)</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Tests Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 lg:px-6 py-4 border-b border-gray-200">
            <h2 class="text-base lg:text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-clock mr-2 text-gray-600"></i>
                So'nggi testlar
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Test ID</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">JSHSHIR (Siz)</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase hidden sm:table-cell">JSHSHIR (Juft)</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Holat</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase hidden lg:table-cell">Vaqt</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($recentTests as $test)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $test->id }}
                            </td>
                            <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <span class="font-mono text-xs lg:text-sm">{{ $test->couple->jshshir_user }}</span>
                            </td>
                            <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                <span class="font-mono text-xs lg:text-sm">{{ $test->couple->jshshir_spouse }}</span>
                            </td>
                            <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                <span class="px-2 lg:px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $test->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $test->status == 'completed' ? 'Tugallangan' : 'Jarayonda' }}
                                </span>
                            </td>
                            <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                                {{ $test->created_at->format('d.m.Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 lg:px-6 py-12 lg:py-16 text-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-20"></i>
                                <p>Hozircha testlar yo'q</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let dailyChart, monthlyChart;

async function updateChart(type, date, chartObj, canvasId, color) {
    try {
        const response = await fetch(`{{ route('admin.chart.data') }}?type=${type}&date=${date}`);
        const newData = await response.json();
        
        const labels = newData.map(item => {
            if (type === 'daily') {
                return new Date(item.label).toLocaleDateString('uz-UZ', { day: '2-digit', month: '2-digit' });
            } else {
                return item.label;
            }
        });
        const values = newData.map(item => item.count);

        if (chartObj) {
            chartObj.data.labels = labels;
            chartObj.data.datasets[0].data = values;
            chartObj.update();
        } else {
            const ctx = document.getElementById(canvasId).getContext('2d');
            return new Chart(ctx, {
                type: type === 'daily' ? 'line' : 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Testlar soni',
                        data: values,
                        borderColor: color,
                        backgroundColor: type === 'daily' ? color + '30' : color + '60',
                        fill: type === 'daily',
                        tension: 0.3,
                        borderRadius: type === 'daily' ? 0 : 8,
                        borderWidth: 2,
                        pointRadius: type === 'daily' ? 4 : 0,
                        pointBackgroundColor: color,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        barThickness: type === 'daily' ? 0 : 20
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.85)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 13 },
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `Testlar soni: ${context.parsed.y} ta`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { 
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                font: { size: 11 },
                                color: '#6b7280',
                                precision: 0, // Butun sonlar
                                stepSize: 1 // Har bir son
                            }
                        },
                        x: { 
                            grid: { 
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: { size: 10 },
                                color: '#6b7280',
                                maxRotation: 45,
                                minRotation: 0
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animation: {
                        duration: 750,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }
    } catch (error) {
        console.error('Chart data loading error:', error);
    }
}

// Chartni yuklab olish
function downloadChart(type) {
    const canvas = document.getElementById(type + 'Chart');
    const url = canvas.toDataURL('image/png');
    const link = document.createElement('a');
    link.download = `${type}-chart-${new Date().toISOString().split('T')[0]}.png`;
    link.href = url;
    link.click();
}

// Birinchi marta yuklanganda
window.onload = async () => {
    dailyChart = await updateChart('daily', document.getElementById('dailyDateFilter').value, null, 'dailyChart', '#3b82f6');
    monthlyChart = await updateChart('monthly', document.getElementById('monthlyDateFilter').value, null, 'monthlyChart', '#a855f7');
};

// Filtirlar o'zgarganda
document.getElementById('dailyDateFilter').addEventListener('change', async (e) => {
    await updateChart('daily', e.target.value, dailyChart, 'dailyChart', '#3b82f6');
});

document.getElementById('monthlyDateFilter').addEventListener('change', async (e) => {
    await updateChart('monthly', e.target.value, monthlyChart, 'monthlyChart', '#a855f7');
});

// Bo'limlar statistikasi yangilash
document.getElementById('sectionDateFilter').addEventListener('change', async (e) => {
    try {
        const response = await fetch(`{{ route('admin.section.stats') }}?date=${e.target.value}`);
        const data = await response.json();
        
        const container = document.getElementById('sectionStatsContainer');
        container.innerHTML = '';
        
        data.forEach(stat => {
            const html = `
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-700">${stat.title}</span>
                            <span class="text-sm font-bold text-gray-900">${stat.avg_score}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full transition-all duration-300"
                                 style="width: ${stat.avg_score}%"></div>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += html;
        });
    } catch (error) {
        console.error('Section stats loading error:', error);
    }
});

// Moslik darajasi statistikasi yangilash
document.getElementById('compatibilityDateFilter').addEventListener('change', async (e) => {
    try {
        const response = await fetch(`{{ route('admin.compatibility.stats') }}?date=${e.target.value}`);
        const data = await response.json();
        
        const container = document.getElementById('compatibilityStatsContainer');
        container.innerHTML = '';
        
        const totalCompatibility = Object.values(data).reduce((sum, val) => sum + val, 0);
        const compatibilityData = [
            { label: 'Juda yuqori', value: data.juda_yuqori, color: 'green' },
            { label: 'Yuqori', value: data.yuqori, color: 'blue' },
            { label: 'O\'rtacha', value: data['o\'rtacha'], color: 'yellow' },
            { label: 'Past', value: data.past, color: 'red' }
        ];
        
        compatibilityData.forEach(item => {
            if (item.value > 0) {
                const percentage = totalCompatibility > 0 ? Math.round((item.value / totalCompatibility) * 100 * 10) / 10 : 0;
                const html = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-${item.color}-500"></div>
                            <span class="text-sm font-medium text-gray-700">${item.label}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-bold text-gray-900">${item.value}</div>
                            <div class="text-xs text-gray-500">(${percentage}%)</div>
                        </div>
                    </div>
                `;
                container.innerHTML += html;
            }
        });
    } catch (error) {
        console.error('Compatibility stats loading error:', error);
    }
});
</script>
@endsection
