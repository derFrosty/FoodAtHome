let httpServer = require('http').createServer()
let io = require('socket.io')(httpServer)
let SessionManager = require("./SessionManager.js")


const axios = require('axios')


httpServer.listen(8080, function () {
    console.log('listening on *:8080')
})

let sessions = new SessionManager()

io.on('connection', function (socket) {
//    console.log('Client has connected. Socket ID = ' + socket.id)


    socket.on('user_logged', (user) => {
        if (user) {
            sessions.addUserSession(user, socket.id)
            socket.join(user.type)
            console.log('User ' + user.id + ' reconnected. Socket ID= ' + socket.id)
            console.log(' -> Total Sessions= ' + sessions.users.size)

            //updated user availability

            axios.put('http://projeto.test/api/updateLoggedAt', {"user_id": user.id, "logged": 1}).then(response =>{
                console.log("ok! user is now logged-in");
                axios.put('http://projeto.test/api/updateAvailability', {"user_id": user.id, "availability": 1}).then(response =>{
                    console.log("ok! user is now available");
                }).catch(error => {
                    console.log("Error! user availability not updated!");
                });
            }).catch(error => {
                console.log("Error! on user logging!");
            });

        }
    })

    socket.on('user_logged_out', (user) => {
        if (user) {
            socket.leave(user.type)
            sessions.removeUserSession(user.id)
            console.log('User Logged OUT: UserID= ' + user.id + ' Socket ID= ' + socket.id)
            console.log(' -> Total Sessions= ' + sessions.users.size)
        }
    })

    // socket.on('disconnect', (reason) => {
    //     let x = sessions.removeSocketIDSession(socket.id)
    //     // console.log('Disconnect user' + x.user.id)
    //     console.log('Disconnect Socket ID= ' + socket.id)
    //     console.log(' -> Total Sessions= ' + sessions.users.size)
    // })

    socket.on('disconnect', (reason) => {
        let x = sessions.removeSocketIDSessionAndGetId(socket.id)

        axios.put('http://projeto.test/api/updateLoggedAt', {"user_id": x.id, "logged": 0}).then(response =>{
            console.log("ok! user is no longer logged-in");
            axios.put('http://projeto.test/api/updateAvailability', {"user_id": x.id, "availability": 0}).then(response =>{
                console.log("ok! user is no longer now available");
            }).catch(error => {
                console.log("Error! user availability not updated!");
            });
        }).catch(error => {
            console.log("Error! on user logging!");
        });

        console.log('Disconnect user' + x.id)

        console.log('Disconnect Socket ID= ' + socket.id)
        console.log(' -> Total Sessions= ' + sessions.users.size)
    })





})