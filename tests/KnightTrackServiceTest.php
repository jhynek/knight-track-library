<?php

declare(strict_types=1);

namespace JHynek\KnightTrack\Tests;

use JHynek\KnightTrack\Field;
use JHynek\KnightTrack\KnightTrackService;
use PHPUnit\Framework\TestCase;

class KnightTrackServiceTest extends TestCase
{

	/**
	 * @dataProvider dpTestShortestTrack
	 * @param array<int, array<int, int>> $result
	 */
	public function testFindShortestTrack(Field $start, Field $target, array $result): void
	{
		$service = new KnightTrackService();
		$track = $service->findShortestTrack($start, $target);
		$this->assertNotEmpty($track);
		foreach ($track as $i => $field) {
			$this->assertEquals($result[$i][0], $field->x);
			$this->assertEquals($result[$i][1], $field->y);
		}
	}

	/**
	 * @return array<int, array<int, array<int, array<int, int>>|Field>>
	 */
	public static function dpTestShortestTrack(): array
	{
		return [
			[new Field(1, 1), new Field(1,1), [[1,1]]],
			[new Field(1, 1), new Field(4,8), [[1,1], [2,3], [1,5], [2,7], [4,8]]],
			[new Field(3, 6), new Field(8,7), [[3,6], [2,4], [4,5], [6,6], [8,7]]],
			[new Field(8, 8), new Field(1,1), [[8,8], [6,7], [4,6], [2,5], [1,3], [3,2], [1,1]]],
		];
	}

}
