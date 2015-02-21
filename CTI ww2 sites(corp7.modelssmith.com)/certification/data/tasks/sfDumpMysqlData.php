<?php

pake_desc('dumps all data from mysql');
pake_task('mysql-dump-data', 'project_exists');

pake_desc('loads all data from mysql');
pake_task('mysql-load-data', 'project_exists');

pake_desc('propel-build-all without losing data');
pake_task('propel-build-all-save-mysql', 'project_exists');


$config = array(
'username' => 'mentoruser',
'password' => '3eDSw2',
'database' => 'mentordb'
);

function run_mysql_dump_data($task, $args) {
    
    global $config;
    $sf_root_dir = sfConfig::get('sf_root_dir');
    $sql_data_dir = $sf_root_dir.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'sql';

    $thecmd = 'mysqldump -u '.$config['username'].' --password='.$config['password'].' '.$config['database'].' --skip-opt --no-create-db --no-create-info --complete-insert';

    $output = array('SET FOREIGN_KEY_CHECKS = 0;', 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";','SET AUTOCOMMIT=0;','START TRANSACTION;');

    exec($thecmd, $output);

    array_push($output,'SET FOREIGN_KEY_CHECKS = 1;','COMMIT;');

    $output = implode("\n", $output);

    try {
        $newfile=$sql_data_dir.DIRECTORY_SEPARATOR.$config['database'].'.insert.sql';
        $file = fopen ($newfile, "w");
        fwrite($file, $output);
        fclose ($file);
    } catch(Exception $e) {
        throw new Exception('The following problem occured while attempting to write the sql dump file:'."\n".$e->getMessage()."\n");
    }

    echo 'dump written to: '.$newfile;

}

function run_mysql_load_data($task, $args) {
    
    global $config;
    $sf_root_dir = sfConfig::get('sf_root_dir');
    $sql_data_dir = $sf_root_dir.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'sql';
    $newfile=$sql_data_dir.DIRECTORY_SEPARATOR.$config['database'].'.insert.sql';
    echo 'executing '.$newfile."\n\n";
    $thecmd = 'mysql -u '.$config['username'].' --password='.$config['password'].' '.$config['database'].' < '.$newfile;
    echo $thecmd."\n\n";
    passthru($thecmd);

    echo "\n\n".'dump loaded from: '.$newfile;
    
}

function run_propel_build_all_save_mysql($task, $args) {

    run_mysql_dump_data($task, $args);
    passthru('symfony propel-build-all');
    run_mysql_load_data($task, $args);

}



