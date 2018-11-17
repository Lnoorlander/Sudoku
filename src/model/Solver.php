<?php

namespace Model;

class Solver
{
	private $originalPuzzle;
	private $alternativePuzzles;
	private $solutions;

	public function __construct(Puzzle $puzzle)
	{
		$this->originalPuzzle = $puzzle;
		$this->alternativePuzzles = [];
		$this->solutions = [];
	}

	public function solve(): void
	{
		$this->originalPuzzle->fillOut();

		if ($this->originalPuzzle->getSolved()) {
			$this->solutions[] = $this->originalPuzzle;
		} else {
			$alternativePuzzles = $this->originalPuzzle->createAlternatives();

			foreach ($alternativePuzzles as $alternativePuzzle) {
				$this->alternativePuzzles[$alternativePuzzle->identifier()] = $alternativePuzzle;
			}
		}

		$this->solveAlternativePuzzle();
	}

	private function solveAlternativePuzzle(): void
	{
		while (\count($this->alternativePuzzles) !== 0) {
			foreach ($this->alternativePuzzles as $identifier => $alternativePuzzle) {
				$alternativePuzzle->fillOut();

				if ($alternativePuzzle->getSolved()) {
					$this->solutions[] = $alternativePuzzle;
				} else {
					$this->alternativePuzzles = array_merge($this->alternativePuzzles, $alternativePuzzle->createAlternatives());
				}

				unset($this->alternativePuzzles[$identifier]);
			}
		}
	}

	public function getSolutions(): array
	{
		return $this->solutions;
	}
}