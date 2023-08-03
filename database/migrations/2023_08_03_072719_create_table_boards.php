<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBoards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ref')->comment('글 그룹');
            $table->integer('ref_step')->comment('자식글 표시용 들여쓰기(sort)');
            $table->integer('ref_order')->comment('그룹내 순서(ddepth)');
            $table->integer('member_seq');
            $table->string('member_name', 20);
            $table->string('board_title');
            $table->longText('board_content');
            $table->integer('board_read')->default(0);
            $table->string('board_state', 1)->default('Y')->comment('Y:정상 / N:삭제');
            $table->string('board_file1')->nullable();
            $table->string('board_file1_ori', 50)->nullable();
            $table->string('board_file2')->nullable();
            $table->string('board_file2_ori', 50)->nullable();
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
        Schema::dropIfExists('boards');
    }
}
