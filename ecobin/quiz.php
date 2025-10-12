<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ecobin Quiz Challenge</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body {
  font-family: 'Comic Sans MS', cursive, sans-serif;
  background: linear-gradient(135deg,#ffe6e6,#fff0f5);
  padding-top: 70px;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin:0;
}

/* Navbar */
.navbar {
  background-color:#c30010;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
.navbar-brand, .navbar-nav .nav-link{
  color:#fff !important;
}
.navbar-nav .nav-link:hover{
  color:#ffd6d9 !important;
}

/* Title */
.game-title{
  text-align:center;
  margin:30px 0;
  animation: bounce 2s infinite;
}
.game-title h2{
  font-size:42px;
  color:#ff1744;
  font-weight:bold;
  text-shadow: 2px 2px #fff;
}
.game-title p{
  font-size:18px;
  color:#555;
}

/* Quiz Container */
.quiz-container{
  max-width:700px;
  background: linear-gradient(135deg,#fff0f0,#ffd6d6);
  padding:30px;
  border-radius:20px;
  box-shadow:0 8px 20px rgba(0,0,0,0.2);
  transition: transform 0.3s;
}
.quiz-container:hover{
  transform: scale(1.02);
}

/* Timer */
.timer{
  font-size:22px;
  font-weight:bold;
  text-align:right;
  color:#ff1744;
  margin-bottom:15px;
  animation: pulse 1s infinite;
}

/* Question */
.question{
  font-size:20px;
  font-weight:600;
  margin-bottom:20px;
}

/* Options */
.options button{
  width:100%;
  margin:5px 0;
  padding:12px;
  font-size:16px;
  border-radius:12px;
  border:none;
  cursor:pointer;
  transition: 0.3s;
}
.options button:hover{
  background: #ffd6d6;
}

/* Buttons */
.btn-play, .btn-next, .btn-back{
  display:block;
  margin:20px auto 0;
  background: linear-gradient(to right,#ff1744,#ff5252);
  color:#fff;
  padding:12px 28px;
  font-size:20px;
  font-weight:bold;
  border-radius:15px;
  text-decoration:none;
  transition: transform 0.2s, box-shadow 0.2s;
}
.btn-play:hover, .btn-next:hover, .btn-back:hover{
  transform: scale(1.1) rotate(-2deg);
  box-shadow:0 0 25px #ff1744;
}
.btn-back{
  background:#333;
}
.btn-back:hover{
  background:#555;
  box-shadow:0 0 15px #333;
}

/* Result */
#result-screen h3{
  color:#ff1744;
  margin-bottom:20px;
  text-shadow:1px 1px #fff;
  animation: bounce 2s infinite;
}

/* Back Button */
.btn-back{
  display:block;
  margin:20px auto;
  background:#333;
  color:#fff;
  padding:12px 30px;
  font-size:16px;
  font-weight:bold;
  border-radius:10px;
  text-decoration:none;
  transition: transform 0.2s, box-shadow 0.2s;
}
.btn-back:hover{
  transform: scale(1.05);
  background:#555;
  box-shadow:0 0 15px #333;
}
/* Animations */
@keyframes bounce {0%,100%{transform: translateY(0);}50%{transform: translateY(-10px);}}
@keyframes pulse {0%,100%{transform: scale(1);}50%{transform: scale(1.1);}}
</style>
</head>
<body>

<

<!-- Title -->
<div class="game-title">
<h2>Quiz Challenge</h2>
<p>Answer all questions about e-waste before time runs out! (2 min)</p>
</div>

<!-- Quiz Container -->
<div class="quiz-container">
<div id="start-screen" class="text-center">
  <a href="#" id="start-btn" class="btn-play"><i class="fas fa-play"></i> Start Quiz</a>
  <a href="game.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Games</a>

</div>

<div id="quiz-screen" style="display:none;">
  <div class="timer">Time Left: <span id="time">02:00</span></div>
  <div class="question" id="question"></div>
  <div class="options" id="options"></div>
  <a href="#" id="next-btn" class="btn-next" style="display:none;">Next</a>
</div>

<div id="result-screen" style="display:none; text-align:center;">
  <h3>Your Score: <span id="score"></span>/10</h3>
  <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Home</a>
</div>
</div>

<script>
const questions=[
  {q:"Which of these is e-waste?", options:["Mobile","Book","Chair","Shirt"], answer:"Mobile"},
  {q:"E-waste recycling reduces?", options:["Pollution","Water","Trees","None"], answer:"Pollution"},
  {q:"Who collects e-waste in Ecobin?", options:["Kabadiwala","Teacher","Driver","Doctor"], answer:"Kabadiwala"},
  {q:"Which material can be recovered from e-waste?", options:["Gold","Paper","Wood","Plastic"], answer:"Gold"},
  {q:"Is it safe to throw e-waste in dustbin?", options:["Yes","No","Sometimes","Always"], answer:"No"},
  {q:"What does Ecobin promote?", options:["Eco-friendly disposal","Burning","Dumping","Selling"], answer:"Eco-friendly disposal"},
  {q:"How often should you dispose old electronics?", options:["Weekly","Monthly","Yearly","Never"], answer:"Yearly"},
  {q:"Which is hazardous in e-waste?", options:["Mercury","Water","Soil","Air"], answer:"Mercury"},
  {q:"What is the first step to schedule pickup?", options:["Register/Login","Call","Email","Wait"], answer:"Register/Login"},
  {q:"How long is the quiz?", options:["1 min","2 min","5 min","10 min"], answer:"2 min"}
];

let quizQuestions=[], current=0, score=0, timer, timeLeft=120;

function startQuiz(){
  quizQuestions=[]; let shuffled=[...questions].sort(()=>0.5-Math.random()); quizQuestions=shuffled.slice(0,10);
  current=0; score=0;
  document.getElementById('start-screen').style.display="none";
  document.getElementById('quiz-screen').style.display="block";
  showQuestion(); startTimer();
}

function showQuestion(){
  const q=quizQuestions[current];
  document.getElementById('question').innerText=(current+1)+". "+q.q;
  const optionsDiv=document.getElementById('options'); optionsDiv.innerHTML="";
  q.options.forEach(opt=>{
    const btn=document.createElement('button'); 
    btn.innerText=opt;
    btn.onclick=()=> selectOption(opt); 
    optionsDiv.appendChild(btn);
  });
  document.getElementById('next-btn').style.display="none";
}

function selectOption(selected){
  const correct=quizQuestions[current].answer;
  if(selected===correct) score++;
  document.querySelectorAll('#options button').forEach(b=>b.disabled=true);
  document.getElementById('next-btn').style.display="block";
}

document.getElementById('next-btn').addEventListener('click',()=>{
  current++;
  if(current<quizQuestions.length) showQuestion();
  else endQuiz();
});

function startTimer(){
  timeLeft=120;
  document.getElementById('time').innerText=formatTime(timeLeft);
  timer=setInterval(()=>{
    timeLeft--; 
    document.getElementById('time').innerText=formatTime(timeLeft);
    if(timeLeft<=0){ 
      clearInterval(timer); 
      endQuiz(); 
    }
  },1000);
}

function formatTime(s){
  let m=Math.floor(s/60), sec=s%60; 
  if(sec<10) sec="0"+sec; 
  if(m<10) m="0"+m; 
  return m+":"+sec;
}

function endQuiz(){
  clearInterval(timer);
  document.getElementById('quiz-screen').style.display="none";
  document.getElementById('result-screen').style.display="block";
  document.getElementById('score').innerText=score;
}

document.getElementById('start-btn').addEventListener('click',startQuiz);
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
