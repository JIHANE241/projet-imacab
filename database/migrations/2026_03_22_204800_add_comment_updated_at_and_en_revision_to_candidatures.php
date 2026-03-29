<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        
        if (!Schema::hasColumn('candidatures', 'comment_updated_at')) {
            Schema::table('candidatures', function (Blueprint $table) {
                $table->timestamp('comment_updated_at')->nullable()->after('commentaire_rd');
            });
        }

        
        DB::statement("ALTER TABLE candidatures MODIFY statut ENUM('en_attente', 'en_revision', 'acceptee', 'refusee') NOT NULL DEFAULT 'en_attente'");
    }

    public function down()
    {
        
        if (Schema::hasColumn('candidatures', 'comment_updated_at')) {
            Schema::table('candidatures', function (Blueprint $table) {
                $table->dropColumn('comment_updated_at');
            });
        }

       
        DB::statement("ALTER TABLE candidatures MODIFY statut ENUM('en_attente', 'acceptee', 'refusee') NOT NULL DEFAULT 'en_attente'");
    }
};