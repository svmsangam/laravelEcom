<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('name');
            $table->string('slug');
            $table->string('image');
            $table->longText('desc');
            $table->string('lead_time');
            $table->double('tax');
            $table->string('tax_type');
            $table->integer('is_promo')->default(0);
            $table->integer('is_featured')->default(0);
            $table->integer('is_discounted')->default(0);
            $table->integer('is_trending')->default(0);
            $table->integer('status')->default(1);
            $table->boolean('hasNoEgg')->default(true);
            $table->longText('keywords');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
