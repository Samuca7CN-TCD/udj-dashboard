<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DigitalManagerGuruTransaction;
use App\Models\EduzzTransaction;
use App\Models\DigitalManagerGuruSubscription;
use App\Models\EduzzSubscription;

class WebhookController extends Controller
{
    public function __construct(){
        date_default_timezone_set('America/Bahia');
    }
    
    public function webhookDMGTransacoes(Request $request){
        Storage::disk('local')->put('public/files/DMGT.txt', $request);
        $api_token = 'iQlm5vrTWqWfD282EXrnVCRipi1gMNGIji9QF0o8';
        if($request['api_token'] == $api_token){
            $dmg_t_id = DigitalManagerGuruTransaction::where('payment_marketplace_id', $request['payment']['marketplace_id'])->value('id');
            $dmg_t = DigitalManagerGuruTransaction::find($dmg_t_id);
            $dmg_t_json = json_decode($dmg_t);
            if(!isset($dmg_t_json) || empty($dmg_t_json)){
                $dmg_t = new DigitalManagerGuruTransaction();
            }
            $dmg_t->cod_id = $request['id'];
            $dmg_t->status = $request['status'];
            $dmg_t->dates_ordered_at = $request['dates']['ordered_at'] != null ? date('Y-m-d H:i:s', $request['dates']['ordered_at']) : null;
            $dmg_t->dates_confirmed_at = $request['dates']['confirmed_at'] != null ? date('Y-m-d H:i:s', $request['dates']['confirmed_at']) : null;
            $dmg_t->dates_canceled_at = $request['dates']['canceled_at'] != null ? date('Y-m-d H:i:s', $request['dates']['canceled_at']) : null;
            $dmg_t->dates_warranty_until = $request['dates']['warranty_until'] != null ? date('Y-m-d H:i:s', $request['dates']['warranty_until']) : null;
            $dmg_t->dates_unavailable_until = $request['dates']['unavailable_until'] != null ? date('Y-m-d H:i:s', $request['dates']['unavailable_until']) : null;
            $dmg_t->contact_id = $request['contact']['id'];
            $dmg_t->contact_name = $request['contact']['name'];
            $dmg_t->contact_email = $request['contact']['email'];
            $dmg_t->product_id = $request['product']['id'];
            $dmg_t->product_name = $request['product']['name'];
            $dmg_t->product_unit_value = $request['product']['unit_value'];
            $dmg_t->product_total_value = $request['product']['total_value'];
            $dmg_t->product_type = $request['product']['type'];
            $dmg_t->product_marketplace_name = $request['product']['marketplace_name'];
            $dmg_t->product_qty = $request['product']['qty'];
            $dmg_t->product_producer_marketplace_id = $request['product']['producer']['marketplace_id'];
            $dmg_t->payment_method = $request['payment']['method'];
            $dmg_t->payment_marketplace_id = $request['payment']['marketplace_id'];
            $dmg_t->payment_marketplace_name = $request['payment']['marketplace_name'];
            $dmg_t->payment_marketplace_value = $request['payment']['marketplace_value'];
            $dmg_t->payment_total = $request['payment']['total'];
            $dmg_t->payment_net = $request['payment']['net'];
            $dmg_t->payment_gross = $request['payment']['gross'];
            $dmg_t->payment_tax_value = $request['payment']['tax']['value'];
            $dmg_t->payment_tax_rate = $request['payment']['tax']['rate'];
            $dmg_t->payment_refuse_reason = $request['payment']['refuse_reason'];
            $dmg_t->payment_credit_card_brand = !empty($request['payment']['credit_card']) ? $request['payment']['credit_card']['brand'] : "";
            $dmg_t->save();
        }
    }

    public function webhookDMGAssinaturas(Request $request){
        Storage::disk('local')->put('public/files/DMGA.txt', $request);
        $api_token = 'iQlm5vrTWqWfD282EXrnVCRipi1gMNGIji9QF0o8';
        if($request['api_token'] == $api_token){
            $dmg_s_id = DigitalManagerGuruSubscription::where('subscription_code', $request['id'])->value('id');
            $dmg_s = DigitalManagerGuruSubscription::find($dmg_s_id);
            $dmg_s_json = json_decode($dmg_s);
            if(empty($dmg_s_json) || !isset($dmg_s_json)){
                $dmg_s = new DigitalManagerGuruSubscription();
            }
            $dmg_s->cod_id = $item->id;
            $dmg_s->subscription_code = $item->subscription_code;
            $dmg_s->contact_id = $item['contact']['id'];
            $dmg_s->contact_name = $item['contact']['name'];
            $dmg_s->product_id = $item['product']['id'];
            $dmg_s->product_name = $item['product']['name'];
            $dmg_s->charged_times = $item['charged_times'];
            $dmg_s->charged_every_days = $item['charged_every_days'];
            $dmg_s->started_at = $item['started_at'] != null ? date('Y-m-d H:i:s', $item['started_at']) : null;
            $dmg_s->created_at = $item['created_at'] !== null ? date('Y-m-d H:i:s', $item['created_at']) : null;
            $dmg_s->updated_at = $item['updated_at'] != null ? date('Y-m-d H:i:s', $item['updated_at']) : null;
            $dmg_s->cancelled_at = $item['cancelled_at'] != null ? date('Y-m-d H:i:s', $item['cancelled_at']) : null;
            $dmg_s->last_status_at = $item['last_status_at'] != null ? date('Y-m-d H:i:s', $item['last_status_at']) : null;
            $dmg_s->last_status = $item['last_status'];
            $dmg_s->payment_method = $item['payment_method'];
            $dmg_s->trial_started_at = date('Y-m-d H:i:s', strtotime($item['trial_started_at']));
            $dmg_s->trial_finished_at = date('Y-m-d H:i:s', strtotime($item['trial_finished_at']));
            $dmg_s->save();
        }
    }

    public function webhookEduzz(Request $request){
        $api_key = '40302d20-9b6e-4898-9e47-b84fc7b84429';
        if($request['origin'] == $api_key || $request['api_key'] == $api_key){
            switch($request['type']){
                case 'invoice':
                    $this->webhookEduzzTrasacoes($request);
                break;
                case 'contract':
                    $this->webhookEduzzAssinaturas($request);
                break;
            }
        }
    }

    private function webhookEduzzTransacoes(Request $request){
        Storage::disk('local')->put('public/files/Eduzz_T.txt', $request);
        $e_t_id = EduzzTransaction::where('sale_id', $request['trans_cod'])->value('id');
        $e_t = EduzzTransaction::find($e_t_id);
        $e_t_json = json_decode($e_t);
        if(!isset($e_t_json) || empty($e_t_json)){
            $e_t = new EduzzTransaction();
        }
        $e_t->sale_id = $request['trans_cod'];
        $e_t->contract_id = $request['recurrence_cod'];
        $e_t->date_create = $request['trans_createdate'] != null ? date('Y-m-d H:i:s', strtotime($this->eduzzDataFormat($request['trans_createdate']).' '.$request['trans_createtime'])) : null;
        $e_t->date_payment = $request['trans_paiddate'] != null ? date('Y-m-d H:i:s', strtotime($this->eduzzDataFormat($request['trans_paiddate']).' '.$request['trans_paidtime'])) : null;
        $e_t->date_update = date('Y-m-d H:i:s');
        $e_t->due_date = $request['trans_duedate'] != null ? date('Y-m-d H:i:s', strtotime($this->eduzzDataFormat($request['trans_duedate']).' '.$request['trans_duetime'])) : null;
        $e_t->sale_status = $request['trans_status'];
        $e_t->sale_status_name = $this->eduzzSaleStatus($request['trans_status']);
        $e_t->sale_item_id = is_array($request['tras_items']) ? $request['tras_items']['0']['item_id'] : null;
        $e_t->sale_item_discount = $request['trans_value'] - ($request['trans_paid'] + $request['eduzz_value'] + $request['other_values']);
        $e_t->sale_amount_win = ($request['trans_paid'] + $request['eduzz_value'] + $request['other_values']);
        $e_t->sale_net_gain = $request['trans_paid'];
        $e_t->sale_total = $request['trans_value'];
        $e_t->sale_payment_method = $this->eduzzMetodosPagamento($request['trans_paymentmethod']);
        $e_t->client_id = $request['cus_cod'];
        $e_t->client_name = $request['cus_name'];
        $e_t->client_email = $request['cus_email'];
        $e_t->content_id = $request['product_cod'];
        $e_t->content_title = $request['product_name'];
        $e_t->save();
    }

    private function webhookEduzzAssinaturas(Request $request){
        Storage::disk('local')->put('public/files/Eduzz_S.txt', $request);
        $e_s_id = EduzzSubscription::where('contract_id', $request['recurrence_cod'])->value('id');
        $e_s = EduzzSubscription::find($e_s_id);
        $e_s_json = json_decode($e_s);
        if(!isset($e_s_json) || empty($e_s_json)){
            $e_s = new EduzzSubscription();
        }

        $e_s->contract_id = $request['recurrence_cod'];
        $e_s->contract_start_date = $request['recurrence_startdate'] != null ? date('Y-m-d H:i:s', strtotime($request['recurrence_startdate'])) : null;
        $e_s->contract_status = $request['recurrence_status_name'];
        $e_s->contract_invoice = $request['trans_cod'];
        $e_s->contract_cancel_date = $request['recurrence_canceled_at'] != null ? date('Y-m-d H:i:s', strtotime($request['recurrence_canceled_at'])) : null;
        $e_s->contract_update_date = date('Y-m-d H:i:s');
        $e_s->contract_cancel_reason = '';
        $e_s->client_id = $request['cus_cod'];
        $e_s->client_name = $request['cus_name'];
        $e_s->client_email = $request['cus_email'];
        $e_s->product_id = $request['product_cod'];
        $e_s->product_name = $request['product_name'];
        $e_s->payment_value = $request['trans_value'];
        $e_s->payment_method = $this->eduzzMetodosPagamento($request['trans_paymentmethod']);
        $e_s->payment_last_date = $request['trans_paiddate'] != null ? date('Y-m-d H:i:s', strtotime($this->eduzzDataFormat($request['trans_paiddate']).' '.$request['trans_paidtime'])) : null;
        $e_s->payment_repeat_type = $this->eduzzPaymentRepeatType($request['recurrence_interval_type']);
        $e_s->save();
    }

    private function eduzzDataFormat($date){
        $p1 = substr($date, 0, 4);
        $p2 = substr($date, 4, 2);
        $p3 = substr($date, 6, 2);
        return $p1.'-'.$p2.'-'.$p3;
    }
    
    private function eduzzSaleStatus($id){
        $status = array(
            '1' => 'Aberta',
            '3' => 'Paga',
            '4' => 'Cancelada',
            '6' => 'Aguardando Reembolso',
            '7' => 'Reembolsado',
            '9' => 'Duplicada',
            '10' => 'Expirada',
            '11' => 'Em Recuperacao',
            '15' => 'Aguardando Pagamento'
        );
        return $status[$id];
    }
    
    private function eduzzSubscriptionStatus($id){
        $status = array(
            '1' => 'Em Dia',
            '2' => 'Aguardando Pagamento',
            '3' => 'Suspenso',
            '4' => 'Cancelado',
            '7' => 'Atrasado',
            '9' => 'Finalizado',
            '10' => 'Trial'
        );
        return $status[$id];
    }
    
    private function eduzzMetodosPagamento($id){
        $metodos = array(
            '1' => 'Boleto Bancário',
            '9' => 'Paypal',
            '11' => 'Desconhecido',
            '13' => 'Visa',
            '14' => 'Amex',
            '15' => 'Mastercard',
            '16' => 'Diners',
            '17' => 'Débito Banco do Brasil',
            '18' => 'Débito Bradesco',
            '19' => 'Débito Itaú',
            '21' => 'Hipercard',
            '22' => 'Débito Banrisul',
            '23' => 'Hiper',
            '24' => 'Elo',
            '25' => 'Paypal Internacional',
            '27' => 'Múltiplos Cartões',
            '32' => 'PIX',
        );
        return $metodos[$id];
    }    

    private function eduzzPaymentRepeatType($type){
        $payment = array(
            'month' => 'M',
            'year' => 'Y',
            'day' => 'D',
            'week' => 'W',
            'semester' => 'S'
        );
        return $payment[$type];
    }
}