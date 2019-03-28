var titulo_multas = '';
var subtitulo_multas = 'Multas Cobradas';
var subY_multas = 'Multados/Cobrados';

function _dataMultas(data)
{

        return [
                        {
                                name: 'Multado',
                                data: data.multados,
                                color: '#c4392d',
                        }, 
                        {
                                name: 'Cobrado',
                                data: data.cobrados,
                                color: '#42DA24',
                        }
                ];
}

function _crearGraficoMultas(data)
{
        Highcharts.chart('grafico_multas', {
                chart     : _confiGrafico('areaspline'),
                title     : _confiTitulo(titulo_multas),
                subtitle  : _confiSubTitulo(subtitulo_multas),
                tooltip   : _confiTooltip(),
                legend    : _confiLegend('#E0EF2C'),
                series    : _dataMultas(data),
                xAxis     : {categories: data.moviles},
                yAxis     : _confiEjeY(subY_multas),
                plotOptions: _confiPlot(),
                responsive: _confiResponsive(),
                credits: {
                        enabled: false
                }
        });
}