// 角に置ける場合は角に置く
// 角に置けない場合は、ランダムに置く
// 角の隣にはできるだけ置かない

function askBrain3({
    blackAvailableCells = [],
    whiteAvailableCells = [],
    turn = "black",
}) {
    console.log(turn + 'Brain3');
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

    const cornerNeighbors = [
        [1, 2],
        [1, 7],
        [2, 1],
        [2, 2],
        [2, 7],
        [2, 8],
        [7, 1],
        [7, 2],
        [7, 7],
        [7, 8],
        [8, 2],
        [8, 7],
    ];

    let availableCornerNeighbors = [];
    let remainCells = [];

    for (let i = 0; i < colorAvailableCells.length; i++) {
        const cell = colorAvailableCells[i];
        const isCornerNeighbor = cornerNeighbors.some(
            (cornerNeighbor) => cornerNeighbor[0] === cell[0] && cornerNeighbor[1] === cell[1]
        );
        if (isCornerNeighbor) {
            availableCornerNeighbors.push(cell);
        } else {
            remainCells.push(cell);
        }
    }

    console.log('availableCornerNeighbors', availableCornerNeighbors);
    console.log('remainCells', remainCells.length);

    if (remainCells.length > 0) {
        const randomIndex = Math.floor(Math.random() * remainCells.length);
        console.log('remainCells randomIndex', randomIndex);
        console.log('remainCells randomIndex', remainCells[randomIndex]);
        return remainCells[randomIndex];
    }   

    const randomIndex = Math.floor(Math.random() * availableCornerNeighbors.length);
    console.log('availableCornerNeighbors randomIndex', randomIndex);
    return availableCornerNeighbors[randomIndex];
}

export { askBrain3 };
