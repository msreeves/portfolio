window.onload = function () {

  var alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
        'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y', 'z'];
  
  var categories;         // Array of topics
  var chosenCategory;     // Selected catagory
  var getHint ;          // Word getHint
  var word ;              // Selected word
  var guess ;             // Guess
  var guesses = [ ];      // Stored guesses
  var lives ;             // Lives
  var counter ;           // Count correct guesses
  var space;              // Number of spaces in word '-'
  var myButtons;
  var letters;
  var list;
  var wordHolder;
  var correct;
  var myStickman;
  var context;
  var hints;
  var gameOver;

  // Get elements
  var showLives = document.getElementById("mylives");
  var getHint = document.getElementById("hint");
  var showClue = document.getElementById("clue");
  var categoryName = document.getElementById("categoryName");



  // create alphabet ul
  var buttons = function () {
    myButtons = document.getElementById('buttons');
    letters = document.createElement('ul');

    for (var i = 0; i < alphabet.length; i++) {
      letters.id = 'alphabet';
      list = document.createElement('li');
      list.id = 'letter';
      list.innerHTML = alphabet[i];
      check();
      myButtons.appendChild(letters);
      letters.appendChild(list);
    }
  }

  var lockLetters = function () {
    if (!letters) {
      return;
    }
    var letterNodes = letters.querySelectorAll('li');
    for (var i = 0; i < letterNodes.length; i++) {
      letterNodes[i].onclick = null;
      letterNodes[i].classList.add('active');
    }
  };

  var revealWord = function () {
    for (var i = 0; i < word.length; i++) {
      guesses[i].innerHTML = word[i];
    }
  };
    
  
  // Select Catagory
  var selectCat = function () {
    if (chosenCategory === categories[0]) {
      categoryName.innerHTML = "The word is an English football team in the top four leagues.";
    } else if (chosenCategory === categories[1]) {
      categoryName.innerHTML = "The word is an Academy Award-winning film.";
    } else if (chosenCategory === categories[2]) {
      categoryName.innerHTML = "The word is a PlayStation game (PS1-PS4 eras).";
    }
  }

  // Create guesses ul
   result = function () {
    wordHolder = document.getElementById('hold');
    correct = document.createElement('ul');

    for (var i = 0; i < word.length; i++) {
      correct.setAttribute('id', 'my-word');
      guess = document.createElement('li');
      guess.setAttribute('class', 'guess');
      if (word[i] === "-") {
        guess.innerHTML = "-";
        space = 1;
      } else {
        guess.innerHTML = "_";
      }

      guesses.push(guess);
      wordHolder.appendChild(correct);
      correct.appendChild(guess);
        
    }
       
  }
   
  
  // Show lives
   comments = function () {
    if (gameOver) {
      return;
    }
    showLives.innerHTML = "You have " + lives + " lives";
    if (lives < 1) {
      showLives.innerHTML = "You're dead!";
      showClue.innerHTML = "Answer: " + word.replace(/-/g, " ");
      revealWord();
      lockLetters();
      gameOver = true;
      return;
    }
    for (var i = 0; i < guesses.length; i++) {
      if (counter + space === guesses.length) {
        showLives.innerHTML = "You Survived The Noose!!";
        lockLetters();
        gameOver = true;
        return;
      }
    }
  }

      // Animate man
  var animate = function () {
    var drawMe = lives ;
    drawArray[drawMe]();
  }

  
   // Hangman
  canvas =  function(){

    myStickman = document.getElementById("stickman");
    context = myStickman.getContext('2d');
    context.beginPath();
    context.strokeStyle = "#fff";
    context.lineWidth = 2;
  };
  
    head = function(){
      myStickman = document.getElementById("stickman");
      context = myStickman.getContext('2d');
      context.beginPath();
      context.arc(60, 25, 10, 0, Math.PI*2, true);
      context.stroke();
    }
    
  draw = function($pathFromx, $pathFromy, $pathTox, $pathToy) {
    
    context.moveTo($pathFromx, $pathFromy);
    context.lineTo($pathTox, $pathToy);
    context.stroke(); 
}

   frame1 = function() {
     draw (0, 150, 150, 150);
   };
   
   frame2 = function() {
     draw (10, 0, 10, 600);
   };
  
   frame3 = function() {
     draw (0, 5, 70, 5);
   };
  
   frame4 = function() {
     draw (60, 5, 60, 15);
   };
  
   torso = function() {
     draw (60, 36, 60, 70);
   };
  
   rightArm = function() {
     draw (60, 46, 100, 50);
   };
  
   leftArm = function() {
     draw (60, 46, 20, 50);
   };
  
   rightLeg = function() {
     draw (60, 70, 100, 100);
   };
  
   leftLeg = function() {
     draw (60, 70, 20, 100);
   };
  
  drawArray = [rightLeg, leftLeg, rightArm, leftArm,  torso,  head, frame4, frame3, frame2, frame1]; 


  // OnClick Function
   check = function () {
    list.onclick = function () {
      if (gameOver) {
        return;
      }
      var guess = (this.innerHTML);
      this.setAttribute("class", "active");
      this.onclick = null;
      for (var i = 0; i < word.length; i++) {
        if (word[i] === guess) {
          guesses[i].innerHTML = guess;
          counter += 1;
        } 
      }
      var j = (word.indexOf(guess));
      if (j === -1) {
        lives -= 1;
        comments();
        animate();
      } else {
        comments();
      }
    }
  }
  
    
  // Play
  play = function () {
    categories = [
        ["arsenal","bournemouth","brighton-and-hove-albion","burnley","chelsea","crystal-palace","everton","huddersfield-town","leicester-city","liverpool","manchester-city","manchester-united","newcastle-united","southampton","stoke-city","swansea","totteham-hotspur","watford","west-bromwich-albion","west-ham","aston-villa","barnsley","birmingham-city","bolton-wanderers","brentford","bristol-city","burton-albion", "cardiff-city","derby-county","fulham","hull-city","ipswich-town","leeds-united","middlesbrough","millwall", "norwich-city","nottingham-forest","preston-north-end","queens-park-rangers","reading", "sheffield-united","sheffield-wednesday", "sunderland","wolves","wimbledon","blackburn-rovers","blackpool","bradford-city","bristol-rovers","bury","charlton-athletic","doncaster-rovers","fleetwood-town","gillingham","milton-keyes-dons","northampton-town","oldham-athletic","oxford-united","peterborough-united","plymouth-argyle","portsmouth","rochdale","rotherham-united","scunthorpe-united","shrewsbury-town","southend-united","walsall","wigan-athletic","accrington-stanley","barnet","cambridge-united","cheltenham-town","chesterfield","colchester","coventry-city","crawley-town","crewe-alexandra","exeter-city","forest-green-rovers","grimsby-town","lincoln-city","luton-town","mansfield-town","morecambe","newport-county","notts-county","port-vale","stevenage","swindon-town","wycombe-wanderers","yeovil-town"],
        
        ["snow-white-and-the-seven-dwarfs","gone-with-the-wind","the-wizard-of-oz","fantasia","oklahoma","ben-hur","some-like-it-hot","west-side-story","the-longest-day","goldfinger","mary-poppins","the-great-race","the-sound-of-music","bonnie-and-clyde","the-dirty-dozen","the-graduate","oliver","the-producers","romeo-and-juilet","butch-cassidy-and-the-sundance-kid","planet-of-the-apes","the-exorcist","the-godfather","the-french-connection","bednobs-and-bromsticks","rocky","star-wars-a-new-hope","close-encounters-of-the-third-kind","alien","jaws","superman","raging-bull","an-american-werewolf-in-london","et-the-extra-terrestrial","an-officer-and-a-gentleman","flashdance","return-of-the-jedi","cocoon","back-to-the-future","top-gun","platoon","the-fly","the-untouchables", "dirty-dancing","wall-street","robocop","rain-man","dangerous-liasons","who-framed-roger-rabbit","working-girl","beetlejuice","driving-miss-daisy","indiana-jones-and-the-last-crusade","ghost","goodfellas","misery","the-silence-of-the-lambs","total-recall","jfk","thelma-and-louise","city-slickers","unforgiven","aladdin","brams-stokes-dracula","malcolm-x","death-becomes-her","schindlers-list","jurassic-park","philadelphia","the-fugitive","mrs-doubtfire","forrest-gump","lion-king","speed","pulp-fiction","ed-wood", "legends-of-the-fall", "braveheart","apollo-thirteen", "the-usual-suspects","toy-story", "jerry-maguire", "the-english-patient","fargo","independence-day","the-nutty-professor","titanic","good-will-hunting","la-confidential","the-full-monty","men-in-black","shakespeare-in-love", "saving-private-ryan","american-beauty","the-matrix","sleepy-hollow", "gladiator", "crouching-tiger-hidden-dragon","wonder-boys","a-beautiful-mind","lord-of-the-rings","gosford-park","pearl-harbor","training-day","chicago","road-to-predition", "finding-nemo","lost-in-translation","million-dollar-baby","the-aviator","ray","finding-neverland","spider-man-two", "eternal-sunshine-of-the-spotless-mind","crash","brokeback-mountain","king-kong","walk-the-line","the-constant-gardner","the-chronicles-of-narnia","the-departed","pans-labyrinth","dreamgirls","the-last-king-of-scotland","no-country-for-old-men", "juno","the-golden-compass","slumdog-millionaire", "the-dark-knight","wall-e","the-hurt-locker","avatar","up","inglourious-basterds","star-trek","the-kings-speech","inception","the-social-network","the-fighter","alice-in-wonderland","black-swan","the-artist","hugo","the-girl-with-the-dragon-tattoo","argo","les-miserables","django-unchained","skyfall","twelve-years-a-slave","gravity","dallas-buyers-club","frozen","the-great-gatsby","birdman","the-grand-budapest-hotel","whiplash","the-imitation-game","american-sniper","the-theory-of-everything","spotlight","mad-max-fury-road","the-revenant","bridge-of-spies","the-danish-girl","the-hateful-eight","moonlight","la-la-land","hacksaw-bridge","arrival","suicide-squad","zootopia"],
        
        ["fifa","tekken","grand-theft-auto","uncharted","days-gone","call-of-duty","battlefied","assassins-creed","wwe-smackdown-vs-raw","project-cars","rayman","resident-evil","formula-one","max-payne","final-fantasy","medal-of-honor","die-hard-vendetta","shadow-of-modor","lord-of-the-rings","prince-of-persia","pro-evolution-soccer","tomb-raider","doom","total-driven","mafia","destiny","mad-max","lma-manager","batman-arkham","colin-mcrae-rally","driver","duke-nukem","fear-effect","gran-turismo","heart-of-darkness","hot-wheels-racing","knockout-kings","street-fighter","metal-gear-solid","mlb","nba","mortal-kombat","moto-gp","madden","need-for-speed","oddworld-abe","premier-manager","ridge-racer","silent-hill","this-is-football","tiger-woods-golf","worms","destiny","burnout","crash-bandicoot","devil-may-cry","dragon-ball-z","dynasty-warriors","fight-night-round","ufc","the-getaway","guitar-hero","hitman","just-cause", "red-faction","the-sims","singstar","sonic","time-crisis","tom-clancy","tony-hawk","top-spin","wipeout","world-rally-championship","red-dead-redemption","the-last-of-us","bioshock","borderlands","dirt","crysis","dark-souls","dead-space","dragon-age","the-elder-scrolls","fear","fallout","far-cry","god-of-war","infamous","killzone","little-big-planet","mass-effect","rock-band","rugby-challenge","skate","the-crew","dead-island","dishorned-two","dragon-quest","the-evil-within","untill-dawn","injustice-two","lords-of-the-fallen","sniper-elite","watch-dogs"]
    ];

    chosenCategory = categories[Math.floor(Math.random() * categories.length)];
    word = chosenCategory[Math.floor(Math.random() * chosenCategory.length)];
    word = word.replace(/\s/g, "-");
    console.log(word);
    buttons();

    guesses = [ ];
    lives = 10;
    counter = 0;
    space = 0;
    gameOver = false;
    result();
    comments();
    selectCat();
    canvas();
  }

  play();
  
  // Hint

    getHint.onclick = function() {

      hints = [
        ["Premier League", "Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League","Premier League", "Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","Championship","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 1","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2","League 2"],
        ["1930s","1930s","1930s","1940s","1950s","1950s","1950s","1960s","1960s","1960s","1960s","1960s","1960s","1960s","1960s","1960s","1960s","1960s","1960s","1960s","1970s","1970s","1970s","1970s","1970s","1970s","1970s","1970s","1970s","1970s","1970s","1980s","1980s","1980s","1980s","1980s","1980s","1980s","1980s","1980s","1980s","1980s","1980s", "1980s","1980s","1980s","1980s","1980s","1980s","1980s","1980s","1980s","1980s", "1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s", "1990s", "1990s","1990s", "1990s","1990s", "1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s","1990s", "1990s","1990s","1990s","1990s","1990s", "2000s", "2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s", "2000s","2000s","2000s","2000s","2000s","2000s","2000s", "2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2000s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s","2010s"],
        
        ["sport","fighting","open world","adventure","horror","shooter","shooter","open world","wrestling","racing","adventure","horror","racing","shooter","adventure","shooting","shooter","open world","adventure","adventure","sport","adventure","shooter","racing","adventure","shooter","open world","sport","adventure","racing","racing","shooter","adventure","racing","adventure","racing","boxing","fighting","adventure","sport","sport","fighting","racing","sport","racing","platform","sport","racing","horror","sport","sport","fighting","shooter","racing","racing","adventure","fighting","fighting","sport","sport","open world","music","shooter","open world", "shooter","open world","music","platform","shooter","shooter","skateboard","sport","platform","racing","open world","horror","shooter","shooter","racing","shooter","adventure","horror","adventure","adventure","shooter","open world","open world","adventure","adventure","shooter","platform","shooter","music","sport","skate","racing","horror","adventure","adventure","horror","horror","fighting","adventure","shooter","open world"]
    ];

    var catagoryIndex = categories.indexOf(chosenCategory);
    var hintIndex = chosenCategory.indexOf(word);
    showClue.innerHTML = "Clue: - " +  hints [catagoryIndex][hintIndex];
  };

   // Reset

  document.getElementById('reset').onclick = function() {
    correct.parentNode.removeChild(correct);
    letters.parentNode.removeChild(letters);
    showClue.innerHTML = "";
    context.clearRect(0, 0, 400, 400);
    play();
  };
  
}



