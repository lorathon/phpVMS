<?php

include '../core/codon.config.php';
echo '<pre>';

$schedules = SchedulesData::findSchedules(array('s.flighttype'=>'P'));
$idx = rand(0, count($schedules)-1);
$sched = $schedules[$idx];
unset($schedules);

echo '<strong>Filing report...</strong><br />';
$data = array(
	'pilotid'=>1,
	'code'=>$sched->code,
	'flightnum'=>$sched->flightnum,
	'route' => 'HYLND DCT PUT J42 RBV J230 BYRDD J48 MOL DCT FLCON',
	'depicao'=>$sched->depicao,
	'arricao'=>$sched->arricao,
	'aircraft'=>$sched->aircraft,
	'flighttime'=>$sched->flighttime,
	'submitdate'=>'NOW()',
	'fuelused'=>6000,
	'source'=>'unittest',
	'comment'=>'Test Flight',
);

$ret = PIREPData::fileReport($data);
if($ret == false)
{
	echo PIREPData::$lasterror;
}

$pirepid = DB::$insert_id;
$report_info = PIREPData::findPIREPS(array('p.pirepid'=>$pirepid));
echo '<br />';
print_r($report_info);


$pilotinfo = PilotData::findPilots(array('p.pilotid'=>1));

print_r($pilotinfo);

echo '<strong>Deleting...</strong><br />';
PIREPData::deletePIREP($pirepid);
$report_info = PIREPData::findPIREPS(array('p.pirepid'=>$pirepid));

if(!$report_info)
{
	echo 'PIREP deleted';
}