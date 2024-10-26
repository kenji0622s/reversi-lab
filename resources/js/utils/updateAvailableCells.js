import getAllDirectionCells from './getAllDirectionCells';

function updateAvailableCells(availableCells, usedCells) {
    availableCells.value = [];
    for (let i = 1; i <= 8; i++) {
        for (let j = 1; j <= 8; j++) {
            if (!usedCells.value.some(usedCell => usedCell[0] === i && usedCell[1] === j)) {
                availableCells.value.push([i, j]);
            }
        }
    }
}

function updateBlackAvailableCells(blackAvailableCells, availableCells, blackCells, whiteCells, turn, players) {
    blackAvailableCells.value = [];
    for (let i = 0; i < availableCells.value.length; i++) {
        const allDirectionCells = getAllDirectionCells(availableCells.value[i]);
        for (let j = 0; j < allDirectionCells.length; j++) {
            if (checkSingleDirectionCells(allDirectionCells[j], blackCells, whiteCells, turn, players)) {
                blackAvailableCells.value.push(availableCells.value[i]);
                break;
            }
        }
    }
}

function updateWhiteAvailableCells(whiteAvailableCells, availableCells, blackCells, whiteCells, turn, players) {
    whiteAvailableCells.value = [];
    for (let i = 0; i < availableCells.value.length; i++) {
        const allDirectionCells = getAllDirectionCells(availableCells.value[i]);
        for (let j = 0; j < allDirectionCells.length; j++) {
            if (checkSingleDirectionCells(allDirectionCells[j], blackCells, whiteCells, turn, players)) {
                whiteAvailableCells.value.push(availableCells.value[i]);
                break;
            }
        }
    }
}

function checkSingleDirectionCells(singleDirectionCells, blackCells, whiteCells, turn, players) {
    const blackJudges = [];
    for (let i = 0; i < singleDirectionCells.length; i++) {
        blackJudges.push(blackCells.value.some(blackCell => blackCell[0] === singleDirectionCells[i][0] && blackCell[1] === singleDirectionCells[i][1]));
    }
    const whiteJudges = [];
    for (let i = 0; i < singleDirectionCells.length; i++) {
        whiteJudges.push(whiteCells.value.some(whiteCell => whiteCell[0] === singleDirectionCells[i][0] && whiteCell[1] === singleDirectionCells[i][1]));
    }
    if (turn.value === players[0]) {
        if (blackJudges[0] && whiteJudges[1]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && whiteJudges[2]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && whiteJudges[3]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && blackJudges[3] && whiteJudges[4]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && blackJudges[3] && blackJudges[4] && whiteJudges[5]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && blackJudges[3] && blackJudges[4] && blackJudges[5] && whiteJudges[6]) {
            return true;
        }
        return false;
    } else {
        if (whiteJudges[0] && blackJudges[1]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && blackJudges[2]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && blackJudges[3]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && whiteJudges[3] && blackJudges[4]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && whiteJudges[3] && whiteJudges[4] && blackJudges[5]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && whiteJudges[3] && whiteJudges[4] && whiteJudges[5] && blackJudges[6]) {
            return true;
        }
        return false;
    }
}

export { updateAvailableCells, updateBlackAvailableCells, updateWhiteAvailableCells, checkSingleDirectionCells };