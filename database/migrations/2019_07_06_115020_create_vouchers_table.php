<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateVouchersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('vouchers',function(Blueprint $table){
            $table->increments("id");
            $table->string("title");
            $table->string("valid_date");
            $table->string("terms_condition");
            $table->string("barcode");
            $table->string("discount");
            $table->string("voucher_type");
            $table->string("voucher_template");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vouchers');
    }

}