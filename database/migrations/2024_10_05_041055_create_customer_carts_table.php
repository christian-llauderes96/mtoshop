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
        // CREATE TABLE carts (
        //     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        //     user_id BIGINT UNSIGNED DEFAULT NULL, -- Nullable for guest users
        //     product_id BIGINT UNSIGNED NOT NULL,
        //     quantity INT UNSIGNED DEFAULT 1,
        //     created_at TIMESTAMP NULL DEFAULT NULL,
        //     updated_at TIMESTAMP NULL DEFAULT NULL,
        //     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        //     FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        // );
        Schema::create('customer_carts', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('customer_carts');
    }
};
