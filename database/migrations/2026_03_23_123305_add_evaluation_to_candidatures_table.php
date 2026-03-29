<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->enum('evaluation', ['favorable', 'defavorable'])->nullable()->after('statut');
            $table->text('evaluation_comment')->nullable()->after('evaluation');
            $table->timestamp('evaluated_at')->nullable()->after('evaluation_comment');
        });
    }

    public function down()
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropColumn(['evaluation', 'evaluation_comment', 'evaluated_at']);
        });
    }
};