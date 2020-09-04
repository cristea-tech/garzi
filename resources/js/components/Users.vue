<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tabela utilizatori</h3>

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search"/>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nume</th>
                  <th>Email</th>
                  <th>Rol</th>
                  <th>Adaugat</th>
                  <th>Modificat</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name | upText }}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.tip | upText}}</td>
                  <td>{{user.created_at | myDate }}</td>
                  <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit fa-fw blue"></i>
                    </a> /
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash fa-fw red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"></td>
                  <td>
                    <button type="button" class="btn btn-success btn-sm" @click="newModal">Creare user <i class="fas fa-user-plus"></i></button>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>

    <div v-if="!$gate.isAdmin()">
        <not-found></not-found>
    </div>
    <div class="modal fade" id="addNew">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div v-show="editmode" class="modal-header bg-success">
            <h4 class="modal-title">Actualizare user</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div v-show="!editmode" class="modal-header bg-primary">
            <h4 class="modal-title">Adaugare user nou</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body blue">
              <form @submit.prevent="editmode ? updateUser(user) : createUser()">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nume</label>
                        <div class="col-sm-10">
                            <input v-model="form.name" type="text" name="name" placeholder="nume utilizator" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"/>
                        <has-error :form="form" field="name"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="email">Email</label>
                        <div class="col-sm-10">
                            <input v-model="form.email" type="email" name="email" placeholder="email utilizator" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"/>
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
                        <label class="col-sm-2 col-form-label">Rol</label>
                        <div class="col-sm-10">
                            <select name="tip" id="tip" type="text" v-model="form.tip" class="form-control" :class="{ 'is-invalid': form.errors.has('tip') }">
                                <option value="User" selected>User</option>
                                <option value="Admin">Admin</option>
                            </select>
                            <has-error :form="form" field="tip"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Descriere</label>
                        <div class="col-sm-10">
                            <textarea v-model="form.descriere" rows="3" type="textarea" placeholder="descriere utilizator (optional)" name="descriere" class="form-control" :class="{ 'is-invalid': form.errors.has('descriere') }"></textarea>
                            <has-error :form="form" field="descriere"></has-error>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Inchide</button>
                    <button v-show="editmode" type="submit" class="btn btn-success btn-sm float-right">Update</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary btn-sm float-right">Salveaza</button>
              </div>
              </form>
          </div>
        </div>

        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  </div>
</template>

<script>

export default {
  data() {
    return {
      // setez o variabila ca sa-mi spuna cand fereastra modala e in editModel sau in addModel
      editmode: true,
        // creez un obiect de tip user
      users : {},
      // preiau valorile din form si initializez variabilele
      form: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        tip: "",
        descriere: "",
      }),
    };
  },
  methods: {
      updateUser(){
        //   console.log('Editare user');
        this.$Progress.start();
        this.form.put('api/user/'+ this.form.id)
        .then(()=>{
            // success
             Swal.fire(
                'Actualizat !',
                'Userul a fost actualizat !',
                'success'
            );
            $('#addNew').modal('hide');
            this.$Progress.finish();
            Fire.$emit('AfterCreate');
        })
        .catch(()=>{
            // eroare
            this.$Progress.fail();
        });

      },
      // folosesc o functie pentru a deschide fereastra modala
      newModal(){
          this.editmode = false;
          this.form.reset();
          $('#addNew').modal('show');
      },
      editModal(user){
          this.editmode = true;
          this.form.reset();
          $('#addNew').modal('show');
          this.form.fill(user);
      },
      // metoda de citire din baza de date a obiectelor user si initializarea variabilei de tip obiect users cu
      // inregistrarile din tabela users
      loadUsers(){
          if(this.$gate.isAdmin())
          {
              axios.get("api/user").then(({ data }) => (this.users = data));
          }
      },
      // functie pentru stergere user
      deleteUser(id){
          // configurez fereastra sweetalert ce trebuie afisata
          Swal.fire({
            title: 'Esti sigur ?',
            text: "Userul nu mai poate fi restaurat !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Da, sterge !'
            }).then((result) => {
                // trimite id pentru stergere la user
                if(result.value){
                    this.form.delete('api/user/'+id)
                    .then(()=>{
                            Swal.fire(
                            'Sters!',
                            'Userul a fost sters !',
                            'success'
                            )
                            Fire.$emit('AfterCreate');

                    })
                    .catch(()=>{
                        Swal.fire("Atentie!", "Ceva este gresit!", "warning");
                    });
                }

            })
      },
      createUser(){
          this.$Progress.start();
          // aplic conditii de validare a raspunsului
          this.form.post('api/user')
          .then(()=>{
              // daca crearea s-a efectuat cu succes atunci
                // semnalizez un eveniment AfterCreate cu metoda emit atasata la Fire
                Fire.$emit('AfterCreate');
                // inchid fereastra modala
                $('#addNew').modal('hide');
                // deschid sweetalert cu mesaj de succes
                toast.fire({
                    icon: 'success',
                    title: 'Userul a fost creat.'
                    });
                this.$Progress.finish();
          })
          .catch(()=>{
              this.$Progress.fail();
              // daca apare eroare la creare
              swal("Atentie!", "Userul nu a fost creat.", "warning");
              toast.fire({
                    icon: 'error',
                    title: 'User nu s-a creat !'
                    });
          });

      }
  },
  created() {
    this.loadUsers();
    // cand evenimentul AfterCreate este produs se declanseaza actualizarea paginii
    Fire.$on('AfterCreate', () => {
        this.loadUsers();
    });
    // setInterval(() => this.loadUsers(),3000);
  },
};
</script>
