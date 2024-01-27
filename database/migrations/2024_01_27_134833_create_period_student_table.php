<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodStudentTable extends Migration
{
    public function up()
    {
        Schema::create('period_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('period_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedInteger('grade')->nullable()->default(null);
            $table->foreign('period_id')->references('id')->on('periods')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('period_student');
    }
}
