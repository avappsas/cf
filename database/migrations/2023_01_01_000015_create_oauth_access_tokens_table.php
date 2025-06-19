<?php
// database/migrations/2023_01_01_000015_create_oauth_access_tokens_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthAccessTokensTable extends Migration
{
    public function up()
    {
        Schema::create('oauth_access_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('client_id');
            $table->string('name', 255)->nullable();
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->datetime('expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('oauth_access_tokens');
    }
}