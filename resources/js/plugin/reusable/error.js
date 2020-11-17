import NetworkErrorHandler from '../error-handler/network';
import swal from '../vue-swal';

export default {
    methods: {
        handleNetworkError(error) {
            let err = NetworkErrorHandler.set(error);
                
            err.handle((errMsg) => {
                swal.setTitle(errMsg).setIcon('error').toast();
            });
        }
    }
}