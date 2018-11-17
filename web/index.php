<?php

use Model\Puzzle;
use Model\Solver;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * INSERT A VALID UNSOLVED SUDOKU PUZZLE
 */
$puzzle1 = [
	[0, 0, 3, 0, 0, 0, 0, 0, 0],
	[1, 0, 0, 0, 0, 0, 0, 0, 0],
	[7, 8, 9, 1, 2, 3, 0, 0, 0],
	[2, 3, 4, 5, 0, 7, 8, 9, 0],
	[5, 0, 7, 8, 9, 1, 0, 0, 0],
	[8, 9, 0, 2, 3, 0, 0, 0, 0],
	[3, 4, 5, 6, 7, 8, 0, 0, 2],
	[0, 0, 8, 9, 1, 0, 3, 4, 5],
	[9, 1, 2, 3, 4, 5, 6, 7, 8]
];
$puzzle2 = [
	[0, 0, 0, 0, 0, 0, 0, 0, 0],
	[0, 0, 0, 0, 0, 0, 0, 0, 0],
	[0, 0, 0, 0, 0, 0, 0, 0, 0],
	[2, 3, 4, 5, 0, 7, 8, 9, 0],
	[5, 0, 7, 8, 9, 1, 0, 0, 0],
	[8, 9, 0, 2, 3, 0, 0, 0, 0],
	[3, 4, 5, 6, 7, 8, 0, 0, 2],
	[0, 0, 8, 9, 1, 0, 3, 4, 5],
	[9, 1, 2, 3, 4, 5, 6, 7, 8],
];
$hardestPuzzle = [
	[8, 0, 0, 0, 0, 0, 0, 0, 0],
	[0, 0, 3, 6, 0, 0, 0, 0, 0],
	[0, 7, 0, 0, 9, 0, 2, 0, 0],
	[0, 5, 0, 0, 0, 7, 0, 0, 0],
	[0, 0, 0, 0, 4, 5, 7, 0, 0],
	[0, 0, 0, 1, 0, 0, 0, 3, 0],
	[0, 0, 1, 0, 0, 0, 0, 6, 8],
	[0, 0, 8, 5, 0, 0, 0, 1, 0],
	[0, 9, 0, 0, 0, 0, 4, 0, 0]
];

$puzzleToSolve = $hardestPuzzle;

$startTime = microtime(true);

$solver = new Solver(new Puzzle($puzzleToSolve));

$solver->solve();

$endTime = microtime(true);

echo '<h1>Found ' . \count($solver->getSolutions()) . ' Solution(s) within ' . round($endTime - $startTime, 3) . ' seconds</h1>';
foreach ($solver->getSolutions() as $index => $solution) {
	echo '<h2>Solution ' . ($index + 1) . ':</h2>';
	echo '<table style="border-collapse: collapse; border: 1px solid black; font-size: 25px">';
	foreach ($solution->getRowsWithColumns() as $rowIndex => $row) {
		echo '<tr style="border: 1px solid black;">';
		foreach ($row as $columnIndex => $column) {
			if ($puzzleToSolve[$rowIndex][$columnIndex] === $column) {
				echo '<td style="border: 1px solid black; color: black; width: 25px; height: 25px; text-align: center; vertical-align: middle; line-height: 25px;">' . $column . '</td>';
			} else {
				echo '<td style="border: 1px solid black; color: green;  width: 25px; height: 25px; text-align: center; vertical-align: middle; line-height: 25px;">' . $column . '</td>';
			}
		}
		echo '</tr>';
	}
	echo '</table>';
}