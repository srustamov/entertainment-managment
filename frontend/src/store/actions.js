export default {
    login({state}, {user,access_token}) {
        state.auth = {
            is:true,
            token:access_token || state.auth.token,
            user:user,
        }
    },
    logout({state}) {
        localStorage.removeItem('token')
        state.auth = {
            is:false,
            token:null,
            user:null,
        }
    }
}