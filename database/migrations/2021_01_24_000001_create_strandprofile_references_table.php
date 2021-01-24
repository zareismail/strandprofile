<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrandprofileReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strandprofile_references', function (Blueprint $table) {
            $table->id();
            $table->string('landlord');
            $table->string('email');
            $table->text('address')->nullable();
            $table->integer('apartment');
            $table->datetime('tenancy_date');
            $table->auth();  
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strandprofile_references');
    }
}
