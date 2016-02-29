<?php

class CommentTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'name' => 'Frederik Mazur Andersen',
            'email' => 'mazurandersen@gmail.com',
            'password' => "sifmaster",
            'role' => "QuizMaster"
        ));

        Comment::create(array(
            'name' => 'Sif Dummy',
            'email' => 'sif@sdu.com',
            'password' => "sif",
            'role' => "QuizMaster"
        ));
    }

}