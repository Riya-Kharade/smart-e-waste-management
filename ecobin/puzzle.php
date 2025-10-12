<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ecobin E-Waste Puzzle Game</title>
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
  margin:20px 0;
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

/* Main Container */
.puzzle-container{
  display: flex;
  gap: 30px;
  max-width: 900px;
  background: linear-gradient(135deg,#fff0f0,#ffd6d6);
  padding:20px;
  border-radius:20px;
  box-shadow:0 8px 20px rgba(0,0,0,0.2);
  justify-content: center;
}

/* Reference Card */
.reference {
  display: flex;
  flex-direction: column;
  align-items: center;
  background:#ffe6e6;
  padding:15px;
  border-radius:15px;
  box-shadow:0 5px 15px rgba(0,0,0,0.2);
}
.reference h3{
  margin-bottom:10px;
  color:#c30010;
  font-weight:bold;
}
.ref-grid {
  display: grid;
  grid-template-columns: repeat(3,60px);
  grid-template-rows: repeat(3,60px);
  gap:5px;
}
.ref-tile {
  background:#fff0f0;
  border-radius:8px;
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:24px;
}

/* Interactive Puzzle */
.game-side{
  display: flex;
  flex-direction: column;
  align-items: center;
}
.timer{
  font-size:22px;
  font-weight:bold;
  color:#ff1744;
  margin-bottom:15px;
  text-align:right;
  width:100%;
  animation: pulse 1s infinite;
}
.grid {
  display: grid;
  grid-template-columns: repeat(3, 100px);
  grid-template-rows: repeat(3, 100px);
  gap: 10px;
}
.tile {
  background: #ffe6e6;
  border-radius: 12px;
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:36px;
  cursor:pointer;
  user-select: none;
  transition: transform 0.2s;
}
.tile.empty {
  background: transparent;
  cursor: default;
}
/* Buttons */
.btn-start, .btn-back{
  display:block;
  margin:15px auto;
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
@keyframes bounce {0%,100%{transform: translateY(0);}50%{transform: translateY(-10px);} }
@keyframes pulse {0%,100%{transform: scale(1);}50%{transform: scale(1.1);} }
</style>
</head>
<body>

<div class="game-title">
<h2>E-Waste Puzzle Game</h2>
<p>Arrange e-waste items in the correct order! Complete in 3 min.</p>
</div>

<div class="puzzle-container">
  <!-- Reference Puzzle -->
  <div class="reference">
    <h3>How Puzzle Should Look</h3>
    <div class="ref-grid" id="ref-grid"></div>
  </div>

  <!-- Interactive Puzzle -->
  <div class="game-side">
    <div id="start-screen" class="text-center">
      <a href="#" id="start-btn" class="btn-start"><i class="fas fa-play"></i> Start Game</a>
    </div>

    <div id="game-screen" style="display:none; width:100%;">
      <div class="timer">Time Left: <span id="time">03:00</span></div>
      <div class="grid" id="grid"></div>
    </div>
  </div>
</div>

<a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Home</a>

<script>
const grid = document.getElementById('grid');
const refGrid = document.getElementById('ref-grid');
const startBtn = document.getElementById('start-btn');
const startScreen = document.getElementById('start-screen');
const gameScreen = document.getElementById('game-screen');

let tiles = [];
let emptyIndex = 8; 
let timer, timeLeft = 180;

// E-waste items (icons)
const eWasteItems = ['📱','💻','📺','🔋','🖱️','⌨️','🖨️','📷',null];

// Render reference puzzle
eWasteItems.forEach(item => {
  const div = document.createElement('div');
  div.className = 'ref-tile';
  div.innerText = item ? item : '';
  refGrid.appendChild(div);
});

// Start game
startBtn.addEventListener('click', () => {
  startScreen.style.display = 'none';
  gameScreen.style.display = 'block';
  initPuzzle();
  startTimer();
});

function initPuzzle() {
  let items = [...eWasteItems];
  shuffle(items);
  grid.innerHTML = '';
  tiles = items.map(n => {
    const div = document.createElement('div');
    div.className = n ? 'tile' : 'tile empty';
    div.innerText = n ? n : '';
    div.addEventListener('click', () => moveTile(div));
    grid.appendChild(div);
    return div;
  });
  emptyIndex = tiles.findIndex(t => t.classList.contains('empty'));
}

function shuffle(array) {
  for(let i=array.length-1;i>0;i--){
    const j=Math.floor(Math.random()*(i+1));
    [array[i], array[j]]=[array[j], array[i]];
  }
}

function moveTile(tile){
  const index = tiles.indexOf(tile);
  const adjacent = [index-1,index+1,index-3,index+3];
  if(adjacent.includes(emptyIndex)){
    [tiles[index].innerText, tiles[emptyIndex].innerText] = [tiles[emptyIndex].innerText, tiles[index].innerText];
    tiles[emptyIndex].classList.remove('empty');
    tiles[index].classList.add('empty');
    emptyIndex = index;
    checkWin();
  }
}

function checkWin(){
  for(let i=0;i<tiles.length-1;i++){
    if(tiles[i].innerText !== eWasteItems[i]) return false;
  }
  clearInterval(timer);
  alert('🎉 You arranged all e-waste items correctly!');
  return true;
}

function startTimer(){
  timeLeft=60;
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
