<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</head>
<body class="bg-light">
<div class="container-lg">
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
                <a class="nav-link text-white" href="AngryBird.php">JavaScript Projects</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="otherProjects.php">Other Projects</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/pages/Vehicle/PHP-Vehicles.php">PHP-Project</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-white disabled" href="#">Contact</a>
            </li>
        </ul>
    </div>
    <div class="d-block container-lg" style="padding-top: 15%">
        <!--            LinkedIn-->
        <a class="row-cols-1 d-inline float-lg-right" href="https://linkedin.com/in/cst-hieunguyen" target="_blank">
            <img src="../contactImage/linkedIn.png" height="60px" width="60px" alt="LinkedIn"/></a>
        <!--            Facebook-->
        <a class="row-cols-1 d-inline float-lg-right" href="https://www.facebook.com/profile.php?id=100007454176801" target="_blank">
            <img src="../contactImage/Facebook-Logo.png" height="52" width="55" alt="Facebook"/></a>
        <!--            Git-->
        <a class="row-cols-1 d-inline float-lg-right" href="https://github.com/nguyen3828/portfolio/" target="_blank">
            <img src="../contactImage/GitHub.png" height="52" width="55" alt="GitHub"/></a>
        <!--            resume-->
        <p class="row-cols-1 d-inline" >Computer System Technology, Saskatchewan Polytechnic<br></p>
        <a class="pr-3 text-center" href="../fileLibrary/HieuNguyenResume.pdf" download>
            <button class="btn btn-large btn-info">My Resume</button></a>

    </div>
</div>
<hr class="container-sm border border-info ">
    <form class="d-block container-lg" style="padding-top: 2%">
        <h4>If you would like to know more about me, you can contact via <a href="mailto:nguyeenh@hotmail.com"> my email</a> or by filling the form below</h4><br/><br/>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">Please enter your email.</small>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Content</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Send</button>
    </form>


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
</html>
