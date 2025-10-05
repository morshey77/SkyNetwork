<?php

namespace skynetwork\game\managers\game\traits;

trait Points
{

    /** @var array<string|int, int> $points */
    protected array $points = [];

	protected int $winPoints = 0;

    /**
     * @return int[]
     *
     * @noinspection PhpUnused
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * @param string|int $key
     * @return int
     */
    public function getPoint(string|int $key): int
    {
        return $this->points[$key] ?? 0;
    }

    /**
     * @param string|int $key
     * @param int $point
     */
    public function setPoint(string|int $key, int $point): void
    {
        $this->points[$key] = $point;
    }

    /**
     * @param string|int $key
     * @param int $point
     * @return void
     */
    public function addPoint(string|int $key, int $point = 1): void
    {
        $this->setPoint($key, $this->getPoint($key) + $point);
    }

    /**
     * @param string|int $key
     * @param int $point
     * @return void
     */
    public function removePoint(string|int $key, int $point = 1): void
    {
        $this->setPoint($key, $this->getPoint($key) > $point ? $this->getPoint($key) - $point : 0);
    }

	public function getWinPoints(): int
	{
		return $this->winPoints;
	}

	public function setWinPoints(int $winPoints): void
	{
		$this->winPoints = $winPoints;
	}
}