
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body class="game-scene">
<div class="wrapper">


    <div class="sliding-background" style="z-index: -1">
<!--Place obstacle to move along with the background   -->
        <div style="position: fixed;bottom:110px">
            <span class="ob"></span>
            <span class="ob"></span>
            <span class="ob"></span>
            <span class="ob"></span>
        </div>

    </div>
        <img id="bird" src="../angryBirds/red/frame0.png" alt="bird">
</div>


</body>
<script>
    const bird = document.getElementById("bird");
    let incr = 1;
    let pressed = false;
    let move;
    let currentPos = 100;
    let drop;
    let initialStart = true;
    let firstLoad = true;

    // const height1 = 100;
    // const height2= 120;
    // const height3 = 140;
    // const height4 = 160;
    // const height5 = 180;
    // const height6 = 200;
    // const height7 = 220;
    // const height8 = 240;
    // const height9 = 260;
    // const height10 = 280;



    bird.addEventListener("load", function () {
        console.log("loaded");
        bird.style.position="absolute";
        //prevent the onload event to call the setInterval over and over again
        if(initialStart){
            initialStart = false;
            drop = setInterval(dropDown,8); //control how fast the free falling is
        }


        // if(firstLoad){
        //     firstLoad = false;
        //     for(let i = 0; i < 4; i++){
        //         //determine height because on random number generator
        //         let obstacle = new Obstacle(100,"/5a37f43f7c3e30.2751996115136164475089.png","bottom");
        //         obstacle.setLeftPosition(i * 400);
        //         document.getElementsByClassName("ob")[i].innerHTML=obstacle.toImage();
        //     }
        // }
    });

    document.body.addEventListener("keydown", function (e) {
        if (e.key === ' ' || e.key === 'Spacebar' || e.keycode === 32) {
            //stop the bird from free falling
            clearInterval(drop);
            //flapping wings
            move = setInterval(function () {
                if (incr >6) {
                    incr = 0;
                    console.log("cleared");
                    clearInterval(move);
                } else {
                    console.log("flap wing");
                    bird.src = `../angryBirds/red/frame${incr++}.png`;
                    console.log(currentPos);
                    currentPos-=50; //controls how high the bird can jump per click
                    bird.style.top = `${currentPos}px`;
                }
            }, 8);
            //continue dropping
            drop = setInterval(dropDown,8);
        }
    });
    document.body.addEventListener("click", function (e) {
        //stop the bird from free falling
        clearInterval(drop);
        //flapping wings
        move = setInterval(function () {
            if (incr >6) {
                incr = 0;
                clearInterval(move);
            } else {
                console.log("flap wing");
                bird.src = `../angryBirds/red/frame${incr++}.png`;
                currentPos-=50; //controls how high the bird can jump per click
                bird.style.top = `${currentPos}px`;
            }
        }, 8);
        //continue dropping
        drop = setInterval(dropDown,8);
    });

    /**
     * This function will move the bird position up, and also change img's source and make it looks like
     * the bird is flapping its wings
     * @param e
     */
    function flapWings(e) {
        move = setInterval(function () {
            if (incr > 6) {
                incr = 0;
                console.log("cleared");
                clearInterval(move);
            } else {
                console.log("flap wing");
                bird.src = `angry birds/red/frame${incr++}.png`;
                console.log(currentPos);
                currentPos-= 0.5;
                bird.style.top = `${currentPos}px`;
            }
        }, 1);
    }

    function dropDown(){
        clearInterval(move);
        currentPos++;
        bird.style.top = `${currentPos}px`;
        gameOver();
    }

    function gameOver(){
        if(currentPos > 610){
            clearInterval(drop);
        }
    }


    class Obstacle{
        constructor(position, src, type) {
            this.leftPos = position;
            this.src = src;
            //height will be random
            let heightDetermine =Math.round(Math.random() * (11 - 1) + 1); // 1 to 10
            switch (heightDetermine) {
                case 1:
                    this.height = height1;
                    break;
                case 2:
                    this.height = height2;
                    break;
                case 3:
                    this.height = height3;
                    break;
                case 4:
                    this.height = height4;
                    break;
                case 5:
                    this.height = height5;
                    break;
                case 6:
                    this.height = height6;
                    break;
                case 7:
                    this.height = height7;
                    break;
                case 8:
                    this.height = height8;
                    break;
                case 9:
                    this.height = height9;
                    break;
                default:
                    this.height = height10;
                    break;
            }
            this.type = type; //top or bottom
            this.topPos = this.type === "top" ? 0 : 700; //topPos will be dependent from type
        }

        //change source
        setSource(src){
            this.src = src;
        }
        setLeftPosition(position){
            this.leftPos= position;
        }

        toImage(){
            return `<img class="obstacle" src="angry birds${this.src}" height="${this.height}px" alt="obstacle" style="position:sticky;top:${this.topPos}px;left=${this.leftPos}px;">`;
        }


    }



</script>


</html>