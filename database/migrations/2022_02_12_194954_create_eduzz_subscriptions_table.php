<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEduzzSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eduzz_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contract_id')->nullable();
            $table->dateTime('contract_start_date')->nullable();
            $table->string('contract_status')->nullable();
            $table->bigInteger('contract_invoice')->nullable();
            $table->dateTime('contract_cancel_date')->nullable();
            $table->dateTime('contract_update_date')->nullable();
            $table->text('contract_cancel_reason')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_email')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->float('payment_value')->nullable();
            $table->string('payment_method')->nullable();
            $table->dateTime('payment_last_date')->nullable();
            $table->char('payment_repeat_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eduzz_subscriptions');
    }
}
