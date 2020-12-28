<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrandprofileReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strandprofile_reports', function (Blueprint $table) {
            $table->id();
            $table->slugging('name');
            $table->auth(); 
            $table->string('group')->default(\Zareismail\Strandprofile\Nova\Acount::class); 
            $table->timestamp('date')->nullable(); 
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
        Schema::dropIfExists('strandprofile_reports');
    }
}
