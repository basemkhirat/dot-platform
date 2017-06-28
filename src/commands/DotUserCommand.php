<?php

use Symfony\Component\Console\Input\InputOption;

/**
 * Class DotUserCommand
 */
class DotUserCommand extends Dot\Command
{

    /**
     * @var string
     */
    protected $name = 'dot:user';

    /**
     * @var string
     */
    protected $description = "Create a new user";


    /**
     * @return bool
     */
    public function fire()
    {

        if ($this->option("root")) {
            $user = User::root()->first();
        }else {
            $user = new User();
        }

        $this->info("\n");

        $this->info("Creating User account:");

        $username = $this->ask("Username", $user->username);
        $password = $this->secret("Password");
        $email = $this->ask("Email", $user->email);
        $name = $this->ask("Full name", $user->first_name);

        $user->username = $username;
        $user->password = $password;
        $user->email = $email;
        $user->repassword = $password;
        $user->first_name = $name;
        $user->api_token = $user->newApiToken();

        if(!$user->validate()){

            foreach ($user->errors()->all() as $error){
                $this->error($error);
            }

            if(count($user->errors()->all())){
                $this->fire();
            }

        }

        if ($this->option("root")) {
            $user->root = 1;
            $user->role_id = Role::superadmin()->first()->id;
        }else{
            $user->role_id = $this->getRoleID();
        }

        $user->backend = 1;
        $user->status = 1;

        $user->save();

        return $this->info("Saved!");

    }

    function getRoleID()
    {

        $this->info("System roles:");

        $roles = Role::all();

        $index = 1;
        foreach ($roles as $role) {
            $this->info("[$index] $role->name");
            $index++;
        }

        $index = $this->ask("Select role for this user");

        if (isset($roles[$index-1])) {
            return $roles[$index-1]->id;
        }

        $this->error("Invalid user role selected");

        $this->info("\n");

        return $this->getRoleID();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['root', null, InputOption::VALUE_NONE, 'Create a root user', null],
        ];
    }

}
