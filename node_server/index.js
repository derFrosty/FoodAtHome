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
        io.to(`${sessions.getUserSession(cook_id).socketID}`).emit('new_order', 'xpto')

        io.to("EM").emit('update_incoming')

    })

    socket.on('order_update', () =>{ //order_ready
        io.to("EM").emit('update_incoming')
    })


    socket.on('order_canceled', (id_para_notificar) =>{

        if(sessions.getUserSession(id_para_notificar)){
            io.to(`${sessions.getUserSession(id_para_notificar).socketID}`).emit('order_canceled')
        }
    })

    socket.on('user_logged', (user) => {
        if (user) {
            sessions.addUserSession(user, socket.id)
            socket.join(user.type)


            //updated user availability

            axios.put(url + '/api/updateLoggedAt', {"user_id": user.id, "logged": 1}).then(response =>{
                if(user.type !== "C"){
                    io.to("EM").emit('update_incoming')
                }
            }).catch(error => {
                console.log("LG1 - Error: "+error.data);
            });

        }
    })

    socket.on('user_logged_out', (user) => {
        if (user) {
            socket.leave(user.type)
            sessions.removeUserSession(user.id)
            if(user.type !== "C"){
                io.to("EM").emit('update_incoming')
            }
        }
    })



    socket.on('disconnect', (reason) => {
        let x = sessions.removeSocketIDSessionAndGetId(socket.id)
        if(x == null){
            return; // user fez logout antes de fechar a página.
        }

        axios.put(url + '/api/updateLoggedAt', {"user_id": x.id, "logged": 0}).then(response =>{
            if(x.type !== "C"){
                io.to("EM").emit('update_incoming')
            }
        }).catch(error => {
            console.log("DC1 - Error: "+error.data);
        });

    })

    socket.on('changeBlockedStatus', (user) => {

        //verficar se user está logado
        let session = sessions.getUserSession(user.id)

        if (session && user.blocked == 1){
            io.to(`${session.socketID}`).emit('blockStatusUpdate')
        }

        //if another manager is logged
        socket.broadcast.to('EM').emit('updateUserList', user);
    })




})