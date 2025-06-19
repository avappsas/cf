<?php
// database/migrations/2023_01_01_000019_create_oauth_refresh_tokens_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthRefreshTokensTable extends Migration
{
    public function up()
    {
        Schema::create('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('access_token_id', 100);
            $table->boolean('revoked');
            $table->datetime('expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('oauth_refresh_tokens');
    }
}