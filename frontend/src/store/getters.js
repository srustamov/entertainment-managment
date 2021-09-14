export default {
    isAuthenticated : (state) => state.auth.is ,
    accessToken: (state) => state.auth.token
}