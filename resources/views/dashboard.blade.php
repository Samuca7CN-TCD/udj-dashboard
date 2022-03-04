<x-app-layout>
    <x-slot name="title">Dashboard UDJ</x-slot>
    <div class="row">
        <h3 class="h3 center-align">Dashboard Finaceiro</h3>
    </div>
    <div class="row">
        <div class="col s12 m6 l4">
            <div id="day-area-card" class="card hoverable">
                <div class="card-content pb-0">
                    <x-form-planos id="form-day-plain" name="plano-dia"></x-form-planos>
                    <p>Hoje</p>
                    <span id="total-dia" class="card-title"></span>
                    <p id="percentual-dia" class="tooltipped" data-position="bottom" data-tooltip="">
                        <span class="preloader"><x-preloader></x-preloader></span>
                    </p>
                </div>
                <div class="card-content p-0">
                    <canvas id="areaChartDays" class="area-graph"></canvas>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l4">
            <div id="month-area-card" class="card hoverable">
                <div class="card-content pb-0">
                    <x-form-planos id="form-month-plain" name="plano-mes"></x-form-planos>
                    <p>Este Mês</p>
                    <span id="total-mes" class="card-title"></span>
                    <p id="percentual-mes" class="tooltipped" data-position="bottom" data-tooltip="">
                        <span class="preloader"><x-preloader color="amber"></x-preloader></span>
                    </p>
                </div>
                <div class="card-content p-0">
                    <canvas id="areaChartMonths" class="area-graph"></canvas>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l4">
            <div id="year-area-card" class="card hoverable">
                <div class="card-content pb-0">
                    <x-form-planos id="form-year-plain" name="plano-ano"></x-form-planos>
                    <p>Este Ano</p>
                    <span id="total-ano" class="card-title"></span>
                    <p id="percentual-ano" class="tooltipped" data-position="bottom" data-tooltip="">
                        <span class="preloader"><x-preloader color="pink"></x-preloader></span>
                    </p>
                </div>
                <div class="card-content p-0">
                    <canvas class="area-graph med-height" id="areaChartYears"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div id="vs-meses" class="card hoverable">
                <div class="card-content">
                    <span class="card-title">Mês atual X Mês anterior</span>
                </div>
                <span class="preloader"><x-linear-preloader color="orange"></x-linear-preloader></span>
                <div class="card-content">
                    <canvas class="line-graph" id="lineChartMonths"></canvas>
                </div>
                <div class="card-content recorrente_mensal">
                    <span id="recorrente-mensal" class="card-title">
                        <span class="preloader"><x-linear-preloader color="amber accent-3"></x-linear-preloader></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 l4">
            <div class="card hoverable">
                <div class="card-content same-height">
                    <p>Taxa de cancelados dos planos mensais</p>
                    <span class="card-title">Churn</span>
                    <h5 id="churn-value">0.0%</h5>
                    <p>Selecione o mês que deseja analisar</p>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="churn-dataM" type="text" class="datepicker month-date churn-datepicker" />
                            <label for="churn-dataM">Mês</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l4">
            <div class="card hoverable">
                <div class="card-content same-height">
                    <x-form-planos id="form-ltv-plain" name="ltv-plain"></x-form-planos>
                    <span class="card-title">LTV</span>
                    <h5 id="ltv-value">R$ 0,00</h5>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="ltv-dataI" type="text" class="datepicker initial-date ltv-datepicker" />
                            <label for="ltv-dataI">Início</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="ltv-dataF" type="text" class="datepicker final-date ltv-datepicker" />
                            <label for="ltv-dataF">Fim</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col m12 l4">
            <div class="card hoverable">
                <div class="card-content same-height">
                    <x-form-planos id="form-tta-plain" name="tta-plain"></x-form-planos>
                    <span class="card-title">Trial para ativo</span>
                    <h5 class="h5" id="tta-value">0 pessoas</h5>
                    <span id="tta-perspective" class="grey-text">de 0 pessoas</span>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="tta-dataI" type="text" class="datepicker initial-date tta-datepicker" />
                            <label for="tta-dataI">Início</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="tta-dataF" type="text" class="datepicker final-date tta-datepicker" />
                            <label for="tta-dataF">Fim</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="col s12 m6">
            <div class="card hoverable">
                <div class="card-content">
                    <p>Índice de abandono</p>
                    <span class="card-title">Cálculo</span>
                    <h5 id="ltv-value">0 pessoas</h5>
                </div>
                <div class="row card-content">
                    <div class="input-field col s12 m6">
                        <input id="calc-dataI" type="text" class="datepicker initial-date calc-datepicker" />
                        <label for="calc-dataI">Início</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="calc-dataF" type="text" class="datepicker final-date calc-datepicker" />
                        <label for="calc-dataF">Fim</label>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    <div class="row">
        <div class="col s12 m6">
            <div class="card status-card hoverable">
                <div class="card-content pb-0">
                    <x-form-planos id="form-status-plain" name="status-plain"></x-form-planos>
                    <span class="card-title">Status</span>
                </div>
                <div class="row card-content no-data d-none">
                    <div>Não há dados para o período selecionado</div>
                </div>
                <div class="card-content status-chart p-0">
                    <canvas class="pie-graph" id="pieChartAll"></canvas>
                </div>
                <div class="row card-content">
                    <div class="input-field col s12 m6">
                        <input id="status-dataI" type="text" class="datepicker initial-date status-datepicker" />
                        <label for="status-dataI">Início</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="status-dataF" type="text" class="datepicker final-date status-datepicker" />
                        <label for="status-dataF">Fim</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card mpagamento-card hoverable">
                <div class="card-content pb-0">
                    <x-form-planos id="form-mpagamento-plain" name="mpagamento-plain"></x-form-planos>
                    <span class="card-title">Métodos de pagamento</span>
                </div>
                <div class="row card-content no-data d-none">
                    <div>Não há dados para o período selecionado</div>
                </div>
                <div class="card-content mpagamento-chart p-0">
                    <canvas class="doughnut-graph" id="doughnutChartAll"></canvas>
                </div>
                <div class="row card-content">
                    <div class="input-field col s12 m6">
                        <input id="mpagamento-dataI" type="text" class="datepicker initial-date mpagamento-datepicker" />
                        <label for="mpagamento-dataI">Início</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="mpagamento-dataF" type="text" class="datepicker final-date mpagamento-datepicker" />
                        <label for="mpagamento-dataF">Fim</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('javascript')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/charts/area-chart-days.js') }}"></script>
    <script src="{{ asset('js/charts/area-chart-months.js') }}"></script>
    <script src="{{ asset('js/charts/area-chart-years.js') }}"></script>
    <script src="{{ asset('js/charts/line-chart-months.js') }}"></script>
    <script src="{{ asset('js/charts/pie-chart-all.js') }}"></script>
    <script src="{{ asset('js/charts/doughnut-chart-all.js') }}"></script>
@endsection
</x-app-layout>



