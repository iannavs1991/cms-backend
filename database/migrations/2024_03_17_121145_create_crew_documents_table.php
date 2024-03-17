<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrewDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crew_id');
            $table->foreignId('document_id');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->foreignId('uploaded_by');
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
        Schema::dropIfExists('crew_documents');
    }
}
