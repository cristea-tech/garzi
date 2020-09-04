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
    isAdminOrAuthor(){
        if(this.user.tip === 'Admin' || this.user.tip === 'Author'){
            return true;
        }
    }
    isAuthorOrAuthor(){
        if(this.user.tip === 'User' || this.user.tip === 'Author'){
            return true;
        }
    }

}
