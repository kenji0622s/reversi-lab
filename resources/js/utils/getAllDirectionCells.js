function getAllDirectionCells(selectedCell) {

    const row = selectedCell[0];
    const column = selectedCell[1];

    const upperLeftCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row - i > 0 && column - i > 0) {
            upperLeftCells.push([row - i, column - i]);
        }
    }

    const upperCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row - i > 0) {
            upperCells.push([row - i, column]);
        }
    }

    const upperRightCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row - i > 0 && column + i <= 8) {
            upperRightCells.push([row - i, column + i]);
        }
    }

    const leftCells = [];
    for (let i = 1; i <= 7; i++) {
        if (column - i > 0) {
            leftCells.push([row, column - i]);
        }
    }

    const rightCells = [];
    for (let i = 1; i <= 7; i++) {
        if (column + i <= 8) {
            rightCells.push([row, column + i]);
        }
    }

    const lowerLeftCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row + i <= 8 && column - i > 0) {
            lowerLeftCells.push([row + i, column - i]);
        }
    }

    const lowerCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row + i <= 8) {
            lowerCells.push([row + i, column]);
        }
    }

    const lowerRightCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row + i <= 8 && column + i <= 8) {
            lowerRightCells.push([row + i, column + i]);
        }
    }

    const allDirectionCells = [upperLeftCells, upperCells, upperRightCells, leftCells, rightCells, lowerLeftCells, lowerCells, lowerRightCells];
    return allDirectionCells;
}

export default getAllDirectionCells;