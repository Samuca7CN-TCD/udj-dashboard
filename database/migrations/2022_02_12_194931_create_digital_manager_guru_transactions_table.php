<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalManagerGuruTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_manager_guru_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_id')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('dates_ordered_at')->nullable();
            $table->dateTime('dates_confirmed_at')->nullable();
            $table->dateTime('dates_canceled_at')->nullable();
            $table->dateTime('dates_warranty_until')->nullable();
            $table->dateTime('dates_unavailable_until')->nullable();
            $table->string('contact_id')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->float('product_unit_value')->nullable();
            $table->float('product_total_value')->nullable();
            $table->string('product_type')->nullable();
            $table->string('product_marketplace_name')->nullable();
            $table->integer('product_qty')->nullable();
            $table->bigInteger('product_producer_marketplace_id')->nullable();
            $table->string('trackings_source')->nullable();
            $table->string('trackings_checkout_source')->nullable();
            $table->string('trackings_utm_source')->nullable();
            $table->string('trackings_utm_campaign')->nullable();
            $table->string('trackings_medium')->nullable();
            $table->string('trackings_content')->nullable();
            $table->string('trackings_term')->nullable();
            $table->json('trackings_pptc')->nullable();
            $table->string('payment_marketplace_id')->nullable();
            $table->string('payment_marketplace_name')->nullable();
            $table->string('payment_marketplace_value')->nullable();
            $table->float('payment_total')->nullable();
            $table->float('payment_net')->nullable();
            $table->float('payment_gross')->nullable();
            $table->float('payment_tax_value')->nullable();
            $table->float('payment_tax_rate')->nullable();
            $table->text('payment_refuse_reason')->nullable();
            $table->string('payment_credit_card_brand')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_manager_guru_transactions');
    }
}
