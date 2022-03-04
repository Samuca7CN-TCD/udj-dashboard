<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEduzzTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eduzz_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sale_id')->nullable();
            $table->bigInteger('contract_id')->nullable();
            $table->dateTime('date_create')->nullable();
            $table->dateTime('date_payment')->nullable();
            $table->dateTime('date_update')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->integer('sale_status')->nullable();
            $table->string('sale_status_name')->nullable();
            $table->bigInteger('sale_item_id')->nullable();
            $table->float('sale_item_discount')->nullable();
            $table->float('sale_amount_win')->nullable();
            $table->float('sale_net_gain')->nullable();
            $table->float('sale_total')->nullable();
            $table->string('sale_payment_method')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_email')->nullable();
            $table->bigInteger('content_id')->nullable();
            $table->string('content_title')->nullable();
            $table->integer('content_type_id')->nullable();
            $table->integer('installments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eduzz_transactions');
    }
}
