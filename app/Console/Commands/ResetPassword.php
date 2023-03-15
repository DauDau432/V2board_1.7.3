<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Utils\Helper;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetPassword extends Command
{
    protected $builder;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:password {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'đặt lại mật khẩu người dùng';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::where('email', $this->argument('email'))->first();
        if (!$user) abort(500, 'hộp thư không tồn tại');
        $password = Helper::guid(false);
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->password_algo = null;
        if (!$user->save()) abort(500, 'Đặt lại không thành công');
        $this->info("!!!thiết lập lại thành công!!!");
        $this->info("Mật khẩu mới là:{$password}, vui lòng thay đổi mật khẩu càng sớm càng tốt.");
    }
}
