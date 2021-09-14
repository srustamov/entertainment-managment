export default {
    login({state}, {user,access_token}) {
        state.auth = {
            is:true,
            token:access_token,
            user:user,
        }
    },
    logout({state}) {
        state.auth = {
            is:false,
            token:null,
            user:null,
        }
    }
}