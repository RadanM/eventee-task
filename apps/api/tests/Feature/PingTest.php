<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class PingTest extends TestCase
{

	public function testPingReturnsPong(): void
	{
		$response = $this->get('/api/ping');

		$response->assertStatus(200);
		$response->assertContent('pong');
	}

}
