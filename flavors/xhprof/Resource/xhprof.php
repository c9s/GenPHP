<?php
// start profiling
xhprof_enable();


// do something here



// stop profiler
$xhprof_data = xhprof_disable();

$XHPROF_ROOT = '/Users/c9s/git/others/facebook/xhprof';

// Saving the XHProf run
// using the default implementation of iXHProfRuns.
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

$xhprof_runs = new XHProfRuns_Default();

// Save the run under a namespace "xhprof_foo".
//
// **NOTE**:
// By default save_run() will automatically generate a unique
// run id for you. [You can override that behavior by passing
// a run id (optional arg) to the save_run() method instead.]
$profiler_namespace = 'xhprof_{{ name }}';
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_{{ name }}");
$profiler_url = sprintf('http://xhprof.dev/index.php?run=%s&source=%s',$run_id, $profiler_namespace);
echo "<a href=$profiler_url>xhprof profiling</a>";
