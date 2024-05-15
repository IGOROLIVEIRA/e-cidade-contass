<?php
include (__DIR__ . "/../jpgraph.php");
include (__DIR__ . "/../jpgraph_gantt.php");

// A new graph with automatic size
$graph = new GanttGraph(0,0,"auto");

//  A new activity on row '0'
$activity = new GanttBar(0,"Project","2001-12-21","2002-02-20");
$graph->Add($activity);

// Display the Gantt chart
$graph->Stroke();
?>
