<?php
// database/migrations/2023_01_01_000016_create_oauth_auth_codes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthAuthCodesTable extends Migration
{
    public function up()
    {
        Schema::create('oauth_auth_codes', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->bigInteger('user_id');
            $table->bigInteger('client_id');
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->datetime('expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('oauth_auth_codes');
    }
}