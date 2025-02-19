class SessionManager {
    constructor() {
        this.users = new Map()
    }
    getUserSession (userID) {
        return this.users.get(userID)
    }
    addUserSession (user, socketID) {
        // If already exists a session for this user ID, reuse the session
        let userSession = this.getUserSession(user.id)
        if (userSession) {
            userSession.user = user
            userSession.socketID = socketID
            return
        }
        // Otherwise, create a new session
        userSession = {
            user: user,
            socketID: socketID
        }
        this.users.set(user.id, userSession)
        return userSession
    }
    removeUserSession (userID) {
        let userSession = this.getUserSession(userID)
        if (!userSession) {
            return null
        }
        let cloneUserSession = Object.assign({}, userSession)
        this.users.delete(cloneUserSession.user.id)
        return cloneUserSession
    }

    removeSocketIDSession (sessionID) {
        for (let [userID, userSession] of this.users) {
            if (userSession.socketID === sessionID) {
                let cloneUserSession = Object.assign({}, userSession)
                this.users.delete(cloneUserSession.user.id)
                return cloneUserSession
            }
        }
        return null
    }

    removeSocketIDSessionAndGetId (socketToRemove) {

        for (let [user, userSession] of this.users) {
            if (userSession.socketID === socketToRemove) {
                let cloneUserSession = Object.assign({}, userSession)
                this.users.delete(cloneUserSession.user.id)
                return cloneUserSession.user
            }
        }
        return null
    }

}
module.exports = SessionManager