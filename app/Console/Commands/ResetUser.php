<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Utils\Helper;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetUser extends Command
{
    protected $builder;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Đặt lại tất cả thông tin người dùng';

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
        if (!$this->confirm("Bạn có chắc chắn muốn đặt lại tất cả thông tin bảo mật của người dùng không?")) {
            return;
        }
        ini_set('memory_limit', -1);
        $users = User::all();
        foreach ($users as $user)
        {
            $user->token = Helper::guid();
            $user->uuid = Helper::guid(true);
            $user->save();
            $this->info("Thông tin bảo mật cho người dùng {$user->email} đã được đặt lại");
        }
    }
}
