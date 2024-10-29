// 角に置ける場合は角に置く
// 角に置けない場合は、ランダムに置く
// 角の隣にはできるだけ置かない

import { randam } from "@/strategies/logic/randam";
import { putCorner } from "@/strategies/logic/put-corner";
import { filterAroundCorner } from "@/strategies/logic/filter-around-corner";
import { putAroundCornerNext } from "@/strategies/logic/put-around-corner-next";
function askBrain4({
    blackAvailableCells = [],
    whiteAvailableCells = [],
    turn = "black",
}) {
    console.log(turn + "Brain4");
    if (turn === "black") {
        return _strategy(blackAvailableCells);
    } else {
        return _strategy(whiteAvailableCells);
    }
}

function _strategy(colorAvailableCells) {

    // putCorner: 角に置ければ角に置く
    const corner = putCorner(colorAvailableCells);
    if (corner) {
        return corner;
    }

    // putAroundCornerNext: 角の周りの隣における場合は、角の周りの隣に置く
    const aroundCornerNext = putAroundCornerNext(colorAvailableCells);
    if (aroundCornerNext) {
        return aroundCornerNext;
    }

    // filterAroundCorner: 角の周りと角の周り以外に分ける
    const { availableAroundCornerCells, availableNotAroundCornerCells } =
        filterAroundCorner(colorAvailableCells);

    // 角の周り以外における場合は、角の周り以外に置く
    if (availableNotAroundCornerCells.length > 0) {
        return randam(availableNotAroundCornerCells);
    }

    // 角の周りしか置けない場合は、角の周りに置く
    return randam(availableAroundCornerCells);
}

export { askBrain4 };