<?php

namespace App\Http\Controllers;

use App\Exports\DigitalManagerGuruTransactionsExport;
use App\Exports\DigitalManagerGuruSubscriptionsExport;
use App\Exports\EduzzTransactionsExport;
use App\Exports\EduzzSubscriptionsExport;
use App\Models\Atualizacao;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(){
        date_default_timezone_set('America/Bahia');
        
    }

    public function index(){
        $atualizacao = Atualizacao::orderBy('id', 'desc')->first();
        //dd($atualizacao);
        if(!isset($atualizacao) || empty($atualizacao)){
            $last_export = 'Nenhuma';
        }else{
            $atualizacao = json_decode($atualizacao);
            $last_export = date('d/m/Y \à\s H:i:s', strtotime($atualizacao->updated_at));
        }
        return view('dashboard', ['last_export' => $last_export]);
    }

    public function export(Request $request){
        $format = $request->formato;
        $start = $this->formatDate($request->start, 's');
        $end = $this->formatDate($request->end, 'e');
        $tipo = $request->tipo;
        $this->registerExportTime();
        switch($request->fonte){
            case 'eduzz':
                return $this->exportEduzz($tipo, $format, $start, $end);
            break;
            case 'guru':
                return $this->exportDigitalManagerGuru($tipo, $format, $start, $end);
            break;
            default:
                return view('/dashboard');
        }
    }

    private function registerExportTime(){
        $atualizacao = new Atualizacao();
        $atualizacao->user_id = Auth::id();
        $atualizacao->save();
    }

    private function exportEduzz($tipo, $format, $start, $end){
        switch($tipo){
            case 'transactions':
                $coluna_ref = 'date_update';
                //dd($tipo, $format, $start, $end, $coluna_ref);
                return (new EduzzTransactionsExport($coluna_ref, $start, $end))->download('eduzz_transacoes.'.$format, $this->getConfigFormat($format));
            break;
            case 'subscriptions':
                $coluna_ref = 'contract_update_date';
                //dd($tipo, $format, $start, $end, $coluna_ref);
                return (new EduzzSubscriptionsExport($coluna_ref, $start, $end))->download('eduzz_assinaturas.'.$format, $this->getConfigFormat($format));
            break;
            default:
                return view('/dashboard');
        }
    }   

    private function exportDigitalManagerGuru($tipo, $format, $start, $end){
        switch($tipo){
            case 'transactions':
                $coluna_ref = 'dates_confirmed_at';
                //dd($tipo, $format, $start, $end, $coluna_ref);
                return (new DigitalManagerGuruTransactionsExport($coluna_ref, $start, $end))->download('dmg_transacoes.'.$format, $this->getConfigFormat($format));
            break;
            case 'subscriptions':
                $coluna_ref = 'updated_at';
                //dd($tipo, $format, $start, $end, $coluna_ref);
                return (new DigitalManagerGuruSubscriptionsExport($coluna_ref, $start, $end))->download('dmg_assinaturas.'.$format, $this->getConfigFormat($format));
            break;
            default:
                return view('/dashboard');
        }
    }   

    private function formatDate($date, $t){
        $dd = substr($date, 0, 2);
        $mm = substr($date, 3, 2);
        $yyyy = substr($date, 6, 4);
        return $yyyy.'-'.$mm.'-'.$dd;
    }

    private function getConfigFormat($format){
        switch($format){
            case 'xlsx':
                return \Maatwebsite\Excel\Excel::XLSX;
            break;
            case 'csv':
                return \Maatwebsite\Excel\Excel::CSV;
            break;
            case 'tsv':
                return \Maatwebsite\Excel\Excel::TSV;
            break;
            case 'ods':
                return \Maatwebsite\Excel\Excel::ODS;
            break;
            case 'xls':
                return \Maatwebsite\Excel\Excel::XLS;
            break;
            case 'html':
                return \Maatwebsite\Excel\Excel::HTML;
            break;
            case 'mpdf':
                return \Maatwebsite\Excel\Excel::MPDF;
            break;
            case 'dompdf':
                return \Maatwebsite\Excel\Excel::DOMPDF;
            break;
            case 'tcpdf':
                return \Maatwebsite\Excel\Excel::TCPDF;
            break;
        }
    }
}
