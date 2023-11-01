<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetNumberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-number-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $filePath = storage_path('api_responses.txt');
        $range = 9999; // Generate all 3-6 digit numbers
        //7567
        while ($range >= 100) {
            usleep(300000);
            $this->info('Number: ' . $range);
            $url = "https://eshop-api.banglalink.net/wp-json/eshop/v1/product?series=019&number=$range&page=1&per_page=9";
            $response = $client->get($url);
            $range--;

            $contents = json_decode($response->getBody()->getContents(), true);

            if (isset($contents['data']['items']) && is_array($contents['data']['items'])) {
                $numbers = array_column($contents['data']['items'], 'number');
            }

            $this->info('Items: ' . implode(', ', $numbers ?? array()));

            // Check if the response is valid
            if ($contents['code'] == 200 && !empty($numbers)) {
                file_put_contents($filePath, implode("\n", $numbers ?? array()) . PHP_EOL, FILE_APPEND);
            }
        }

        $this->info('API calls and responses saved to ' . $filePath);

        return 0;
    }
}
