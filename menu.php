<footer style="position:fixed; bottom:0px; left:0px; right:0px; width:100%; height:60px; z-index:9999;">
    <div style="float:left; width:25%; height:60px; text-align:center;">
        <a href="index.php" ><button class="btn btn-default" style="text-decoration:none; background-color:#587eac; color:#fff; font-size:20px; width:100%; line-height:60px;">Activity</button></a>
    </div>
    <div style="float:left; width:25%; height:60px; text-align:center;">
        <a href="employee.php" ><button class="btn btn-default" style="text-decoration:none; background-color:#587eac; color:#fff; font-size:20px; width:100%; line-height:60px;">Kudos</button></a>
    </div>
    <div style="float:left; width:25%; height:60px; text-align:center;">
        <a href="profile.php?id=<?php echo $id; ?>" ><button class="btn btn-default" style="text-decoration:none; background-color:#587eac; color:#fff; font-size:20px; width:100%; line-height:60px;">Profile</button></a>
    </div>
    <div style="float:left; width:25%; height:60px; text-align:center;">
        <a href="inbox.php" ><button class="btn btn-default" style="text-decoration:none; background-color:#587eac; color:#fff; font-size:20px; width:100%; line-height:60px;">Inbox</button></a>
    </div>
</footer>

<nav id="menu">
    <ul>
        <li>
            <a href="index.php">
                <i class="i-about i-small"></i>Activity
            </a>
        </li>
        <li>
            <a href="employee.php">
                <i class="i-about i-small"></i>Give Kudos
            </a>
        </li>
        <li>
            <a href="profile.php?id=<?php echo $id; ?>">
                <i class="i-about i-small"></i>Profile
            </a>
        </li>
        <li>
            <a href="inbox.php">
                <i class="i-about i-small"></i>Inbox
            </a>
        </li>
        <li>
            <a href="leader.php">
                <i class="i-about i-small"></i>Leader boards
            </a>
        </li>
        <li>
            <a href="shop.php">
                <i class="i-about i-small"></i>Shop
            </a>
        </li>
        <li>
            <a href="setting.php">
                <i class="i-about i-small"></i>Setting
            </a>
        </li>
        <li>
            <a href="logout.php">
                <i class="i-about i-small"></i>Logout
            </a>
        </li>
    </ul>
</nav>