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

    spanTimeWithMillisec(time, type="seconds")
    {
        let result= {},
            hours = 0,
            minutes = 0,
            seconds = 0,
            text = '00:00:00.00';
        
        switch (type) {
            case 'seconds':
                hours = Math.floor(time / 60 / 60),
                minutes = Math.floor(time / 60) - (hours * 60),
                seconds = parseFloat(time % 60).toFixed(2);
                break;
        }
        
        text = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');

        result = {
            h: hours,
            m: minutes,
            s: seconds,
            text: text
        }

        return result;
    }

    spanTimeToSeconds(sp=null, toFixed=null) {
        if (sp) {
            let timeArr = sp.split(':'),
                seconds = '';
            
            seconds = (parseInt(timeArr[0]) * 3600) + (parseInt(timeArr[1]) * 60) + parseFloat(timeArr[2]);

            if (toFixed && (typeof toFixed == 'number')) {
                return parseFloat(seconds).toFixed(toFixed);
            }
            return parseFloat(seconds);
        }
    }
}

export default new DateObj();