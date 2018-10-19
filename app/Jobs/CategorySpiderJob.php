<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\SpiderService\CategorySpider;
use Illuminate\Support\Facades\Log;

class CategorySpiderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected  $params;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ( new CategorySpider())->do($this->params);
        return true;

    }
    /*
    //失败处理
    public static function failed(Exception $exception)
    {
        // 给用户发送失败通知，等等...
    }
    */
}
