
function whiteStrategyModel1(whiteAvailableCells) {
    const whiteAvailableCellLength = whiteAvailableCells.value.length;
    const randomIndex = Math.floor(Math.random() * whiteAvailableCellLength);
    return whiteAvailableCells.value[randomIndex];
}

function blackStrategyModel1(blackAvailableCells) {
    const blackAvailableCellLength = blackAvailableCells.value.length;
    const randomIndex = Math.floor(Math.random() * blackAvailableCellLength);
    return blackAvailableCells.value[randomIndex];
}

export { whiteStrategyModel1, blackStrategyModel1 };