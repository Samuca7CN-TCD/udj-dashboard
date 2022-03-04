<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function webhookDMGTransacoes(Request $request){
        Storage::disk('local')->put('public/files/DMGT.txt', $request);
        $api_token = 'iQlm5vrTWqWfD282EXrnVCRipi1gMNGIji9QF0o8';
        if($request['api_token'] == $api_token){
            //$contabil = Contabil::where('id_cliente', $request['contact']['id'])->where('id_contrato', $request['id'])->value('id');
            //$contabil = Contabil::find($contabil);
            //$contabil_json = json_decode($contabil);
            //if(empty($contabil_json) || !isset($contabil_json)){
                $contabil = new Contabil();
            //}
            $contabil->id_contrato = $request['id'];
            $contabil->id_cliente = $request['contact']['id'];
            $contabil->email = $request['contact']['email'];
            $contabil->fonte_id = $this->getFonteId('digital_manager_guru_transactions');
            $contabil->assinatura_id = $this->getAssinaturaIdById($request['product']['id']);
            $contabil->valor_total = $request['payment']['total'];
            $contabil->valor_taxa = $request['payment']['marketplace_value'];
            $contabil->valor_liquido = $request['payment']['net'];
            
            $payment_method = $request['payment']['method'];
            if($payment_method == 'credit_card'){
                $payment_method = $request['payment']['credit_card']['brand'];
            }
    
            $contabil->metodo_pagamento = $payment_method;
            $contabil->status_transacao_id = $this->getStatusId('digital_manager_guru_transactions', $request['status']);
            $contabil->paid_at = !empty($request['invoice']) ? date('Y-m-d H:i:s', strtotime($request['invoice']['period_start'])) : null;
            $contabil->created_at = date('Y-m-d H:i:s', strtotime($request['dates']['created_at']));
            $contabil->updated_at = date('Y-m-d H:i:s', strtotime($request['dates']['updated_at']));
            $contabil->save();
        }
    }

    public function webhookDMGAssinaturas(Request $request){
        Storage::disk('local')->put('public/files/DMGA.txt', $request);
        $api_token = 'iQlm5vrTWqWfD282EXrnVCRipi1gMNGIji9QF0o8';
        if($request['api_token'] == $api_token){
            $cliente = Cliente::where('id_cliente', $request['last_transaction']['contact']['id'])->where('id_contrato', $request['last_transaction']['id'])->value('id');
            $cliente = Cliente::find($cliente);
            $cliente_json = json_decode($cliente);
            if(empty($cliente_json) || !isset($cliente_json)){
                $cliente = new Cliente();
            }
            $cliente->id_contrato = $request['last_transaction']['id'];
            $cliente->id_cliente = $request['last_transaction']['contact']['id'];
            $cliente->fonte_id = $this->getFonteId('digital_manager_guru_subscriptions');
            $cliente->assinatura_id = $this->getAssinaturaIdById($request['last_transaction']['product']['id']);
            $cliente->status_assinatura_id = $this->getStatusId('digital_manager_guru_subscriptions', $request['last_status']);
            $payment_method = $request['last_transaction']['payment']['method'];
            if($payment_method == 'credit_card'){
                $payment_method = $request['last_transaction']['payment']['credit_card']['brand'];
            }

            $cliente->metodo_pagamento = $payment_method;
            $cliente->cancelled_at = date('Y-m-d H:i:s', strtotime($request['last_transaction']['dates']['canceled_at']));
            $cliente->trial_finished_at = date('Y-m-d H:i:s', strtotime($request['trial_finished_at']));
            $cliente->created_at = date('Y-m-d H:i:s', strtotime($request['last_transaction']['dates']['created_at']));
            $cliente->updated_at = date('Y-m-d H:i:s', strtotime($request['last_transaction']['dates']['updated_at']));
            $cliente->save();
        }
    }

    public function webhookEduzz(Request $request){
        Storage::disk('local')->put('public/files/EduzzITEM.txt', $request);
        $api_key = '40302d20-9b6e-4898-9e47-b84fc7b84429';
        if($request['api_key'] == $api_key){
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
