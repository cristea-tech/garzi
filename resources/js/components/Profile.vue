<style>
.widget-user-header{
    background-position: center center;
    background-size: cover;
    height: 250px;
}
</style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                    <!-- Add the bg image to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-black" style="background-image: url('./img/user-cover.jpg')">

                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">User logat </h5>
                                <span class="description-text">{{ this.form.name }}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">Ultima modificare</h5>
                                <span class="description-text">30.08.2020 15.08.06</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">IP STATIE</h5>
                                <span class="description-text">192.168.1.200</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Tab Settings Activ -->
                        <div class="active tab-pane" id="settings">
                            <form class="form-horizontal">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Nume</label>
                                <div class="col-sm-10">
                                <input v-model="form.name" type="text" id="name" placeholder="Nume" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"/>
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                <input type="email"  v-model="form.email" id="email" placeholder="Email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"/>
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Parola</label>
                                <div class="col-sm-10">
                                    <input v-model="form.password" type="password" name="password" placeholder="parola utilizator" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"/>
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="descriere" class="col-sm-2 col-form-label">Descriere</label>
                                <div class="col-sm-10">
                                <textarea v-model="form.descriere" id="descriere" placeholder="descriere" class="form-control" :class="{ 'is-invalid': form.errors.has('descriere') }"></textarea>
                                    <has-error :form="form" field="descriere"></has-error>
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="photo" class="col-sm-2 col-form-label">Profile foto</label>
                                    <div class="col-sm-5">
                                        <input type="file" @change="updateProfile" name="photo" class="form-control-file" id="uploadfile"/>
                                    </div>
                                </div>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                <button @click.prevent = "updateInfo" type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                            </form>
                        </div>
                            <!-- Tab Activity  -->
                            <div class="tab-pane" id="activity">
                            <!-- Post -->
                            <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="" alt="user image">
                                <span class="username">
                                <a href="#">Jonathan Burke Jr.</a>
                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Shared publicly - 7:30 PM today</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>

                            <p>
                                <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                <span class="float-right">
                                <a href="#" class="link-black text-sm">
                                    <i class="far fa-comments mr-1"></i> Comments (5)
                                </a>
                                </span>
                            </p>

                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                            </div>
                            <!-- /.post -->

                        </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            <!-- /.nav-tabs-custom -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                 form: new Form({
                    id: "",
                    name: "",
                    email: "",
                    password: "",
                    tip: "",
                    descriere: "",
                    photo: ""
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            // afisez poza de profil in pagina de profil
            getProfilePhoto(){
                // atasez calea fisierului la numele fisierului
                let prefix = (this.form.photo.match(/\//) ? '' : '/img/profile/');
                return prefix + this.form.photo;
                // return "img/profile/"+ this.form.photo;
            },
            updateInfo(){
                // afisez bara de progres incarcare
                this.$Progress.start();
                // daca userul pune parola in campul de parola si apoi sterge parola
                // campul de parola va avea valoarea undefined
               if(this.form.password == ''){
                    this.form.password = undefined;
                }

                this.form.put('api/profile')
                .then(()=>{
                    // opresc bara de progres si afisez mesaj de success
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Profilul a fost actualizat.'
                    });
                    console.log('Profilul a fost actualizat.');
                })
                .catch(()=>{
                    // opresc bara de progres cu fail pentru a indica o eroare
                    toast.fire({
                        icon: 'error',
                        title: 'Profilul nu a fost actualizat.'
                    });
                    this.$Progress.fail();
                    console.log('Profilul a fost actualizat.');
                });
            },
            updateProfile(e){
                // console.log('uploading');
                // definesc o variabila in care stochez fisierul
                let file = e.target.files[0];
                // trimit informatii la consola pentru a verifica daca fisierul a fost incarcat
                console.log(file);
                // folosesc conversia fisierului la Base64 si transform imaginea in text
                let reader = new FileReader();
                // verific daca fisierul e mai mic de 2mb
                if(file['size']< 2111775){
                    reader.onloadend = (file)=>{
                    // console.log('RESULT', reader.result)
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
                }else{
                    // daca fiserul e mai mare de 2mb afisez eroare de operare
                     Swal.fire({
                        icon: 'error',
                        title: 'Eroare dimensiune fisier !',
                        text:'Nu pot fi incarcate imagini mai mari de 2mb !',
                        //footer: 'ceva in footer'
                        });
                }
            }
        },
        created() {
            axios.get("api/profile")
            .then(({ data }) => (this.form.fill(data)));
        }
    }
</script>
