// 角に置ける場合は角に置く
// 角に置けない場合は、ランダムに置く

function askBrain2({
    blackAvailableCells = [],
    whiteAvailableCells = [],
    turn = "black",
}) {
    console.log(turn + 'Brain2');
    if (turn === "black") {
        return _strategy(blackAvailableCells);
    } else {
        return _strategy(whiteAvailableCells);
    }
}

function _strategy(colorAvailableCells) {
    const corners = [
        [1, 1],
        [1, 8],
        [8, 1],
        [8, 8],
    ];

    for (let i = 0; i < corners.length; i++) {
        const corner = corners[i];
        const canCorner = colorAvailableCells.some(
            (cell) => cell[0] === corner[0] && cell[1] === corner[1]
        );
        if (canCorner) {
            return corner;
        }
    }

    const randomIndex = Math.floor(Math.random() * colorAvailableCells.length);
    return colorAvailableCells[randomIndex];
}

export { askBrain2 };
