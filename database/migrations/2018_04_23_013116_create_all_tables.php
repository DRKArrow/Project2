<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbladmins', function(Blueprint $table)
		{
			$table->string('admin_name',30);
			$table->string('admin_email',50)->primary();
			$table->string('admin_pass',100);
		});

		Schema::create('tblsales', function(Blueprint $table)
		{
			$table->increments('sale_id');
			$table->string('sale_avatar')->default('images/user.png');
			$table->string('sale_name',30);
			$table->string('sale_email',50)->unique();
			$table->string('sale_pass',100);
			$table->string('sale_phone',15);
		});

		Schema::create('tblmajors', function(Blueprint $table)
		{
			$table->increments('major_id');
			$table->string('major_name',30);
		});

		Schema::create('tblcourses', function(Blueprint $table)
		{
			$table->increments('course_id');
			$table->string('course_name',36);
			$table->integer('major_id')->unsigned();
			$table->foreign('major_id')->references('major_id')->on('tblmajors');
		});

		Schema::create('tblschedules', function(Blueprint $table)
		{
			$table->increments('schedule_id');
			$table->string('schedule_name',50);
			$table->time('schedule_start');
			$table->time('schedule_end');
		});
		
		Schema::create('tblclasses', function(Blueprint $table)
		{
			$table->increments('class_id');
			$table->string('class_name',60);
			$table->date('class_startdate');
			$table->boolean('check')->default('0');
			$table->integer('course_id')->unsigned();
			$table->integer('schedule_id')->unsigned();
			$table->unique(['course_id','schedule_id']);
			$table->foreign('course_id')->references('course_id')->on('tblcourses');
			$table->foreign('schedule_id')->references('schedule_id')->on('tblschedules');
		});

		Schema::create('tblstudents', function(Blueprint $table)
		{
			$table->increments('student_id');
			$table->string('student_name');
			$table->string('student_phone',15)->unique();
			$table->string('student_email',50)->unique();
			$table->integer('sale_id')->unsigned();
			$table->foreign('sale_id')->references('sale_id')->on('tblsales');
		});

		Schema::create('tblinterest', function(Blueprint $table)
		{
			$table->integer('student_id')->unsigned();
			$table->string('interest',10);
			$table->unique(['student_id','interest']);
			$table->foreign('student_id')->references('student_id')->on('tblstudents');
		});

		Schema::create('tblclass_detail', function(Blueprint $table)
		{
			$table->integer('class_id')->unsigned();
			$table->integer('student_id')->unsigned();
			$table->primary(['class_id','student_id']);
			$table->foreign('class_id')->references('class_id')->on('tblclasses');
			$table->foreign('student_id')->references('student_id')->on('tblstudents');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbladmins');
		Schema::drop('tblsales');
		Schema::drop('tblmajors');
		Schema::drop('tblcourses');
		Schema::drop('tblclasses');
		Schema::drop('tblschedules');
		Schema::drop('tblstudents');
		Schema::drop('tblinterest');
		Schema::drop('tblclass_detail');
	}

}
