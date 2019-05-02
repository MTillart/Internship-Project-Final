/*
*This script is for JavaScript to collect data from user and send it to server using AJAX
*Data collected:
    *   dbTime (when webpage was loaded)
    *   toWhere (in which webpage the user is)
    *   fromWhere (href where user went)
    *   duration (how long was the user on the page)
 */

//Get time when page was opened
function getStamp() {
    var aeg = Date();
    aeg.toLocaleString();
    return aeg
}

// Time stamp
const theTime = getStamp();
const theTimeMs = new Date().getTime();
//current link the user is on
const fromWhere= location.pathname.substring(location.pathname.lastIndexOf("/") + 1);




//formatting time for database
const dbTime = new Date().toJSON().slice(0, 19).replace('T', ' ');

//get cliked link href
var all = document.querySelector("body");
const part= "localhost";
let toWhere = 'proofing error';

function proof() {
    var elementName = event.target.nodeName;
    var aElement = null;
    // console.log("proofing");
    // console.log(elementName);

    // if (elementName === 'A') {  /* wenn Ziel ein Link ist */
    if (elementName === 'A') {  /* wenn Ziel ein Link ist */
        console.log('proofing');
        aElement = event.target;
        // console.log(aElement);
        // aElementTarget = aElement.getAttribute("target");
        toWhere = aElement.getAttribute("href");

    }else{
        console.log("No track");
    }

}

//new varaibles for next function
let leavingTime= '';
let timeDiff= '';


window.addEventListener("click", proof,); /* Event Delegation -> Links mit JavaScript abfangen */
// all.addEventListener("onunload", saveData);
const xhr = new XMLHttpRequest();

// This function activates when user is clicking on a link or reloading the page

window.addEventListener("beforeunload", saveData,true);

function saveData(){

    console.log("sending...");
    leavingTime= new Date().getTime();
    timeDiff = (leavingTime - theTimeMs);

    //function to chang milliseconds to string
    var getTimeString = function(timeInMs) {
        var delim = ":";
        var hours = Math.floor(timeInMs / (1000 * 60 * 60) % 60);
        var minutes = Math.floor(timeInMs / (1000 * 60) % 60);
        var seconds = Math.floor(timeInMs / 1000 % 60);

        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        return hours + delim + minutes + delim + seconds;
    };
    var sec = Math.floor(timeDiff /1000);
    var mins = Math.floor(sec / 60);
    // var hrs = Math.floor(mins / 60);

    let duration = getTimeString(timeDiff);
    //AJAX
    xhr.onreadystatechange = function(){
        alert("sending")
    };
    xhr.open("POST", "main.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        console.log("data sent");
    };
    xhr.send("dbTime="+dbTime+"&toWhere="+toWhere+"&fromWhere="+fromWhere+"&duration="+duration);

}

// });
