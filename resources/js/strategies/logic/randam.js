// ランダムに置く

function randam(inputCells) {
    const randomIndex = Math.floor(Math.random() * inputCells.length);
    return inputCells[randomIndex];
}

export { randam };