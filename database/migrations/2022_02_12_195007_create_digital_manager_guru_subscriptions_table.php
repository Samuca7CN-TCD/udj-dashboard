<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalManagerGuruSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_manager_guru_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_id')->nullable();
            $table->string('subscription_code')->nullable();
            $table->string('contact_id')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('charged_times')->nullable();
            $table->integer('charged_every_days')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('last_status_at')->nullable();
            $table->string('last_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->dateTime('trial_started_at')->nullable();
            $table->dateTime('trial_finished_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_manager_guru_subscriptions');
    }
}
