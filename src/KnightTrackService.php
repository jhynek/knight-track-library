<?php

declare(strict_types=1);

namespace JHynek\KnightTrack;

class KnightTrackService
{

	/** @const int[][] */
	private const POSSIBLE_MOVES = [
		[-2, -1], [-2, 1],
		[-1, -2], [-1, 2],
		[1, -2], [1, 2],
		[2, -1], [2, 1],
	];

	/**
	 * @return Field[]
	 */
	public function findShortestTrack(Field $start, Field $target): array
	{
		$queue = new \SplQueue();
		$visited = [];
		$parents = [];

		// init queue with starting field
		$queue->enqueue($start);
		$visited[$start->x][$start->y] = true;
		$parents[$start->x][$start->y] = null;

		while (!$queue->isEmpty()) {
			/** @var Field $current */
			$current = $queue->dequeue();
			if (!($current instanceof Field)){
				throw new \RuntimeException('This should never happend exception');
			}

			// we found the target field, reconstruct path from target to start
			if ($this->isSameField($current, $target)) {
				return $this->reconstructPath($current, $parents);
			}

			// try all possible moves
			foreach (self::POSSIBLE_MOVES as $move) {
				try {
					$next = new Field($current->x + $move[0], $current->y + $move[1]);
				} catch (\InvalidArgumentException $e) {
					// field is out of chessboard bounds, pass it
					continue;
				}

				// if field is not visited, enqueue it and mark as visited
				if (!isset($visited[$next->x][$next->y])) {
					$queue->enqueue($next);
					$visited[$next->x][$next->y] = true;
					$parents[$next->x][$next->y] = $current;
				}
			}
		}

		// fail-safe, path not found
		return [];
	}

	private function isSameField(Field $a, Field $b): bool
	{
		return $a->x === $b->x && $a->y === $b->y;
	}

	/**
	 * @param array<int, array<int, Field|null>> $parents
	 * @return Field[]
	 */
	private function reconstructPath(Field $current, array $parents): array
	{
		$path = [];
		while ($current) {
			$path[] = $current;
			$current = $parents[$current->x][$current->y] ?? null;
		}
		// reverse for correct order
		return array_reverse($path);
	}
}
