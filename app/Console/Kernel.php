<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Feeds;
use Log;
use Cache;
use Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function (){
            $feed = Feeds::make('https://www.winespectator.com/rss/rss?t=dwp');
            
            Cache::flush();
            $arr = [];
            
            foreach($feed->get_items()as $item){
                $date =  Carbon::parse($item->get_date())->startOfDay();
                if($date->eq(Carbon::today())){
                    Log::debug($item->get_title());
                    
                    $data = [
                        'title' => $item->get_title(),
                        'pubDate' => $item->get_date(),
                        'description' => $item->get_description(),
                        'link' => $item->get_link(),
                        'category' => $item->get_category(),
                        'author' => $item->get_author()
                    ];

                    $arr[] = $item->get_title();
                    
                    Cache::put($item->get_title(), $data , now()->addDays(1));
                    Log::debug($item->get_title());
                } 
            };

            Cache::put('available_wines', $arr, now()->addDays(1));
            Log::debug(count($feed->get_items()));
        
        })->dailyAt('6:00'); //everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
