<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ecobin Sorting Game</title>
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

/* Game Container */
.sort-container{
  display:flex;
  flex-direction: column;
  align-items: center;
  max-width:800px;
  background: linear-gradient(135deg,#fff0f0,#ffd6d6);
  padding:30px;
  border-radius:20px;
  box-shadow:0 8px 20px rgba(0,0,0,0.2);
}

/* Timer */
.timer{
  font-size:22px;
  font-weight:bold;
  text-align:right;
  color:#ff1744;
  width:100%;
  margin-bottom:20px;
  animation: pulse 1s infinite;
}

/* Items Area */
.items {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  margin-bottom: 40px;
  gap: 20px;
}
.item {
  width:120px;
  height:120px;
  background:#ffe6e6;
  border-radius:15px;
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:40px;
  color:#ff1744;
  cursor: grab;
  transition: transform 0.2s, background 0.2s;
}
.item:active {
  cursor: grabbing;
  transform: scale(1.1);
}

/* Trash Bins */
.bins {
  display: flex;
  justify-content: space-around;
  width:100%;
  gap:20px;
}
.bin {
  width:140px;
  height:140px;
  border-radius:15px;
  background:#ffd6d6;
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:18px;
  font-weight:bold;
  color:#c30010;
  transition: transform 0.3s, background 0.3s;
}
.bin.hovered{
  transform: scale(1.05);
  background:#ffb0b0;
}

/* Buttons */
.btn-start, .btn-back{
  display:block;
  margin:20px auto;
  background: linear-gradient(to right,#ff1744,#ff5252);
  color:#fff;
  padding:12px 28px;
  font-size:20px;
  font-weight:bold;
  border-radius:15px;
  text-decoration:none;
  transition: transform 0.2s, box-shadow 0.2s;
}
.btn-start:hover, .btn-back:hover{
  transform: scale(1.05);
  box-shadow:0 0 20px #ff1744;
}
.btn-back{
  background:#333;
}
.btn-back:hover{
  background:#555;
}



@keyframes bounce {0%,100%{transform: translateY(0);}50%{transform: translateY(-10px);}}
@keyframes pulse {0%,100%{transform: scale(1);}50%{transform: scale(1.1);}}
</style>
</head>
<body>


<!-- Navbar -->


<div class="game-title">
<h2>Sorting Game</h2>
<p>Drag & Drop e-waste items into the correct bins! Complete it before the timer ends.</p>
</div>

<div class="sort-container">

<div id="start-screen" class="text-center">
  <a href="#" id="start-btn" class="btn-start"><i class="fas fa-play"></i> Start Game</a>
</div>

<div id="game-screen" style="display:none; width:100%;">
  <div class="timer">Time Left: <span id="time">00:30</span></div>

  <div class="items" id="items">
    <div class="item" draggable="true" data-type="mobile"><i class="fas fa-mobile-alt"></i></div>
    <div class="item" draggable="true" data-type="laptop"><i class="fas fa-laptop"></i></div>
    <div class="item" draggable="true" data-type="battery"><i class="fas fa-battery-three-quarters"></i></div>
    <div class="item" draggable="true" data-type="tv"><i class="fas fa-tv"></i></div>
  </div>

  <div class="bins">
    <div class="bin" data-type="mobile">Mobile</div>
    <div class="bin" data-type="laptop">Laptop</div>
    <div class="bin" data-type="battery">Battery</div>
    <div class="bin" data-type="tv">TV</div>
  </div>
</div>

<a href="game.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Game Page</a>
</div>

<script>
const items = document.querySelectorAll('.item');
const bins = document.querySelectorAll('.bin');
const startBtn = document.getElementById('start-btn');
const startScreen = document.getElementById('start-screen');
const gameScreen = document.getElementById('game-screen');

let score = 0;
let timer;
let timeLeft = 30; // 30 seconds

startBtn.addEventListener('click', ()=>{
  startScreen.style.display = 'none';
  gameScreen.style.display = 'block';
  startTimer();
});

items.forEach(item=>{
  item.addEventListener('dragstart', dragStart);
});

bins.forEach(bin=>{
  bin.addEventListener('dragover', dragOver);
  bin.addEventListener('drop', dropItem);
});

function dragStart(e){
  e.dataTransfer.setData('type', this.dataset.type);
  setTimeout(()=> this.style.display='none',0);
}
function dragOver(e){
  e.preventDefault();
  this.classList.add('hovered');
}
function dropItem(e){
  e.preventDefault();
  const type = e.dataTransfer.getData('type');
  this.classList.remove('hovered');
  const draggedItem = document.querySelector(`.item[data-type='${type}']`);
  if(this.dataset.type===type){
    draggedItem.remove();
    score++;
    if(score===items.length) alert('🎉 You sorted all items correctly!');
  } else {
    draggedItem.style.display='block';
    alert('❌ Wrong bin!');
  }
}

function startTimer(){
  timeLeft=30; // 30 seconds
  document.getElementById('time').innerText=formatTime(timeLeft);
  timer=setInterval(()=>{
    timeLeft--;
    document.getElementById('time').innerText=formatTime(timeLeft);
    if(timeLeft<=0){
      clearInterval(timer);
      alert('⏰ Time Over!');
    }
  },1000);
}

function formatTime(s){
  let m=Math.floor(s/60), sec=s%60;
  if(sec<10) sec="0"+sec;
  if(m<10) m="0"+m;
  return m+":"+sec;
}
</script>

</body>
</html>
