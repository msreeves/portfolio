 var mybutton = document.getElementById("myBtn");

 window.onscroll = function() {scrollFunction()};

 function scrollFunction() {
   if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
       mybutton.style.display = "block";
   } else {
    mybutton.style.display = "none";
   }
 }

 function topFunction() {
   document.body.scrollTop = 0;
   document.documentElement.scrollTop = 0;
}


var myProfiler = document.getElementById("profile");

myProfiler.addEventListener("change", loadMyData, false);

function loadMyData() {
  var ProfilerStored = myProfiler.options[myProfiler.selectedIndex].value;

  var myRequest = new XMLHttpRequest();

  myRequest.open(
    "GET",
    "https://raw.githubusercontent.com/msreeves87/perception-story/master/characters.json",
    true
  );

  myRequest.onload = function() {
    if (myRequest.readyState == 4 && myRequest.status == 200) {
      var myData = JSON.parse(myRequest.responseText);

      document.getElementById("nameC").innerHTML =
        myData.data[ProfilerStored].name;

      document.getElementById("heightC").innerHTML =
        myData.data[ProfilerStored].height;

      document.getElementById("weightC").innerHTML =
        myData.data[ProfilerStored].weight;

      document.getElementById("ageC").innerHTML =
        myData.data[ProfilerStored].age;

      document.getElementById("occupationC").innerHTML =
        myData.data[ProfilerStored].occupation;

      document.getElementById("hometownC").innerHTML =
        myData.data[ProfilerStored].hometown;

      document.getElementById("nationalityC").innerHTML =
        myData.data[ProfilerStored].nationality;

      document.getElementById("haircolourC").innerHTML =
        myData.data[ProfilerStored].hair_color;

      document.getElementById("eyecolourC").innerHTML =
        myData.data[ProfilerStored].eye_color;

      document.getElementById("skincolourC").innerHTML =
        myData.data[ProfilerStored].skin_color;

      console.log(myData);
    }
  };

  myRequest.send();

  console.log(myRequest);
}

