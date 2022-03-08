<x-app-layout>
    <x-slot name="title">Dashboard UDJ</x-slot>
    <div class="row">
        <h3 class="h3 center-align">Exportar Dados</h3>
    </div>
    <form id="export" class="row" method="get" action="/exportar">
        <div class="input-field col s12 m6">
            <input type="text" name="start" class="datepicker" />
            <label for="data">Início</label>
        </div>
        <div class="input-field col s12 m6">
            <input type="text" name="end" class="datepicker" />
            <label for="data">Fim</label>
        </div>
        <div class="input-field col s12 m6">
            <select name="fonte">
                <option value="eduzz" selected>Eduzz</option>
                <option value="guru">Digital Manager Guru</option>
            </select>
            <label>Selecione a fonte de dados</label>
        </div>
        <div class="input-field col s12 m6">
            <select name="formato">
                <option value="xlsx">XLSX</option>
                <option value="csv" selected>CSV</option>
                <option value="tsv">TSV</option>
                <option value="ods">ODS</option>
                <option value="xls">XLS</option>
                <!--<option value="html">HTML</option>
                <option value="mpdf">MPDF</option>
                <option value="dompdf">DOMPDF</option>
                <option value="tcpdf">TCPDF</option>-->
            </select>
            <label>Selecione o formato de exportação</label>
        </div>
        <div class="row">
            <div class="input-field col s4 m3 l2">
                <p>
                    <label>
                        <input class="with-gap" name="tipo" type="radio" value="transactions" checked />
                        <span>Transações</span>
                    </label>
                </p>
            </div>
            <div class="input-field col s4 m3 l2">
                <p>
                    <label>
                        <input class="with-gap" name="tipo" type="radio" value="subscriptions"/>
                        <span>Assinaturas</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="input-field col s12">
            <button class="btn waves-effect waves-light" type="submit">Exportar
                <i class="material-icons right">send</i>
            </button>
        </div>
    </form>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <p id="last_export" class="text-gray lighten-3">Última exportação: {{ $last_export }}</p>
                </div>
            </div>
        </div>
    </div>
@section('javascript')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
</x-app-layout>



