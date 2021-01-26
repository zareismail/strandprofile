<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStrandprofileReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('strandprofile_references', function (Blueprint $table) { 
            $table->renameColumn('tenancy_date', 'started_at');
            $table->datetime('finished_in')->default(now()); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('strandprofile_references', function (Blueprint $table) { 
            $table->renameColumn('started_at', 'tenancy_date');
            $table->dropColumn('finished_in'); 
        });
    }
}
