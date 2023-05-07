<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->dateTime("fecha");
            $table->integer("estado")->default(1);
            $table->text("observacion")->nullable();

            $table->unsignedBigInteger("cliente_id");
            $table->unsignedBigInteger("user_id");

            $table->foreign("cliente_id")->references("id")->on("clientes");
            $table->foreign("user_id")->references("id")->on("users");

            
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
        Schema::dropIfExists('pedidos');
    }
}
