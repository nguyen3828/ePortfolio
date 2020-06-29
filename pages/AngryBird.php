<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JavaScript Projects</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="../script/gameScript.js"></script>

</head>
<body class="bg-light">
<div>
    <div class="container-lg fixed-top bg-light" >
        <h1 class=" display-5 text-center awesome">Hieu Nguyen</h1><br>
        <h4 class=" display-5 text-center">Computer System Technology</h4>
        <!--Navigation-->

        <ul class="nav nav-pills nav-fill bg-dark">
            <li class="nav-item">
                <a class="nav-link text-white" href="../index.php">Welcome</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="about.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active disabled text-white" href="AngryBird.php">JavaScript Projects</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="otherProjects.php">Other Projects</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/pages/Vehicle/PHP-Vehicles.php">PHP-Project</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="contact.php">Contact</a>
            </li>
        </ul>
    </div>
</div>

<div class="d-block container-lg d-block container-lg" style="padding-top: 10%">
    <h2>About this project</h2>
    <span>
        This is an angry birds game that I have been working on. It demonstrates the usage of various JavaScript skills which I have learned from both in school and during my free time.
    </span>
</div>
<div class="embed-responsive embed-responsive-16by9 d-block container-lg" style="height: auto;">
    <iframe id="gameScene" class="embed-responsive-item" src="AngryBirdGame.php" style="height:90%"></iframe>
</div>


</body>
<!-- Footer -->
<footer class="container-lg page-footer font-italic fixed-bottom">

    <!-- Copyright -->
    <div class=" container-lg footer-copyright text-center py-3">© April 27, 2020 Copyright:
        <a href="https://linkedin.com/in/cst-hieunguyen" target="_blank" style="color: black"> Hieu Nguyen</a>
    </div>

    <!-- Copyright -->

</footer>
<!-- Footer -->

<!--<script>-->
<!--    let frame = document.getElementById("gameScene");-->
<!--    console.log(frame);-->
<!--    frame.addEventListener("load", function(){-->
<!--        let iframe = document.getElementById("gameScene").contentWindow.document;-->
<!--        console.log(iframe);-->

<!--        iframe.getElementById("startGame").addEventListener("click", function(){-->
<!--           frame.src="./AngryBirdGame.html";-->
<!--        });-->
<!--    });-->



<!--</script>-->
</html>