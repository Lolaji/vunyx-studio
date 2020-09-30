import { result } from "lodash";

class DateObj {
    constructor () {}

    spanTime(time, paramType = 'seconds') {
        let result = {},
            h = '';

        let timeConv = new Date(time * 1000).toISOString().substr(11, 8);
        let split = timeConv.split(':');
        
        result = {
            h: split[0],
            m: split[1],
            s: split[2],
        }

        if (parseInt(result.h) > 0)
            h = result.h+':';


        result['text'] = h+result.m+':'+result.s;


        return result;
    }
}

export default new DateObj();