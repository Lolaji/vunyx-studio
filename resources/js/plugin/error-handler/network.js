import Swal from "sweetalert2";

class NetworkErrorHandler 
{
    constructor()
    {
        this.status = null;
        this.statusText = '';
        this.resMsg = '';
    }

    handle(error) {
        if (error.response) {
            this.status = error.response.status;
            this.responseMsg = error.response.data.message;
            switch (error.response.status) {
                case 400:
                    this.statusText = "Not found";
                    break;
                case 419:
                    this.statusText = 'Unauthorized.';
                    break;
                case 500:
                    this.statusText = 'Unable to process the your request due to system error. Please try again later.';
                    break;
            }
        } else {
            this.statusText = 'Network Error. Please check your network.';
        }
        return this;
    }
    unauthorized()
    {
        if (this.status === 419) {
            return true;
        }
        return false;
    }
    internalServerError()
    {
        if (this.status === 500) {
            return true;
        }
        return false;
    }
    notFound()
    {
        if (this.status === 400) {
            return true;
        }
        return false;
    }
    timeout()
    {
        if (this.status === undefined || this.status === null) {
            return true;
        }
        return false;
    }
    message() {
        return this.statusText;
    }
    responseMessage()
    {
        return this.responseMsg;
    }
}

export default new NetworkErrorHandler();