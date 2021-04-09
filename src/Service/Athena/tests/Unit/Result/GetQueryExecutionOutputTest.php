<?php

namespace AsyncAws\Athena\Tests\Unit\Result;

use AsyncAws\Athena\Result\GetQueryExecutionOutput;
use AsyncAws\Core\Response;
use AsyncAws\Core\Test\Http\SimpleMockedResponse;
use AsyncAws\Core\Test\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\MockHttpClient;

class GetQueryExecutionOutputTest extends TestCase
{
    public function testGetQueryExecutionOutput(): void
    {
        // see https://docs.aws.amazon.com/athena/latest/APIReference/API_GetQueryExecution.html
        $content = [
            'QueryExecution' => [
                'Status' => [
                    'State' => 'QUEUED',
                ],
            ],
        ];
        $response = new SimpleMockedResponse(json_encode($content));

        $client = new MockHttpClient($response);
        $result = new GetQueryExecutionOutput(new Response($client->request('POST', 'http://localhost'), $client, new NullLogger()));

        self::assertSame('QUEUED', $result->getQueryExecution()->getStatus()->getState());
    }
}
