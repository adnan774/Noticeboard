//Date is the JS class that handles all things date and time.
//var today = new Date();
//var date = new Date(year,month,day);

//We obtain the system's current time in hour, minutes and seconds.
//var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
//The lecture covered this. We place the value of our time variable as the text in our <div> with an id of time.
//document.getElementById("time").innerHTML = time;

setInterval (time, 1000);
function time() {
    const time = new Date();
    document.getElementById("time").innerHTML = time.toLocaleTimeString();
}


var t = new Date();
var date = t.getUTCDate();
var month = t.getUTCMonth() + 1;
var year = t.getUTCFullYear();  
var tDate = date + "/" + month + "/" + year;
document.getElementById("date").innerHTML = tDate;



//Ths particular function accepts a parameter named theme oftype any.
function changeColour() {
    href = document.getElementById("style").getAttribute("href");
    currentTheme = href.includes("dark");
    cssStyle = "";
    if (!currentTheme){
        document.getElementById("style").setAttribute("href", "index-dark.css");
        cssStyle = "index-dark.css"
    } else{
        document.getElementById("style").setAttribute("href", "index-light.css");
        cssStyle = "index-light.css"
    }
    $.post("header.php", {mode: cssStyle})
    .done(function(data){
    });
}



//Ths particular function accepts a parameter named theme oftype any.
function changeColour(mode) {
    // if we send the word dark from our webpage...
    if (mode === "dark") {
        //Set the background colour to black
        document.getElementById("background").style.backgroundColor = "black";
        //Set the text colour to white
        document.getElementById("background").style.color = "white";
    } else if (mode === "light") {
        //Set the background colour to white
        document.getElementById("background").style.backgroundColor = "white";
        //Set the text colour to black
        document.getElementById("background").style.color = "black";
    } else {
        //Else - if anything else including null issent from our webpage
        //Set the background to cadet blue
        document.getElementById("background").style.backgroundColor = "cadetblue";
        //Set the text colour to black
        document.getElementById("background").style.color = "black";
    }
}


