<?php

    $allowDir = [
        'components',
        'lookups'
    ];

    $currentDir = Config::get('view.paths');
    $currentDir = array_shift($currentDir) . '/includes/library/';

    $files = [];
    foreach ($allowDir as $dir)
    {
        $vdir = 'includes/library/' . $dir;
        $dir = $currentDir . $dir;
        if (is_dir($dir))
        {
            $lf = scandir($dir);
            foreach ($lf as $file)
            {
                if (in_array($file, [ '.', '..' ])) continue;

                $ffile = $dir . '/' . $file;
                $vfile = $vdir . '/' . $file;
                if (file_exists($ffile))
                {
                    $bldlen = strlen('.blade.php');
                    if (is_dir($ffile))
                    {
                        $sfile = $ffile . '/index.blade.php';
                        $vsfile = $vfile . '/index';
                        if (file_exists($sfile) && !is_dir($sfile))
                        {
                            $files[] = $vsfile;
                        }
                    }
                    else if (stripos($file, '.blade.php') !== false && (substr($file, ($bldlen * -1)) === '.blade.php'))
                    {
                        $files[] = substr($vfile, 0, (strlen($vfile) - $bldlen));
                    }
                }
            }
        }
    }
    
?>

@foreach ($files as $file)
    @include($file)
@endforeach
