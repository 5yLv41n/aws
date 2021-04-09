<?php

namespace AsyncAws\Athena\Tests\Unit\Input;

use AsyncAws\Athena\Input\StartQueryExecutionInput;
use AsyncAws\Athena\ValueObject\EncryptionConfiguration;
use AsyncAws\Athena\ValueObject\QueryExecutionContext;
use AsyncAws\Athena\ValueObject\ResultConfiguration;
use AsyncAws\Core\Test\TestCase;

class StartQueryExecutionInputTest extends TestCase
{
    public function testRequest(): void
    {
        $input = new StartQueryExecutionInput([
            'QueryString' => 'SELECT field FROM table LIMIT 1',
            'ClientRequestToken' => 'token',
            'QueryExecutionContext' => new QueryExecutionContext([
                'Database' => 'db',
                'Catalog' => 'aws_catalog',
            ]),
            'ResultConfiguration' => new ResultConfiguration([
                'OutputLocation' => 's3://bucket',
            ]),
        ]);

        // see https://docs.aws.amazon.com/athena/latest/APIReference/Welcome.html/API_StartQueryExecution.html
        $expected = '
            POST / HTTP/1.0
            Content-Type: application/x-amz-json-1.1
            x-amz-target: AmazonAthena.StartQueryExecution

            {"QueryString":"SELECT field FROM table LIMIT 1","ClientRequestToken":"token","QueryExecutionContext":{"Database":"db","Catalog":"aws_catalog"},"ResultConfiguration":{"OutputLocation":"s3:\/\/bucket"}}
                ';

        self::assertRequestEqualsHttpRequest($expected, $input->request());
    }
}
