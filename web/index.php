<?php

use Model\Puzzle;
use Model\Solver;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * INSERT A VALID UNSOLVED SUDOKU PUZZLE
 */
$puzzle = [
	[0, 0, 2, 1, 4, 0, 9, 0, 0],
	[1, 4, 0, 9, 0, 8, 3, 5, 2],
	[0, 0, 0, 0, 5, 2, 1, 4, 0],
	[0, 3, 0, 0, 0, 4, 0, 8, 9],
	[2, 7, 0, 6, 0, 0, 5, 0, 1],
	[0, 8, 9, 0, 0, 1, 0, 7, 0],
	[4, 0, 0, 7, 1, 5, 0, 0, 0],
	[0, 0, 5, 0, 9, 0, 0, 2, 3],
	[0, 0, 6, 4, 0, 0, 7, 0, 0]
];

$solver = new Solver(new Puzzle($puzzle));

$solver->solve();

foreach ($solver->getSolutions() as $index => $solution) {
	echo '<h2>Solution ' . $index . ':</h2>';
	echo '<table style="border-collapse: collapse; border: 1px solid black; font-size: 25px">';
	foreach ($solution->getRowsWithColumns() as $rowIndex => $row) {
		echo '<tr style="border: 1px solid black;">';
		foreach ($row as $columnIndex => $column) {
			if ($puzzle[$rowIndex][$columnIndex] === $column) {
				echo '<td style="border: 1px solid black; color: black; width: 25px; height: 25px; text-align: center; vertical-align: middle; line-height: 25px;">' . $column . '</td>';
			} else {
				echo '<td style="border: 1px solid black; color: green;  width: 25px; height: 25px; text-align: center; vertical-align: middle; line-height: 25px;">' . $column . '</td>';
			}
		}
		echo '</tr>';
	}
	echo '</table>';
}