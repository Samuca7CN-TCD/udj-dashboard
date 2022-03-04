<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DigitalManagerGuruTransaction;
use App\Models\EduzzTransaction;
use App\Models\DigitalManagerGuruSubscription;
use App\Models\EduzzSubscription;

class WebhookController extends Controller
{
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
        $e_t_id = EduzzTransaction::where('id_cliente', $request['cus_cod'])->where('id_contrato', $request['recurrence_cod'])->value('id');
        $e_t = EduzzTransaction::find($e_t_id);
        $e_t_json = json_decode($e_t);
        if(!isset($e_t_json) || empty($e_t_json)){
            $e_t = new EduzzTransaction();
        }
        $e_t->sale_id = $item->sale_id;
        $e_t->contract_id = $item->contract_id;
        $e_t->date_create = $item->date_create != null ? date('Y-m-d H:i:s', strtotime($item->date_create)) : null;
        $e_t->date_payment = $item->date_payment != null ? date('Y-m-d H:i:s', strtotime($item->date_payment)) : null;
        $e_t->date_update = $item->date_update != null ? date('Y-m-d H:i:s', strtotime($item->date_update)) : null;
        $e_t->due_date = $item->due_date != null ? date('Y-m-d H:i:s', strtotime($item->due_date)): null;
        $e_t->sale_status = $item->sale_status;
        $e_t->sale_status_name = $item->sale_status_name;
        $e_t->sale_item_id = $item->sale_item_id;
        $e_t->sale_item_discount = $item->sale_item_discount;
        $e_t->sale_amount_win = $item->sale_amount_win;
        $e_t->sale_net_gain = $item->sale_net_gain;
        $e_t->sale_total = $item->sale_total;
        $e_t->sale_payment_method = $item->sale_payment_method;
        $e_t->client_id = $item->client_id;
        $e_t->client_name = $item->client_name;
        $e_t->client_email = $item->client_email;
        $e_t->content_id = $item->content_id;
        $e_t->content_title = $item->content_title;
        $e_t->content_type_id = $item->content_type_id;
        $e_t->installments = $item->installments;
        $e_t->save();

        ///////////////////////////////////////////
        
        //$contabil = Contabil::where('id_cliente', $request['cus_cod'])->where('id_contrato', $request['recurrence_cod'])->value('id');
        //$contabil = Contabil::find($contabil);
        //if(!isset($contabil) || empty($contabil)){
            $contabil = new Contabil();
        //}
        $contabil->id_contrato = $request['recurrence_cod'];
        $contabil->id_cliente = $request['cus_cod'];
        $contabil->email = $request['cus_email'];
        $contabil->fonte_id = $this->getFonteId('eduzz_sales');
        $contabil->assinatura_id = $this->getAssinaturaIdById($request['product_cod']);
        $contabil->valor_total = $request['trans_value'];
        $contabil->valor_taxa = $request['eduzz_value'] + $request['other_values'];
        $contabil->valor_liquido = $request['trans_paid'];
        $contabil->metodo_pagamento = $request['trans_paymentmethod'];
        $contabil->status_transacao_id = $this->getStatusId('eduzz_sales', $request['trans_status']);
        $contabil->paid_at = !empty($request['trans_paiddate']) ? date('Y-m-d H:i:s', strtotime($request['trans_paiddate'].' '.$request['trans_paidtime'])) : null;
        $contabil->created_at = date('Y-m-d H:i:s', strtotime($request['trans_createdate'].' '.$request['trans_createtime']));
        $contabil->updated_at = date('Y-m-d H:i:s', strtotime($request['recurrence_startdate']));
        $contabil->save();
    }

    private function webhookEduzzAssinaturas(Request $request){
        Storage::disk('local')->put('public/files/Eduzz_S.txt', $request);
        $cliente = Cliente::where('id_cliente', $request['cus_cod'])->where('id_contrato', $request['recurrence_cod'])->value('id');
        $cliente = Cliente::find($cliente);
        if(!isset($cliente) || empty($cliente)){
            $cliente = new Cliente();
        }
        $cliente->id_contrato = $request['recurrence_cod'];
        $cliente->id_cliente = $request['cus_cod'];
        $cliente->email = $request['cus_email'];
        $cliente->fonte_id = $this->getFonteId('eduzz_subscriptions');
        $cliente->assinatura_id = $this->getAssinaturaIdById($request['product_cod']);
        $cliente->status_request_id = $this->getStatusId('eduzz_subscriptions', $request['recurrence_status_name']);
        $cliente->metodo_pagamento = $request['trans_paymentmethod'];
        $cliente->cancelled_at = !empty($request['recurrence_cancelled_at']) ? date('Y-m-d H:i:s', strtotime($request['recurrence_cancelled_at'])) : null;
        $cliente->created_at = date('Y-m-d H:i:s', strtotime($request['trans_createdate'].' '.$request['trans_createtime']));
        $cliente->updated_at = date('Y-m-d H:i:s', strtotime($request['recurrence_startdate']));
        $cliente->save();
    }
}
