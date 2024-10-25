function directionReverse(singleDirectionCells, blackCells, whiteCells, turn) {
    const blackJudges = [];
    for (let i = 0; i < singleDirectionCells.length; i++) {
        blackJudges.push(blackCells.value.some(blackCell => blackCell[0] === singleDirectionCells[i][0] && blackCell[1] === singleDirectionCells[i][1]));
    }
    const whiteJudges = [];
    for (let i = 0; i < singleDirectionCells.length; i++) {
        whiteJudges.push(whiteCells.value.some(whiteCell => whiteCell[0] === singleDirectionCells[i][0] && whiteCell[1] === singleDirectionCells[i][1]));
    }

    if (turn.value === players[0]) {
        if (whiteJudges[0] && blackJudges[1]) {
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[0][0] && whiteCell[1] === singleDirectionCells[0][1]), 1);
            blackCells.value.push(singleDirectionCells[0]);
        }
        if (whiteJudges[0] && whiteJudges[1] && blackJudges[2]) {
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[0][0] && whiteCell[1] === singleDirectionCells[0][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[1][0] && whiteCell[1] === singleDirectionCells[1][1]), 1);
            blackCells.value.push(singleDirectionCells[0], singleDirectionCells[1]);
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && blackJudges[3]) {
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[0][0] && whiteCell[1] === singleDirectionCells[0][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[1][0] && whiteCell[1] === singleDirectionCells[1][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[2][0] && whiteCell[1] === singleDirectionCells[2][1]), 1);
            blackCells.value.push(singleDirectionCells[0], singleDirectionCells[1], singleDirectionCells[2]);
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && whiteJudges[3] && blackJudges[4]) {
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[0][0] && whiteCell[1] === singleDirectionCells[0][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[1][0] && whiteCell[1] === singleDirectionCells[1][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[2][0] && whiteCell[1] === singleDirectionCells[2][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[3][0] && whiteCell[1] === singleDirectionCells[3][1]), 1);
            blackCells.value.push(singleDirectionCells[0], singleDirectionCells[1], singleDirectionCells[2], singleDirectionCells[3]);
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && whiteJudges[3] && whiteJudges[4] && blackJudges[5]) {
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[0][0] && whiteCell[1] === singleDirectionCells[0][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[1][0] && whiteCell[1] === singleDirectionCells[1][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[2][0] && whiteCell[1] === singleDirectionCells[2][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[3][0] && whiteCell[1] === singleDirectionCells[3][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[4][0] && whiteCell[1] === singleDirectionCells[4][1]), 1);
            blackCells.value.push(singleDirectionCells[0], singleDirectionCells[1], singleDirectionCells[2], singleDirectionCells[3], singleDirectionCells[4]);
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && whiteJudges[3] && whiteJudges[4] && whiteJudges[5] && blackJudges[6]) {
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[0][0] && whiteCell[1] === singleDirectionCells[0][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[1][0] && whiteCell[1] === singleDirectionCells[1][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[2][0] && whiteCell[1] === singleDirectionCells[2][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[3][0] && whiteCell[1] === singleDirectionCells[3][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[4][0] && whiteCell[1] === singleDirectionCells[4][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === singleDirectionCells[5][0] && whiteCell[1] === singleDirectionCells[5][1]), 1);
            blackCells.value.push(singleDirectionCells[0], singleDirectionCells[1], singleDirectionCells[2], singleDirectionCells[3], singleDirectionCells[4], singleDirectionCells[5]);
        }
    } else {
        if (blackJudges[0] && whiteJudges[1]) {
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[0][0] && blackCell[1] === singleDirectionCells[0][1]), 1);
            whiteCells.value.push(singleDirectionCells[0]);
        }
        if (blackJudges[0] && blackJudges[1] && whiteJudges[2]) {
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[0][0] && blackCell[1] === singleDirectionCells[0][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[1][0] && blackCell[1] === singleDirectionCells[1][1]), 1);
            whiteCells.value.push(singleDirectionCells[0], singleDirectionCells[1]);
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && whiteJudges[3]) {
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[0][0] && blackCell[1] === singleDirectionCells[0][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[1][0] && blackCell[1] === singleDirectionCells[1][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[2][0] && blackCell[1] === singleDirectionCells[2][1]), 1);
            whiteCells.value.push(singleDirectionCells[0], singleDirectionCells[1], singleDirectionCells[2]);
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && blackJudges[3] && whiteJudges[4]) {
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[0][0] && blackCell[1] === singleDirectionCells[0][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[1][0] && blackCell[1] === singleDirectionCells[1][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[2][0] && blackCell[1] === singleDirectionCells[2][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[3][0] && blackCell[1] === singleDirectionCells[3][1]), 1);
            whiteCells.value.push(singleDirectionCells[0], singleDirectionCells[1], singleDirectionCells[2], singleDirectionCells[3]);
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && blackJudges[3] && blackJudges[4] && whiteJudges[5]) {
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[0][0] && blackCell[1] === singleDirectionCells[0][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[1][0] && blackCell[1] === singleDirectionCells[1][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[2][0] && blackCell[1] === singleDirectionCells[2][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[3][0] && blackCell[1] === singleDirectionCells[3][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[4][0] && blackCell[1] === singleDirectionCells[4][1]), 1);
            whiteCells.value.push(singleDirectionCells[0], singleDirectionCells[1], singleDirectionCells[2], singleDirectionCells[3], singleDirectionCells[4]);
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && blackJudges[3] && blackJudges[4] && blackJudges[5] && whiteJudges[6]) {
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[0][0] && blackCell[1] === singleDirectionCells[0][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[1][0] && blackCell[1] === singleDirectionCells[1][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[2][0] && blackCell[1] === singleDirectionCells[2][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[3][0] && blackCell[1] === singleDirectionCells[3][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[4][0] && blackCell[1] === singleDirectionCells[4][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === singleDirectionCells[5][0] && blackCell[1] === singleDirectionCells[5][1]), 1);
            whiteCells.value.push(singleDirectionCells[0], singleDirectionCells[1], singleDirectionCells[2], singleDirectionCells[3], singleDirectionCells[4], singleDirectionCells[5]);
        }
    }
}

export default directionReverse;
