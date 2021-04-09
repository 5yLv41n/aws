<?php

namespace AsyncAws\Athena\Tests\Integration;

use AsyncAws\Athena\AthenaClient;
use AsyncAws\Athena\Input\GetQueryExecutionInput;
use AsyncAws\Athena\Input\StartQueryExecutionInput;
use AsyncAws\Athena\ValueObject\EncryptionConfiguration;
use AsyncAws\Athena\ValueObject\QueryExecutionContext;
use AsyncAws\Athena\ValueObject\ResultConfiguration;
use AsyncAws\Core\Credentials\NullProvider;
use AsyncAws\Core\Test\TestCase;

class AthenaClientTest extends TestCase
{
/*    public function testGetQueryExecution(): void
    {
        $client = $this->getClient();

        $input = new GetQueryExecutionInput([
            'QueryExecutionId' => 'foobar',
        ]);
        $result = $client->GetQueryExecution($input);

        $result->resolve();
dd($result->getQueryExecution()->getQueryExecutionId());
        self::assertTODO('QUEUED', $result->getQueryExecution()->getStatus());
    }*/

    public function testStartQueryExecution(): void
    {
        $client = $this->getClient();

        $input = new StartQueryExecutionInput([
            'QueryString' => 'SELECT field FROM table LIMIT 1',
            'ClientRequestToken' => 'token',
            'QueryExecutionContext' => new QueryExecutionContext([
                'Database' => 'db',
                'Catalog' => 'catalog',
            ]),
            'ResultConfiguration' => new ResultConfiguration([
                'OutputLocation' => 's3://bucket',
            ]),
        ]);
        $result = $client->StartQueryExecution($input);

        $result->resolve();

        self::assertSame('changeIt', $result->getQueryExecutionId());
    }

    private function getClient(): AthenaClient
    {
        return new AthenaClient([
            'endpoint' => 'http://localhost:4576',
        ], new NullProvider());
    }
}
