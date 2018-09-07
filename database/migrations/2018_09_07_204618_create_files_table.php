<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('print_job_id')->unsigned();
            $table->string('original_filename')->nullable();
            $table->string('filename')->nullable();
            $table->timestamps();

            $table->foreign('print_job_id')
                ->references('id')
                ->on('print_jobs')
                ->onDelete('cascade');
        });

        $printjobs = \App\Models\PrintJob::all();
        foreach($printjobs as $printjob){
            $file = new \App\Models\File([
                'filename' => $printjob->filename,
                'original_filename' => $printjob->original_filename,
            ]);
            $printjob->files()->save($file);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
