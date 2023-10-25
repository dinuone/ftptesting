<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_data', function (Blueprint $table) {
            $table->id();
            $table->string('file_id');
            $table->string('column1');
            $table->string('column2');
            $table->string('column3');
            $table->string('column4');
            $table->string('column5');
            $table->string('column6');
            $table->string('column7');
            $table->string('column8');
            $table->string('column9');
            $table->string('column10');
            $table->string('column11');
            $table->string('column12');
            $table->string('column13');
            $table->string('column14');
            $table->string('column15');
            $table->string('column16');
            $table->string('column17');
            $table->string('column18');
            $table->string('column19');
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
        Schema::dropIfExists('file_data');
    }
}
