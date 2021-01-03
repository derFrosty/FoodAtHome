let httpServer = require('http').createServer()
let io = require('socket.io')(httpServer)
let SessionManager = require("./SessionManager.js")

const axios = require('axios')
const myModule = require('./env.js');
let url = myModule.env().url;

httpServer.listen(8080, function () {
    console.log('listening on *:8080')
})

let sessions = new SessionManager()

io.on('connection', function (socket) {
//    console.log('Client has connected. Socket ID = ' + socket.id)

    socket.on('order_placed_on_online_cook', (cook_id) => {
        console.log("order placed!")
        console.log(sessions.getUserSession(cook_id).socketID)
        io.to(`${sessions.getUserSession(cook_id).socketID}`).emit('new_order', 'xpto')

    })

    socket.on('user_logged', (user) => {
        if (user) {
            sessions.addUserSession(user, socket.id)
            socket.join(user.type)
            // console.log('User ' + user.id + ' reconnected. Socket ID= ' + socket.id)
            // console.log(' -> Total Sessions= ' + sessions.users.size)

            //updated user availability

            axios.put(url + '/api/updateLoggedAt', {"user_id": user.id, "logged": 1}).then(response =>{
                // console.log("ok! user is now logged-in");
                axios.put(url + '/api/updateAvailability', {"user_id": user.id, "availability": 1}).then(response =>{
                    // console.log("ok! user is now available");
                }).catch(error => {
                    console.dir(error)
                    console.log("LG1 - Error: "+error.data.msg);
                });
            }).catch(error => {
                console.log("LG2 - Error: "+error.data.msg);
            });

        }
    })

    socket.on('user_logged_out', (user) => {
        if (user) {
            socket.leave(user.type)
            sessions.removeUserSession(user.id)
            // console.log('User Logged OUT: UserID= ' + user.id + ' Socket ID= ' + socket.id)
            // console.log(' -> Total Sessions= ' + sessions.users.size)
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
        if(x == null){
            return; // user fez logout antes de fechar a página.
        }

        axios.put(url + '/api/updateLoggedAt', {"user_id": x.id, "logged": 0}).then(response =>{
            // console.log("ok! user is no longer logged-in");
            axios.put(url + '/api/updateAvailability', {"user_id": x.id, "availability": 0}).then(response =>{
                // console.log("ok! user is no longer available");

            }).catch(error => {
                console.log("DC1 - Error: " + error.data.msg);
            });
        }).catch(error => {
            console.log("DC2 - Error: "+error.data.msg);
        });

        // console.log('Disconnect user' + x.id)
        //
        // console.log('Disconnect Socket ID= ' + socket.id)
        // console.log(' -> Total Sessions= ' + sessions.users.size)
    })

    socket.on('changeBlockedStatus', (user) => {

        //verficar se user está logado
        let session = sessions.getUserSession(user.id)

        if (session && user.blocked == 1){
            io.to(`${session.socketID}`).emit('blockStatusUpdate')
        }

    })




})