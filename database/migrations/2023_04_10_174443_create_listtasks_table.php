<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListtasksTable extends Migration
{
    /**таблица заданий
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listtasks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // название задания
            $table->integer('numer')->nullable(); //номер задания
            $table->integer('klass')->nullable(); //класс задания
            $table->string('time')->nullable(); // время выполнения
            $table->integer('num_quest')->nullable(); //количество вопросов
            $table->string('purpose')->nullable(); // Назначение задания годовая или полугодовая или ученый процесс
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
        Schema::dropIfExists('listtasks');
    }
}
