<?php

namespace App\Console\Commands;

use App\Models\MoPost;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PostStatusUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update post status command after 2 weeks';

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
        $twoWeeksAgo = Carbon::now()->subWeeks(2);

        $postsToHide = MoPost::where('status', true)
            ->where('created_at', '<', $twoWeeksAgo)
            ->get();

        foreach ($postsToHide as $post) {
            $post->update(['status' => 1]);
            $poster = $post->user;
            NotificationUserJob::dispatch(
                $poster->user_id,
                "Bài đăng bị ẩn",
                'Tin đăng của bạn đã bị ẩn, nếu phòng vẫn chưa được cho thuê thì hãy hiển thị lại tin đăng nha.',
                TypeFCM::POST_CANCEL,
                NotiUserDefineCode::USER_NORMAL,
                $post->id,
            );
        }

        $threeWeeks = Carbon::now()->subWeeks(3);

        $postsToHide = MoPost::where('status', true)
            ->where('created_at', '<', $threeWeeks)
            ->get();

        foreach ($postsToHide as $post) {

            // Send notification to the poster
            $poster = $post->user; // Assuming a user relationship on the Post model
            NotificationUserJob::dispatch(
                $poster->user_id,
                "Bài đăng bị ẩn",
                'Tin đăng của bạn đã bị ẩn, nếu phòng vẫn chưa được cho thuê thì hãy hiển thị lại tin đăng nha.',
                TypeFCM::POST_CANCEL,
                NotiUserDefineCode::USER_NORMAL,
                $post->id,
            );
            $post->update(['status' => 0]);
        }
    }
}