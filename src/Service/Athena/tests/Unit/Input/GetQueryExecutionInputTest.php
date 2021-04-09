<?php

namespace AsyncAws\Athena\Tests\Unit\Input;

use AsyncAws\Athena\Input\GetQueryExecutionInput;
use AsyncAws\Core\Test\TestCase;

class GetQueryExecutionInputTest extends TestCase
{
    public function testRequest(): void
    {
        $input = new GetQueryExecutionInput([
            'QueryExecutionId' => 'foobar',
        ]);

        // see https://docs.aws.amazon.com/athena/latest/APIReference/Welcome.html/API_GetQueryExecution.html
        $expected = '
            POST / HTTP/1.0
            Content-Type: application/x-amz-json-1.1
            x-amz-target: AmazonAthena.GetQueryExecution

            {
            "QueryExecutionId": "foobar"
        }
                ';

        self::assertRequestEqualsHttpRequest($expected, $input->request());
    }
}
