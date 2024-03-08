<?php

class App
{
    private string $id;

    private int $nbRequests = 0;

    public function __construct()
    {
        $this->id = uniqid();
        error_log(date('Y-m-d H:i:s') . " - {$this->id} - starting app");
    }

    public function handle(
        array $get,
        array $post,
        array $cookie,
        array $files,
        array $server,
    ): string {
        error_log(date('Y-m-d H:i:s') . " - {$this->id} - processing request...");
        error_log(date('Y-m-d H:i:s') . " - {$this->id} - SERVER :");
        error_log(var_export($_SERVER, true));

        $rand = rand(1, 3) + rand(0, 1) + rand(2, 5) + rand(0, 3);

        error_log(date('Y-m-d H:i:s') . " - {$this->id} - process will run during {$rand} seconds");
        sleep($rand);

        return "Request successfully processed";
    }

    public function terminate(): void
    {
        $this->nbRequests++;
        error_log(date('Y-m-d H:i:s') . " - {$this->id} - {$this->nbRequests} requests processed");
    }

    public function shutdown(): void
    {
        error_log(date('Y-m-d H:i:s') . " - {$this->id} - ending app");
    }

    public function getAppId(): string
    {
        return $this->id;
    }
}
