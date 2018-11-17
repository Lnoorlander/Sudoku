<?php

namespace Model;

class Puzzle
{
	private $rowsWithColumns;
	private $solved;

	public function __construct(array $rowsWithColumns)
	{
		$this->rowsWithColumns = $rowsWithColumns;
		$this->solved = false;
	}

	public function fillOut(): void
	{
		do {
			$canFill = false;

			foreach ($this->rowsWithColumns as $rowIndex => $row) {
				foreach ($row as $columnIndex => $column) {
					if ($column === 0) {
						$possibleSolutions = $this->possibleSolutionsForField($rowIndex, $columnIndex);

						if (\count($possibleSolutions) === 1) {
							$this->rowsWithColumns[$rowIndex][$columnIndex] = $possibleSolutions[0];

							$canFill = true;
						}
					}
				}
			}
		} while ($canFill);

		$this->setSolved();
	}

	public function createAlternatives(): array
	{
		$alternatives = array();

		foreach ($this->rowsWithColumns as $rowIndex => $row) {
			foreach ($row as $columnIndex => $column) {
				if ($column === 0) {
					$possibleSolutions = $this->possibleSolutionsForField($rowIndex, $columnIndex);

					if (\count($possibleSolutions) > 1) {
						foreach ($possibleSolutions as $possibleSolution) {
							$this->rowsWithColumns[$rowIndex][$columnIndex] = $possibleSolution;

							$alternatives[] = new Puzzle($this->rowsWithColumns);

							$this->rowsWithColumns[$rowIndex][$columnIndex] = 0;
						}
					}
				}
			}
		}

		return $alternatives;
	}

	public function identifier(): string
	{
		$identifier = '';

		foreach ($this->rowsWithColumns as $row) {
			foreach ($row as $column) {
				$identifier .= $column;
			}
		}

		return $identifier;
	}

	private function possibleSolutionsForField(int $fieldRow, int $fieldColumn): array
	{
		$numbers = array_unique(
			array_merge(
				$this->numbersInRow($fieldRow),
				$this->numbersInColumn($fieldColumn),
				$this->numbersInBlock($fieldRow, $fieldColumn)
			)
		);

		return array_values(array_diff([1, 2, 3, 4, 5, 6, 7, 8, 9], $numbers));
	}

	private function numbersInRow(int $fieldRow): array
	{
		$numbers = array();

		for ($i = 0; $i < 9; $i++) {
			$number = $this->rowsWithColumns[$fieldRow][$i];

			if ($number !== 0) {
				$numbers[] = $number;
			}
		}

		return array_values(array_unique($numbers));
	}

	private function numbersInColumn(int $fieldColumn): array
	{
		$numbers = array();

		for ($i = 0; $i < 9; $i++) {
			$number = $this->rowsWithColumns[$i][$fieldColumn];

			if ($number !== 0) {
				$numbers[] = $number;
			}
		}

		return array_values(array_unique($numbers));
	}

	private function numbersInBlock(int $fieldRow, int $fieldColumn): array
	{
		$numbers = array();

		$rows = $this->blockIndexes($fieldRow);
		$columns = $this->blockIndexes($fieldColumn);

		foreach ($rows as $row) {
			foreach ($columns as $column) {
				$number = $this->rowsWithColumns[$row][$column];

				if ($number !== 0) {
					$numbers[] = $number;
				}
			}
		}

		return array_values(array_unique($numbers));
	}

	private function blockIndexes(int $input): array
	{
		$offset = $input % 3;

		switch ($offset) {
			case 0:
				return [$input, $input + 1, $input + 2];
			case 1:
				return [$input - 1, $input, $input + 1];
			case 2:
				return [$input - 2, $input - 1, $input];
			default:
				return [];
		}
	}

	private function setSolved(): void
	{
		$solved = true;

		foreach ($this->rowsWithColumns as $row) {
			foreach ($row as $column) {
				if ($column === 0) {
					$solved = false;
				}
			}
		}

		$this->solved = $solved;
	}

	public function getRowsWithColumns(): array
	{
		return $this->rowsWithColumns;
	}

	public function getSolved(): bool
	{
		return $this->solved;
	}
}