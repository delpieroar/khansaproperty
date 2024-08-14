<header>
<div class="logo">
    <a href="index.php"><img src="pictures/logoptupdate.PNG"></a> 
</div>
<nav>
    <ul>
        <li><form method="GET" action="search.php"><input type="text" name="cari" class="kotakCari" required><input type="submit" name="cariRumah" value="CARI" class="tombolCari"></form></li>
        <li class="navlist"><a href="index.php">HOME</a></li>
        <li class="navlist"><a href="properti.php">PROPERTI</a></li>
        <li class="navlist"><a href="contact.php">CONTACT</a></li>
        <?php 
            if(isset($_SESSION['level'])){
        ?>
            <li class='navlist'><a href='management.php'>MANAGEMENT</a></li>
            <li class="navlist tombolAkun"><a href="account.php">ACCOUNT</a></li>
        <?php
            }else{
        ?>  
            <li class="tombolLogin"><a href="login.php">LOG IN</a></li>
        <?php 
            }
        ?>
    </ul>
</nav>
</header>