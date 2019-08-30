<?php

namespace Webup\LaravelPush\Jobs\Push;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Validator;
use Webup\LaravelPush\Entities\Push;
use Webup\LaravelPush\Repositories\PushRepository;
use Illuminate\Validation\ValidationException;

class RemoveToken
{
    use Dispatchable, Queueable;

    private $uuid;
    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $uuid, array $data)
    {
        $this->uuid = $uuid;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PushRepository $pushRepo)
    {
        $validator = $this->getValidator($this->data);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $validator->getData();
        $pushToken = new Push($this->uuid, $data['token'], $data['platform'], "");

        $pushRepo->remove($pushToken);
    }

    private function getValidator(array $data)
    {
        $validator = Validator::make($data, [
            'token' => 'required',
            'platform' => 'required|integer|in:1,2'
        ]);

        return $validator;
    }
}
