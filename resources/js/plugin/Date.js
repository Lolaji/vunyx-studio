import { result } from "lodash";

class DateObj {
    constructor() {
        this.form = 'authomatic';
    }

    spanTime(time, paramType = 'seconds') {
        let result = {},
            h = '';

        let timeConv = new Date(time * 1000).toISOString().substr(11, 8);
        let split = timeConv.split(':');
        
        result = {
            h: split[0],
            m: split[1],
            s: split[2],
            text: timeConv
        }

        if (parseInt(result.h) > 0)
            h = result.h+':';


        result['rand'] = h+result.m+':'+result.s;


        return result;
    }

    display(form) {
        this.form = form;
    }
}

export default new DateObj();