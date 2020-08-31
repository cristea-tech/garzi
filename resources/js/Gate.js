export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){
        return this.user.tip === 'Admin';
    }
    isUser(){
        return this.user.tip === 'User';
    }

}
