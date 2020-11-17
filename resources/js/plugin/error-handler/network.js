import Swal from "sweetalert2";

class NetworkErrorHandler 
{
    constructor()
    {

    }

    handle(error) {
        console.log(error);

        if (error.response) {
            return error.response.data.message;
        } else {
            return 'Something went wrong.';
        }
    }
}

export default new NetworkErrorHandler();