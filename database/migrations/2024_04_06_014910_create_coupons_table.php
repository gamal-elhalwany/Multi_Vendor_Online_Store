<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('coupons')) {
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code');
                $table->string('name');
                $table->unsignedBigInteger('store_id');
                $table->foreign('store_id')->references('id')->on('stores');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');
                $table->integer('max_uses');
                $table->integer('user_max_uses');
                $table->enum('type', ['persentage', 'fixed'])->default('persentage');
                $table->double('discount_amount', 10, 2)->nullable();
                $table->double('min_amount', 10, 2)->nullable();
                $table->integer('status')->default(1);
                $table->timestamp('start_at');
                $table->timestamp('end_at');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
