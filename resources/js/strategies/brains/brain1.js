// ランダムに置く
import { randam } from '@/strategies/logic/randam';

function askBrain1({
    blackAvailableCells = [],
    whiteAvailableCells = [],
    turn = "black",
}) {
    console.log(turn + ": Brain1");
    if (turn === "black") {
        return randam(blackAvailableCells);
    } else {
        return randam(whiteAvailableCells);
    }
}

export { askBrain1 };
