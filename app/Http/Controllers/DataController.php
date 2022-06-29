<?php

namespace App\Http\Controllers;

use App\Models\JwtToken;
use App\Models\DigitalManagerGuruTransaction;
use App\Models\EduzzTransaction;
use App\Models\DigitalManagerGuruSubscription;
use App\Models\EduzzSubscription;

class DataController extends Controller
{
    public function __construct(){
        date_default_timezone_set('America/Bahia');
    }

    public function fillBdd($fonte){
        switch($fonte){
            case 'dmg-t':
                DigitalManagerGuruTransaction::truncate();
                $this->getDigitalManagerGuruTransactions();
            break;
            case 'e-t':
                EduzzTransaction::truncate();
                $this->getEduzzTransactions();
            break;
            case 'dmg-s':
                DigitalManagerGuruSubscription::truncate();
                $this->getDigitalManagerGuruSubscriptions();
            break;
            case 'e-s':
                EduzzSubscription::truncate();
                $this->getEduzzSubscriptions();
            break;
            case 'all-t':
                $this->fillBdd('digital_manager_guru_transactions');
                $this->fillBdd('eduzz_sales');
            break;
            case 'all-s':
                $this->fillBdd('digital_manager_guru_subsriptions');
                $this->fillBdd('eduzz_subscriptions');
            break;
            case 'all':
                $this->fillBdd('digital_manager_guru_transactions');
                $this->fillBdd('eduzz_sales');
                $this->fillBdd('digital_manager_guru_subsriptions');
                $this->fillBdd('eduzz_subscriptions');
            break;
            default:
                return redirect('/dashboard');
        }
    }

    private function getDigitalManagerGuruTransactions(){
        $api_key = '94e9f19b-f11e-41d0-ba1b-81e923c2cf94|IDv9v27E1puc7MtYppkixzQbCWkUotWb6zVrkalG';
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$api_key,
            'Accept: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $url = "https://digitalmanager.guru/api/v1/transactions?transaction_status[]=abandoned&transaction_status[]=analysis&transaction_status[]=approved&transaction_status[]=billet_printed&transaction_status[]=blocked&transaction_status[]=canceled&transaction_status[]=chargeback&transaction_status[]=completed&transaction_status[]=delayed&transaction_status[]=dispute&transaction_status[]=expired&transaction_status[]=in_recovery&transaction_status[]=refunded&transaction_status[]=rejected&transaction_status[]=scheduled&transaction_status[]=started&transaction_status[]=trial&transaction_status[]=waiting_payment&page=";
        $pagina = 1;
        do{
            curl_setopt($ch, CURLOPT_URL, $url.$pagina);
            $result = curl_exec($ch);
            if($result !== false){
                $result = json_decode($result);
                if(isset($result->data) && !empty($result->data)){
                    foreach($result->data as $item){
                        $dmg_t = new DigitalManagerGuruTransaction();
                        $dmg_t->cod_id = $item->id;
                        $dmg_t->status = $item->status;
                        $dmg_t->dates_canceled_at = (isset($item->dates->canceled_at) && !empty($item->dates->canceled_at)) ? date('Y-m-d H:i:s', $item->dates->canceled_at) : null;
                        $dmg_t->dates_confirmed_at = (isset($item->dates->confirmed_at) && !empty($item->dates->confirmed_at)) ? date('Y-m-d H:i:s', $item->dates->confirmed_at) : null;
                        $dmg_t->dates_created_at = (isset($item->dates->created_at) && !empty($item->dates->created_at)) ? date('Y-m-d H:i:s', $item->dates->created_at) : null;
                        $dmg_t->dates_expires_at = (isset($item->dates->expires_at) && !empty($item->dates->expires_at)) ? date('Y-m-d H:i:s', strtotime($item->dates->expires_at)) : null;
                        $dmg_t->dates_ordered_at = (isset($item->dates->ordered_at) && !empty($item->dates->ordered_at)) ? date('Y-m-d H:i:s', $item->dates->ordered_at) : null;
                        $dmg_t->dates_unavailable_until = (isset($item->dates->unavailable_until) && !empty($item->dates->unavailable_until)) ? date('Y-m-d H:i:s', $item->dates->unavailable_until) : null;
                        $dmg_t->dates_updated_at = (isset($item->dates->updated_at) && !empty($item->dates->updated_at)) ? date('Y-m-d H:i:s', $item->dates->updated_at) : null;
                        $dmg_t->dates_warranty_until = (isset($item->dates->warranty_until) && !empty($item->dates->warranty_until)) ? date('Y-m-d H:i:s', $item->dates->warranty_until) : null;
                        $dmg_t->contact_id = $item->contact->id;
                        $dmg_t->contact_name = $item->contact->name;
                        $dmg_t->contact_email = $item->contact->email;
                        $dmg_t->product_id = $item->product->id;
                        $dmg_t->product_name = $item->product->name;
                        $dmg_t->product_unit_value = $item->product->unit_value;
                        $dmg_t->product_total_value = $item->product->total_value;
                        $dmg_t->product_type = $item->product->type;
                        $dmg_t->product_marketplace_name = $item->product->marketplace_name;
                        $dmg_t->product_qty = $item->product->qty;
                        $dmg_t->product_producer_marketplace_id = $item->product->producer->marketplace_id;
                        $dmg_t->trackings_source = $item->trackings->source;
                        $dmg_t->trackings_checkout_source = $item->trackings->checkout_source;
                        $dmg_t->trackings_utm_source = $item->trackings->utm_source;
                        $dmg_t->trackings_utm_campaign = $item->trackings->utm_campaign;
                        $dmg_t->trackings_utm_medium = $item->trackings->utm_medium;
                        $dmg_t->trackings_utm_content = $item->trackings->utm_content;
                        $dmg_t->trackings_utm_term = $item->trackings->utm_term;
                        $dmg_t->trackings_pptc = json_encode($item->trackings->pptc);
                        $dmg_t->payment_method = $item->payment->method;
                        $dmg_t->payment_marketplace_id = $item->payment->marketplace_id;
                        $dmg_t->payment_marketplace_name = $item->payment->marketplace_name;
                        $dmg_t->payment_marketplace_value = $item->payment->marketplace_value;
                        $dmg_t->payment_total = $item->payment->total;
                        $dmg_t->payment_net = $item->payment->net;
                        $dmg_t->payment_gross = $item->payment->gross;
                        $dmg_t->payment_tax_value = $item->payment->tax->value;
                        $dmg_t->payment_tax_rate = $item->payment->tax->rate;
                        $dmg_t->payment_refuse_reason = $item->payment->refuse_reason;
                        $dmg_t->payment_credit_card_brand = !empty($item->payment->credit_card) ? $item->payment->credit_card->brand : "";
                        $dmg_t->save();
                        //dd($item);
                    }
                }else{
                    dd('RESULT->DATA', $result);
                }
            }else{
                dd('RESULT', $result);
            }
        }while($result->last_page > $pagina++);
        curl_close($ch);
    }

    private function getDigitalManagerGuruSubscriptions(){
        $api_key = '94e9f19b-f11e-41d0-ba1b-81e923c2cf94|IDv9v27E1puc7MtYppkixzQbCWkUotWb6zVrkalG';
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$api_key,
            'Accept: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $url = "https://digitalmanager.guru/api/v1/subscriptions?subscription_status[]=active&subscription_status[]=canceled&subscription_status[]=expired&subscription_status[]=inactive&subscription_status[]=pastdue&subscription_status[]=started&subscription_status[]=trial&page=";
        $pagina = 1;
        do{
            curl_setopt($ch, CURLOPT_URL, $url.$pagina);
            $result = curl_exec($ch);
            if($result !== false){
                $result = json_decode($result);
                if(isset($result->data) && !empty($result->data)){
                    foreach($result->data as $item){
                        $dmg_s = new DigitalManagerGuruSubscription();
                        $dmg_s->cod_id = $item->id;
                        $dmg_s->subscription_code = $item->subscription_code;
                        $dmg_s->contact_id = $item->contact->id;
                        $dmg_s->contact_name = $item->contact->name;
                        $dmg_s->product_id = $item->product->id;
                        $dmg_s->product_name = $item->product->name;
                        $dmg_s->charged_times = $item->charged_times;
                        $dmg_s->charged_every_days = $item->charged_every_days;
                        $dmg_s->started_at = (isset($item->started_at) && !empty($item->started_at)) ? date('Y-m-d H:i:s', $item->started_at) : null;
                        $dmg_s->created_at = (isset($item->created_at) && !empty($item->created_at)) ? date('Y-m-d H:i:s', $item->created_at) : null;
                        $dmg_s->updated_at = (isset($item->updated_at) && !empty($item->updated_at)) ? date('Y-m-d H:i:s', $item->updated_at) : null;
                        $dmg_s->cancelled_at = (isset($item->cancelled_at) && !empty($item->cancelled_at)) ? date('Y-m-d H:i:s', $item->cancelled_at) : null;
                        $dmg_s->last_status_at = (isset($item->last_status_at) && !empty($item->last_status_at)) ? date('Y-m-d H:i:s', $item->last_status_at) : null;
                        $dmg_s->last_status = $item->last_status;
                        $dmg_s->payment_method = $item->payment_method;
                        $dmg_s->trial_started_at = (isset($item->trial_started_at) && !empty($item->trial_started_at)) ? date('Y-m-d H:i:s', strtotime($item->trial_started_at)) : null;
                        $dmg_s->trial_finished_at = (isset($item->trial_finished_at) && !empty($item->trial_finished_at)) ? date('Y-m-d H:i:s', strtotime($item->trial_finished_at)) : null;
                        $dmg_s->save();
                        //dd($item);
                    }
                }else{
                    dd('RESULT->DATA', $result);
                }
            }else{
                dd('RESULT', $result);
            }
        }while($result->last_page > $pagina++);
        curl_close($ch);
    }

    private function getEduzzTransactions(){
        $jwt_token = $this->getJWTToken();
        $headers = Array(
            'Content-Type: application/json',
            'Token: '.$jwt_token
        );
        $base_url = "https://api2.eduzz.com/sale/get_sale_list?start_date=2000-01-01&end_date=".date('Y')."-12-31&page=";
        $total_paginas = 0;
        $pagina = 1;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        do{
            $url = $base_url.$pagina;
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            if($result === false){
                echo 'Curl error!';
            }else{
                $result = json_decode($result);
                if(isset($result->data) && !empty($result->data)){
                    foreach($result->data as $item){
                        $e_t = new EduzzTransaction();
                        $e_t->sale_id = $item->sale_id;
                        $e_t->contract_id = $item->contract_id;
                        $e_t->date_create = (isset($item->date_create) && !empty($item->date_create)) ? date('Y-m-d H:i:s', strtotime($item->date_create)) : null;
                        $e_t->date_payment = (isset($item->date_payment) && !empty($item->date_payment)) ? date('Y-m-d H:i:s', strtotime($item->date_payment)) : null;
                        $e_t->date_update = (isset($item->date_update) && !empty($item->date_update)) ? date('Y-m-d H:i:s', strtotime($item->date_update)) : null;
                        $e_t->due_date = (isset($item->due_date) && !empty($item->due_date)) ? date('Y-m-d H:i:s', strtotime($item->due_date)): null;
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
                        $e_t->save();
                    }
                }
            }
            if(empty($result->paginator) || !isset($result->paginator)){
                echo "<h1>(Contábeis) Página: ".$pagina."</h1>";
                echo "<p><pre>".print_r($result, 1)."</pre></p>";
                break;
            }
        }while($result->paginator->totalPages > $pagina++);
        curl_close($ch);
    }

    private function getEduzzSubscriptions(){
        $jwt_token = $this->getJWTToken();
        $headers = Array(
            'Content-Type: application/json',
            'Token: '.$jwt_token
        );
        $base_url = "https://api2.eduzz.com/subscription/get_contract_list?start_date=2000-01-01&end_date=".date('Y')."-12-31&page=";
        $total_paginas = 0;
        $pagina = 1;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        do{
            $url = $base_url.$pagina;
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            if($result === false){
                echo 'Curl error!';
            }else{
                $result = json_decode($result);
                if(isset($result->data) && !empty($result->data)){
                    foreach($result->data as $item){
                        $e_s = new EduzzSubscription();
                        $e_s->contract_id = $item->contract_id;
                        $e_s->contract_start_date = (isset($item->contract_start_date) && !empty($item->contract_start_date)) ? date('Y-m-d H:i:s', strtotime($item->contract_start_date)) : null;
                        $e_s->contract_status = $item->contract_status;
                        $e_s->contract_invoice = $item->contract_invoice;
                        $e_s->contract_cancel_date = (isset($item->contract_cancel_date) && !empty($item->contract_cancel_date)) ? date('Y-m-d H:i:s', strtotime($item->contract_cancel_date)) : null;
                        $e_s->contract_update_date = (isset($item->contract_update_date) && !empty($item->contract_update_date)) ? date('Y-m-d H:i:s', strtotime($item->contract_update_date)) : null;
                        $e_s->contract_cancel_reason = $item->contract_cancel_reason;
                        $e_s->client_id = $item->client_id;
                        $e_s->client_name = $item->client_name;
                        $e_s->client_email = $item->client_email;
                        $e_s->product_id = $item->product_id;
                        $e_s->product_name = $item->product_name;
                        $e_s->payment_value = $item->payment_value;
                        $e_s->payment_method = $item->payment_method;
                        $e_s->payment_last_date = (isset($item->payment_last_date) && !empty($item->payment_last_date)) ? date('Y-m-d H:i:s', strtotime($item->payment_last_date)) : null;
                        $e_s->payment_repeat_type = $item->payment_repeat_type;
                        $e_s->save();
                    }
                }
            }
            if(empty($result->paginator) || !isset($result->paginator)){
                echo "<h1>(Contábeis) Página: ".$pagina."</h1>";
                echo "<p><pre>".print_r($result, 1)."</pre></p>";
                break;
            }
        }while($result->paginator->totalPages > $pagina++);
        curl_close($ch);
    }

    private function getJWTToken(){
        $url = "https://api2.eduzz.com/credential/generate_token";
        $public_key = '67783237';
        $api_key = '2f5e5db95a';
        $email = 'universidadedosjovens@gmail.com';
        $headers = Array(
            'Content-Type: application/json',
            'Accept: application/json'
        );
        $data = Array(
            'publickey' => '67783237',
            'apikey' => '2f5e5db95a',
            'email' => 'universidadedosjovens@gmail.com'
        );

        $data = json_encode($data);
        $jwt_token_old = JWTToken::find(1);

        while(empty($jwt_token_old)){
            $jwt_token_old = new JWTToken();
            $jwt_token_old->valor = "";
            $jwt_token_old->renovation_at = date('Y-m-d H:i:s', time() - 1);
            $jwt_token_old->save();
            $jwt_token_old = JWTToken::find(1);
        }
        $jwt_token_old_decode = json_decode($jwt_token_old);

        $rev_time = strtotime($jwt_token_old_decode->renovation_at);
        $now_time = strtotime(date('Y-m-d H:i:s'));

        if($rev_time < $now_time){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $jwt_token = curl_exec($ch);
            curl_close($ch);
            $jwt_token = json_decode($jwt_token);
            if(!empty($jwt_token->success)){
                $jwt_token_old->valor = $jwt_token->data->token;
                $jwt_token_old->renovation_at = date('Y-m-d H:i:s', time() + 900);
                $jwt_token_old->updated_at = date('Y-m-d H:i:s');
                $jwt_token_old->save();
                return $jwt_token->data->token;
            }else{
                return false;
            }
        }else{
            return $jwt_token_old_decode->valor;
        }
    }


    public function curlDigitalManagerGuru($type){
        $api_key = '94e9f19b-f11e-41d0-ba1b-81e923c2cf94|IDv9v27E1puc7MtYppkixzQbCWkUotWb6zVrkalG';
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$api_key,
            'Accept: application/json'
        );
        $pagina = 1;
        switch($type){
            case 'assinaturas':
                $base = "https://digitalmanager.guru/api/v1/subscriptions?page=";
            break;
            case 'transacoes':
                $base = "https://digitalmanager.guru/api/v1/transactions?page=";
            break;
            case 'abandonadas':
                $base = "https://digitalmanager.guru/api/v1/transactions?transaction_status[]=abandoned&page=";
            break;
            case 'trial':
                $base = "https://digitalmanager.guru/api/v1/transactions?transaction_status[]=trial&page=";
            break;
            default:
                $base = "";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        do{
            $url = $base.$pagina;
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            $result = json_decode($result);
            //echo "<p><pre>".print_r($result, 1)."</pre></p>";
            foreach($result->data as $item){
                echo "<p><pre>".print_r($item, 1)."</pre></p>";
                
            }
            $qtd_paginas = $result->last_page;
        }while($qtd_paginas > $pagina++);
        curl_close($ch);
    }

    public function curlEduzz($type){
        $jwt_token = $this->getJWTToken();
        $headers = Array(
            'Content-Type: application/json',
            'Token: '.$jwt_token
        );
        switch($type){
            case 'assinaturas':
                $base = "https://api2.eduzz.com/subscription/get_contract_list/?start_date=2000-01-01&end_date=".date('Y')."-12-31&page=";
            break;
            case 'transacoes':
                $base = "https://api2.eduzz.com/sale/get_sale_list/?start_date=2000-01-01&end_date=".date('Y')."-12-31&page=";
            break;
            default:
                $base = "";
        }
        $total_paginas = 0;
        $pagina = 1;
        $fonte_id = $this->getFonteId('eduzz_sales');
        //Contabil::where('fonte_id', 2)->delete();
        $url = $base.$pagina;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $result = json_decode($result);
        echo "<p><pre>".print_r($result, 1)."</pre></p>";
        $total_paginas = $result->paginator->totalPages;
        $count = 1;
        ++$pagina;
        
        while($total_paginas > $pagina){
            $url = $base.$pagina++;
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            $result = json_decode($result);
            echo "<p><pre>".print_r($result, 1)."</pre></p>";
        }
        curl_close($ch);
    }
}
