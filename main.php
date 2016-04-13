<?php
session_start();
include "scripts/mysql_connect.php"; 
$username = $_SESSION["username"]; 
$password = $_SESSION["password"];
$sql = mysql_query("SELECT * FROM user WHERE username='$username' AND password='$password' LIMIT 1"); 
$count = mysql_num_rows($sql); 
if ($count == 0) { 
    echo "<script type='text/javascript'>history.back(alert('Your information does not exist!'))</script>";
    exit();
}

if (isset($_POST["search"])) {
    $id = $_POST["id"];
    $key='DEC8DDF9A8AD7DFDA3ED1C13ABD5C9D7';
    $appid = 730;
    $link1 = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$key.'&steamids='.$id.'');
    $info = json_decode($link1, true);
    echo $link1;

    if ($info['response']['players'][0]['steamid'] == "") {
        echo "<script type='text/javascript'>history.back(alert('That use does not exist!'))</script>";
        exit();
    }
    else {
        $steamid = $info['response']['players'][0]['steamid'];
        $nick = $info['response']['players'][0]['personaname'];
        $photo = $info['response']['players'][0]['avatar'];
        $name = $info['response']['players'][0]['realname'];
        $country = $info['response']['players'][0]['loccountrycode'];
    }

    /*
    echo $steamid;
    echo "<p>";
    echo $nick;
    echo "<p>";
    echo $photo;
    echo "<p>";
    echo $name;
    echo "<p>";
    echo $country;
    echo "<p>";
    */

    $link2 = file_get_contents('http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid='.$appid.'&key='.$key.'&steamid='.$id.'');
    $stats = json_decode($link2, true);
    echo $link2;
    echo "<p>";
    $name1 = $stats['playerstats']['stats'][0]['name'];
    $kill = $stats['playerstats']['stats'][0]['value'];
    $name2 = $stats['playerstats']['stats'][1]['name'];
    $death = $stats['playerstats']['stats'][1]['value'];
    $name3 = $stats['playerstats']['stats'][5]['name'];
    $win = $stats['playerstats']['stats'][5]['value'];
    
    /*
    echo $stats['playerstats']['stats'][0]['name'];
    echo "<p>";
    echo $stats['playerstats']['stats'][0]['value'];
    echo "<p>";
    echo $stats['playerstats']['stats'][1]['name'];
    echo "<p>";
    echo $stats['playerstats']['stats'][1]['value'];
    echo "<p>";
    echo $stats['playerstats']['stats'][5]['name'];
    echo "<p>";
    echo $stats['playerstats']['stats'][5]['value'];
    echo "<p>";
    */

    $sql = mysql_query("INSERT INTO search (username, country, name, nick, photo, death, win, kills) 
        VALUES('$username','$country','$name',
        '$nick','$photo','$death','$win','$kill')") or die (mysql_error()); 
}

if (isset($_POST["compare"])) {
    $com_photo1 = $_SESSION["photo"];
    $com_name1 = $_SESSION["name"];
    $com_nick1 = $_SESSION["nick"];
    $com_country1 = $_SESSION["country"];
    $com_kill1 = $_SESSION["kill"];
    $com_death1 = $_SESSION["death"];
    $com_win1 = $_SESSION["win"];
    $com_photo2 = $com_photo1;
    $com_name2 = $com_name1;
    $com_nick2 = $com_nick1;
    $com_country2 = $com_country1;
    $com_kill2 = $com_kill1;
    $com_death2 = $com_death1;
    $com_win2 = $com_wind1;
    $com_photo1 = $_POST["photo"];
    $com_name1 = $_POST["name"];
    $com_nick1 = $_POST["nick"];
    $com_country1 = $_POST["country"];
    $com_kill1 = $_POST["kill"];
    $com_death1 = $_POST["death"];
    $com_win1 = $_POST["win"];
    $_SESSION["photo"] = $com_photo1;
    $_SESSION["name"] = $com_name1;
    $_SESSION["nick"] = $com_nick1;
    $_SESSION["country"] = $com_country1;
    $_SESSION["kill"] = $com_kill1;
    $_SESSION["death"] = $com_death1;
    $_SESSION["win"] = $com_win1;
}

if (isset($_POST["save"]) && $_POST["photo1"] != "" && $_POST["photo2"] != "") {
    $photo1 = $_POST["photo1"];
    $name1 = $_POST["name1"];
    $nick1 = $_POST["nick1"];
    $country1 = $_POST["country1"];
    $kill1 = $_POST["kill1"];
    $death1 = $_POST["death1"];
    $win1 = $_POST["win1"];
    $photo2 = $_POST["photo2"];
    $name2 = $_POST["name2"];
    $nick2 = $_POST["nick2"];
    $country2 = $_POST["country2"];
    $kill2 = $_POST["kill2"];
    $death2 = $_POST["death2"];
    $win2 = $_POST["win2"];
    $sql = mysql_query("INSERT INTO comparison (username, country1, name1, nick1, photo1, death1, win1, kill1, 
        country2, name2, nick2, photo2, death2, win2, kill2) 
        VALUES('$username','$country1','$name1','$nick1','$photo1','$death1','$win1','$kill1',
        '$country2','$name2','$nick2','$photo2','$death2','$win2','$kill2')") or die (mysql_error()); 
}
if ((isset($_POST["save"]) && $_POST["photo1"] == "") ||
    (isset($_POST["save"]) && $_POST["photo2"] == "")) {
    echo "<script type='text/javascript'>history.back(alert('You cannot save at this time!'))</script>";
}
?>

<html>
<head>
    <?php include_once("src.php"); ?>
</head>
<body class="o-page">
    <h1>Counter-Strike: Global Offensive Statistics</h1>
    <div id="content">
        <a href="logout.php"><button class="btn btn-success" style="margin:2px;">Logout</button></a>
        <div style="overflow:auto;">
            <h2>Find</h2>
            <form method="post" action="main.php">
                <input placeholder="Please provide the steam ID" name="id" type="text" class="form-control" pattern="[0-9]{1,24}" required><br>
                <input name="search" type="submit" class="btn btn-success" value="Search"><br>
            </form>
        </div>
        <div style="overflow:auto;">
            <h2>Recent Searches</h2>
            <?php 
            $username = $_SESSION["username"];
            $sql = mysql_query("SELECT * FROM search WHERE username = '$username' LIMIT 20");
            $count = mysql_num_rows($sql); 
            if ($count > 0) {
                while($row = mysql_fetch_array($sql)) { 
                    $name = $row["name"];
                    $nick = $row["nick"];
                    $photo = $row["photo"];
                    $country = $row["country"];
                    $kill = $row["kills"];
                    $death = $row["death"];
                    $win = $row["win"];
                    ?>
                    <form method="post" action="main.php" style="float:left; margin:1%;">
                        <img src="<?php echo $photo; ?>" style="width:60px;height:60px;vertical-align:middle;"><br>
                        <a href="#" style="text-decoration:none; color:black; font-size:12px;">
                        <span style="font-size:10px">Name</span>: <?php echo $name; ?></a><br>
                        <a href="#" style="text-decoration:none; color:black; font-size:12px;">
                        <span style="font-size:10px">nick</span>: <?php echo $nick; ?></a><br>
                        <a href="#" style="text-decoration:none; color:black; font-size:12px;">
                        <span style="font-size:10px">Country</span>: <?php echo $country; ?></a><br>
                        <a href="#" style="text-decoration:none; color:black; font-size:12px;">
                        <span style="font-size:10px">Kill</span>: <?php echo $kill; ?></a><br>
                        <a href="#" style="text-decoration:none; color:black; font-size:12px;">
                        <span style="font-size:10px">Death</span>: <?php echo $death; ?></a><br>
                        <a href="#" style="text-decoration:none; color:black; font-size:12px;">
                        <span style="font-size:10px">Win</span>: <?php echo $win; ?></a><br>
                        <input type="hidden" name="photo" value="<?php echo $photo; ?>">
                        <input type="hidden" name="name" value="<?php echo $name; ?>">
                        <input type="hidden" name="nick" value="<?php echo $nick; ?>">
                        <input type="hidden" name="country" value="<?php echo $country; ?>">
                        <input type="hidden" name="kill" value="<?php echo $kill; ?>">
                        <input type="hidden" name="death" value="<?php echo $death; ?>">
                        <input type="hidden" name="win" value="<?php echo $win; ?>">
                        <input type="submit" name="compare" value="compare">
                    </form>                 
                    <?php
                }
            }
            ?>
        </div>
        <div style="overflow:auto;">
            <h2>Compare</h2>
            <form method="post" action="main.php" style="float:left; margin:1%;">
                <div style="float:left; margin:2%;">
                    <div style="float:left;">
                        <img src="<?php echo $com_photo1; ?>" style="width:60px;height:60px;vertical-align:middle;float:left;">
                        <div style="clear:both; text-align:center">
                        <?php echo $com_name1; ?><br>
                        <?php echo $com_nick1; ?><br>
                        <?php echo $com_country1; ?><br>
                        <?php echo $com_kill1; ?><br>
                        <?php echo $com_death1; ?><br>
                        <?php echo $com_win1; ?><br>
                        </div>
                    </div>
                    <div style="float:left;">
                        <img src="<?php echo $com_photo2; ?>" style="width:60px;height:60px;vertical-align:middle;float:left;">
                        <div style="clear:both; text-align:center">
                        <?php echo $com_name2; ?><br>
                        <?php echo $com_nick2; ?><br>
                        <?php echo $com_country2; ?><br>
                        <?php echo $com_kill2; ?><br>
                        <?php echo $com_death2; ?><br>
                        <?php echo $com_win2; ?><br>
                        </div>
                    </div>     
                </div>  
                <input type="hidden" name="photo1" value="<?php echo $com_photo1; ?>">
                <input type="hidden" name="name1" value="<?php echo $com_name1; ?>">
                <input type="hidden" name="nick1" value="<?php echo $com_nick1; ?>">
                <input type="hidden" name="country1" value="<?php echo $com_country1; ?>">
                <input type="hidden" name="kill1" value="<?php echo $com_kill1; ?>">
                <input type="hidden" name="death1" value="<?php echo $com_death1; ?>">
                <input type="hidden" name="win1" value="<?php echo $com_win1; ?>">
                <input type="hidden" name="photo2" value="<?php echo $com_photo2; ?>">
                <input type="hidden" name="name2" value="<?php echo $com_name2; ?>">
                <input type="hidden" name="nick2" value="<?php echo $com_nick2; ?>">
                <input type="hidden" name="country2" value="<?php echo $com_country2; ?>">
                <input type="hidden" name="kill2" value="<?php echo $com_kill2; ?>">
                <input type="hidden" name="death2" value="<?php echo $com_death2; ?>">
                <input type="hidden" name="win2" value="<?php echo $com_win2; ?>">
                <input type="submit" name="save" class="btn btn-success" value="save">
            </form>
        </div>
        <div style="overflow:auto;">
            <h2>Recent Comparisons</h2>
            <?php 
            $username = $_SESSION["username"];
            $sql = mysql_query("SELECT * FROM comparison WHERE username = '$username' LIMIT 20");
            $count = mysql_num_rows($sql); 
            if ($count > 0) {
                while($row = mysql_fetch_array($sql)) { 
                    $com_name1 = $row["name1"];
                    $com_nick1 = $row["nick1"];
                    $com_photo1 = $row["photo1"];
                    $com_country1 = $row["country1"];
                    $com_kill1 = $row["kill1"];
                    $com_death1 = $row["death1"];
                    $com_win1 = $row["win1"];
                    $com_name2 = $row["name2"];
                    $com_nick2 = $row["nick2"];
                    $com_photo2 = $row["photo2"];
                    $com_country2 = $row["country2"];
                    $com_kill2 = $row["kill2"];
                    $com_death2 = $row["death2"];
                    $com_win2 = $row["win2"];
                    ?>
                    <div style="float:left; margin:2%;">
                        <div style="float:left;">
                            <img src="<?php echo $com_photo1; ?>" style="width:60px;height:60px;vertical-align:middle;float:left;">
                            <div style="clear:both; text-align:center">
                            <?php echo $com_name1; ?><br>
                            <?php echo $com_nick1; ?><br>
                            <?php echo $com_country1; ?><br>
                            <?php echo $com_kill1; ?><br>
                            <?php echo $com_death1; ?><br>
                            <?php echo $com_win1; ?><br>
                            </div>
                        </div>
                        <div style="float:left;">
                            <img src="<?php echo $com_photo2; ?>" style="width:60px;height:60px;vertical-align:middle;float:left;">
                            <div style="clear:both; text-align:center">
                            <?php echo $com_name2; ?><br>
                            <?php echo $com_nick2; ?><br>
                            <?php echo $com_country2; ?><br>
                            <?php echo $com_kill2; ?><br>
                            <?php echo $com_death2; ?><br>
                            <?php echo $com_win2; ?><br>
                            </div>
                        </div>     
                    </div>  
                    <?php
                }
            }
            ?>
        </div>


    </div>
</body>
</html>