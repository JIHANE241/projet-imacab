<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE candidatures MODIFY statut ENUM('en_attente', 'en_revision', 'evalue', 'acceptee', 'refusee') NOT NULL DEFAULT 'en_attente'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE candidatures MODIFY statut ENUM('en_attente', 'en_revision', 'acceptee', 'refusee') NOT NULL DEFAULT 'en_attente'");
    }
};
