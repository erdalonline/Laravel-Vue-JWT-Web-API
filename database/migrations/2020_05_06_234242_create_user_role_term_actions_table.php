<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTermActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role_term_actions', function (Blueprint $table) {
            $table->id('id');
            $table->string ('action',250);
            $table->string ('name', 100)->nullable ();
            $table->string ('url', 250)->nullable ();
            $table->string ('prefix', 250)->nullable ();
            $table->integer ('top_id')->nullable ()->default (0);
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
        Schema::dropIfExists('user_role_term_actions');
    }
}
