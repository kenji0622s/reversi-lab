import { askBrain1 } from "@/strategies/brains/brain1";
import { askBrain2 } from "@/strategies/brains/brain2";
import { askBrain3 } from "@/strategies/brains/brain3";
import { askBrain4 } from "@/strategies/brains/brain4";
import { askBrain5 } from "@/strategies/brains/brain5";

// { brain_id: strategy }の形でVueに渡す
export const strategies = {
    1: askBrain1,
    2: askBrain2,
    3: askBrain3,
    4: askBrain4,
    5: askBrain5,
};
