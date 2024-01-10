<?php

declare(strict_types=1);

namespace JHynek\KnightTrack;

/**
 * Representation of a chessboard field.
 */
class Field
{

	/** @const int */
	private const CHESSBOARD_MAX_DIMENSION = 8;

	/**
	 * @throw \InvalidArgumentException When invalid coordinates are given
	 */
	public function __construct(
		public readonly int $x,
		public readonly int $y,
	)
	{
		if (!$this->isValid()) {
			throw new \InvalidArgumentException('Invalid field coordinates: ' . $this);
		}
	}

	public function __toString(): string
	{
		return "[$this->x, $this->y]";
	}

	/** Checks if field is in chessboard bounds */
	private function isValid(): bool
	{
		return $this->x >= 1 && $this->x <= self::CHESSBOARD_MAX_DIMENSION
			&& $this->y >= 1 && $this->y <= self::CHESSBOARD_MAX_DIMENSION;
	}
}
