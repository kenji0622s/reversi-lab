// 角に置ける場合は角に置く
// 角に置けない場合は、ランダムに置く

import { randam } from '@/strategies/logic/randam';
import { putCorner } from '@/strategies/logic/put-corner';
import { putAccordingToCellLevel } from '@/strategies/logic/put-according-to-cell-level';

function askBrain6({
    blackAvailableCells = [],
    whiteAvailableCells = [],
    turn = "black",
}) {
    console.log(turn + ": Brain6");
    if (turn === "black") {
        return _strategy(blackAvailableCells);
    } else {
        return _strategy(whiteAvailableCells);
    }
}

function _strategy(colorAvailableCells) {

    const cell = putAccordingToCellLevel(colorAvailableCells);
    if (cell) {
        return cell;
    }

    return randam(colorAvailableCells);
}

export { askBrain6 };
