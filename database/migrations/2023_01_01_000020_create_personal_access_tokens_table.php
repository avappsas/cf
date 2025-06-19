<?php

// database/migrations/2023_01_01_000020_create_personal_access_tokens_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    public function up()
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tokenable_type', 255);
            $table->bigInteger('tokenable_id');
            $table->string('name', 255);
            $table->string('token', 64);
            $table->text('abilities')->nullable();
            $table->datetime('last_used_at')->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
}