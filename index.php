<?php
include("plantillaArriba.php");
include ("database/conexion.php");
@session_start();
?>
<!-- content -->
<section id="content">
<?php /* echo $_SESSION[username]; */ ?>
    <div id="containerCentral" class="container">
        <div id ="divLogin">
            <?php if (isset($_SESSION["error_cnx"])){ ?>
            <p class="error_cnx"><b>Error:</b><?php echo $_SESSION["error_cnx"] ?></p>
            <?php
                unset($_SESSION["error_cnx"]);
             } ?>
            <form class="formLogin" name="form1" action = "sga.php" method = "post">
                <p>
                    <label >
                        IP/ HOST:
                        <input type="text" name="username" id="ip">
                    </label>
                </p>
                <p>
                    <label >
                        PORT:
                        <input type="text" name="username" id="port">
                    </label>
                </p>
                <p>
                    <label >
                        User Name
                        <input type="text" name="username" id="user">
                    </label>
                </p>
                <p>
                    <label class="passLogin">
                        Password
                        <input type="password" name="password" id="password">
                    </label>
                </p>
                <p>

                    <label class="sidLogin">
                        SID
                        <input type="text" name="SID" id="SID">
                    </label>
                </p>
                <p>
                    <label class="btnLogin">
                        <input type="submit" name="button" id="button" value="Login">                                
                    </label>
                </p>
            </form>
       </div>
    </div>

    
<?php include("plantillaAbajo.php"); ?>