<?php

namespace App\Console\Commands;

use App\Jobs\SendPostEmail;
use App\Listeners\SendSubscribedMail;
use App\Mail\PostPublishedMessage;
use App\Models\Subscription;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:latest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the latest post to all subscribers';

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
     * @return int
     */
    public function handle()
    {
        $subs = Subscription::all();

        foreach ($subs as $sub)
        {
            $post = $sub->website->posts->last();

            try {
                Mail::to($sub->user->email)->send(new PostPublishedMessage($sub->user, $post));
            }
            catch (Exception $e){
                echo "Cannot send email to " . $sub->user->email . " Error : ". $e->getMessage(). "\n";
            }
        }
        return 0;
    }
}
