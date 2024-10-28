// ランダムに置く


function askBrain1({ blackAvailableCells = [], whiteAvailableCells = [], turn = 'black' }) { 
    if (turn === 'black') {
        return _strategy(blackAvailableCells);
    } else {
        return _strategy(whiteAvailableCells);
    }
}

function _strategy(colorAvailableCells) {
    const randomIndex = Math.floor(Math.random() * colorAvailableCells.length);
    return colorAvailableCells[randomIndex];
}

export { askBrain1 };