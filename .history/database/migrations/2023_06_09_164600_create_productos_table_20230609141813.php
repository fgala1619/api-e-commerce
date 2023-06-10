<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->float('precio');
            $table->integer('stock');
            $table->string('categoria', 50);
            $table->string('tags', 50)->nullable();
            $table->string('descripcion', 150)->nullable();
            $table->string('informacion', 150)->nullable();
            $table->string('valoracion', 150)->nullable();
            $table->integer('sku')->unique();
            $table->string('url_imagen')->nullable();
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
        Schema::dropIfExists('productos');
    }
}
