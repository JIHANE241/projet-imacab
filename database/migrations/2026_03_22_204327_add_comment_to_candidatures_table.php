<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
public function up()
{
    Schema::table('candidatures', function (Blueprint $table) {
        $table->text('comment')->nullable()->after('statut');
        $table->timestamp('comment_updated_at')->nullable()->after('comment');
    });
}

public function down()
{
    Schema::table('candidatures', function (Blueprint $table) {
        $table->dropColumn(['comment', 'comment_updated_at']);
    });
}
};
