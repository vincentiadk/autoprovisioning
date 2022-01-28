<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Traits\Authorization;
use GuzzleHttp\Client;
use App\Models\User;
use App\Models\MetroList;

class CheckTask extends Command
{
    use Authorization;
    protected $signature = 'check:task';
    protected $description = 'Command description';
    private $url;
    private $client;
    public $token;
    public $header;

    public function __construct()
    {
        parent::__construct();
        $this->url = config('metro.url');
        $this->client = new Client(["base_uri" => $this->url, "http_errors" => false, 'verify' => false]);
        $this->token = $this->getToken(null, User::find(session('id')));
        $this->header = $this->getHeader($this->token);
    }

    public function handle()
    {
        $user = User::find(1);
        try {
            $listTasks = MetroList::where('status', '!=', 'closed')
            //->where('status', '!=', 'submitted')
            ->get();
            foreach($listTasks as $task) {
                $token = $this->getToken(null, $user);
                $header = $this->getHeader($token);
                $response = $this->client->get("/network/v1/tasks/" . $task->task_id, $header);
                $result = json_decode($response->getBody()->getContents(), true);
                if($response->getStatusCode() == 200){
                    $task->update([
                        'status' => $result["status"]
                    ]);
                }
                \Log::info($result);
            }
        } catch (\Exception $e) {
            return false;
        }
        return 0;
    }  
}