<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignIdToSmBankPaymentSlips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_bank_payment_slips', function (Blueprint $table) {
            $name ="assign_id";
            if (!Schema::hasColumn('sm_bank_payment_slips', $name)) {
                $table->integer('assign_id')->nullable()->unsigned()->after('amount');
                $table->foreign('assign_id')->references('id')->on('sm_fees_assigns')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_bank_payment_slips', function (Blueprint $table) {
            //
            $table->dropColumn('assign_id');
        });
    }
}
