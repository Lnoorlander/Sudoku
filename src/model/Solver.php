<?php

namespace Model;

class Solver
{
	private $originalPuzzle;
	private $alternativePuzzles;
	private $solutions;
	private $filledPuzzles;

	public function __construct(Puzzle $puzzle)
	{
		$this->originalPuzzle = $puzzle;
		$this->alternativePuzzles = [];
		$this->solutions = [];
		$this->filledPuzzles = [];
	}

	public function solve(): void
	{
		$this->originalPuzzle->fillOut();
		$this->filledPuzzles[] = $this->originalPuzzle->getIdentifier();

		if ($this->originalPuzzle->getSolved()) {
			$this->solutions[$this->originalPuzzle->solvedIdentifier()] = $this->originalPuzzle;
		} else {
			$alternativePuzzles = $this->originalPuzzle->createAlternatives();

			foreach ($alternativePuzzles as $alternativePuzzle) {
				if (!isset($this->filledPuzzles[$alternativePuzzle->getIdentifier()])) {
					$this->alternativePuzzles[$alternativePuzzle->getIdentifier()] = $alternativePuzzle;
				}
			}
		}

		$this->solveAlternativePuzzles();
	}

	private function solveAlternativePuzzles(): void
	{
		while (\count($this->alternativePuzzles) !== 0) {
			foreach ($this->alternativePuzzles as $identifier => $alternativePuzzle) {
				$this->filledPuzzles[] = $alternativePuzzle->getIdentifier();

				if ($alternativePuzzle->fillOut()) {

					if ($alternativePuzzle->getSolved()) {
						$this->solutions[$alternativePuzzle->solvedIdentifier()] = $alternativePuzzle;
					} else {
						$alternativePuzzles = $alternativePuzzle->createAlternatives();

						foreach ($alternativePuzzles as $newAlternativePuzzle) {
							if (!isset($this->filledPuzzles[$newAlternativePuzzle->getIdentifier()])) {
								$this->alternativePuzzles[$newAlternativePuzzle->getIdentifier()] = $newAlternativePuzzle;
							}
						}
					}
				}

				unset($this->alternativePuzzles[$identifier]);
			}
		}
	}

	public function getSolutions(): array
	{
		return array_values($this->solutions);
	}
}