// 角に置ける場合は角に置く
// 角に置けない場合は、ランダムに置く

import { randam } from '@/strategies/logic/randam';
import { putCorner } from '@/strategies/logic/put-corner';
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

    const corner = putCorner(colorAvailableCells);
    if (corner) {
        return corner;
    }

    return randam(colorAvailableCells);
}

export { askBrain2 };
